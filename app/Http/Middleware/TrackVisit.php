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
            [$pageType, $title] = match ($routeName) {
                'home'             => ['home', 'Beranda'],
                'layanan'          => ['service_list', 'Layanan'],
                'product'          => ['product_list', 'Produk'],
                'portofolio'       => ['portfolio_list', 'Portfolio'],
                'software-house'   => ['software_house', 'Software House'],
                'contact'          => ['contact', 'Kontak'],
                'detail-product'   => ['product', $route->parameter('slug')],
                default            => ['page', null],
            };

            PageVisit::create([
                'page_type'  => $pageType,
                'url'        => $request->fullUrl(),
                'title'      => $title,
                'ip_address' => $request->ip(),
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
