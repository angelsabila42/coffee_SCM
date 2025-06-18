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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date'); // Corresponds to Order Date/Invoice Date
            $table->string('vendor_name')->nullable(); // e.g., Elgon Cooperative
            $table->string('vendor_po_box')->nullable();
            $table->string('vendor_city')->nullable();
            $table->string('vendor_country')->nullable();
            $table->string('bill_to_name'); // e.g., GlobalBean Connect Exporters
            $table->string('bill_to_po_box')->nullable();
            $table->string('bill_to_city')->nullable();
            $table->string('bill_to_country')->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('currency')->default('Ugx'); // Default to Uganda Shillings
            $table->string('bank_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('status')->default('Sent'); // e.g., Sent, Awaiting Pay, Paid
            $table->string('purpose')->nullable(); // e.g., Batch 10
            $table->string('recipient_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
