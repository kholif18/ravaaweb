<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeCategoryController extends Controller
{
    /**
     * Display the edit form for homepage categories
     */
    public function edit()
    {
        // Get all homepage categories ordered by position
        $categories = HomepageCategory::ordered()->get();
        
        // Group categories by position for easier access in blade
        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData['category' . $category->position] = $category;
        }
        
        return view('admin.home.categories', compact('categoryData'));
    }

    /**
     * Update homepage categories
     */
    public function update(Request $request)
    {
        $request->validate([
            'category1_icon' => 'required|string|max:50',
            'category1_title' => 'required|string|max:255',
            'category1_description' => 'required|string',
            'category2_icon' => 'required|string|max:50',
            'category2_title' => 'required|string|max:255',
            'category2_description' => 'required|string',
            'category3_icon' => 'required|string|max:50',
            'category3_title' => 'required|string|max:255',
            'category3_description' => 'required|string',
            'category4_icon' => 'required|string|max:50',
            'category4_title' => 'required|string|max:255',
            'category4_description' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Update category 1
            HomepageCategory::updateOrCreate(
                ['position' => 1],
                [
                    'icon' => $request->category1_icon,
                    'title' => $request->category1_title,
                    'description' => $request->category1_description
                ]
            );

            // Update category 2
            HomepageCategory::updateOrCreate(
                ['position' => 2],
                [
                    'icon' => $request->category2_icon,
                    'title' => $request->category2_title,
                    'description' => $request->category2_description
                ]
            );

            // Update category 3
            HomepageCategory::updateOrCreate(
                ['position' => 3],
                [
                    'icon' => $request->category3_icon,
                    'title' => $request->category3_title,
                    'description' => $request->category3_description
                ]
            );

            // Update category 4
            HomepageCategory::updateOrCreate(
                ['position' => 4],
                [
                    'icon' => $request->category4_icon,
                    'title' => $request->category4_title,
                    'description' => $request->category4_description
                ]
            );

            DB::commit();

            return redirect()->route('admin.home.categories.edit')
                ->with('success', 'Kategori homepage berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle category status
     */
    public function toggleStatus($position)
    {
        $category = HomepageCategory::where('position', $position)->firstOrFail();
        
        $category->update([
            'is_active' => !$category->is_active
        ]);

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json([
            'success' => true,
            'message' => "Kategori $status",
            'is_active' => $category->is_active
        ]);
    }

    /**
     * Reset to default categories
     */
    public function reset()
    {
        DB::table('homepage_categories')->truncate();

        $defaultCategories = [
            [
                'position' => 1,
                'icon' => 'bi-paint-bucket',
                'title' => 'Desain Grafis',
                'description' => 'Logo, brosur, banner, kartu nama, dan desain kreatif lainnya untuk bisnis Anda.',
                'is_active' => true
            ],
            [
                'position' => 2,
                'icon' => 'bi-printer',
                'title' => 'Percetakan',
                'description' => 'Cetak offset dan digital dengan kualitas tinggi untuk segala kebutuhan percetakan.',
                'is_active' => true
            ],
            [
                'position' => 3,
                'icon' => 'bi-pen',
                'title' => 'Alat Tulis Kantor',
                'description' => 'Berbagai kebutuhan ATK dengan kualitas terbaik untuk mendukung produktivitas.',
                'is_active' => true
            ],
            [
                'position' => 4,
                'icon' => 'bi-tshirt',
                'title' => 'Sablon & Merchandise',
                'description' => 'Sablon kaos, mug, tumbler, dan merchandise custom untuk branding perusahaan.',
                'is_active' => true
            ]
        ];

        foreach ($defaultCategories as $category) {
            HomepageCategory::create($category);
        }

        return redirect()->route('admin.home.categories.edit')
            ->with('success', 'Kategori berhasil direset ke default!');
    }
}