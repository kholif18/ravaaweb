<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->orderBy('order')->paginate(10);
        return view('admin.services.content', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:service_categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Service::create($validated);
        return redirect()->route('admin.services.content')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:service_categories,id',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $service->update($validated);
        return redirect()->route('admin.services.content')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('admin.services.content')->with('success', 'Layanan berhasil dihapus!');
    }
}
