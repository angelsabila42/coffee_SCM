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
        Schema::create('coffee_batches', function (Blueprint $table) {
             $table->id(); 
            $table->string('coffee_type'); // e.g., 'Arabica', 'Robusta'
            $table->string('grade');       // e.g., 'Grade A', 'Commercial', 'Specialty'
            $table->decimal('price_per_kilogram', 8, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffee_batches');
    }
};
