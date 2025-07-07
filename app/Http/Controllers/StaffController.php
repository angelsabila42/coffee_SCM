<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\WorkAssignment;
use App\Models\LeaveHistory; 

class StaffController extends Controller
{


public function staff()
{
        $staff = Staff::orderBy('id', 'asc')->get(); // All staff for the main table, oldest first
        $totalStaffCount = Staff::count();
        $absentStaffCount = Staff::where('status', 'On Leave')->count(); 
        $warehouseCount = 4; 

         $workAssignments = WorkAssignment::with('staff')->get(); 
         $leaveHistory = LeaveHistory::with('staff')->get(); // Fetching leave history for the Leave History tab
        $staffMembersForDropdown =  Staff::select('id', 'full_name')->get(); // For staff dropdowns in modals

       
       return view('staff_management.staff', compact('staff','totalStaffCount', 'absentStaffCount', 'warehouseCount','workAssignments', 'staffMembersForDropdown','leaveHistory'));
}
public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'status' => 'required|string',
        'phone_number' => 'required|string',
        'email' => 'required|email'
    ]);

    Staff::create($request->all());

    return redirect()->route('staff_management.staff')->with('success', 'Staff added successfully!');
}

public function destroy($id)
{
    $staff = Staff::findOrFail($id);
    $staff->delete();

    return redirect()->route('staff_management.staff')->with('success', 'Staff deleted successfully!');
}

public function show(Staff $staff) 
{
    return response()->json($staff);
}
public function edit(Staff $staff)
 {
         return redirect()->route('staff_management.staff')->with('success', 'Staff updated successfully!');
    }
}