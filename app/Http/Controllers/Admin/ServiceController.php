<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $services = $query->orderBy('order')->orderBy('name')
            ->paginate($request->input('per_page', 15))
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.services._table', compact('services'))->render();
        }

        return view('admin.services.index', [
            'services' => $services,
            'filters' => $request->only(['search', 'status', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:services,name',
            'slug'     => 'nullable|string|max:255|unique:services,slug',
            'icon'     => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'order'    => 'required|integer|min:0',
            'status'   => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        Service::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Layanan berhasil ditambahkan!']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return response()->json([
            'success' => true,
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:services,name,' . $service->id,
            'slug'     => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'icon'     => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'order'    => 'required|integer|min:0',
            'status'   => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $service->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Layanan berhasil diperbarui!']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada layanan yang dipilih.');
        }

        Service::whereIn('id', $ids)->delete();

        return redirect()->route('admin.services.index')
            ->with('success', count($ids) . ' layanan berhasil dihapus!');
    }

    public function updateStatus(Request $request, Service $service)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        return redirect()->back()
            ->with('success', 'Status layanan berhasil diperbarui!');
    }
}
