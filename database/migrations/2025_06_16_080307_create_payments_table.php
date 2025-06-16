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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique(); // e.g., PL_7248, Receipt# 4343
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null'); // Link to invoice, nullable if payment is not directly tied to an existing invoice
            $table->string('payer');
            $table->decimal('amount_paid', 10, 2);
            $table->date('date_paid');
            $table->string('payment_mode')->nullable();
            $table->string('status')->default('Sent'); // e.g., Sent, Awaiting Pay, Paid
            $table->string('coffee_type')->nullable(); // From Payment Records table
            $table->string('payment_description')->nullable(); // From Payment Records table (e.g., Batch 10)
            $table->string('recipient_name')->nullable(); // From Payment Records table
            $table->string('receipt_file_path')->nullable(); // To store the uploaded receipt file path
            $table->timestamps();
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
