<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveHistory;
use App\Models\Staff;


class LeaveHistoryController extends Controller
{
    
    public function leavehistory()
    {
        // Fetch all leave history records
        $leaveHistory = LeaveHistory::with('staff')->get();

        // Return the view with the leave history data
        return view('staff_management.staff', compact('leaveHistory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('staff_management.staff')->with('error', 'Direct access to create form not allowed.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Approved,Rejected,Cancelled',
            
        ]);

        $latestLeave = LeaveHistory::orderBy('leave_id', 'desc')->first();
        $nextIdNum = ($latestLeave) ? (int)substr($latestLeave->leave_id, 1) + 1 : 1;
        $validatedData['leave_id'] = 'L' . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);

        try {
            $staffMember = Staff::find($validatedData['staff_id']);
            if ($staffMember) {
                LeaveHistory::create($validatedData);

                // Redirect back to the staff management page with a success message
                // and keep the "Leave History" tab active.
                return redirect()->route('staff_management.staff')
                                 ->with('success_leave_history', 'Leave record added successfully!')
                                 ->with('active_tab', 'leave');
            } else {
                return redirect()->back()
                                 ->with('error', 'Staff member not found.')
                                 ->withInput()
                                 ->with('open_leavehistory_modal', true);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput()
                             ->with('open_leavehistory_modal', true); // Flag to reopen modal
        }
    }
     function show(string $id)
    {
        $leaveHistory = LeaveHistory::findOrFail($id);
        return response()->json($leaveHistory->load('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    function update(Request $request, string $id)
    {
         $validatedData = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Approved,Rejected,Cancelled',
            'reason' => 'nullable|string',
        ]);

        $leaveHistory = LeaveHistory::findOrFail($id);
        // No need to generate leave_id for update, it already exists
        $leaveHistory->update($validatedData);

        return redirect()->route('staff_management.staff')
                         ->with('success_leave_history', 'Leave record updated successfully!')
                         ->with('open_leavehistory_modal', true)
                         ->with('active_tab', 'leave');
    }

    /**
     * Remove the specified resource from storage.
     */
    function destroy(string $id)
    {
        $leaveHistory = LeaveHistory::findOrFail($id);
        $leaveHistory->delete();
        return redirect()->route('staff_management.staff')
                         ->with('success_leave_history', 'Leave record deleted successfully!')
                         ->with('active_tab', 'leave');
    }

    /**
     * Update the status of a leave request.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $leave = LeaveHistory::findOrFail($id);
            $leave->status = $request->status;
            $leave->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
