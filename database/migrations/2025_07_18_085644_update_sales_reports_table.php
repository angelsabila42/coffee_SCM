<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_reports', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->json('data')->nullable();
            $table->decimal('total_sales', 12, 2)->default(0);
            $table->integer('total_quantity')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('sales_reports', function (Blueprint $table) {
            $table->dropColumn(['title', 'data', 'total_sales', 'total_quantity']);
        });
    }
};
