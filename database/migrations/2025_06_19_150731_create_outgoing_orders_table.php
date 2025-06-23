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
        Schema::create('outgoing_orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderID')->unique();
            $table->timestamps();
            $table->integer('quantity');
            $table->string('status');
            $table->date('deadline');
            $table->string('coffeeType');
            $table->foreignId('vendor_id')->constrained('vendor')->onDelete('cascade'); 
            $table->foreignId('work_center_id')->constrained()->onDelete('cascade');      
            
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_orders');
    }
};
