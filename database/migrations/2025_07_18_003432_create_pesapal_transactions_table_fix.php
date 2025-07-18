<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesapal_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('pesapal_tracking_id')->nullable();
            $table->string('pesapal_merchant_reference')->unique();
            $table->foreignId('importer_id')->constrained('importer_models');
            $table->json('order_ids'); // Store selected order IDs
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('PENDING'); // PENDING, COMPLETED, FAILED, CANCELLED
            $table->string('payment_method')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->json('pesapal_response')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesapal_transactions');
    }
};
