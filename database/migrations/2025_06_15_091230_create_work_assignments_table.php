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
        Schema::create('work_assignments', function (Blueprint $table) {
            $table->string('assignment_id', 7)->primary(); 
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Foreign key to staff table and cascade on delete ie delete staff, deletes assignments
            $table->string('staff_name', 20); 
            $table->string('center_name', 20);
            $table->string('role', 50); // Role at the time of assignment
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
        Schema::dropIfExists('work_assignments');
    }
};
