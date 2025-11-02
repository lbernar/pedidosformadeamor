<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Slider Model
 * 
 * Represents homepage carousel/slider items
 */
class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo',
        'heading',
        'content',
        'button_text',
        'button_url',
        'position',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope for active sliders
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered sliders
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
