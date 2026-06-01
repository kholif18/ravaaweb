<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        Faq::create($validated);
        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $faq->update($validated);
        return redirect()->back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ berhasil dihapus!');
    }
}
