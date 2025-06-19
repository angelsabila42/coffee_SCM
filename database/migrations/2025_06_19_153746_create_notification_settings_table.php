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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('in-app-alerts');
            $table->boolean('email-alerts');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained('vendor')->onDelete('cascade');
            $table->foreignId('transporters_id')->constrained()->onDelete('cascade');
            $table->foreignId('importer_model_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
