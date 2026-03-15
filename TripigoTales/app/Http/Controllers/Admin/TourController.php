<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Tour;
use App\Models\Category;
use App\Exports\ToursExport;
use App\Imports\ToursImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use ZipArchive;

class TourController extends Controller
{

    protected function storeCompressedImage(UploadedFile $file, string $relativeDir, int $maxWidth = 1920, int $quality = 80): string
    {
        $absoluteDir = public_path(trim($relativeDir, '/'));
        File::ensureDirectoryExists($absoluteDir);

        $mime = $file->getMimeType();
        $tmpPath = $file->getRealPath();

        if (!$tmpPath || !$mime || !function_exists('imagecreatetruecolor')) {
            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move($absoluteDir, $name);
            return trim($relativeDir, '/').'/'.$name;
        }

        $src = null;
        if ($mime === 'image/jpeg') {
            $src = @imagecreatefromjpeg($tmpPath);
        } elseif ($mime === 'image/png') {
            $src = @imagecreatefrompng($tmpPath);
        } elseif ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) {
            $src = @imagecreatefromwebp($tmpPath);
        }

        if (!$src) {
            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move($absoluteDir, $name);
            return trim($relativeDir, '/').'/'.$name;
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);

        $dstW = $srcW;
        $dstH = $srcH;

