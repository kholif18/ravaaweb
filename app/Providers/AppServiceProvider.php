<?php

namespace App\Providers;

use App\Models\Setting;
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
        // Share $settings to all frontend views
        View::composer('frontend.*', function ($view) {
            $view->with('settings', Setting::allAsArray());
        });
    }
}
