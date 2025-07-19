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
        Schema::table('pesapal_transactions', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->default('general')->after('description');
            $table->unsignedBigInteger('vendor_id')->nullable()->after('payment_type');
            $table->unsignedBigInteger('transporter_id')->nullable()->after('vendor_id');
            $table->string('delivery_route')->nullable()->after('transporter_id');
            
            // Add foreign key constraints if needed
            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('set null');
            $table->foreign('transporter_id')->references('id')->on('transporters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesapal_transactions', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['transporter_id']);
            $table->dropColumn(['payment_type', 'vendor_id', 'transporter_id', 'delivery_route']);
        });
    }
};
