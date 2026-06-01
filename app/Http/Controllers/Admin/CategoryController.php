<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::with('parent')
            ->withCount('products')
            ->ordered();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by parent
        if ($parent = $request->input('parent')) {
            if ($parent === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $parent);
            }
        }

        // Paginate
        $categories = $query->paginate($request->input('per_page', 10))
            ->withQueryString();

        // Get all active categories for dropdown with hierarchy
        $allActiveCategories = Category::active()->ordered()->get(['id', 'name', 'parent_id']);
        $parentCategories = $this->formatCategoriesForDropdown($allActiveCategories);

        if ($request->ajax()) {
            return view('admin.categories._table', compact('categories'))->render();
        }

        return view('admin.categories.index', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
            'filters' => $request->only(['search', 'status', 'parent', 'per_page']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Default icon if not provided
        if (empty($validated['icon'])) {
            $validated['icon'] = 'fas fa-tags';
        }

        try {
            DB::beginTransaction();

            Category::create($validated);

            DB::commit();

            // Return JSON response for AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil ditambahkan!'
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON response for AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Optional - hanya jika dibutuhkan halaman detail
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', [
            'category' => $category->load(['parent', 'children', 'products']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * Mengembalikan JSON untuk modal
     */
    public function edit(Category $category)
    {
        try {
            // Get all active categories except self and its descendants for parent candidates
            $descendantIds = $this->getDescendantIds($category);
            $excludeIds = array_merge([$category->id], $descendantIds);
            
            $categories = Category::active()
                ->whereNotIn('id', $excludeIds)
                ->ordered()
                ->get(['id', 'name', 'parent_id']);
            
            $parentCategories = $this->formatCategoriesForDropdown($categories);
            
            // Always return JSON for this endpoint
            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'icon' => $category->icon,
                    'order' => $category->order,
                    'status' => $category->status,
                    'parent_id' => $category->parent_id,
                    'meta_title' => $category->meta_title,
                    'meta_description' => $category->meta_description,
                    'meta_keywords' => $category->meta_keywords,
                    'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $category->updated_at->format('Y-m-d H:i:s'),
                ],
                'parent_categories' => $parentCategories
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Prevent circular reference (check self and all descendants)
        if ($validated['parent_id']) {
            if ($validated['parent_id'] == $category->id) {
                $errorMessage = 'Kategori tidak dapat menjadi parent dari dirinya sendiri.';
            } else {
                $descendantIds = $this->getDescendantIds($category);
                if (in_array($validated['parent_id'], $descendantIds)) {
                    $errorMessage = 'Kategori tidak dapat menjadi sub-kategori dari anaknya sendiri.';
                }
            }

            if (isset($errorMessage)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage
                    ], 422);
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        try {
            DB::beginTransaction();

            $category->update($validated);

            DB::commit();

            // Return JSON response for AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil diperbarui!'
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON response for AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki produk.');
        }

        // Check if category has children
        if ($category->children()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki sub-kategori. Hapus sub-kategori terlebih dahulu.');
        }

        try {
            DB::beginTransaction();

            $category->delete();

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete categories.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
        ]);

        // Convert JSON string to array if needed
        $ids = is_string($validated['ids']) ? json_decode($validated['ids'], true) : $validated['ids'];

        // Check if any category has products or children
        $invalidCategories = Category::whereIn('id', $ids)
            ->where(function ($query) {
                $query->has('products')
                    ->orHas('children');
            })
            ->get();

        if ($invalidCategories->isNotEmpty()) {
            $categoryNames = $invalidCategories->pluck('name')->implode(', ');
            
            return redirect()->back()
                ->with('error', "Kategori berikut tidak dapat dihapus karena memiliki produk atau sub-kategori: {$categoryNames}");
        }

        try {
            DB::beginTransaction();

            Category::whereIn('id', $ids)->delete();

            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', count($ids) . ' kategori berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update category status.
     */
    public function updateStatus(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validated);

        return redirect()->back()
            ->with('success', 'Status kategori berhasil diperbarui!');
    }

    /**
     * Get categories for dropdown.
     */
    public function getCategoriesForDropdown(Request $request)
    {
        $categories = Category::active()
            ->ordered()
            ->when($request->input('exclude'), function ($query, $excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->get(['id', 'name', 'parent_id']);

        return response()->json([
            'categories' => $this->formatCategoriesForDropdown($categories),
        ]);
    }

    /**
     * Format categories for dropdown with hierarchy.
     */
    private function formatCategoriesForDropdown($categories, $parentId = null, $level = 0)
    {
        $result = [];
        
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->name = str_repeat('— ', $level) . $category->name;
                $result[] = $category;
                
                $children = $this->formatCategoriesForDropdown($categories, $category->id, $level + 1);
                $result = array_merge($result, $children);
            }
        }
        
        return $result;
    }

    /**
     * Get all descendant IDs of a category.
     */
    private function getDescendantIds(Category $category): array
    {
        $descendantIds = [];
        
        $getIds = function ($category) use (&$getIds, &$descendantIds) {
            foreach ($category->children as $child) {
                $descendantIds[] = $child->id;
                $getIds($child);
            }
        };
        
        $getIds($category);
        
        return $descendantIds;
    }
}