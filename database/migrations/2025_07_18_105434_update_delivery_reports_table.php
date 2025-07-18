<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('delivery_reports', function (Blueprint $table) {
        $table->string('title')->nullable();
        $table->json('data')->nullable(); // Delivery entries
        $table->integer('total_deliveries')->default(0);
    });
}

public function down(): void
{
    Schema::table('delivery_reports', function (Blueprint $table) {
        $table->dropColumn(['title', 'data', 'total_deliveries']);
    });
}

};
