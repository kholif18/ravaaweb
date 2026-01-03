<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/home-banner', [\App\Http\Controllers\Admin\HomeBannerController::class, 'getActiveBannerApi']);
});