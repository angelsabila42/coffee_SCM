<?php

namespace Database\Seeders;

use App\Models\LeaveHistory;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class LeaveHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */    public function run()
    {
        // Clear existing leave history records first to ensure proper ID sequence
        LeaveHistory::truncate();
        
        // Get available staff members
        $staff = Staff::all();
        
        if ($staff->count() > 0) {
            // Explicitly defined leave records - no random data
            $leaveRecords = [
                [
                    'leave_id' => 'L001',
                    'staff_name' => 'John Ayebale',
                    'leave_type' => 'Annual Leave',
                    'start_date' => '2025-10-22',
                    'end_date' => '2026-10-20',
                    'status' => 'Pending'
                ],
                [
                    'leave_id' => 'L002',
                    'staff_name' => 'John Ayebale',
                    'leave_type' => 'Sick Leave',
                    'start_date' => '2025-07-15',
                    'end_date' => '2025-07-22',
                    'status' => 'Approved'
                ],
                [
                    'leave_id' => 'L003',
                    'staff_name' => 'Leora Reichel',
                    'leave_type' => 'Annual Leave',
                    'start_date' => '2025-08-01',
                    'end_date' => '2025-08-15',
                    'status' => 'Rejected'
                ],
                [
                    'leave_id' => 'L004',
                    'staff_name' => 'Halie Simonis',
                    'leave_type' => 'Compassionate Leave',
                    'start_date' => '2025-07-10',
                    'end_date' => '2025-07-17',
                    'status' => 'Approved'
                ],
                [
                    'leave_id' => 'L005',
                    'staff_name' => 'Prof. Myrna McKenzie',
                    'leave_type' => 'Annual Leave',
                    'start_date' => '2025-09-05',
                    'end_date' => '2025-09-19',
                    'status' => 'Pending'
                ],
                [
                    'leave_id' => 'L006',
                    'staff_name' => 'Leora Reichel',
                    'leave_type' => 'Maternity Leave',
                    'start_date' => '2025-11-01',
                    'end_date' => '2026-02-01',
                    'status' => 'Cancelled'
                ]
            ];
            
            // Create each leave record with exact details
            foreach ($leaveRecords as $record) {
                $staffId = Staff::where('full_name', $record['staff_name'])->first()->id ?? $staff->first()->id;
                
                LeaveHistory::create([
                    'leave_id' => $record['leave_id'],
                    'staff_id' => $staffId,
                    'leave_type' => $record['leave_type'],
                    'start_date' => $record['start_date'],
                    'end_date' => $record['end_date'],
                    'status' => $record['status'],
                ]);
            }
        }
    }
}
