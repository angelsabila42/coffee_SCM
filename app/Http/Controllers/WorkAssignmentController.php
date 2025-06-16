<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAssignment;
use App\Models\Staff;

class WorkAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function WorkAssign()
    {
        // Get all assignments, eager load staff relationship
        $workAssignments = WorkAssignment::with('staff')->get();
        return view('staff_management.workassignment', compact('workAssignments'));
    }

    /* Store a newly created work assignment in storage. */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'staff_id' => 'required|exists:staff,id', // Ensure staff_id exists in staff table
            'center_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // IMPORTANT: Review assignment_id generation.
        // If 'assignment_id' is your primary key and needs to be unique and non-sequential,
        // consider Laravel's UUIDs/ULIDs:
        // 1. Add `use Illuminate\Support\Str;`
        // 2. $validatedData['assignment_id'] = (string) Str::uuid(); // For UUID
        // 3. Ensure your migration uses $table->uuid('assignment_id')->primary(); or $table->ulid('assignment_id')->primary();
        
        $latestAssignment = WorkAssignment::orderBy('id', 'desc')->first();
        $nextIdNum = ($latestAssignment) ? (int)substr($latestAssignment->assignment_id, 1) + 1 : 1;
        $validatedData['assignment_id'] = 'A' . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);



        WorkAssignment::create($validatedData);

        return redirect()->back()->with('success', 'Work assignment added successfully!');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkAssignment $workAssignment)
    {
        return response()->json($workAssignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkAssignment $workAssignment)
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
    public function destroy(WorkAssignment $workAssignment)
    {
        $workAssignment->delete();
        return redirect()->back()->with('success', 'Work assignment deleted successfully!');
    }
}