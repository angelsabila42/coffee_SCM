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

        Schema::create('order_status_loggers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('action'); 
            $table->morphs('loggable'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_loggers');
    }
};
