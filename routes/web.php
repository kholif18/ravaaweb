<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/layanan', [FrontendController::class, 'layanan'])->name('layanan');
Route::get('/product', [FrontendController::class, 'product'])->name('product');
Route::get('/product/{slug}', [FrontendController::class, 'detailProduct'])->name('detail-product');
Route::get('/portofolio', [FrontendController::class, 'portofolio'])->name('portofolio');
Route::get('/software-house', [FrontendController::class, 'softwareHouse'])->name('software-house');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Admin Login Routes
|--------------------------------------------------------------------------
*/
Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin.auth','role:admin,admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            $stats = [
                ['Produk', \App\Models\Product::count(), 'box', 'primary'],
                ['Kategori', \App\Models\Category::count(), 'tags', 'success'],
                ['Testimoni', \App\Models\Testimonial::count(), 'star', 'warning'],
                ['Portfolio', \App\Models\PortfolioItem::count(), 'images', 'info'],
            ];

            return view('admin.dashboard.index', compact('stats'));
        })->name('dashboard');

        // Categories
        Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk.destroy');
        Route::put('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.status.update');
        Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::resource('categories', CategoryController::class);

        // Tags
        Route::delete('tags/bulk-delete', [App\Http\Controllers\Admin\TagController::class, 'bulkDestroy'])->name('tags.bulk.destroy');
        Route::resource('tags', App\Http\Controllers\Admin\TagController::class);

        // Media Library
        Route::delete('media/bulk-delete', [App\Http\Controllers\Admin\MediaController::class, 'destroyMultiple'])->name('media.bulk.destroy');
        Route::post('media/upload-multiple', [App\Http\Controllers\Admin\MediaController::class, 'storeMultiple'])->name('media.store.multiple');
        Route::get('media/picker', [App\Http\Controllers\Admin\MediaController::class, 'picker'])->name('media.picker');
        Route::resource('media', App\Http\Controllers\Admin\MediaController::class)->except(['show', 'edit', 'update']);

        // Products
        Route::delete('products/bulk-delete', [App\Http\Controllers\Admin\ProductController::class, 'destroyMultiple'])->name('products.bulk.destroy');
        Route::put('products/bulk-restore', [App\Http\Controllers\Admin\ProductController::class, 'restoreMultiple'])->name('products.bulk.restore');
        Route::delete('products/force-delete', [App\Http\Controllers\Admin\ProductController::class, 'forceDestroyMultiple'])->name('products.force.destroy');
        Route::put('products/{id}/restore', [App\Http\Controllers\Admin\ProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force', [App\Http\Controllers\Admin\ProductController::class, 'forceDestroy'])->name('products.force');
        Route::put('products/{product}/media-order', [App\Http\Controllers\Admin\ProductController::class, 'updateMediaOrder'])->name('products.media.order');
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

        // Settings
        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Services
        Route::delete('services/bulk-delete', [App\Http\Controllers\Admin\ServiceController::class, 'bulkDestroy'])->name('services.bulk.destroy');
        Route::put('services/{service}/status', [App\Http\Controllers\Admin\ServiceController::class, 'updateStatus'])->name('services.status.update');
        Route::post('services/reorder', [App\Http\Controllers\Admin\ServiceController::class, 'reorder'])->name('services.reorder');
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->except(['show']);

        // Portfolio
        Route::delete('portfolio/bulk-delete', [App\Http\Controllers\Admin\PortfolioItemController::class, 'bulkDestroy'])->name('portfolio.bulk.destroy');
        Route::put('portfolio/{portfolioItem}/status', [App\Http\Controllers\Admin\PortfolioItemController::class, 'updateStatus'])->name('portfolio.status.update');
        Route::post('portfolio/reorder', [App\Http\Controllers\Admin\PortfolioItemController::class, 'reorder'])->name('portfolio.reorder');
        Route::resource('portfolio', App\Http\Controllers\Admin\PortfolioItemController::class)->except(['show']);

        // Testimonials
        Route::delete('testimonials/bulk-delete', [App\Http\Controllers\Admin\TestimonialController::class, 'bulkDestroy'])->name('testimonials.bulk.destroy');
        Route::put('testimonials/{testimonial}/status', [App\Http\Controllers\Admin\TestimonialController::class, 'updateStatus'])->name('testimonials.status.update');
        Route::post('testimonials/reorder', [App\Http\Controllers\Admin\TestimonialController::class, 'reorder'])->name('testimonials.reorder');
        Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);

        // Banners
        Route::delete('banners/bulk-delete', [App\Http\Controllers\Admin\BannerController::class, 'bulkDestroy'])->name('banners.bulk.destroy');
        Route::put('banners/{banner}/status', [App\Http\Controllers\Admin\BannerController::class, 'updateStatus'])->name('banners.status.update');
        Route::post('banners/reorder', [App\Http\Controllers\Admin\BannerController::class, 'reorder'])->name('banners.reorder');
        Route::resource('banners', App\Http\Controllers\Admin\BannerController::class)->except(['show']);

    });
