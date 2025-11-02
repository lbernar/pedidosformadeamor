<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ProductPhoto Model
 * 
 * Represents additional photos for a product
 */
class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'photo',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the product this photo belongs to
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
