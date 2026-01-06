<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'category_id',
        'description',
        'short_description',
        'price',
        'discount_price',
        'discount_start',
        'discount_end',
        'cost_price',
        'stock_quantity',
        'minimum_stock',
        'stock_status',
        'manage_stock',
        'is_featured',
        'is_best_seller',
        'is_new_arrival',
        'weight',
        'length',
        'width',
        'height',
        'unit',
        'tags',
        'colors',
        'sizes',
        'images',
        'main_image',
        'specifications',
        'features',
        'usage_instructions',
        'warranty_info',
        'status',
        'view_count',
        'sold_count',
        'order_count',
        'rating_average',
        'rating_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
        'has_variants',
        'variant_attributes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
        'manage_stock' => 'boolean',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'tags' => 'array',
        'colors' => 'array',
        'sizes' => 'array',
        'images' => 'array',
        'view_count' => 'integer',
        'sold_count' => 'integer',
        'order_count' => 'integer',
        'rating_average' => 'decimal:2',
        'rating_count' => 'integer',
        'published_at' => 'datetime',
        'has_variants' => 'boolean',
        'variant_attributes' => 'array',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }
    
    // Harga terendah dari semua varian
    public function getMinPriceAttribute()
    {
        if (!$this->has_variants) {
            return $this->price;
        }
        
        return $this->variants()->min('price');
    }
    
    // Harga tertinggi dari semua varian
    public function getMaxPriceAttribute()
    {
        if (!$this->has_variants) {
            return $this->price;
        }
        
        return $this->variants()->max('price');
    }
    
    // Mendapatkan varian berdasarkan atribut
    public function getVariantByAttributes($attributes)
    {
        return $this->variants()
            ->where('attribute_options', json_encode($attributes))
            ->first();
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate slug if empty
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            // Generate SKU if empty
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8)) . '-' . time();
            }

            // Set published_at if status is published
            if ($product->status === 'published' && empty($product->published_at)) {
                $product->published_at = now();
            }
        });

        static::updating(function ($product) {
            // Update slug if name changed
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            // Set published_at if status changed to published
            if ($product->isDirty('status') && $product->status === 'published' && empty($product->published_at)) {
                $product->published_at = now();
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the orders that contain this product.
     */
    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class, 'order_items')
    //         ->withPivot('quantity', 'price', 'discount', 'total')
    //         ->withTimestamps();
    // }

    // /**
    //  * Get the reviews for the product.
    //  */
    // public function reviews()
    // {
    //     return $this->hasMany(ProductReview::class);
    // }

    // /**
    //  * Get the wishlist items for the product.
    //  */
    // public function wishlistItems()
    // {
    //     return $this->hasMany(WishlistItem::class);
    // }

    // /**
    //  * Get the product variations.
    //  */
    // public function variations()
    // {
    //     return $this->hasMany(ProductVariation::class);
    // }

    /**
     * Get related products.
     */
    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id')
            ->withTimestamps()
            ->withPivot('order')
            ->withTimestamps()
            ->orderByPivot('order');
    }

    /**
     * Get cross-sell products.
     */
    public function crossSellProducts()
    {
        return $this->belongsToMany(Product::class, 'product_cross_sells', 'product_id', 'cross_sell_product_id')
            ->withTimestamps();
    }

    /**
     * Get products that this product is related to.
     */
    public function relatedTo()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'related_product_id', 'product_id')
            ->withPivot('order')
            ->withTimestamps()
            ->orderByPivot('order');
    }

    /**
     * Get up-sell products.
     */
    public function upSellProducts()
    {
        return $this->belongsToMany(Product::class, 'product_up_sells', 'product_id', 'up_sell_product_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include best seller products.
     */
    public function scopeBestSeller($query)
    {
        return $query->where('is_best_seller', true);
    }

    /**
     * Scope a query to only include new arrival products.
     */
    public function scopeNewArrival($query)
    {
        return $query->where('is_new_arrival', true);
    }

    /**
     * Scope a query to only include in stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

    /**
     * Scope a query to order by best selling.
     */
    public function scopeBestSelling($query)
    {
        return $query->orderBy('sold_count', 'desc');
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopeMostViewed($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * Scope a query to order by rating.
     */
    public function scopeTopRated($query)
    {
        return $query->orderBy('rating_average', 'desc');
    }

    /**
     * Scope a query to order by price.
     */
    public function scopePrice($query, $order = 'asc')
    {
        return $query->orderBy('price', $order);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Check if product has discount.
     */
    public function hasDiscount(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentageAttribute(): ?float
    {
        if (!$this->hasDiscount()) {
            return null;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100, 2);
    }

    /**
     * Get selling price (discounted price or regular price).
     */
    public function getSellingPriceAttribute()
    {
        if ($this->has_variants) {
            // Untuk produk varian, return harga terendah dari semua varian
            $minPrice = $this->variants()->min('price');
            
            // Cek apakah ada varian dengan diskon aktif
            $variantWithDiscount = $this->variants()->activeDiscount()->orderBy('discount_price')->first();
            
            if ($variantWithDiscount) {
                return $variantWithDiscount->discount_price < $minPrice ? 
                    $variantWithDiscount->discount_price : $minPrice;
            }
            
            return $minPrice;
        }
        
        // Untuk produk non-varian
        if ($this->hasActiveDiscount()) {
            return $this->discount_price;
        }
        
        return $this->price;
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        if (!$this->manage_stock) {
            return $this->stock_status === 'in_stock';
        }

        return $this->stock_quantity > 0 && $this->stock_status === 'in_stock';
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        if (!$this->manage_stock) {
            return $this->stock_status === 'out_of_stock';
        }

        return $this->stock_quantity <= 0 || $this->stock_status === 'out_of_stock';
    }

    /**
     * Get stock status text.
     */
    public function getStockStatusTextAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'Stok Habis';
        }

        if ($this->isLowStock()) {
            return 'Stok Terbatas';
        }

        if ($this->stock_status === 'pre_order') {
            return 'Pre Order';
        }

        if ($this->stock_status === 'backorder') {
            return 'Back Order';
        }

        return 'Tersedia';
    }

    /**
     * Get stock status badge class.
     */
    public function getStockStatusBadgeClassAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'danger';
        }

        if ($this->isLowStock()) {
            return 'warning';
        }

        if ($this->stock_status === 'pre_order') {
            return 'info';
        }

        if ($this->stock_status === 'backorder') {
            return 'primary';
        }

        return 'success';
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted discount price.
     */
    public function getFormattedDiscountPriceAttribute(): ?string
    {
        if (!$this->hasDiscount()) {
            return null;
        }

        return 'Rp ' . number_format($this->discount_price, 0, ',', '.');
    }

    /**
     * Get formatted selling price.
     */
    public function getFormattedSellingPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->selling_price, 0, ',', '.');
    }

    /**
     * Get main image URL.
     */
    public function getMainImageUrlAttribute(): ?string
    {
        
        // Jika ada main_image
        if ($this->main_image) {
            // Cek apakah sudah full URL (misal dari external source)
            if (filter_var($this->main_image, FILTER_VALIDATE_URL)) {
                return $this->main_image;
            }
            
            // Gunakan Storage facade (lebih konsisten dengan Laravel)
            
            // Juga fallback ke asset() jika Storage gagal
            try {
                if (Storage::disk('public')->exists('products/' . $this->main_image)) {
                    return Storage::disk('public')->url('products/' . $this->main_image);
                }
            } catch (\Exception $e) {
                // Fallback ke asset jika ada error
                return asset('storage/products/' . $this->main_image);
            }
        }

        // Fallback to first image in images array
        $images = $this->image_urls;
        if (!empty($images[0])) {
            return $images[0];
        }

        return asset('images/default-product.png');
    }

    /**
     * Get all image URLs as array
     * Ini untuk kompatibilitas dengan view yang menggunakan $product->images
     */
    public function getImagesAttribute($value)
    {
        // Jika value dari database adalah JSON, decode
        if (is_string($value) && !empty($value)) {
            $images = json_decode($value, true);
            return is_array($images) ? $images : [];
        }
        
        // Jika sudah array atau null
        return $value ?? [];
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute(): array
    {
        $urls = [];
        
        // Add main image first
        if ($this->main_image && !filter_var($this->main_image, FILTER_VALIDATE_URL)) {
            try {
                if (Storage::disk('public')->exists('products/' . $this->main_image)) {
                    $urls[] = Storage::disk('public')->url('products/' . $this->main_image);
                } else {
                    $urls[] = asset('storage/products/' . $this->main_image);
                }
            } catch (\Exception $e) {
                $urls[] = asset('storage/products/' . $this->main_image);
            }
        }

        // Add other images from images field
        $images = $this->images;
        if (!empty($images) && is_array($images)) {
            foreach ($images as $image) {
                // Skip jika sama dengan main_image
                if ($image === $this->main_image) {
                    continue;
                }
                
                // Handle full URL atau filename
                if (filter_var($image, FILTER_VALIDATE_URL)) {
                    $urls[] = $image;
                } else {
                    try {
                        if (Storage::disk('public')->exists('products/' . $image)) {
                            $urls[] = Storage::disk('public')->url('products/' . $image);
                        } else {
                            $urls[] = asset('storage/products/' . $image);
                        }
                    } catch (\Exception $e) {
                        $urls[] = asset('storage/products/' . $image);
                    }
                }
            }
        }

        // Jika tidak ada gambar sama sekali
        if (empty($urls)) {
            $urls[] = asset('images/default-product.png');
        }

        return $urls;
    }

    /**
     * Get categories hierarchy.
     */
    public function getCategoryHierarchyAttribute(): array
    {
        $hierarchy = [];
        
        if ($this->category) {
            $category = $this->category;
            
            // Add all ancestors
            while ($category) {
                $hierarchy[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
                
                $category = $category->parent;
            }
            
            $hierarchy = array_reverse($hierarchy);
        }
        
        return $hierarchy;
    }

    /**
     * Get estimated profit.
     */
    public function getEstimatedProfitAttribute(): ?float
    {
        if (!$this->cost_price) {
            return null;
        }

        return $this->selling_price - $this->cost_price;
    }

    /**
     * Get profit margin percentage.
     */
    public function getProfitMarginAttribute(): ?float
    {
        if (!$this->cost_price || $this->cost_price <= 0) {
            return null;
        }

        $profit = $this->selling_price - $this->cost_price;
        return round(($profit / $this->cost_price) * 100, 2);
    }

    /**
     * Increment view count.
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Update sold count.
     */
    public function updateSoldCount(int $quantity): void
    {
        $this->increment('sold_count', $quantity);
        $this->decrement('stock_quantity', $quantity);
        
        // Update stock status if needed
        if ($this->stock_quantity <= 0) {
            $this->update(['stock_status' => 'out_of_stock']);
        } elseif ($this->stock_quantity <= $this->minimum_stock) {
            $this->update(['stock_status' => 'in_stock']);
        }
    }

    /**
     * Add rating.
     */
    public function addRating(int $rating): void
    {
        $totalRating = ($this->rating_average * $this->rating_count) + $rating;
        $this->rating_count++;
        $this->rating_average = $totalRating / $this->rating_count;
        $this->save();
    }

    // Method untuk cek diskon aktif dengan tanggal
    public function hasActiveDiscount(): bool
    {
        if ($this->has_variants) {
            // Untuk produk varian, cek apakah ada varian dengan diskon aktif
            return $this->variants()->activeDiscount()->exists();
        }
        
        // Untuk produk non-varian dengan sistem tanggal
        return $this->discount_price && 
            $this->discount_start && 
            $this->discount_end &&
            now()->between($this->discount_start, $this->discount_end);
    }

    // Method untuk cek stok rendah yang sudah disesuaikan dengan varian
    public function isLowStock(): bool
    {
        if ($this->has_variants) {
            // Untuk produk varian, cek total stok
            $totalStock = $this->variants()->sum('stock_quantity');
            return $totalStock > 0 && $totalStock <= $this->minimum_stock;
        }
        
        return $this->stock_quantity > 0 && $this->stock_quantity <= $this->minimum_stock;
    }

    // Scope untuk produk dengan diskon aktif
    public function scopeWithActiveDiscount($query)
    {
        return $query->where(function($q) {
            $q->where(function($q1) {
                // Produk non-varian dengan diskon aktif
                $q1->where('has_variants', false)
                ->whereNotNull('discount_price')
                ->where('discount_start', '<=', now())
                ->where('discount_end', '>=', now());
            })->orWhereHas('variants', function($q2) {
                // Produk varian dengan varian yang punya diskon aktif
                $q2->whereNotNull('discount_price')
                ->where('discount_start', '<=', now())
                ->where('discount_end', '>=', now());
            });
        });
    }
}