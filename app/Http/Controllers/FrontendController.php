<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function layanan()
    {
        $categories = ServiceCategory::active()->orderBy('order')->get();
        $faqs = Faq::active()->orderBy('order')->get();
        $settings = Setting::where('group', 'services')->orWhere('group', 'general')->get()->pluck('value', 'key');
        
        return view('frontend.layanan', compact('categories', 'faqs', 'settings'));
    }

    public function product()
    {
        // Load categories and products for the catalogue page
        $categories = \App\Models\Category::active()->orderBy('order')->get();
        $products = \App\Models\Product::with(['category', 'mainMedia', 'galleryMedia'])
            ->published()
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('frontend.product', compact('categories', 'products'));
    }

    public function detailProduct($slug)
    {
        // Load a single product by slug including media and variants
        $product = \App\Models\Product::with(['category', 'mainMedia', 'galleryMedia', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('frontend.detail-product', compact('product'));
    }

    public function portofolio()
    {
        return view('frontend.portofolio');
    }

    public function softwareHouse()
    {
        return view('frontend.software-house');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
