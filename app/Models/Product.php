<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Product Model
 * 
 * Represents a product in the ecommerce store with colors, sizes, photos and reviews
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'old_price',
        'current_price',
        'qty',
        'featured_photo',
        'description',
        'short_description',
        'features',
        'conditions',
        'return_policy',
        'total_views',
        'is_featured',
        'is_active',
        'end_category_id',
    ];

    protected $casts = [
        'old_price' => 'decimal:2',
        'current_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'total_views' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the end category this product belongs to
     */
    public function endCategory(): BelongsTo
    {
        return $this->belongsTo(EndCategory::class, 'end_category_id');
    }

    /**
     * Get all colors available for this product
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_color')
            ->withTimestamps();
    }

    /**
     * Get all sizes available for this product
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_size')
            ->withTimestamps();
    }

    /**
     * Get all additional photos for this product
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('order');
    }

    /**
     * Get all ratings and reviews for this product
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Get order items for this product
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    /**
     * Get total number of ratings
     */
    public function getTotalRatingsAttribute(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute(): bool
    {
        return $this->qty > 0;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if (!$this->old_price || $this->old_price <= $this->current_price) {
            return null;
        }

        return (int) round((($this->old_price - $this->current_price) / $this->old_price) * 100);
    }

    /**
     * Increment view count
     */
    public function incrementViews(): void
    {
        $this->increment('total_views');
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for in stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }

    /**
     * Scope for latest products
     */
    public function scopeLatest($query, $limit = 10)
    {
        return $query->active()->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope for popular products (most viewed)
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->active()->orderBy('total_views', 'desc')->limit($limit);
    }
}
