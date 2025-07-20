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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_id')->unique(); // e.g., NX_009
            $table->string('pickup_location')->nullable();
            $table->dateTime('dispatch_date_time')->nullable();
            $table->string('delivery_destination'); // e.g., Germany
            $table->integer('quantity'); // e.g., 3000 kg
            $table->string('coffee_type'); // e.g., Arabica
            $table->string('coffee_grade')->nullable();
            $table->string('status')->default('Scheduled'); // e.g., Scheduled, In transit, Delivered
            $table->string('assigned_driver')->nullable(); // e.g., Higenyi William
            $table->date('eta')->nullable(); // Estimated Time of Arrival
            $table->date('date_ordered');
            $table->foreignId('incoming_order_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
