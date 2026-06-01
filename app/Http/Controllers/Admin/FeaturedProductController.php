<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class FeaturedProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get(['id', 'name', 'price', 'is_featured', 'is_best_seller', 'discount_price']);
        return view('admin.home.featured', compact('products'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Reset all featured/best seller flags first if needed, or handle per product
        // For simplicity, we just update the ones provided
        
        $newProducts = $request->input('new_products', []); // Usually newest arrival
        $discountProducts = $request->input('discount_products', []); 
        $popularProducts = $request->input('popular_products', []); // Best seller

        // Clear existing featured/best_seller flags if you want strict control
        Product::query()->update(['is_featured' => false, 'is_best_seller' => false]);

        if (!empty($newProducts)) {
            Product::whereIn('id', $newProducts)->update(['is_featured' => true]);
        }

        if (!empty($popularProducts)) {
            Product::whereIn('id', $popularProducts)->update(['is_best_seller' => true]);
        }

        return redirect()->back()->with('success', 'Featured products berhasil diperbarui!');
    }
}
