<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates site settings table for configuration
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('footer_about')->nullable();
            $table->text('footer_copyright')->nullable();
            
            // Contact Information
            $table->text('contact_address')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('contact_map_iframe')->nullable();
            
            // SEO Meta Tags
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            
            // Home Page Settings
            $table->boolean('home_service_enabled')->default(true);
            $table->boolean('home_featured_products_enabled')->default(true);
            $table->boolean('home_latest_products_enabled')->default(true);
            $table->integer('featured_products_limit')->default(8);
            $table->integer('latest_products_limit')->default(8);
            
            // Payment Gateways
            $table->string('paypal_email')->nullable();
            $table->string('stripe_public_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->text('bank_details')->nullable();
            
            // Scripts
            $table->text('before_head_scripts')->nullable();
            $table->text('after_body_scripts')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
