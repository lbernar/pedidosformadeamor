<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Top Level Category Model
 * 
 * Represents the highest level in the category hierarchy (e.g., Men, Women, Kids)
 */
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'top_categories';

    protected $fillable = [
        'name',
        'show_on_menu',
    ];

    protected $casts = [
        'show_on_menu' => 'boolean',
    ];

    /**
     * Get all mid-level categories under this top category
     */
    public function midCategories(): HasMany
    {
        return $this->hasMany(MidCategory::class, 'top_category_id');
    }

    /**
     * Get all end categories through mid categories
     */
    public function endCategories()
    {
        return $this->hasManyThrough(
            EndCategory::class,
            MidCategory::class,
            'top_category_id',
            'mid_category_id'
        );
    }

    /**
     * Get all products under this top category
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
