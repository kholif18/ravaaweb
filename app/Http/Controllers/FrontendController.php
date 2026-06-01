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
        return view('frontend.product');
    }

    public function detailProduct()
    {
        return view('frontend.detail-product');
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
