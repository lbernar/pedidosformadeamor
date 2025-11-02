<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates payments table for tracking payment transactions
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('payment_id')->unique(); // Internal payment ID
            $table->string('transaction_id')->nullable(); // External payment gateway ID
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            $table->enum('payment_method', ['paypal', 'stripe', 'bank_transfer', 'pix'])->default('pix');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            
            // Card Information (last 4 digits only, never store full card)
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            
            // Bank Transfer Information
            $table->text('bank_transfer_info')->nullable();
            
            // PIX Information
            $table->string('pix_key')->nullable();
            $table->string('pix_qr_code')->nullable();
            
            // Payment Gateway Response
            $table->json('gateway_response')->nullable();
            
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('customer_id');
            $table->index('payment_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
