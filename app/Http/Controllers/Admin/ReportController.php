<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
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
    public function index()
    {
        // ── 1. Content Metrics (existing) ──
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalPortfolio = PortfolioItem::count();
        $totalServices = Service::count();
        $totalTestimonials = Testimonial::count();
        $totalBanners = Banner::count();
        $totalUsers = User::count();
        $totalMedia = Media::count();

        $productStatus = Product::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->pluck('count', 'status')->toArray();

        $productsPerCategory = Category::withCount('products')
            ->orderBy('products_count', 'desc')->get();

        $featuredProductsCount = Product::where('is_featured', true)->count();

        $serviceStatus = Service::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->pluck('count', 'status')->toArray();

        $portfolioStatus = PortfolioItem::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->pluck('count', 'status')->toArray();

        $testimonialStatus = Testimonial::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')->get()->pluck('count', 'status')->toArray();

        $avgPrice = Product::avg('price') ?? 0;
        $maxPrice = Product::max('price') ?? 0;
        $minPrice = Product::min('price') ?? 0;

        $discountedCount = Product::where(function($query) {
            $query->whereNotNull('price_discount')->where('price_discount', '>', 0);
        })->count();

        // ── 2. Analytics ──
        $totalVisits    = PageVisit::count();
        $todayVisits    = PageVisit::today()->count();
        $thisWeekVisits = PageVisit::thisWeek()->count();
        $thisMonthVisits = PageVisit::thisMonth()->count();
        $uniqueVisitors = PageVisit::uniqueVisitors(now()->subDays(30)->toDateTimeString());

        // Daily chart data — last 14 days
        $dailyVisits = PageVisit::dailyVisits(14);
        $chartLabels14 = array_keys($dailyVisits);
        $chartValues14 = array_values($dailyVisits);

        // Hourly chart — today
        $hourlyData = PageVisit::hourlyVisitsToday();

        // Most visited pages — this month
        $popularPages = PageVisit::mostVisitedPages(10, now()->startOfMonth()->toDateTimeString());

        // Visits by type — this month
        $visitsByType = PageVisit::visitsByType(now()->startOfMonth()->toDateTimeString());

        // Top products by views
        $topProducts = Product::where('status', 'active')
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get(['id', 'name', 'slug', 'views_count']);

        // Top portfolio by views
        $topPortfolio = PortfolioItem::where('status', 'active')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'views_count']);

        return view('admin.reports.index', compact(
            // Existing content metrics
            'totalProducts', 'totalCategories', 'totalPortfolio', 'totalServices',
            'totalTestimonials', 'totalBanners', 'totalUsers', 'totalMedia',
            'productStatus', 'productsPerCategory', 'featuredProductsCount',
            'serviceStatus', 'portfolioStatus', 'testimonialStatus',
            'avgPrice', 'maxPrice', 'minPrice', 'discountedCount',
            // Analytics
            'totalVisits', 'todayVisits', 'thisWeekVisits', 'thisMonthVisits', 'uniqueVisitors',
            'chartLabels14', 'chartValues14', 'hourlyData',
            'popularPages', 'visitsByType',
            'topProducts', 'topPortfolio'
        ));
    }
}
