<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all leave_histories with empty/null leave_id, ordered by created_at
        $leaves = DB::table('leave_histories')
            ->whereNull('leave_id')
            ->orWhere('leave_id', '')
            ->orderBy('created_at')
            ->get();

        $counter = 1;
        foreach ($leaves as $leave) {
            $leaveId = 'L' . str_pad($counter, 3, '0', STR_PAD_LEFT);
            DB::table('leave_histories')
                ->where('id', $leave->id)
                ->update(['leave_id' => $leaveId]);
            $counter++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set leave_id to empty string for all records to avoid NOT NULL constraint violation
        DB::table('leave_histories')->update(['leave_id' => '']);
    }
};
