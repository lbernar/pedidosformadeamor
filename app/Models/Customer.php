<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Customer Model
 * 
 * Represents a customer account with authentication and order history
 * Uses bcrypt for password hashing (secure replacement for MD5)
 */
class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'billing_name',
        'billing_company',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_country',
        'shipping_name',
        'shipping_company',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip_code',
        'shipping_country',
        'token',
        'email_verified_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Automatically hash password when setting
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Get all orders for this customer
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all payments made by this customer
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all messages/tickets from this customer
     */
    public function messages(): HasMany
    {
        return $this->hasMany(CustomerMessage::class);
    }

    /**
     * Get all product ratings by this customer
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Check if customer has billing address
     */
    public function hasBillingAddress(): bool
    {
        return !empty($this->billing_address);
    }

    /**
     * Check if customer has shipping address
     */
    public function hasShippingAddress(): bool
    {
        return !empty($this->shipping_address);
    }

    /**
     * Get total orders count
     */
    public function getTotalOrdersAttribute(): int
    {
        return $this->orders()->count();
    }

    /**
     * Get total spent amount
     */
    public function getTotalSpentAttribute(): float
    {
        return $this->orders()
            ->where('status', 'completed')
            ->sum('total');
    }
}
