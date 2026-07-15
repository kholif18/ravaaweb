<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['track.visit', 'maintenance'])->group(function () {
    Route::get('/', [FrontendController::class, 'home'])->name('home');
    Route::get('/layanan', [FrontendController::class, 'layanan'])->name('layanan');
    Route::get('/product', [FrontendController::class, 'product'])->name('product');
    Route::get('/product/{slug}', [FrontendController::class, 'detailProduct'])->name('detail-product');
    Route::get('/portofolio', [FrontendController::class, 'portofolio'])->name('portofolio');
    Route::get('/software-house', [FrontendController::class, 'softwareHouse'])->name('software-house');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact', [FrontendController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:contact');
    Route::get('/search', [FrontendController::class, 'search'])->name('search');
});

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Admin Login Routes
|--------------------------------------------------------------------------
*/
// Redirect /login to admin login for convenience
Route::redirect('login', 'admin/login', 301);

Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post')->middleware('throttle:login');
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
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
        Route::post('profile/avatar/remove', [App\Http\Controllers\Admin\ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

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

        // Users
        Route::put('users/{user}/status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.update-status');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);

        // Roles
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');

        // Reports & Analytics
        Route::get('reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

        // System Logs
        Route::delete('logs/clear', [App\Http\Controllers\Admin\LogController::class, 'clear'])->name('logs.clear');
        Route::get('logs', [App\Http\Controllers\Admin\LogController::class, 'index'])->name('logs.index');

        // Home Builder
        Route::get('home', [App\Http\Controllers\Admin\HomeBuilderController::class, 'index'])->name('home.index');
        Route::post('home', [App\Http\Controllers\Admin\HomeBuilderController::class, 'store'])->name('home.store');

        // Software House Builder
        Route::get('software-house', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'index'])->name('software-house.index');
        Route::post('software-house', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'store'])->name('software-house.store');
        Route::put('software-house/service/{id}', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'updateService'])->name('software-house.service.update');
        Route::post('software-house/features', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'storeFeature'])->name('software-house.features.store');
        Route::post('software-house/features/reorder', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'reorderFeatures'])->name('software-house.features.reorder');
        Route::put('software-house/features/{index}', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'updateFeature'])->name('software-house.features.update');
        Route::delete('software-house/features/{index}', [App\Http\Controllers\Admin\SoftwareHouseBuilderController::class, 'deleteFeature'])->name('software-house.features.destroy');

        // Services
        Route::delete('services/bulk-delete', [App\Http\Controllers\Admin\ServiceController::class, 'bulkDestroy'])->name('services.bulk.destroy');
        Route::put('services/{service}/status', [App\Http\Controllers\Admin\ServiceController::class, 'updateStatus'])->name('services.status.update');
        Route::post('services/reorder', [App\Http\Controllers\Admin\ServiceController::class, 'reorder'])->name('services.reorder');
        Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->except(['show']);

        // Portfolio
        Route::delete('portfolio/bulk-delete', [App\Http\Controllers\Admin\PortfolioItemController::class, 'bulkDestroy'])->name('portfolio.bulk.destroy');
        Route::put('portfolio/{portfolioItem}/status', [App\Http\Controllers\Admin\PortfolioItemController::class, 'updateStatus'])->name('portfolio.status.update');
        Route::post('portfolio/reorder', [App\Http\Controllers\Admin\PortfolioItemController::class, 'reorder'])->name('portfolio.reorder');
        Route::resource('portfolio', App\Http\Controllers\Admin\PortfolioItemController::class)->parameters([
            'portfolio' => 'portfolioItem'
        ])->except(['show']);

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

        // Contact Submissions
        Route::delete('contact-submissions/bulk-delete', [App\Http\Controllers\Admin\ContactSubmissionController::class, 'bulkDestroy'])->name('contact-submissions.bulk.destroy');
        Route::put('contact-submissions/{contactSubmission}/mark-as-read', [App\Http\Controllers\Admin\ContactSubmissionController::class, 'markAsRead'])->name('contact-submissions.mark-as-read');
        Route::put('contact-submissions/{contactSubmission}/mark-as-unread', [App\Http\Controllers\Admin\ContactSubmissionController::class, 'markAsUnread'])->name('contact-submissions.mark-as-unread');
        Route::resource('contact-submissions', App\Http\Controllers\Admin\ContactSubmissionController::class)->only(['index', 'show', 'destroy']);

        // Footer Links
        Route::delete('footer-links/bulk-delete', [App\Http\Controllers\Admin\FooterLinkController::class, 'bulkDestroy'])->name('footer-links.bulk.destroy');
        Route::put('footer-links/{footerLink}/status', [App\Http\Controllers\Admin\FooterLinkController::class, 'updateStatus'])->name('footer-links.status.update');
        Route::post('footer-links/reorder', [App\Http\Controllers\Admin\FooterLinkController::class, 'reorder'])->name('footer-links.reorder');
        Route::resource('footer-links', App\Http\Controllers\Admin\FooterLinkController::class);

    });
