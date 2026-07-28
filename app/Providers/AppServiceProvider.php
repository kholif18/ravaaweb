<?php

namespace App\Providers;

use App\Models\ContactSubmission;
use App\Models\NavLink;
use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register rate limiters (always available, even with route cache)
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Share $settings to all frontend views
        View::composer('frontend.*', function ($view) {
            $view->with('settings', Setting::allAsArray());
        });

        // Share active nav links to frontend views (top-level only, children eager-loaded)
        View::composer('frontend.*', function ($view) {
            $view->with('navLinks', NavLink::active()->topLevel()->with('children')->ordered()->get());
        });

        // Share notification count to admin header
        View::composer('admin.partials.header', function ($view) {
            $unreadSubmissionsCount = ContactSubmission::where('status', 'unread')->count();
            $view->with('unreadSubmissionsCount', $unreadSubmissionsCount);
        });
    }
}
