<?php

namespace App\Imports;

use App\Models\Tour;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ToursImport implements ToModel, WithHeadingRow, WithValidation
{
    protected ?string $mediaBasePath = null;

    public function __construct(?string $mediaBasePath = null)
    {
        $this->mediaBasePath = $mediaBasePath;
    }

    /**
     * Find or create a category (parent category) by name.
     */
    protected function findOrCreateCategory(string $categoryName): ?int
    {
        if (empty(trim($categoryName))) {
            return null;
        }

        $categoryName = trim($categoryName);
        
        // Find existing category (parent category only)
        $category = Category::where('name', $categoryName)
            ->whereNull('parent_id')
            ->first();

        if (!$category) {
            // Create new parent category
            $category = Category::create([
                'name' => $categoryName,
                'parent_id' => null,
                'status' => 1,
            ]);
        }

        return $category->id;
    }

    /**
     * Find or create a subcategory by name and parent category.
     */
    protected function findOrCreateSubcategory(string $subcategoryName, int $categoryId): ?int
    {
        if (empty(trim($subcategoryName))) {
            return null;
        }

        $subcategoryName = trim($subcategoryName);
        
        // Find existing subcategory with the same parent
        $subcategory = Category::where('name', $subcategoryName)
            ->where('parent_id', $categoryId)
            ->first();

        if (!$subcategory) {
            // Create new subcategory
            $subcategory = Category::create([
                'name' => $subcategoryName,
                'parent_id' => $categoryId,
                'status' => 1,
            ]);
        }

        return $subcategory->id;
    }

    protected function resolveFile(string $archivePath): ?string
    {
        if (!$this->mediaBasePath || !trim($archivePath)) {
            return null;
        }
        $fullPath = $this->mediaBasePath . '/' . ltrim(str_replace('\\', '/', $archivePath), '/');
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            return null;
        }
        return $fullPath;
    }

    protected function copyToUploads(string $fullPath, string $subdir): string
    {
        $targetDir = public_path('uploads/tours/' . $subdir);
        File::ensureDirectoryExists($targetDir);
        $name = time() . '_' . uniqid() . '_' . basename($fullPath);
        $destPath = 'uploads/tours/' . $subdir . '/' . $name;
        copy($fullPath, public_path($destPath));
        return $destPath;
    }

    public function model(array $row)
    {
        $imagePath = null;
        $pdfPath = null;
        $galleryImages = [];

        if ($this->mediaBasePath) {
            $img = $row['image'] ?? null;
            if ($img && trim($img) !== '') {
                $full = $this->resolveFile(trim($img));
                if ($full) {
                    $imagePath = $this->copyToUploads($full, '');
                }
            }
            $pdf = $row['pdf'] ?? null;
            if ($pdf && trim($pdf) !== '') {
                $full = $this->resolveFile(trim($pdf));
                if ($full) {
                    $pdfPath = $this->copyToUploads($full, '');
                }
            }
            $gallery = $row['gallery_images'] ?? null;
            if ($gallery && trim($gallery) !== '') {
                foreach (explode(',', $gallery) as $path) {
                    $path = trim($path);
                    if ($path === '') continue;
                    $full = $this->resolveFile($path);
                    if ($full) {
                        $galleryImages[] = $this->copyToUploads($full, 'gallery');
                    }
                }
            }
        }

        $priceIncludes = $row['price_includes'] ?? null;
        if (is_string($priceIncludes) && $priceIncludes !== '') {
            $decoded = json_decode($priceIncludes, true);
            $priceIncludes = is_array($decoded) ? $decoded : (array_filter(explode(',', $priceIncludes)));
        } else {
            $priceIncludes = [];
        }

        $departureReturn = $row['departure_return_location'] ?? null;
        if (is_string($departureReturn) && $departureReturn !== '') {
            $decoded = json_decode($departureReturn, true);
            $departureReturn = is_array($decoded) ? $decoded : (array_filter(explode(',', $departureReturn)));
        } else {
            $departureReturn = [];
        }

        $whatToExpect = $row['what_to_expect'] ?? null;
        if (is_string($whatToExpect) && $whatToExpect !== '') {
            $decoded = json_decode($whatToExpect, true);
            $whatToExpect = is_array($decoded) ? $decoded : (array_filter(explode(',', $whatToExpect)));
        } else {
            $whatToExpect = [];
        }

        $day = $row['day'] ?? null;
        if (is_string($day) && $day !== '') {
            $decoded = json_decode($day, true);
            $day = is_array($decoded) ? $decoded : (array_filter(explode(',', $day)));
        } else {
            $day = [];
        }

        $travelPlan = $row['travel_plan'] ?? null;
        if (is_string($travelPlan) && $travelPlan !== '') {
            $decoded = json_decode($travelPlan, true);
            $travelPlan = is_array($decoded) ? $decoded : [];
        } else {
            $travelPlan = [];
        }

        $status = isset($row['status']) && (strtolower($row['status']) === 'active' || $row['status'] === 1) ? 1 : 0;

        // Handle category and subcategory by name
        $categoryId = null;
        $subcategoryId = null;

        // Get category name (support both 'category' and 'category_id' for backward compatibility)
        $categoryName = $row['category'] ?? $row['category_id'] ?? null;
        if ($categoryName) {
            // If it's numeric, treat as ID (backward compatibility)
            if (is_numeric($categoryName)) {
                $categoryId = (int) $categoryName;
            } else {
                // It's a name, find or create
                $categoryId = $this->findOrCreateCategory($categoryName);
            }
        }

        // Get subcategory name (support both 'subcategory' and 'subcategory_id' for backward compatibility)
        $subcategoryName = $row['subcategory'] ?? $row['subcategory_id'] ?? null;
        if ($subcategoryName && $categoryId) {
            // If it's numeric, treat as ID (backward compatibility)
            if (is_numeric($subcategoryName)) {
                $subcategoryId = (int) $subcategoryName;
            } else {
                // It's a name, find or create with parent category
                $subcategoryId = $this->findOrCreateSubcategory($subcategoryName, $categoryId);
            }
        }

        return new Tour([
            'title' => $row['title'] ?? '',
            'location' => $row['location'] ?? null,
            'language' => $row['language'] ?? null,
            'star_rating' => isset($row['star_rating']) ? (int) $row['star_rating'] : null,
            'image' => $imagePath,
            'gallery_images' => $galleryImages,
            'pdf' => $pdfPath,
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId,
            'tour_duration' => isset($row['tour_duration']) && $row['tour_duration'] !== '' ? (int) $row['tour_duration'] : null,
            'price' => isset($row['price']) && $row['price'] !== '' ? $row['price'] : null,
            'two_person_share' => $row['two_person_share'] ?? null,
            'three_person_share' => $row['three_person_share'] ?? null,
            'special_discount' => $row['special_discount'] ?? null,
            'discount_status' => isset($row['discount_status']) ? (int) $row['discount_status'] : 0,
            'max_people' => isset($row['max_people']) && $row['max_people'] !== '' ? (int) $row['max_people'] : null,
            'min_age' => isset($row['min_age']) && $row['min_age'] !== '' ? (int) $row['min_age'] : null,
            'bedroom' => isset($row['bedroom']) && $row['bedroom'] !== '' ? (int) $row['bedroom'] : null,
            'friday_date' => !empty($row['friday_date']) ? $row['friday_date'] : null,
            'pickup' => $row['pickup'] ?? null,
            'departure_time' => !empty($row['departure_time']) ? $row['departure_time'] : null,
            'description' => $row['description'] ?? null,
            'what_to_expect' => $whatToExpect,
            'day' => $day,
            'price_includes' => $priceIncludes,
            'departure_return_location' => $departureReturn,
            'travel_plan' => $travelPlan,
            'status' => $status,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }
}
