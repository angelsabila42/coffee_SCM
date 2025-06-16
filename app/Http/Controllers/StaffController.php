<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{


public function staff()
{
    $staff = Staff::all();
    return view('staff_management.staff', compact('staff'));
}
public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'work_center' => 'required|string|max:255',
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
  public function edit(Staff $staff)
    {
        // This method might return a view with the edit form or data for an AJAX modal.
        // For a modal, you might return a JSON response or a partial view.
        return response()->json($staff); 
    }
}
