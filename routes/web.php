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

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/layanan', [FrontendController::class, 'layanan'])->name('layanan');
Route::get('/product', [FrontendController::class, 'product'])->name('product');
Route::get('/detail-product', [FrontendController::class, 'detailProduct'])->name('detail-product');
Route::get('/portofolio', [FrontendController::class, 'portofolio'])->name('portofolio');
Route::get('/software-house', [FrontendController::class, 'softwareHouse'])->name('software-house');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.dummy')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard.index');
        })->name('dashboard');

        // ========== KONTEN HALAMAN ==========
        
        // Home Page Management
        Route::prefix('home')->name('home.')->group(function () {
            // Banner Hero
            Route::get('/banner', [HomeBannerController::class, 'edit'])->name('banner');
            Route::put('/banner', [HomeBannerController::class, 'update'])->name('banner.update');
            Route::post('/banner/reset', [HomeBannerController::class, 'reset'])->name('banner.reset');
            Route::post('/banner/upload-image', [HomeBannerController::class, 'uploadImage'])->name('banner.upload-image');
            
            // Service Categories
            Route::get('categories', [HomeCategoryController::class, 'edit'])->name('categories.edit');
            Route::put('categories/update', [HomeCategoryController::class, 'update'])->name('categories.update');
            Route::post('categories/{position}/toggle-status', [HomeCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
            Route::post('categories/reset', [HomeCategoryController::class, 'reset'])->name('categories.reset');
            
            // Promo Banner
            Route::get('/promo', [PromoBannerController::class, 'index'])->name('promo');
            Route::put('/promo/update', [PromoBannerController::class, 'update'])->name('promo.update');
            Route::get('/promo/preview', [PromoBannerController::class, 'preview'])->name('promo.preview');
            Route::post('/promo/reset', [PromoBannerController::class, 'reset'])->name('promo.reset');
            
            // Featured Products
            Route::get('/featured', [FeaturedProductController::class, 'index'])->name('featured');
            Route::put('/featured', [FeaturedProductController::class, 'update'])->name('featured.update');
        });
        
        // Layanan Page Management
        Route::prefix('services')->name('services.')->group(function () {
            // Service Categories Tabs
            Route::get('/categories', [ServiceCategoryController::class, 'index'])->name('categories');
            Route::put('/categories', [ServiceCategoryController::class, 'update'])->name('categories.update');
            
            // Service Content (5 layanan)
            Route::get('/content', [ServiceController::class, 'index'])->name('content');
            Route::get('/content/create', [ServiceController::class, 'create'])->name('content.create');
            Route::post('/content', [ServiceController::class, 'store'])->name('content.store');
            Route::get('/content/{service}/edit', [ServiceController::class, 'edit'])->name('content.edit');
            Route::put('/content/{service}', [ServiceController::class, 'update'])->name('content.update');
            Route::delete('/content/{service}', [ServiceController::class, 'destroy'])->name('content.destroy');
            
            // FAQ Section
            Route::get('/faq', [FaqController::class, 'index'])->name('faq');
            
            // Process Section
            Route::get('/process', function () {
                return view('admin.services.process');
            })->name('process');
        });
        
        // Produk Page Management
        Route::prefix('products-page')->name('products-page.')->group(function () {
            // Product Categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

            // Promo Banner
            Route::get('/promo', [PromoBannerController::class, 'index'])->name('promo');
        });
        
        // Portfolio Page Management
        Route::prefix('portfolio-page')->name('portfolio-page.')->group(function () {
            // Portfolio Items Settings
            Route::get('/items', [PortfolioItemController::class, 'index'])->name('items');
            
            // Portfolio Filter Settings
            Route::get('/filter', [ServiceCategoryController::class, 'index'])->name('filter');
            
            // Testimonials Slider
            Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
            
            // Stats Counter
            Route::get('/stats', function () {
                return view('admin.portfolio-page.stats');
            })->name('stats');

            // CTA Section
            Route::get('/cta', function () {
                return view('admin.portfolio-page.cta');
            })->name('cta');
        });
        
        // Software House Page Management
        Route::prefix('software')->name('software.')->group(function () {
            // Hero Section
            Route::get('/hero', [SettingController::class, 'index'])->name('hero');
            
            // Tech Services
            Route::get('/services', [ServiceController::class, 'index'])->name('services');
            
            // Tech Stack
            Route::get('/stack', [SettingController::class, 'index'])->name('stack');
            
            // Development Process
            Route::get('/process', [SettingController::class, 'index'])->name('process');
            
            // Tech Portfolio
            Route::get('/portfolio', [PortfolioItemController::class, 'index'])->name('portfolio');
            
            // Pricing Plans
            Route::get('/pricing', [SettingController::class, 'index'])->name('pricing');
            
            // CTA Section
            Route::get('/cta', [SettingController::class, 'index'])->name('cta');
        });
        
        // Contact Page Management (single page)
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', function () {
                return view('admin.contact.index');
            })->name('index');
            
            Route::put('/update', function () {
                return redirect()->back()->with('success', 'Contact page updated successfully');
            })->name('update');
        });
        
        // ========== MANAJEMEN PRODUK ==========
        
        // Media 
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [MediaController::class, 'index'])->name('index');
            Route::get('/picker', [MediaController::class, 'picker'])->name('picker');
            Route::post('/', [MediaController::class, 'store'])->name('store');
            Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
            Route::get('/{media}', [MediaController::class, 'show'])->name('show');
            Route::delete('/{media}', [MediaController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-destroy', [MediaController::class, 'bulkDestroy'])->name('bulk.destroy');
            Route::post('/bulk-download', [MediaController::class, 'bulkDownload'])->name('bulk.download');
            Route::post('/search', [MediaController::class, 'search'])->name('search');
            Route::get('/stats/summary', [MediaController::class, 'getStats'])->name('stats.summary');
            Route::get('/download/{media}', [MediaController::class, 'download'])->name('download');
            Route::post('/regenerate-thumbnails', [MediaController::class, 'regenerateThumbnails'])->name('regenerate.thumbnails');
             Route::get('/get-batch', [MediaController::class, 'getBatch'])->name('get-batch');
        });

        // Products tetap ada
        Route::resource('products', ProductController::class);
        // Products
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            
            // Additional routes
            Route::post('/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('bulk.destroy');
            Route::put('/{product}/status', [ProductController::class, 'updateStatus'])->name('status.update');
            Route::put('/{product}/stock', [ProductController::class, 'updateStock'])->name('stock.update');
            Route::get('/export', [ProductController::class, 'export'])->name('export');
        });
        
        // Product Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('bulk.destroy');
            Route::put('/{category}/status', [CategoryController::class, 'updateStatus'])->name('status.update');
            
            // API untuk get category data (JSON) - PASTIKAN INI SEBELUM ROUTE {category}
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            
            // Opsional
            Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
            Route::get('/dropdown', [CategoryController::class, 'getCategoriesForDropdown'])->name('dropdown');
        });
        // ========== MANAJEMEN KONTEN ==========
        
        // Portfolio Items CRUD
        Route::resource('portfolio-items', PortfolioItemController::class)->except(['show']);
        
        // Testimonials CRUD
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        
        // FAQ Management
        Route::resource('faq', FaqController::class)->except(['show', 'create', 'edit']);
        Route::post('faq/reorder', [FaqController::class, 'reorder'])->name('faq.reorder');
        
        // Form Submissions
        Route::prefix('form-submissions')->name('form-submissions.')->group(function () {
            Route::get('/', [ContactSubmissionController::class, 'index'])->name('index');
            Route::get('/{contact_submission}', [ContactSubmissionController::class, 'show'])->name('show');
            Route::put('/{contact_submission}', [ContactSubmissionController::class, 'update'])->name('update');
            Route::delete('/{contact_submission}', [ContactSubmissionController::class, 'destroy'])->name('destroy');
        });
        
        // ========== PENGATURAN ==========
        
        // Website Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/{group?}', [SettingController::class, 'index'])->name('index');
            Route::put('/update', [SettingController::class, 'update'])->name('update');
            
            // Legacy/Specific routes if needed
            Route::get('/general', [SettingController::class, 'index'])->name('general');
            Route::get('/contact', [SettingController::class, 'index'])->name('contact');
            Route::get('/social', [SettingController::class, 'index'])->name('social');
            Route::get('/promo', [SettingController::class, 'index'])->name('promo');
            Route::get('/email', [SettingController::class, 'index'])->name('email');
        });
        
        // ========== STATISTIK ==========
        
        Route::prefix('statistics')->name('statistics.')->group(function () {
            // Website Traffic
            Route::get('/traffic', function () {
                return view('admin.statistics.traffic');
            })->name('traffic');
            
            // Page Views
            Route::get('/page-views', function () {
                return view('admin.statistics.page-views');
            })->name('page-views');
            
            // Form Submissions Stats
            Route::get('/form-submissions', function () {
                return view('admin.statistics.form-submissions');
            })->name('form-submissions');
            
            // Product Views
            Route::get('/product-views', function () {
                return view('admin.statistics.product-views');
            })->name('product-views');
        });
        
        // ========== UTILITIES ==========
        
        // Export Data
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/products', function () {
                // Return CSV or Excel file
                return response()->download('products.csv');
            })->name('products');
            
            Route::get('/form-submissions', function () {
                return response()->download('submissions.csv');
            })->name('form-submissions');
            
            Route::get('/testimonials', function () {
                return response()->download('testimonials.csv');
            })->name('testimonials');
        });
        
        // Import Data
        Route::prefix('import')->name('import.')->group(function () {
            Route::get('/products', function () {
                return view('admin.import.products');
            })->name('products');
            
            Route::post('/products', function () {
                return redirect()->back()->with('success', 'Products imported successfully');
            })->name('products.process');
        });

    });


// Route::prefix('admin')
//     ->name('admin.')
//     ->middleware(['auth'])
//     ->group(function () {
//         Route::get('/dashboard', function () {
//             return view('admin.dashboard.index');
//         })->name('dashboard');
//     });
