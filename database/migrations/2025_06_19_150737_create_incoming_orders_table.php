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
        Schema::create('incoming_orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderID')->unique();
            $table->timestamps();
            $table->integer('quantity');
            $table->string('coffeeType');
            $table->string('status');
            $table->date('deadline');
            $table->string('grade');
            $table->string('destination');
            $table->foreignId('importer_model_id')->constrained()->onDelete('cascade');    

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_orders');
    }
};
