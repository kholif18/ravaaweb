<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\PromoBannerController;
use App\Http\Controllers\Admin\HomeCategoryController;

Route::get('/', function () {
    return view('frontend/home');
});

Route::get('/layanan', function () {
    return view('frontend/layanan');
});

Route::get('/product', function () {
    return view('frontend/product');
});

Route::get('/detail-product', function () {
    return view('frontend/detail-product');
});

Route::get('/portofolio', function () {
    return view('frontend/portofolio');
});

Route::get('/software-house', function () {
    return view('frontend/software-house');
});

Route::get('/contact', function () {
    return view('frontend/contact');
});

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
            Route::get('/featured', function () {
                return view('admin.home.featured');
            })->name('featured');
            
            Route::put('/featured', function () {
                // Update featured products logic here
                return redirect()->back()->with('success', 'Featured products updated successfully');
            })->name('featured.update');
        });
        
        // Layanan Page Management
        Route::prefix('services')->name('services.')->group(function () {
            // Service Categories Tabs
            Route::get('/categories', function () {
                return view('admin.services.categories');
            })->name('categories');
            
            Route::put('/categories', function () {
                return redirect()->back()->with('success', 'Service categories updated successfully');
            })->name('categories.update');
            
            // Service Content (5 layanan)
            Route::get('/content', function () {
                return view('admin.services.content');
            })->name('content');
            
            Route::put('/content', function () {
                return redirect()->back()->with('success', 'Service content updated successfully');
            })->name('content.update');
            
            // FAQ Section
            Route::get('/faq', function () {
                return view('admin.services.faq');
            })->name('faq');
            
            Route::put('/faq', function () {
                return redirect()->back()->with('success', 'FAQ updated successfully');
            })->name('faq.update');
            
            // Process Section
            Route::get('/process', function () {
                return view('admin.services.process');
            })->name('process');
            
            Route::put('/process', function () {
                return redirect()->back()->with('success', 'Process section updated successfully');
            })->name('process.update');
        });
        
        // Produk Page Management
        Route::prefix('products-page')->name('products-page.')->group(function () {
            // Product Categories
            Route::get('/categories', function () {
                return view('admin.products-page.categories');
            })->name('categories');
            
            // Product Grid/List Settings
            Route::get('/grid', function () {
                return view('admin.products-page.grid');
            })->name('grid');
            
            // Promo Banner
            Route::get('/promo', function () {
                return view('admin.products-page.promo');
            })->name('promo');
        });
        
        // Portfolio Page Management
        Route::prefix('portfolio-page')->name('portfolio-page.')->group(function () {
            // Portfolio Items Settings
            Route::get('/items', function () {
                return view('admin.portfolio-page.items');
            })->name('items');
            
            // Portfolio Filter Settings
            Route::get('/filter', function () {
                return view('admin.portfolio-page.filter');
            })->name('filter');
            
            // Testimonials Slider
            Route::get('/testimonials', function () {
                return view('admin.portfolio-page.testimonials');
            })->name('testimonials');
            
            // Stats Counter
            Route::get('/stats', function () {
                return view('admin.portfolio-page.stats');
            })->name('stats');
        });
        
        // Software House Page Management
        Route::prefix('software')->name('software.')->group(function () {
            // Tech Services
            Route::get('/services', function () {
                return view('admin.software.services');
            })->name('services');
            
            // Tech Stack
            Route::get('/stack', function () {
                return view('admin.software.stack');
            })->name('stack');
            
            // Tech Portfolio
            Route::get('/portfolio', function () {
                return view('admin.software.portfolio');
            })->name('portfolio');
            
            // Pricing Plans
            Route::get('/pricing', function () {
                return view('admin.software.pricing');
            })->name('pricing');
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
        
        // Products CRUD
        Route::prefix('products')->name('products.')->group(function () {
            // List all products
            Route::get('/', function () {
                return view('admin.products.index');
            })->name('index');
            
            // Create product form
            Route::get('/create', function () {
                return view('admin.products.create');
            })->name('create');
            
            // Store new product
            Route::post('/', function () {
                return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
            })->name('store');
            
            // Edit product form
            Route::get('/{id}/edit', function ($id) {
                return view('admin.products.edit', compact('id'));
            })->name('edit');
            
            // Update product
            Route::put('/{id}', function ($id) {
                return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
            })->name('update');
            
            // Delete product
            Route::delete('/{id}', function ($id) {
                return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
            })->name('destroy');
            
            // Toggle product status
            Route::patch('/{id}/toggle-status', function ($id) {
                return redirect()->back()->with('success', 'Product status updated');
            })->name('toggle-status');
        });
        
        // Product Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', function () {
                return view('admin.categories.index');
            })->name('index');
            
            Route::post('/', function () {
                return redirect()->back()->with('success', 'Category created successfully');
            })->name('store');
            
            Route::put('/{id}', function ($id) {
                return redirect()->back()->with('success', 'Category updated successfully');
            })->name('update');
            
            Route::delete('/{id}', function ($id) {
                return redirect()->back()->with('success', 'Category deleted successfully');
            })->name('destroy');
        });
        
        // ========== MANAJEMEN KONTEN ==========
        
        // Portfolio Items CRUD
        Route::prefix('portfolio-items')->name('portfolio-items.')->group(function () {
            Route::get('/', function () {
                return view('admin.portfolio-items.index');
            })->name('index');
            
            Route::get('/create', function () {
                return view('admin.portfolio-items.create');
            })->name('create');
            
            Route::post('/', function () {
                return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item created');
            })->name('store');
            
            Route::get('/{id}/edit', function ($id) {
                return view('admin.portfolio-items.edit', compact('id'));
            })->name('edit');
            
            Route::put('/{id}', function ($id) {
                return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item updated');
            })->name('update');
            
            Route::delete('/{id}', function ($id) {
                return redirect()->route('admin.portfolio-items.index')->with('success', 'Portfolio item deleted');
            })->name('destroy');
        });
        
        // Testimonials CRUD
        Route::prefix('testimonials')->name('testimonials.')->group(function () {
            Route::get('/', function () {
                return view('admin.testimonials.index');
            })->name('index');
            
            Route::get('/create', function () {
                return view('admin.testimonials.create');
            })->name('create');
            
            Route::post('/', function () {
                return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created');
            })->name('store');
            
            Route::get('/{id}/edit', function ($id) {
                return view('admin.testimonials.edit', compact('id'));
            })->name('edit');
            
            Route::put('/{id}', function ($id) {
                return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated');
            })->name('update');
            
            Route::delete('/{id}', function ($id) {
                return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted');
            })->name('destroy');
            
            // Approve testimonial
            Route::patch('/{id}/approve', function ($id) {
                return redirect()->back()->with('success', 'Testimonial approved');
            })->name('approve');
            
            // Feature testimonial
            Route::patch('/{id}/feature', function ($id) {
                return redirect()->back()->with('success', 'Testimonial featured');
            })->name('feature');
        });
        
        // FAQ Management
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/', function () {
                return view('admin.faq.index');
            })->name('index');
            
            Route::post('/', function () {
                return redirect()->back()->with('success', 'FAQ added');
            })->name('store');
            
            Route::put('/{id}', function ($id) {
                return redirect()->back()->with('success', 'FAQ updated');
            })->name('update');
            
            Route::delete('/{id}', function ($id) {
                return redirect()->back()->with('success', 'FAQ deleted');
            })->name('destroy');
            
            // Reorder FAQs
            Route::post('/reorder', function () {
                return response()->json(['success' => true]);
            })->name('reorder');
        });
        
        // Form Submissions
        Route::prefix('form-submissions')->name('form-submissions.')->group(function () {
            Route::get('/', function () {
                return view('admin.form-submissions.index');
            })->name('index');
            
            Route::get('/{id}', function ($id) {
                return view('admin.form-submissions.show', compact('id'));
            })->name('show');
            
            Route::patch('/{id}/mark-read', function ($id) {
                return redirect()->back()->with('success', 'Marked as read');
            })->name('mark-read');
            
            Route::patch('/{id}/mark-replied', function ($id) {
                return redirect()->back()->with('success', 'Marked as replied');
            })->name('mark-replied');
            
            Route::delete('/{id}', function ($id) {
                return redirect()->route('admin.form-submissions.index')->with('success', 'Submission deleted');
            })->name('destroy');
            
            // Bulk actions
            Route::post('/bulk-mark-read', function () {
                return redirect()->back()->with('success', 'Selected submissions marked as read');
            })->name('bulk-mark-read');
            
            Route::post('/bulk-delete', function () {
                return redirect()->back()->with('success', 'Selected submissions deleted');
            })->name('bulk-delete');
        });
        
        // ========== PENGATURAN ==========
        
        // Website Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            // General Settings
            Route::get('/general', function () {
                return view('admin.settings.general');
            })->name('general');
            
            Route::put('/general', function () {
                return redirect()->back()->with('success', 'General settings updated');
            })->name('general.update');
            
            // Contact Information
            Route::get('/contact', function () {
                return view('admin.settings.contact');
            })->name('contact');
            
            Route::put('/contact', function () {
                return redirect()->back()->with('success', 'Contact information updated');
            })->name('contact.update');
            
            // Social Media
            Route::get('/social', function () {
                return view('admin.settings.social');
            })->name('social');
            
            Route::put('/social', function () {
                return redirect()->back()->with('success', 'Social media links updated');
            })->name('social.update');
            
            // Promo & Discounts
            Route::get('/promo', function () {
                return view('admin.settings.promo');
            })->name('promo');
            
            Route::put('/promo', function () {
                return redirect()->back()->with('success', 'Promo settings updated');
            })->name('promo.update');
            
            // Email Settings
            Route::get('/email', function () {
                return view('admin.settings.email');
            })->name('email');
            
            Route::put('/email', function () {
                return redirect()->back()->with('success', 'Email settings updated');
            })->name('email.update');
            
            // Backup & Restore
            Route::get('/backup', function () {
                return view('admin.settings.backup');
            })->name('backup');
            
            Route::post('/backup/create', function () {
                return redirect()->back()->with('success', 'Backup created successfully');
            })->name('backup.create');
            
            Route::post('/backup/restore', function () {
                return redirect()->back()->with('success', 'Backup restored successfully');
            })->name('backup.restore');
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
        
        // Media Library
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', function () {
                return view('admin.media.index');
            })->name('index');
            
            Route::post('/upload', function () {
                return response()->json(['success' => true]);
            })->name('upload');
            
            Route::delete('/{id}', function ($id) {
                return response()->json(['success' => true]);
            })->name('destroy');
            
            // Browse media
            Route::get('/browse', function () {
                return view('admin.media.browse');
            })->name('browse');
        });
        
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
