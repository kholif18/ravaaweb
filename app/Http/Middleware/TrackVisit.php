<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Track every frontend page visit.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful HTML responses on frontend, skip admin/ajax/json
        if (!$response->isSuccessful() || $request->expectsJson() || $request->ajax()) {
            return $response;
        }

        $route = $request->route();
        $routeName = $route?->getName();

        // Skip admin routes
        if ($routeName && str_starts_with($routeName, 'admin.')) {
            return $response;
        }

        try {
            [$pageType, $pageId, $title] = match ($routeName) {
                'home'             => ['home', null, 'Beranda'],
                'layanan'          => ['service_list', null, 'Layanan'],
                'product'          => ['product_list', null, 'Produk'],
                'portofolio'       => ['portfolio_list', null, 'Portfolio'],
                'software-house'   => ['software_house', null, 'Software House'],
                'contact'          => ['contact', null, 'Kontak'],
                'detail-product'   => ['product', $route->parameter('slug'), $route->parameter('slug')],
                default            => ['page', null, null],
            };

            // Deduplicate: same IP + same page = 1 visit per day
            $ip = $request->ip();
            if (PageVisit::hasVisitedToday($pageType, $pageId, $ip)) {
                return $response;
            }

            PageVisit::create([
                'page_type'  => $pageType,
                'page_id'    => $pageId,
                'url'        => $request->fullUrl(),
                'title'      => $title,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'visited_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Don't break the page if tracking fails
            report($e);
        }

        return $response;
    }
}
