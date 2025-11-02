<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the products table and related pivot tables for colors, sizes, and photos
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('current_price', 10, 2);
            $table->integer('qty')->default(0);
            $table->string('featured_photo');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('features')->nullable();
            $table->text('conditions')->nullable();
            $table->text('return_policy')->nullable();
            $table->integer('total_views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('end_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('end_category_id');
            $table->index('is_featured');
            $table->index('is_active');
            $table->index('slug');
        });

        // Product Photos (multiple photos per product)
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('photo');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('product_id');
        });

        // Product Colors (Many-to-Many)
        Schema::create('product_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_id', 'color_id']);
        });

        // Product Sizes (Many-to-Many)
        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_id', 'size_id']);
        });

        // Product Ratings and Reviews
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->timestamps();

            $table->index('product_id');
            $table->index('customer_id');
            $table->unique(['product_id', 'customer_id']); // One review per customer per product
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ratings');
        Schema::dropIfExists('product_size');
        Schema::dropIfExists('product_color');
        Schema::dropIfExists('product_photos');
        Schema::dropIfExists('products');
    }
};
