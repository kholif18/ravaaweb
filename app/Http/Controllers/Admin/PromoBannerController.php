<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromoBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Database\Seeders\PromoBannerSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PromoBannerController extends Controller
{
    public function index()
    {
        $promo = PromoBanner::first();
        return view('admin.home.promo', compact('promo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:200',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string|max:100',
            'cta_text' => 'required|string|max:200',
            'whatsapp_number' => 'required|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'color' => 'required|in:primary,success,warning,danger,purple',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:start_date',
            'status' => 'boolean',
            'remove_image' => 'boolean'
        ]);

        $promo = PromoBanner::firstOrNew([]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($promo->image_url) {
                Storage::delete($promo->image_url);
            }
            
            $path = $request->file('image')->store('promo-banners', 'public');
            $validated['image_url'] = $path;
        } elseif ($request->has('remove_image') && $promo->image_url) {
            Storage::delete($promo->image_url);
            $validated['image_url'] = null;
        }

        $validated['status'] = $request->boolean('status');

        $promo->fill($validated);
        $promo->save();

        return redirect()->route('admin.home.promo')
            ->with('success', 'Promo banner berhasil diperbarui!');
    }

    public function preview()
    {
        $promo = PromoBanner::where('status', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('expiry_date', '>=', now())
            ->first();

        return view('frontend.promo-preview', compact('promo'));
    }

    public function reset()
    {
        // Hapus gambar jika ada
        $promo = PromoBanner::first();
        if ($promo && $promo->image_url) {
            Storage::disk('public')->delete($promo->image_url);
        }

        // Reset via seeder
        Artisan::call('db:seed', [
            '--class' => PromoBannerSeeder::class,
            '--force' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo banner berhasil dikembalikan ke default'
        ]);
    }
}
