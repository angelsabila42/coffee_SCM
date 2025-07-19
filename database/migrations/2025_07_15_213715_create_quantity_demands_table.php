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
        Schema::create('quantity_demands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('importer_model_id')->constrained()->onDelete('cascade'); 
            $table->string('year',8);
            $table->biginteger('quantity_(60kg_bags)');
            $table->string('yearsAsCustomer');
            $table->integer('orderFreqPerYear');
            $table->integer('avgOrderSize_kg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantity_demands');
    }
};
