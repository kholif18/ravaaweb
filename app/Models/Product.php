<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
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
    ];

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
            ->withTimestamps();
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
    public function getSellingPriceAttribute(): float
    {
        return $this->hasDiscount() ? $this->discount_price : $this->price;
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
     * Check if product is low in stock.
     */
    public function isLowStock(): bool
    {
        if (!$this->manage_stock) {
            return false;
        }

        return $this->stock_quantity <= $this->minimum_stock && $this->stock_quantity > 0;
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
        if ($this->main_image) {
            return asset('storage/products/' . $this->main_image);
        }

        // Fallback to first image in images array
        if (!empty($this->images)) {
            $images = json_decode($this->images, true);
            if (!empty($images[0])) {
                return asset('storage/products/' . $images[0]);
            }
        }

        return asset('images/default-product.png');
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute(): array
    {
        $urls = [];
        
        // Add main image first
        if ($this->main_image) {
            $urls[] = asset('storage/products/' . $this->main_image);
        }

        // Add other images
        if (!empty($this->images)) {
            $images = json_decode($this->images, true);
            foreach ($images as $image) {
                if ($image !== $this->main_image) {
                    $urls[] = asset('storage/products/' . $image);
                }
            }
        }

        // If no images, add default
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
}