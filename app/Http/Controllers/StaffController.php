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
        // Use regular staff data (Livewire component will take care of filtering)
        $staff = Staff::orderBy('id', 'asc')->paginate(10); // All staff for the main table, oldest first

        $totalStaffCount = Staff::count();
        $absentStaffCount = Staff::whereIn('status', ['On Leave', 'Suspended'])->count();
        $warehouseCount = 4;

        $workAssignments = WorkAssignment::with('staff')->get(); 
        $leaveHistory = LeaveHistory::with('staff')->get(); // Fetching leave history for the Leave History tab
        $staffMembersForDropdown =  Staff::select('id', 'full_name')->get(); // For staff dropdowns in modals
        $workCenters = \App\Models\WorkCenter::all();
        
        return view('staff_management.staff', compact('staff','totalStaffCount', 'absentStaffCount', 'warehouseCount','workAssignments', 'staffMembersForDropdown','leaveHistory', 'workCenters'));
}
public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'status' => 'required|string',
        'phone_number' => 'required|string',
        'email' => 'required|email',
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->except('profile_picture');

    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $data['profile_picture'] = $path;
    }

    Staff::create($data);

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
    return response()->json([
        'id' => $staff->id,
        'full_name' => $staff->full_name,
        'role' => $staff->role,
        'status' => $staff->status,
        'phone_number' => $staff->phone_number,
        'email' => $staff->email,
        'profile_picture_url' => $staff->profile_picture_url,
        // add other fields as needed
    ]);
}

public function update(Request $request, Staff $staff)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'status' => 'required|string',
        'phone_number' => 'required|string',
        'email' => 'required|email',
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->except('profile_picture');

    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if it exists
        if ($staff->profile_picture) {
            \Storage::disk('public')->delete($staff->profile_picture);
        }
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $data['profile_picture'] = $path;
    }

    $staff->update($data);

    return redirect()->route('staff_management.staff')->with('success', 'Staff updated successfully!');
}

public function edit(Staff $staff)
 {
         return redirect()->route('staff_management.staff')->with('success', 'Staff updated successfully!');
    }
    public function updateStatus(Request $request, Staff $staff)
    {
        $request->validate([
            'status' => 'required|string|in:Active,Suspended,On Leave'
        ]);
        $staff->status = $request->status;
        $staff->save();
        return response()->json(['success' => true, 'status' => $staff->status]);
    }
    public function updateProfilePicture(Request $request, $id)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $staff = Staff::findOrFail($id);

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($staff->profile_picture) {
                \Storage::disk('public')->delete($staff->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $staff->profile_picture = $path;
            $staff->save();

            return response()->json([
                'success' => true, 
                'message' => 'Profile picture updated successfully',
                'profile_picture_url' => $staff->profile_picture_url
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No profile picture was provided'
        ], 400);
    }

    public function getStaffDetails($id)
    {
        $staff = Staff::findOrFail($id);
        return response()->json([
            'staff' => $staff,
            'profile_picture_url' => $staff->profile_picture_url
        ]);
    }
}