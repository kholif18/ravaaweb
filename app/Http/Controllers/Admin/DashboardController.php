<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
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

        // ── Analytics data ──
        $todayVisits   = PageVisit::today()->count();
        $thisWeekVisits = PageVisit::thisWeek()->count();
        $thisMonthVisits = PageVisit::thisMonth()->count();
        $totalVisits   = PageVisit::count();
        $uniqueVisitors = PageVisit::uniqueVisitors(now()->subDays(30)->toDateTimeString());

        // Daily chart data (last 7 days)
        $dailyVisits = PageVisit::dailyVisits(7);
        $chartLabels = array_keys($dailyVisits);
        $chartValues = array_values($dailyVisits);

        // Most visited pages this month
        $popularPages = PageVisit::mostVisitedPages(5, now()->startOfMonth()->toDateTimeString());

        // Top products by views
        $topProducts = Product::where('status', 'active')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'slug', 'views_count']);

        return view('admin.dashboard.index', compact(
            'stats', 'recentProducts',
            'todayVisits', 'thisWeekVisits', 'thisMonthVisits', 'totalVisits', 'uniqueVisitors',
            'chartLabels', 'chartValues',
            'popularPages', 'topProducts'
        ));
    }
}
