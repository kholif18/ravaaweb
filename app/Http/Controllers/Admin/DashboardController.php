<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\PortfolioItem;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            ['Produk', Product::count(), 'box', 'primary'],
            ['Kategori', Category::count(), 'tags', 'success'],
            ['Testimoni', Testimonial::count(), 'star', 'warning'],
            ['Portfolio', PortfolioItem::count(), 'images', 'info'],
        ];

        $recentProducts = Product::with('category')->latest()->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentProducts'));
    }
}