        $dst = imagecreatetruecolor($dstW, $dstH);

        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $dstW, $dstH, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBase = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $baseName) ?: 'image';
        $nameBase = time().'_'.uniqid().'_'.$safeBase;

        $relativePath = '';
        $absolutePath = '';

        if (function_exists('imagewebp')) {
            $fileName = $nameBase.'.webp';
            $relativePath = trim($relativeDir, '/').'/'.$fileName;
            $absolutePath = $absoluteDir.DIRECTORY_SEPARATOR.$fileName;
            imagewebp($dst, $absolutePath, $quality);
        } else {
            $fileName = $nameBase.'.jpg';
            $relativePath = trim($relativeDir, '/').'/'.$fileName;
            $absolutePath = $absoluteDir.DIRECTORY_SEPARATOR.$fileName;
            imagejpeg($dst, $absolutePath, $quality);
        }

        imagedestroy($src);
        imagedestroy($dst);

        if (!file_exists($absolutePath)) {
            $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move($absoluteDir, $name);
            return trim($relativeDir, '/').'/'.$name;
        }

        return $relativePath;
    }

    public function index()
    {
        $tours = Tour::with(['category','subcategory'])
                    ->latest()
                    ->get();

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.tours.create', compact('categories'));
    }

    /**
     * Validation rules for tour create/update.
     */
    protected function tourValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'title'              => 'nullable|string|max:255',
            'location'           => 'nullable|string|max:255',
            'language'           => 'nullable|string|max:100',
            'star_rating'        => 'nullable|integer|min:1|max:5',
            'category_id'        => 'nullable|exists:categories,id',
            'subcategory_id'     => 'nullable|exists:categories,id',
            'tour_duration'      => 'nullable|string|max:255',
            'price'              => 'nullable|numeric|min:0',
            'special_discount'   => 'nullable|numeric|min:0',
            'day'                => 'nullable|string|max:255',
            'max_people'         => 'nullable|integer|min:1',
            'min_age'            => 'nullable|integer|min:0|max:120',
            'bedroom'            => 'nullable|string|max:255',
            'friday_date'        => 'nullable|date',
            'pickup'             => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'what_to_expect'     => 'nullable|string',
            'price_includes'     => 'nullable',
            'departure_return_location' => 'nullable',
            'available_dates'    => 'nullable|string',
            // Schedule fields
            'schedule_type'      => 'nullable|in:weekly,specific,open',
            'schedule_days'      => 'nullable|array',
            'schedule_days.*'    => 'nullable|integer|min:0|max:6',
            'specific_dates'     => 'nullable|string',
        ];
        $rules['image'] = $isUpdate
            ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
            : 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';
        $rules['gallery_images'] = 'nullable|array';
        $rules['gallery_images.*'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';
        $rules['pdf'] = $isUpdate
            ? 'nullable|mimes:pdf|max:15360'
            : 'nullable|mimes:pdf|max:15360';
        return $rules;
    }

    public function store(Request $request)
    {
        $request->validate($this->tourValidationRules(false));

        $data = $request->all();

        // ✅ Status and GST toggle
        // Set friday_date to the next upcoming Friday (Automated)
        $nextFriday = Carbon::now()->next(Carbon::FRIDAY);
        $data['friday_date'] = $nextFriday->toDateString();

        // Process 'available_dates' as 'Closed/Blocked' dates
        if ($request->available_dates) {
            $data['available_dates'] = array_values(array_filter(array_map('trim', explode(',', $request->available_dates))));
        } else {
            $data['available_dates'] = [];
        }

        // === Schedule Fields ===
        $data['schedule_type'] = $request->schedule_type ?? 'open';
        if ($data['schedule_type'] === 'weekly') {
            $data['schedule_days']   = array_map('intval', $request->schedule_days ?? []);
            $data['specific_dates']  = [];
        } elseif ($data['schedule_type'] === 'specific') {
            $data['specific_dates']  = array_values(array_filter(array_map('trim', explode(',', $request->specific_dates ?? ''))));
            $data['schedule_days']   = [];
        } else {
            $data['schedule_days']   = [];
            $data['specific_dates']  = [];
        }

        /* ===============================
           MAIN IMAGE UPLOAD (public/uploads/tours)
        ================================*/
        if ($request->hasFile('image')) {
            $data['image'] = $this->storeCompressedImage($request->file('image'), 'uploads/tours');
        }

        /* ===============================
           GALLERY IMAGES (other images - multiple)
        ================================*/
        if ($request->hasFile('gallery_images')) {
            $paths = [];
            foreach ($request->file('gallery_images') as $file) {
                $paths[] = $this->storeCompressedImage($file, 'uploads/tours/gallery');
            }
            $data['gallery_images'] = $paths;
        }
    
        /* ===============================
           PDF UPLOAD (public/uploads)
        ================================*/
        if ($request->hasFile('pdf')) {
            $pdfName = time().'_'.$request->pdf->getClientOriginalName();
            $request->pdf->move(public_path('uploads/tours'), $pdfName);
            $data['pdf'] = 'uploads/tours/'.$pdfName;
        }
    
        // ✅ Multi Inputs
        $data['price_includes'] = $request->price_includes
            ? explode(',', $request->price_includes)
            : [];
    
        $data['departure_return_location'] = $request->departure_return_location
            ? explode(',', $request->departure_return_location)
            : [];
        
         $data['day'] = $request->day
            ? explode(',', $request->day)
            : []; 
        
         $data['what_to_expect'] = $request->what_to_expect
            ? explode(',', $request->what_to_expect)
            : [];     
    
        // ✅ Travel Plan
        if ($request->question) {
            $plans = [];
            foreach ($request->question as $i => $q) {
                if (!empty($q) || !empty($request->answer[$i])) {
                    $plans[] = [
                        'question' => $q,
                        'answer'   => $request->answer[$i] ?? ''
                    ];
                }
            }
            $data['travel_plan'] = $plans;
        }
    
        Tour::create($data);

        Cache::forget('home_tours');
        Cache::forget('home_discountedTours');
    
        return redirect()->route('tours.index')
            ->with('success', 'Tour created successfully');
    }


    public function edit($slug)
    {  
        $tour = Tour::where('slug', $slug)->firstOrFail();

        $categories = Category::whereNull('parent_id')->get();
        $subcategories = Category::where('parent_id',$tour->category_id)->get();

        return view('admin.tours.edit',
            compact('tour','categories','subcategories'));
    }


    public function update(Request $request, $slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();

        $request->validate($this->tourValidationRules(true));

        /* ===============================
        BASIC DATA
        ================================*/
        $data = [
            'title' => $request->title,
            'location' => $request->location,
            'language' => $request->language,
            'star_rating' => $request->star_rating,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'tour_duration' => $request->tour_duration,

            'price' => $request->price,
            'special_discount' => $request->special_discount,
            'discount_status' => $request->discount_status ?? 0,
            
            'max_people' => $request->max_people,
            'min_age' => $request->min_age,
            'bedroom' => $request->bedroom,
            'friday_date' => Carbon::now()->next(Carbon::FRIDAY)->toDateString(),
            'pickup' => $request->pickup,
            'departure_time' => $request->departure_time,

            'description' => $request->description,

            'status' => $request->has('status') ? 1 : 0,
            
            'available_dates'   => $request->available_dates
                ? array_values(array_filter(array_map('trim', explode(',', $request->available_dates))))
                : [],

            // === Schedule Fields ===
            'schedule_type'  => $request->schedule_type ?? 'open',
            'schedule_days'  => $request->schedule_type === 'weekly'
                ? array_map('intval', $request->schedule_days ?? [])
                : [],
            'specific_dates' => $request->schedule_type === 'specific'
                ? array_values(array_filter(array_map('trim', explode(',', $request->specific_dates ?? ''))))
                : [],
        ];

            /* ===============================
       MAIN IMAGE UPDATE (public/uploads/tours)
    ================================*/
    if ($request->hasFile('image')) {
        if ($tour->image && file_exists(public_path($tour->image))) {
            @unlink(public_path($tour->image));
        }
        $data['image'] = $this->storeCompressedImage($request->file('image'), 'uploads/tours');
    }

    /* ===============================
       GALLERY IMAGES (other images - multiple)
    ================================*/
    if ($request->hasFile('gallery_images')) {
        $existing = is_array($tour->gallery_images) ? $tour->gallery_images : [];
        foreach ($existing as $path) {
            if ($path && file_exists(public_path($path))) {
                @unlink(public_path($path));
            }
        }
        $paths = [];
        foreach ($request->file('gallery_images') as $file) {
            $paths[] = $this->storeCompressedImage($file, 'uploads/tours/gallery');
        }
        $data['gallery_images'] = $paths;
    }

    /* ===============================
       PDF UPDATE (public/uploads)
    ================================*/
    if ($request->hasFile('pdf')) {

        // old pdf delete
        if ($tour->pdf && file_exists(public_path($tour->pdf))) {
            unlink(public_path($tour->pdf));
        }

        $pdfName = time().'_'.$request->pdf->getClientOriginalName();
        $request->pdf->move(public_path('uploads/tours'), $pdfName);
        $data['pdf'] = 'uploads/tours/'.$pdfName;
    }

        /* ===============================
        MULTI INPUT (ARRAY)
        ================================*/
     // ✅ Price Includes
            if ($request->filled('price_includes')) {
                $data['price_includes'] = array_filter(
                    explode(',', $request->price_includes)
                );
            }

            // ✅ Departure / Exclusions
            if ($request->filled('departure_return_location')) {
                $data['departure_return_location'] = array_filter(
                    explode(',', $request->departure_return_location)
                );
            }

            // ✅ Day
            if ($request->filled('day')) {
                $data['day'] = array_filter(
                    explode(',', $request->day)
                );
            }

            // ✅ What to Expect
            if ($request->filled('what_to_expect')) {
                $data['what_to_expect'] = array_filter(
                    explode(',', $request->what_to_expect)
                );
            }

        /* ===============================
        TRAVEL PLAN (Q&A)
        ================================*/
        $travelPlan = [];
        if ($request->question && $request->answer) {
            foreach ($request->question as $i => $q) {
                if (!empty($q) || !empty($request->answer[$i])) {
                    $travelPlan[] = [
                        'question' => $q,
                        'answer'   => $request->answer[$i],
                    ];
                }
            }
        }
        $data['travel_plan'] = $travelPlan;

        /* ===============================
        UPDATE
        ================================*/
        $tour->update($data);

        Cache::forget('home_tours');
        Cache::forget('home_discountedTours');

        return redirect()
            ->route('tours.index')
            ->with('success', 'Tour updated successfully');
    }


