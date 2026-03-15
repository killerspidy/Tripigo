<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tour;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    // ============================================
    // CATEGORIES (PARENT CATEGORIES ONLY)
    // ============================================

    /**
     * Display a listing of parent categories only.
     */
    public function index()
    {  
        $categories = Category::whereNull('parent_id')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new parent category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created parent category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'parent_id' => null, // Always null for parent categories
            'status'    => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/categories');
            File::ensureDirectoryExists($dir);
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success','Category saved successfully');
    }

    /**
     * Show the form for editing a parent category.
     */
    public function edit(Category $category)
    {
        // Ensure this is a parent category
        if ($category->parent_id !== null) {
            return redirect()->route('categories.index')
                ->with('error', 'This is a subcategory. Please edit it from subcategories page.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update a parent category.
     */
    public function update(Request $request, Category $category)
    {
        // Ensure this is a parent category
        if ($category->parent_id !== null) {
            return redirect()->route('categories.index')
                ->with('error', 'This is a subcategory. Please update it from subcategories page.');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'parent_id' => null, // Always null for parent categories
            'status'    => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                @unlink(public_path($category->image));
            }
            $dir = public_path('uploads/categories');
            File::ensureDirectoryExists($dir);
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success','Category updated successfully');
    }

    /**
     * Remove a parent category (and its subcategories).
     */
    public function destroy(Category $category)
    {
        // Ensure this is a parent category
        if ($category->parent_id !== null) {
            return redirect()->route('categories.index')
                ->with('error', 'This is a subcategory. Please delete it from subcategories page.');
        }

        /* ===============================
           DELETE TOURS (CATEGORY & SUBCATEGORY)
        ================================*/
        Tour::where('category_id', $category->id)
            ->orWhere('subcategory_id', $category->id)
            ->delete();

        /* ===============================
           DELETE CATEGORY IMAGE
        ================================*/
        if (!empty($category->image)) {
            $imagePath = public_path($category->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        /* ===============================
           DELETE CHILD CATEGORIES + THEIR IMAGES
        ================================*/
        foreach ($category->children as $child) {
            // delete child category image
            if (!empty($child->image)) {
                $childImage = public_path($child->image);
                if (file_exists($childImage)) {
                    @unlink($childImage);
                }
            }

            // delete tours of sub-category
            Tour::where('subcategory_id', $child->id)->delete();

            $child->delete();
        }

        /* ===============================
           DELETE CATEGORY
        ================================*/
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Category deleted successfully');
    }

    // ============================================
    // SUBCATEGORIES (CHILD CATEGORIES)
    // ============================================

    /**
     * Display a listing of subcategories only.
     */
    public function subcategoriesIndex()
    {  
        $subcategories = Category::whereNotNull('parent_id')
            ->with('parent')
            ->latest()
            ->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function subcategoriesCreate()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.subcategories.create', compact('parents'));
    }

    /**
     * Store a newly created subcategory.
     */
    public function subcategoriesStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Ensure parent_id is a parent category
        $parent = Category::findOrFail($request->parent_id);
        if ($parent->parent_id !== null) {
            return redirect()->route('subcategories.index')
                ->with('error', 'Selected category is not a parent category.');
        }

        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status'    => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/categories');
            File::ensureDirectoryExists($dir);
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('subcategories.index')
            ->with('success','Subcategory saved successfully');
    }

    /**
     * Show the form for editing a subcategory.
     */
    public function subcategoriesEdit(Category $category)
    {
        // Ensure this is a subcategory
        if ($category->parent_id === null) {
            return redirect()->route('subcategories.index')
                ->with('error', 'This is a parent category. Please edit it from categories page.');
        }

        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.subcategories.edit', ['subcategory' => $category, 'parents' => $parents]);
    }

    /**
     * Update a subcategory.
     */
    public function subcategoriesUpdate(Request $request, Category $category)
    {
        // Ensure this is a subcategory
        if ($category->parent_id === null) {
            return redirect()->route('subcategories.index')
                ->with('error', 'This is a parent category. Please update it from categories page.');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'parent_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Ensure parent_id is a parent category
        $parent = Category::findOrFail($request->parent_id);
        if ($parent->parent_id !== null) {
            return redirect()->route('subcategories.index')
                ->with('error', 'Selected category is not a parent category.');
        }

        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'status'    => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                @unlink(public_path($category->image));
            }
            $dir = public_path('uploads/categories');
            File::ensureDirectoryExists($dir);
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        $category->update($data);

        return redirect()->route('subcategories.index')
            ->with('success','Subcategory updated successfully');
    }

    /**
     * Remove a subcategory.
     */
    public function subcategoriesDestroy(Category $category)
    {
        // Ensure this is a subcategory
        if ($category->parent_id === null) {
            return redirect()->route('subcategories.index')
                ->with('error', 'This is a parent category. Please delete it from categories page.');
        }

        /* ===============================
           DELETE TOURS OF SUBCATEGORY
        ================================*/
        Tour::where('subcategory_id', $category->id)->delete();

        /* ===============================
           DELETE SUBCATEGORY IMAGE
        ================================*/
        if (!empty($category->image)) {
            $imagePath = public_path($category->image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        /* ===============================
           DELETE SUBCATEGORY
        ================================*/
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Subcategory deleted successfully');
    }


    public function catTour(Request $request, $slug)
    {
        // Get selected categories from request (for filtering via checkboxes)
        $selectedCategoryIds = $request->get('categories', []);
        
        // Convert to array if it's a single value
        if (!is_array($selectedCategoryIds)) {
            $selectedCategoryIds = $selectedCategoryIds ? [$selectedCategoryIds] : [];
        }
        
        // Find main category by slug
        $category = Category::where('slug', $slug)->where('status', 1)->first();

        // If no categories selected via checkboxes but we have a slug, use that category
        if (empty($selectedCategoryIds) && $category) {
            $selectedCategoryIds = [$category->id];
        }
        
        // Ensure we have at least one category to work with
        if (empty($selectedCategoryIds)) {
            if ($category) {
                $selectedCategoryIds = [$category->id];
            } else {
                // Get first active parent category as default
                $defaultCategory = Category::whereNull('parent_id')
                    ->where('status', 1)
                    ->first();
                if ($defaultCategory) {
                    $selectedCategoryIds = [$defaultCategory->id];
                    $category = $defaultCategory;
                } else {
                    $tours = collect();
                    $category = null;
                    $categoriesWithCount = collect();
                    $sort = $request->get('sort', '');
                    return view('frontend.category_tours', compact('category', 'tours', 'categoriesWithCount', 'sort'));
                }
            }
        }

        // Build tours query based on selected categories
        $toursQuery = Tour::where('status', 1)
            ->where(function($query) use ($selectedCategoryIds) {
                $query->whereIn('category_id', $selectedCategoryIds)
                      ->orWhereIn('subcategory_id', $selectedCategoryIds);
            });

        $sort = $request->get('sort', '');
        if ($sort === 'price_asc') {
            $toursQuery->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $toursQuery->orderBy('price', 'desc');
        } else {
            $toursQuery->latest();
        }
        $tours = $toursQuery->get();

        $countsByCategory = Tour::where('status', 1)
            ->selectRaw('category_id, count(*) as c')
            ->groupBy('category_id')
            ->pluck('c', 'category_id');
        $countsBySubcategory = Tour::where('status', 1)
            ->selectRaw('subcategory_id, count(*) as c')
            ->groupBy('subcategory_id')
            ->pluck('c', 'subcategory_id');

        $categoriesWithCount = Category::where('status', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($cat) use ($countsByCategory, $countsBySubcategory) {
                $cat->tours_count = ($countsByCategory[$cat->id] ?? 0) + ($countsBySubcategory[$cat->id] ?? 0);
                return $cat;
            });

        return view('frontend.category_tours', compact('category', 'tours', 'categoriesWithCount', 'sort'));
    }


}
