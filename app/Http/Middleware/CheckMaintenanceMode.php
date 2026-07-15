<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle maintenance mode.
     *
     * - Block frontend for regular visitors.
     * - Allow admin panel, sitemap, and admin login.
     * - Allow authenticated admin users to preview frontend changes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Setting::get('maintenance_mode') === '1') {
            // Always allow: admin panel, sitemap, admin login, and logout
            if ($request->is('admin/*') || $request->is('admin')
                || $request->is('sitemap.xml')
                || $request->is('admin/login') || $request->is('admin/logout')) {
                return $next($request);
            }

            // Allow authenticated admin users to preview frontend
            if (Auth::guard('admin')->check()) {
                return $next($request);
            }

            return response()->view('frontend.maintenance', [], 503);
        }

        return $next($request);
    }
}
