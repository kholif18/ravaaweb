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
        $categories = ServiceCategory::orderBy('order')->get();
        return view('admin.services.categories', compact('categories'));
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
        $serviceCategory->delete();
        return redirect()->back()->with('success', 'Kategori layanan berhasil dihapus!');
    }
}
