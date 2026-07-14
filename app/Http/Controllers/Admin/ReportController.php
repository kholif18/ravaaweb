<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Banner;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a summary report of products, services, portfolio, and website statistics.
     */
    public function index()
    {
        // 1. General summary metrics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalPortfolio = PortfolioItem::count();
        $totalServices = Service::count();
        $totalTestimonials = Testimonial::count();
        $totalBanners = Banner::count();
        $totalUsers = User::count();
        $totalMedia = Media::count();

        // 2. Product status breakdown
        $productStatus = Product::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // 3. Products per category distribution
        $productsPerCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        // 4. Featured products count
        $featuredProductsCount = Product::where('is_featured', true)->count();

        // 5. Service status breakdown
        $serviceStatus = Service::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // 6. Portfolio item status breakdown
        $portfolioStatus = PortfolioItem::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // 7. Testimonial status breakdown
        $testimonialStatus = Testimonial::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // 8. Product pricing stats
        $avgPrice = Product::avg('price') ?? 0;
        $maxPrice = Product::max('price') ?? 0;
        $minPrice = Product::min('price') ?? 0;
        
        $discountedCount = Product::where(function($query) {
            $query->whereNotNull('price_discount')
                  ->where('price_discount', '>', 0);
        })->count();

        return view('admin.reports.index', compact(
            'totalProducts', 'totalCategories', 'totalPortfolio', 'totalServices',
            'totalTestimonials', 'totalBanners', 'totalUsers', 'totalMedia',
            'productStatus', 'productsPerCategory', 'featuredProductsCount',
            'serviceStatus', 'portfolioStatus', 'testimonialStatus',
            'avgPrice', 'maxPrice', 'minPrice', 'discountedCount'
        ));
    }
}
