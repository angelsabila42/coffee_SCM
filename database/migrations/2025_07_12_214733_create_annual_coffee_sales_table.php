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
        Schema::create('annual_coffee_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('year',8);
            $table->biginteger('bags_60kg');
            $table->biginteger('metric_tonnes');
            $table->biginteger('value_usd');
            $table->decimal('unit_value_usd_per_kg', 8, 2);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_coffee_sales');
    }
};
