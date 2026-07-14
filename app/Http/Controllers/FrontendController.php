<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactSubmission;
use App\Models\PortfolioItem;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    private function getSettings(): array
    {
        $settings = Setting::allAsArray();
        if (!empty($settings['logo_media_id'])) {
            $media = \App\Models\Media::find($settings['logo_media_id']);
            if ($media) {
                $settings['site_logo'] = $media->url;
            }
        }
        return $settings;
    }

    /**
     * Format price to Rupiah string
     */
    private function formatPrice($price): string
    {
        return 'Rp ' . number_format((float) $price, 0, ',', '.');
    }

    /**
     * Get display data for a product (used in cards/lists)
     */
    private function productDisplayData(Product $product): object
    {
        $thumb = $product->thumbnail ?? $product->media()->first();
        $imageUrl = $thumb?->url ?? asset('images/default-image.png');

        // Determine badge
        $badge = '';
        if ($product->discount_active) {
            $badge = 'Diskon ' . ($product->discount_percent > 0 ? round($product->discount_percent) . '%' : 'Spesial');
        } elseif ($product->is_featured) {
            $badge = 'Unggulan';
        }

        // Handle variants price
        $variants = $product->variants ? $product->variants->filter(fn($v) => $v->is_active) : collect();
        $hasVariants = $variants->count() > 0;

        if ($hasVariants) {
            $minPrice = $variants->min(fn($v) => (float) $v->effective_price);
            $maxPrice = $variants->max(fn($v) => (float) $v->effective_price);

            if ($minPrice === $maxPrice) {
                $effectivePrice = $this->formatPrice($minPrice);
            } else {
                $effectivePrice = 'Mulai ' . $this->formatPrice($minPrice);
            }
            $price = $this->formatPrice($variants->min(fn($v) => (float) $v->price));
            $originalPrice = null;

            // Show discount badge if any variant is discounted and main product badge is empty
            if (empty($badge)) {
                $discountedVariants = $variants->filter(fn($v) => $v->discount_active);
                if ($discountedVariants->count() > 0) {
                    $maxDiscount = $discountedVariants->max(fn($v) => (float) $v->discount_percent);
                    if ($maxDiscount > 0) {
                        $badge = 'Diskon ' . round($maxDiscount) . '%';
                    }
                }
            }
        } else {
            $price = $this->formatPrice($product->price);
            $originalPrice = $product->discount_active ? $this->formatPrice($product->price) : null;
            $effectivePrice = $this->formatPrice($product->effective_price);
        }

        return (object) [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => $product->category?->name ?? '',
            'category_slug' => $product->category?->slug ?? '',
            'price' => $price,
            'original_price' => $originalPrice,
            'effective_price' => $effectivePrice,
            'image' => $imageUrl,
            'badge' => $badge,
            'type' => $product->is_service ? 'service' : 'product',
            'description' => strip_tags($product->short_description ?? $product->description ?? ''),
            'short_description' => strip_tags($product->short_description ?? ''),
            'stock' => $product->stock,
            'is_featured' => $product->is_featured,
            'has_variants' => $hasVariants,
        ];
    }

    public function home()
    {
        $defaultContent = [
            'hero' => [
                'banner_ids' => [],
            ],
            'categories' => [
                'title' => 'Kategori Layanan',
                'subtitle' => 'Solusi lengkap untuk kebutuhan kreatif bisnis Anda',
                'category_ids' => [],
            ],
            'products' => [
                'title' => 'Produk Unggulan',
                'subtitle' => 'Temukan produk terbaik pilihan untuk kebutuhan Anda',
                'type' => 'featured',
                'limit' => 8,
                'product_ids' => [],
            ],
            'rich_text' => [
                'title' => '',
                'content' => '',
                'is_visible' => false,
            ]
        ];

        $page = \App\Models\Page::where('slug', 'home')->first();
        $content = array_replace_recursive($defaultContent, $page?->content ?? []);

        // 1. Query Banners
        $bannerQuery = Banner::active()->ordered();
        if (!empty($content['hero']['banner_ids'])) {
            $bannerQuery->whereIn('id', $content['hero']['banner_ids']);
        }
        $banners = $bannerQuery->get();

        // 2. Query Categories
        $categoryQuery = Category::where('status', 'active')->orderBy('order');
        if (!empty($content['categories']['category_ids'])) {
            $categoryQuery->whereIn('id', $content['categories']['category_ids']);
        }
        $categories = $categoryQuery->get();

        // 3. Query Products
        $limit = (int) ($content['products']['limit'] ?? 8);
        $productType = $content['products']['type'] ?? 'featured';
        
        $productQuery = Product::where('status', 'active')
            ->with(['category', 'thumbnail', 'media', 'variants']);

        if ($productType === 'featured') {
            $productQuery->where('is_featured', true)->latest();
        } elseif ($productType === 'latest') {
            $productQuery->latest();
        } elseif ($productType === 'selected' && !empty($content['products']['product_ids'])) {
            $productQuery->whereIn('id', $content['products']['product_ids']);
        } else {
            $productQuery->where('is_featured', true)->latest();
        }

        $products = $productQuery->limit($limit)->get()->map(fn($p) => $this->productDisplayData($p));

        $settings = $this->getSettings();

        return view('frontend.home', compact('categories', 'products', 'banners', 'settings', 'content'));
    }

    public function layanan()
    {
        $services = Service::active()->ordered()->get();
        $settings = $this->getSettings();
        return view('frontend.layanan', compact('services', 'settings'));
    }

    public function product(Request $request)
    {
        $categories = Category::where('status', 'active')->orderBy('order')->get();

        $query = Product::where('status', 'active')
            ->with(['category', 'thumbnail', 'media', 'variants']);

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by type (service/product)
        if ($request->filled('type') && $request->type !== 'all') {
            $isService = $request->type === 'service';
            $query->where('is_service', $isService);
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $products->getCollection()->transform(fn($p) => $this->productDisplayData($p));

        $settings = $this->getSettings();

        return view('frontend.product', compact('categories', 'products', 'settings'));
    }

    public function detailProduct($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category', 'media', 'variants.media', 'tags', 'thumbnail'])
            ->firstOrFail();

        // Gallery images
        $galleryImages = $product->media->map(fn($m) => [
            'id' => $m->id,
            'url' => $m->url,
            'name' => $m->name,
        ])->toArray();

        // Main image
        $mainImage = $product->thumbnail?->url ?? ($product->media->first()?->url ?? asset('images/default-image.png'));

        // Badge
        $badge = '';
        $badgeType = '';
        if ($product->discount_active) {
            $badge = 'Diskon ' . round($product->discount_percent) . '%';
            $badgeType = 'discount';
        } elseif ($product->is_featured) {
            $badge = 'Unggulan';
            $badgeType = 'featured';
        }

        // Features from product
        $features = $product->features ?? [];

        // Variants
        $variants = $product->variants->filter(fn($v) => $v->is_active);

        // Price display
        if ($variants->count() > 0) {
            $minPrice = $variants->min(fn($v) => (float) $v->effective_price);
            $maxPrice = $variants->max(fn($v) => (float) $v->effective_price);

            if ($minPrice == $maxPrice) {
                $priceDisplay = $this->formatPrice($minPrice);
            } else {
                $priceDisplay = $this->formatPrice($minPrice) . ' - ' . $this->formatPrice($maxPrice);
            }
            $originalPrice = null;
        } else {
            $priceDisplay = $this->formatPrice($product->effective_price);
            $originalPrice = $product->discount_active ? $this->formatPrice($product->price) : null;
        }

        // Group variant types
        $variantTypes = [];
        if ($product->variant_types) {
            foreach ($product->variant_types as $vt) {
                $variantTypes[$vt['name']] = $vt['values'] ?? [];
            }
        }

        // Related products (same category, exclude current)
        $relatedProducts = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'thumbnail', 'variants'])
            ->limit(4)
            ->latest()
            ->get()
            ->map(fn($p) => $this->productDisplayData($p));

        // Stock status
        $totalStock = $variants->count() > 0
            ? $variants->sum('stock')
            : $product->stock;
        $inStock = $totalStock > 0;

        $settings = $this->getSettings();

        return view('frontend.detail-product', compact(
            'product', 'galleryImages', 'mainImage', 'priceDisplay',
            'originalPrice', 'badge', 'badgeType', 'features',
            'variants', 'variantTypes', 'relatedProducts',
            'inStock', 'totalStock', 'settings'
        ));
    }

    public function portofolio()
    {
        $portfolioItems = PortfolioItem::active()->ordered()->get();
        $settings = $this->getSettings();
        return view('frontend.portofolio', compact('portfolioItems', 'settings'));
    }

    public function softwareHouse()
    {
        $portfolioItems = PortfolioItem::active()->ordered()->get();
        $service = Service::where('name', 'Software House')->first();
        
        $defaultContent = [
            'hero' => [
                'title' => 'Software House',
                'description' => 'Kami mengembangkan solusi digital custom untuk bisnis Anda — dari website hingga aplikasi mobile dan IoT.',
            ],
            'layanan' => [
                'title' => 'Layanan Pengembangan Software',
                'subtitle' => 'Kami menyediakan layanan pengembangan software end-to-end yang disesuaikan dengan kebutuhan bisnis Anda.',
            ],
            'proses' => [
                'title' => 'Bagaimana Kami Bekerja',
                'subtitle' => 'Langkah-langkah sistematis untuk menghadirkan solusi software terbaik bagi bisnis Anda.',
                'steps' => [
                    ['title' => 'Konsultasi', 'description' => 'Diskusi kebutuhan dan tujuan bisnis Anda untuk menentukan solusi yang tepat.'],
                    ['title' => 'Desain', 'description' => 'Perancangan arsitektur sistem dan antarmuka pengguna yang intuitif.'],
                    ['title' => 'Development', 'description' => 'Proses pengembangan menggunakan teknologi terkini dengan standar kualitas tinggi.'],
                    ['title' => 'Launch', 'description' => 'Deployment ke production dan pendampingan hingga sistem berjalan lancar.'],
                ]
            ],
            'portfolio' => [
                'title' => 'Proyek Software Kami',
                'subtitle' => 'Beberapa proyek pengembangan software yang telah kami selesaikan.',
                'categories' => ['Web App', 'Mobile App', 'IoT & Embedded'],
            ]
        ];

        $page = \App\Models\Page::getBySlug('software-house', $defaultContent);
        $dbContent = $page->content ?? [];
        $content = array_replace_recursive($defaultContent, $dbContent);

        $settings = $this->getSettings();
        return view('frontend.software-house', compact('portfolioItems', 'service', 'content', 'settings'));
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('frontend.contact', compact('settings'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactSubmission::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
        }

        return redirect()->route('contact')->with('success', 'Pesan berhasil dikirim!');
    }
}
