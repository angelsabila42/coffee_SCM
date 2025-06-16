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
        Schema::create('leave_history', function (Blueprint $table) {
            $table->string('leave_id',5)->primary(); 
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Foreign key to staff table
            $table->string('staff_name',20); 
            $table->string('type',15); // e.g., "Sick Leave", "Annual Leave"
            $table->string('status',15); // e.g., "Approved", "Pending"
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_history');
    }
};
