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
        Schema::create('importer_demands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('importer_model_id')->constrained()->onDelete('cascade'); 
            $table->integer('robusta_(60kg_bags)')->default(0);
            $table->integer('arabica_(60kg_bags)')->default(0);
            $table->integer('yearsAsCustomer')->default(0);
            $table->integer('orderFreqPerYear')->default(0);
            $table->integer('total_(60kg_bags)')->default(0);
            $table->decimal('arabica_pct',5,2)->default(0);
            $table->integer('avgOrderSize')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importer_demands');
    }
};
