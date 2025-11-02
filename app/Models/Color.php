<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Color Model
 * 
 * Represents product color options (e.g., Red, Blue, Black)
 */
class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'hex_code',
    ];

    /**
     * Get all products with this color
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_color')
            ->withTimestamps();
    }
}
