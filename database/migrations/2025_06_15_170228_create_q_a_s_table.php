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
            $table->string('reportID')->unique();
            $table->date('date');
            $table->string('testers_initials');
            $table->string('region');
            $table->foreignId('vendor_id')->constrained('vendor');
            $table->string('ref');
            $table->string('crop_year');
            $table->string('screen_description')->nullable();
            $table->string('color');
            $table->json('defects')->nullable();
            $table->string('fragrance');
            $table->decimal('moisture_content', 8, 2);
            $table->text('overall_impression');
            $table->enum('status', ['draft', 'submitted'])->default('draft');
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
