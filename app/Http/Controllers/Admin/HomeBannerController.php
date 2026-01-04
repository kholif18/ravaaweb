<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateHomeBannerRequest;

class HomeBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $banner = HomeBanner::first();
        
        // If no banner exists, create a default one
        if (!$banner) {
            $banner = HomeBanner::create([
                'title' => 'Solusi Kreatif untuk Desain, Print & ATK Anda',
                'description' => 'Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif. Hasil kreatif yang memukau untuk kebutuhan bisnis Anda.',
                'button1_text' => 'Lihat Layanan',
                'button1_link' => '/layanan',
                'button2_text' => 'Portfolio Kami',
                'button2_link' => '/portofolio',
                'is_active' => true,
            ]);
        }
        
        return view('admin.home.banner', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomeBannerRequest $request)
    {
        $validated = $request->validated();
    
        $banner = HomeBanner::firstOrFail();
        
        if (!$banner) {
            $banner = new HomeBanner();
        }

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'button1_text' => $validated['button1_text'],
            'button1_link' => $validated['button1_link'],
            'button2_text' => $validated['button2_text'],
            'button2_link' => $validated['button2_link'],
        ];

        // Handle image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($banner->image && Storage::exists('public/banners/' . basename($banner->image))) {
                Storage::delete('public/banners/' . basename($banner->image));
            }

            // Store new image
            $imagePath = $request->file('banner_image')->store('banners', 'public');
            $data['image'] = $imagePath;
        }

        // Handle image removal
        if ($request->has('banner_image_remove') && $banner->image) {
            if (Storage::exists('public/banners/' . basename($banner->image))) {
                Storage::delete('public/banners/' . basename($banner->image));
            }
            $data['image'] = null;
        }

        // Update or create banner
        if ($banner->exists) {
            $banner->update($data);
        } else {
            $banner = HomeBanner::create($data);
        }

        return redirect()->route('admin.home.banner')
            ->with('success', 'Banner berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $imagePath = $request->file('image')->store('banners', 'public');
            
            return response()->json([
                'success' => true,
                'image_url' => Storage::url($imagePath),
                'image_path' => $imagePath,
                'message' => 'Gambar berhasil diupload',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload gambar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reset banner to default values
     */
    public function reset()
    {
        $banner = HomeBanner::firstOrFail();

        $banner->update([
            'title' => 'Solusi Kreatif untuk Desain, Print & ATK Anda',
            'description' => 'Ravaa Creative menyediakan layanan desain grafis, percetakan, dan alat tulis kantor berkualitas tinggi dengan harga kompetitif.',
            'button1_text' => 'Lihat Layanan',
            'button1_link' => '/layanan',
            'button2_text' => 'Portfolio Kami',
            'button2_link' => '/portofolio',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil direset!',
        ]);
    }
}
