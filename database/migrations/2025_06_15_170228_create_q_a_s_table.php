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
        Schema::create('q_a_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('reportID');
            $table->date('start_period');
            $table->date('end_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_a_s');
    }
};