public function destroy($slug)
{
    $tour = Tour::where('slug', $slug)->firstOrFail();

    /* ===============================
       DELETE MAIN IMAGE
    ================================*/
    if ($tour->image && file_exists(public_path($tour->image))) {
        @unlink(public_path($tour->image));
    }

    /* ===============================
       DELETE GALLERY IMAGES
    ================================*/
    if (!empty($tour->gallery_images) && is_array($tour->gallery_images)) {
        foreach ($tour->gallery_images as $path) {
            if ($path && file_exists(public_path($path))) {
                @unlink(public_path($path));
            }
        }
    }

    /* ===============================
       DELETE PDF (public/uploads)
    ================================*/
    if ($tour->pdf && file_exists(public_path($tour->pdf))) {
        unlink(public_path($tour->pdf));
    }

    /* ===============================
       DELETE RECORD
    ================================*/
    $tour->delete();

    Cache::forget('home_tours');
    Cache::forget('home_discountedTours');

    return redirect()
        ->route('tours.index')
        ->with('success', 'Tour deleted successfully');
}

    /**
     * Export tours as a ZIP archive containing XLSX and media folder.
     */
    public function exportArchive()
    {
        $tempDir = storage_path('app/temp/tours_export_' . time());
        $mediaDir = $tempDir . '/media';
        File::ensureDirectoryExists($mediaDir);

        $tours = Tour::orderBy('id')->get();
        foreach ($tours as $tour) {
            if ($tour->image && file_exists(public_path($tour->image))) {
                $ext = pathinfo($tour->image, PATHINFO_EXTENSION);
                copy(public_path($tour->image), $mediaDir . '/' . $tour->id . '_main.' . $ext);
            }
            if ($tour->pdf && file_exists(public_path($tour->pdf))) {
                $ext = pathinfo($tour->pdf, PATHINFO_EXTENSION);
                copy(public_path($tour->pdf), $mediaDir . '/' . $tour->id . '_pdf.' . $ext);
            }
            if (!empty($tour->gallery_images) && is_array($tour->gallery_images)) {
                foreach ($tour->gallery_images as $i => $path) {
                    if ($path && file_exists(public_path($path))) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        copy(public_path($path), $mediaDir . '/' . $tour->id . '_gallery_' . $i . '.' . $ext);
                    }
                }
            }
        }

        $xlsxPath = $tempDir . '/tours.xlsx';
        $xlsxContent = Excel::raw(new ToursExport(true), ExcelType::XLSX);
        File::put($xlsxPath, $xlsxContent);

        $zipPath = storage_path('app/temp/tours_archive_' . time() . '.zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            File::deleteDirectory($tempDir);
            return redirect()->route('tours.index')->with('error', 'Could not create archive.');
        }
        $zip->addFile($xlsxPath, 'tours.xlsx');
        foreach (File::allFiles($mediaDir) as $file) {
            $zip->addFile($file->getRealPath(), 'media/' . $file->getFilename());
        }
        $zip->close();
        File::deleteDirectory($tempDir);

        return response()->download($zipPath, 'tours_archive.zip')->deleteFileAfterSend(true);
    }

    /**
     * Import tours from a ZIP archive (XLSX + media).
     */
    public function importArchive(Request $request)
    {
        $request->validate([
            'archive' => 'required|file|mimes:zip|max:102400',
        ], [
            'archive.required' => 'Please select a ZIP archive.',
            'archive.mimes'   => 'The file must be a ZIP archive.',
            'archive.max'     => 'The archive may not be greater than 100 MB.',
        ]);

        $zipPath = $request->file('archive')->getRealPath();
        $extractDir = storage_path('app/temp/tours_import_' . time());
        File::ensureDirectoryExists($extractDir);

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return redirect()->route('tours.index')->with('error', 'Invalid or corrupted ZIP file.');
        }
        $zip->extractTo($extractDir);
        $zip->close();

        $xlsxPath = $extractDir . '/tours.xlsx';
        $basePath = $extractDir;
        if (!file_exists($xlsxPath)) {
            $dirs = array_filter(glob($extractDir . '/*'), 'is_dir');
            if (count($dirs) === 1) {
                $basePath = $dirs[0];
                $xlsxPath = $basePath . '/tours.xlsx';
            }
        }
        if (!file_exists($xlsxPath)) {
            File::deleteDirectory($extractDir);
            return redirect()->route('tours.index')->with('error', 'Archive must contain tours.xlsx at root or inside a single folder.');
        }

        try {
            Excel::import(new ToursImport($basePath), $xlsxPath);
        } catch (\Throwable $e) {
            File::deleteDirectory($extractDir);
            return redirect()->route('tours.index')->with('error', 'Import failed: ' . $e->getMessage());
        }
        File::deleteDirectory($extractDir);

        return redirect()->route('tours.index')->with('success', 'Tours imported from archive successfully.');
    }
}

