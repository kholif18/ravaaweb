<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\PromoBannerController;
use App\Http\Controllers\Admin\HomeCategoryController;
use App\Http\Controllers\Admin\PortfolioItemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FeaturedProductController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;

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

Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin.auth','role:admin,admin'])
    ->group(function () {

        // 1. Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');

        // 2. Katalog Produk (Entity-based)
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
        Route::delete('products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk.destroy');
        Route::resource('products', ProductController::class);
        Route::put('products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.status.update');
        
        Route::delete('categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk.destroy');
        Route::resource('categories', CategoryController::class);
        Route::put('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.status.update');
        
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [MediaController::class, 'index'])->name('index');
            Route::get('/picker', [MediaController::class, 'picker'])->name('picker');
            Route::post('/store', [MediaController::class, 'store'])->name('store');
            Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
            Route::get('/{media}/download', [MediaController::class, 'download'])->name('download');
            Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-destroy', [MediaController::class, 'bulkDestroy'])->name('bulk.destroy');
            Route::post('/bulk-download', [MediaController::class, 'bulkDownload'])->name('bulk.download');
        });

        // 3. Layanan & Portfolio
        Route::resource('services', ServiceController::class);
        Route::delete('services/bulk-delete', [ServiceController::class, 'bulkDestroy'])->name('services.bulk.destroy');
        
        Route::resource('service-categories', ServiceCategoryController::class);
        Route::delete('service-categories/bulk-delete', [ServiceCategoryController::class, 'bulkDestroy'])->name('service-categories.bulk.destroy');

        Route::resource('portfolio-items', PortfolioItemController::class)->except(['show']);
        Route::delete('portfolio-items/bulk-delete', [PortfolioItemController::class, 'bulkDestroy'])->name('portfolio-items.bulk.destroy');
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('faq', FaqController::class)->except(['show', 'create', 'edit']);

        // 4. Manajemen Halaman (CMS)
        Route::prefix('cms')->group(function() {
            // Home Page
            Route::prefix('home')->name('home.')->group(function () {
                Route::get('/banner', [HomeBannerController::class, 'edit'])->name('banner');
                Route::put('/banner', [HomeBannerController::class, 'update'])->name('banner.update');
                Route::get('/promo', [PromoBannerController::class, 'index'])->name('promo');
                Route::get('/featured', [FeaturedProductController::class, 'index'])->name('featured');
            });
            
            // Software House
            Route::prefix('software')->name('software.')->group(function () {
                Route::get('/hero', [SettingController::class, 'index'])->name('hero');
            });

            // Contact Page
            Route::prefix('contact')->name('contact.')->group(function () {
                Route::get('/', function () { return view('admin.contact.index'); })->name('index');
            });
        });

        // 5. Interaksi
        Route::resource('form-submissions', ContactSubmissionController::class)->only(['index', 'show', 'destroy', 'update']);
        
        Route::prefix('statistics')->name('statistics.')->group(function () {
            Route::get('/traffic', function () { return view('admin.statistics.traffic'); })->name('traffic');
            Route::get('/page-views', function () { return view('admin.statistics.page-views'); })->name('page-views');
        });

        // 6. Sistem
        Route::get('settings/{group?}', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/update', [SettingController::class, 'update'])->name('settings.update');

    });
