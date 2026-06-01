<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar_url' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        Testimonial::create($validated);
        return redirect()->back()->with('success', 'Testimonial berhasil ditambahkan!');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar_url' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $testimonial->update($validated);
        return redirect()->back()->with('success', 'Testimonial berhasil diperbarui!');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial berhasil dihapus!');
    }
}
