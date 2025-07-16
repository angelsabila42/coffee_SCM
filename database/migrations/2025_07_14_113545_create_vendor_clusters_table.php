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
        Schema::create('vendor_clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendor')->onDelete('cascade');
            $table->integer('total_(60kg_bags)')->default(0);
            $table->integer('robusta_(60kg_bags)')->default(0);
            $table->integer('arabica_(60kg_bags)')->default(0);
            $table->integer('avgPricePerKg_UGX');
            $table->integer('yearsActive')->default(0);
            $table->float('marketShare_pct')->default(0);
            $table->float('arabica_pct')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_clusters');
    }
};
