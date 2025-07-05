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
        Schema::table('work_assignments', function (Blueprint $table) {
            // Remove old work_center column if exists
            if (Schema::hasColumn('work_assignments', 'work_center')) {
                $table->dropColumn('work_center');
            }
            // Add new work_center_id foreign key
            $table->unsignedBigInteger('work_center_id')->nullable()->after('staff_id');
            $table->foreign('work_center_id')->references('id')->on('work_centers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_assignments', function (Blueprint $table) {
            $table->dropForeign(['work_center_id']);
            $table->dropColumn('work_center_id');
            $table->string('work_center', 20)->nullable();
        });
    }
};
