<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Mid Level Category Model
 * 
 * Represents the middle level in the category hierarchy (e.g., Accessories, Shoes, Clothing)
 */
class MidCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mid_categories';

    protected $fillable = [
        'name',
        'top_category_id',
    ];

    /**
     * Get the parent top category
     */
    public function topCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'top_category_id');
    }

    /**
     * Get all end categories under this mid category
     */
    public function endCategories(): HasMany
    {
        return $this->hasMany(EndCategory::class, 'mid_category_id');
    }

    /**
     * Get all products under this mid category through end categories
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            EndCategory::class,
            'mid_category_id',
            'end_category_id'
        );
    }
}
