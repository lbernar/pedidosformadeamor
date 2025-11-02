<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * End Level Category Model
 * 
 * Represents the final/deepest level in the category hierarchy (e.g., Boots, Sneakers, T-Shirts)
 * This is where products are directly assigned
 */
class EndCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'end_categories';

    protected $fillable = [
        'name',
        'mid_category_id',
    ];

    /**
     * Get the parent mid category
     */
    public function midCategory(): BelongsTo
    {
        return $this->belongsTo(MidCategory::class, 'mid_category_id');
    }

    /**
     * Get all products in this end category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'end_category_id');
    }

    /**
     * Get the top category through mid category
     */
    public function topCategory()
    {
        return $this->midCategory->topCategory ?? null;
    }
}
