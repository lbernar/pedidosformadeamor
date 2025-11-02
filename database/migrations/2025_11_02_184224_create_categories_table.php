<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates a hierarchical category system with three levels:
     * - Top Level Categories (Men, Women, Kids)
     * - Mid Level Categories (Accessories, Shoes, etc)
     * - End Level Categories (Final product categories)
     */
    public function up(): void
    {
        // Top Level Categories
        Schema::create('top_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('show_on_menu')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Mid Level Categories
        Schema::create('mid_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('top_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('top_category_id');
        });

        // End Level Categories (Final product categories)
        Schema::create('end_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('mid_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('mid_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('end_categories');
        Schema::dropIfExists('mid_categories');
        Schema::dropIfExists('top_categories');
    }
};
