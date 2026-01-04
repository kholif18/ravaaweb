<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ServiceCategoryResource;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Filter by category
        if ($request->has('category')) {
            $category = ServiceCategory::where('slug', $request->category)
                ->orWhere('id', $request->category)
                ->first();
            
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter active only
        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        // Filter popular only
        if ($request->boolean('popular_only', false)) {
            $query->popular();
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination or all
        if ($request->boolean('paginate', true)) {
            $perPage = $request->get('per_page', 12);
            $services = $query->with('category')->paginate($perPage);
            return ServiceResource::collection($services);
        }

        $services = $query->with('category')->get();
        return ServiceResource::collection($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('services/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $service = Service::create($data);

        // Update category services count
        $service->updateCategoryCount();

        return response()->json([
            'message' => 'Layanan berhasil ditambahkan',
            'data' => new ServiceResource($service->load('category'))
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari berdasarkan ID atau slug
        $service = Service::where('id', $id)
            ->orWhere('slug', $id)
            ->with(['category', 'reviews'])
            ->firstOrFail();

        // Increment views
        $service->incrementViews();

        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($service->gallery) {
                foreach ($service->gallery as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('services/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $service->update($data);

        return response()->json([
            'message' => 'Layanan berhasil diperbarui',
            'data' => new ServiceResource($service->fresh()->load('category'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Delete associated images
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        if ($service->gallery) {
            foreach ($service->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $service->delete();

        // Update category services count
        $service->updateCategoryCount();

        return response()->json([
            'message' => 'Layanan berhasil dihapus'
        ]);
    }

    /**
     * Get services by category
     */
    public function byCategory($categorySlug)
    {
        $category = ServiceCategory::where('slug', $categorySlug)
            ->orWhere('id', $categorySlug)
            ->firstOrFail();

        $services = $category->services()
            ->active()
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return response()->json([
            'category' => new ServiceCategoryResource($category),
            'services' => ServiceResource::collection($services)
        ]);
    }

    /**
     * Get popular services
     */
    public function popular()
    {
        $services = Service::with('category')
            ->active()
            ->popular()
            ->orderBy('order')
            ->limit(8)
            ->get();

        return ServiceResource::collection($services);
    }

    /**
     * Increment views
     */
    public function incrementViews(Service $service)
    {
        $service->incrementViews();
        
        return response()->json([
            'message' => 'View count incremented',
            'views_count' => $service->views_count
        ]);
    }
}
