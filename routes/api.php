<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceCategoryController;

Route::prefix('v1')->group(function () {
    Route::get('/home-banner', [\App\Http\Controllers\Admin\HomeBannerController::class, 'getActiveBannerApi']);
});

// Service Categories Routes
Route::prefix('service-categories')->group(function () {
    Route::get('/', [ServiceCategoryController::class, 'index']);
    Route::post('/', [ServiceCategoryController::class, 'store']);
    Route::post('/update-order', [ServiceCategoryController::class, 'updateOrder']);
    
    Route::prefix('{service_category}')->group(function () {
        Route::get('/', [ServiceCategoryController::class, 'show']);
        Route::put('/', [ServiceCategoryController::class, 'update']);
        Route::patch('/', [ServiceCategoryController::class, 'update']);
        Route::delete('/', [ServiceCategoryController::class, 'destroy']);
        Route::post('/restore', [ServiceCategoryController::class, 'restore']);
        Route::post('/toggle-status', [ServiceCategoryController::class, 'toggleStatus']);
    });
});

// Service Routes
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/popular', [ServiceController::class, 'popular']);
    Route::get('/category/{categorySlug}', [ServiceController::class, 'byCategory']);
    Route::post('/', [ServiceController::class, 'store']);
    
    Route::prefix('{service}')->group(function () {
        Route::get('/', [ServiceController::class, 'show']);
        Route::put('/', [ServiceController::class, 'update']);
        Route::patch('/', [ServiceController::class, 'update']);
        Route::delete('/', [ServiceController::class, 'destroy']);
        Route::post('/increment-views', [ServiceController::class, 'incrementViews']);
    });
});