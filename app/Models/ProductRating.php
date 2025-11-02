<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ProductRating Model
 * 
 * Represents customer ratings and reviews for products
 */
class ProductRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
        'comment',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the product being rated
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the customer who made the rating
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
