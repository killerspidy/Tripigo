<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Exports\BlogsExport;
use App\Imports\BlogsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
        ]);

        $data = $request->all();
        
        // Status
        $data['status'] = $request->has('status') ? 1 : 0;

        // Image Upload
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = 'uploads/blogs/'.$imageName;
        }

        Blog::create($data);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully');
    }

    public function edit($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'published_date' => $request->published_date,
            'status' => $request->has('status') ? 1 : 0,
        ];

        // Image Update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = 'uploads/blogs/'.$imageName;
        }

        $blog->update($data);

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog updated successfully');
    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Delete image
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        // Delete record
        $blog->delete();

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog deleted successfully');
    }

    public function export()
    {
        return Excel::download(new BlogsExport, 'blogs.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        Excel::import(new BlogsImport, $request->file('file'));

        return redirect()->route('blogs.index')
            ->with('success', 'Blogs imported successfully.');
    }

    /**
     * Export blogs as a ZIP archive containing XLSX and media folder.
     */
    public function exportArchive()
    {
        $tempDir = storage_path('app/temp/blogs_export_' . time());
        $mediaDir = $tempDir . '/media';
        File::ensureDirectoryExists($mediaDir);

        $blogs = Blog::orderBy('id')->get();
        foreach ($blogs as $blog) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                $destName = $blog->id . '_' . basename($blog->image);
                copy(public_path($blog->image), $mediaDir . '/' . $destName);
            }
        }

        $xlsxPath = $tempDir . '/blogs.xlsx';
        $xlsxContent = Excel::raw(new BlogsExport(true), ExcelType::XLSX);
        File::put($xlsxPath, $xlsxContent);

        $zipPath = storage_path('app/temp/blogs_archive_' . time() . '.zip');
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            File::deleteDirectory($tempDir);
            return redirect()->route('blogs.index')->with('error', 'Could not create archive.');
        }
        $zip->addFile($xlsxPath, 'blogs.xlsx');
        foreach (File::allFiles($mediaDir) as $file) {
            $zip->addFile($file->getRealPath(), 'media/' . $file->getFilename());
        }
        $zip->close();
        File::deleteDirectory($tempDir);

        return response()->download($zipPath, 'blogs_archive.zip')->deleteFileAfterSend(true);
    }

    /**
     * Import blogs from a ZIP archive (XLSX + media).
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
        $extractDir = storage_path('app/temp/blogs_import_' . time());
        File::ensureDirectoryExists($extractDir);

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return redirect()->route('blogs.index')->with('error', 'Invalid or corrupted ZIP file.');
        }
        $zip->extractTo($extractDir);
        $zip->close();

        // Accept blogs.xlsx at root or inside a single top-level folder (e.g. when user zips the folder)
        $xlsxPath = $extractDir . '/blogs.xlsx';
        $basePath = $extractDir;
        if (!file_exists($xlsxPath)) {
            $dirs = array_filter(glob($extractDir . '/*'), 'is_dir');
            if (count($dirs) === 1) {
                $basePath = $dirs[0];
                $xlsxPath = $basePath . '/blogs.xlsx';
            }
        }
        if (!file_exists($xlsxPath)) {
            File::deleteDirectory($extractDir);
            return redirect()->route('blogs.index')->with('error', 'Archive must contain blogs.xlsx at root or inside a single folder.');
        }

        try {
            Excel::import(new BlogsImport($basePath), $xlsxPath);
        } catch (\Throwable $e) {
            File::deleteDirectory($extractDir);
            return redirect()->route('blogs.index')->with('error', 'Import failed: ' . $e->getMessage());
        }
        File::deleteDirectory($extractDir);

        return redirect()->route('blogs.index')->with('success', 'Blogs imported from archive successfully.');
    }
}
