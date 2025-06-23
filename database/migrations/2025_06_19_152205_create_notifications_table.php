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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('NotID')->unique();
            $table->timestamps();
            $table->boolean('is_read');
            $table->text('message');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendor')->onDelete('cascade');
            $table->foreignId('transporters_id')->constrained()->onDelete('cascade');
            $table->foreignId('importer_model_id')->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('incoming_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('outgoing_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
