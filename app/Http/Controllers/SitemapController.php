<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Models\Product;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $services = Service::where('status', 'active')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $portfolios = PortfolioItem::where('status', 'active')
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $content = view('sitemap', compact('products', 'services', 'portfolios'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
