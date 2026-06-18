<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount('services')->orderBy('order')->get();
        return view('admin.service-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        ServiceCategory::create($validated);
        return redirect()->back()->with('success', 'Kategori layanan berhasil ditambahkan!');
    }

    public function update(Request $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $serviceCategory->update($validated);
        return redirect()->back()->with('success', 'Kategori layanan berhasil diperbarui!');
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        if ($serviceCategory->services()->exists()) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki layanan.');
        }

        $serviceCategory->delete();
        return redirect()->back()->with('success', 'Kategori layanan berhasil dihapus!');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids'), true);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $categories = ServiceCategory::whereIn('id', $ids)->get();
        $canDelete = true;
        foreach ($categories as $category) {
            if ($category->services()->exists()) {
                $canDelete = false;
                break;
            }
        }

        if (!$canDelete) {
            return redirect()->back()->with('error', 'Beberapa kategori tidak bisa dihapus karena masih memiliki layanan.');
        }

        ServiceCategory::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', count($ids) . ' kategori berhasil dihapus!');
    }
}
