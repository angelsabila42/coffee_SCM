<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAssignment;
use App\Models\Staff;
use Illuminate\Validation\ValidationException;

class WorkAssignmentController extends Controller
{
    public function workAssign()
    {
        // Get all assignments, eager load staff relationship
        $workAssignments = WorkAssignment::with('staff')->get();
        $staffMembersForDropdown = Staff::all(['id', 'full_name']);
        return view('staff_management.Workassignment', compact('workAssignments','staffMembersForDropdown'));
    }

    /* Store a newly created work assignment in storage. */
    public function store(Request $request)
    {
       try {
            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id', // Ensures staff_id exists in staff table
                'work_center' => 'required|string|max:255', 
                'role' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date', // Changed to nullable based on typical assignment
            ]); 

            // --- Assignment ID Generation ---
            // Current sequential 'A001', 'A002' approach:
            $latestAssignment = WorkAssignment::orderBy('assignment_id', 'desc')->first();
            $nextIdNum = ($latestAssignment) ? (int)substr($latestAssignment->assignment_id, 1) + 1 : 1;
            $validatedData['assignment_id'] = 'A' . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);



            // Create the Work Assignment record
            WorkAssignment::create($validatedData);

            // Redirect back with success message and keep the "Work Assignment History" tab active
            return redirect()->route('staff_management.staff')
                             ->with('success_work_assignment', 'Work assignment added successfully!')
                             ->with('active_tab', 'work');

        } catch (ValidationException $e) {
            // Redirect back with input and errors, also set a session flag to reopen the modal
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput()
                             ->with('open_work_assignment_modal', true) // Flag to reopen modal
                             ->with('active_tab', 'work'); // Keep work assignment tab active

        } catch (\Exception $e) {
            // Catch any other unexpected errors
            return redirect()->back()
                             ->with('error_work_assignment', 'Failed to add work assignment: ' . $e->getMessage())
                             ->with('active_tab', 'work');
        }
    }
}

   
    /**
     * Show the form for editing the specified resource.
     */
     function edit(WorkAssignment $workAssignment)
    {
        return response()->json($workAssignment);
    }

    /**
     * Update the specified resource in storage.
     */
     function update(Request $request, WorkAssignment $workAssignment)
    {
        $validatedData = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'center_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        
        $workAssignment->update($validatedData);

        return redirect()->back()->with('success', 'Work assignment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
     function destroy(WorkAssignment $workAssignment)
    {
        $workAssignment->delete();
        return redirect()->back()->with('success', 'Work assignment deleted successfully!');
    }
