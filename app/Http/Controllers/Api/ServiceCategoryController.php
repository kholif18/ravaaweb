<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceCategoryRequest;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ServiceCategory::query();

        // Filter aktif saja
        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination atau semua data
        if ($request->has('paginate') && $request->boolean('paginate', true)) {
            $perPage = $request->get('per_page', 15);
            $categories = $query->paginate($perPage);
            return ServiceCategoryResource::collection($categories);
        }

        $categories = $query->get();
        return ServiceCategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceCategoryRequest $request)
    {
        $category = ServiceCategory::create($request->validated());

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => new ServiceCategoryResource($category)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari berdasarkan ID atau slug
        $category = ServiceCategory::where('id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();

        // Load services jika diminta
        if (request()->boolean('with_services', false)) {
            $category->load('services');
        }

        return new ServiceCategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        $serviceCategory->update($request->validated());

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'data' => new ServiceCategoryResource($serviceCategory->fresh())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        // Cek apakah kategori memiliki layanan
        if ($serviceCategory->services()->exists()) {
            return response()->json([
                'message' => 'Tidak dapat menghapus kategori yang memiliki layanan'
            ], Response::HTTP_CONFLICT);
        }

        $serviceCategory->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    /**
     * Restore soft deleted category
     */
    public function restore($id)
    {
        $category = ServiceCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return response()->json([
            'message' => 'Kategori berhasil dipulihkan',
            'data' => new ServiceCategoryResource($category)
        ]);
    }

    /**
     * Update order of categories
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:service_categories,id',
            'categories.*.order' => 'required|integer'
        ]);

        foreach ($request->categories as $item) {
            ServiceCategory::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'message' => 'Urutan kategori berhasil diperbarui'
        ]);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(ServiceCategory $serviceCategory)
    {
        $serviceCategory->update([
            'is_active' => !$serviceCategory->is_active
        ]);

        $status = $serviceCategory->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json([
            'message' => "Kategori berhasil {$status}",
            'data' => new ServiceCategoryResource($serviceCategory)
        ]);
    }
}
