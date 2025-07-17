<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkAssignment;
use App\Models\Staff;
use Illuminate\Validation\ValidationException;
use App\Models\WorkCenter; 

class WorkAssignmentController extends Controller
{
    public function workassign(Request $request)
    {
        // Get all assignments, eager load staff and workCenter relationships
        $workAssignments = WorkAssignment::with(['staff', 'workCenter'])->get();
        $staffMembersForDropdown = Staff::all(['id', 'full_name']);
        $workCenters = WorkCenter::all();
        
        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            // Transform the data to include the workCenter name
            $formattedAssignments = $workAssignments->map(function($assignment) {
                return [
                    'assignment_id' => $assignment->assignment_id,
                    'staff_id' => $assignment->staff_id,
                    'staff_name' => $assignment->staff->full_name ?? 'Unknown',
                    'work_center_id' => $assignment->work_center_id,
                    'work_center' => $assignment->workCenter->centerName ?? 'Not Assigned',
                    'role' => $assignment->role,
                    'start_date' => $assignment->start_date,
                    'end_date' => $assignment->end_date,
                ];
            });
            return response()->json($formattedAssignments);
        }
        
        // Return the Workassignment view with work assignments and dropdowns
        return view('staff_management.Workassignment', compact(
            'workAssignments', 'staffMembersForDropdown', 'workCenters'
        ));
    }

    /* Store a newly created work assignment in storage. */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id',
                'role' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            // Select a random work center that hasn't been used recently if possible
            $allWorkCenters = WorkCenter::all();
            
            if ($allWorkCenters->isEmpty()) {
                throw new \Exception('No work centers available.');
            }
            
            // Get the most recently assigned work centers (last 3)
            $recentWorkCenterIds = WorkAssignment::orderBy('created_at', 'desc')
                ->take(3)
                ->pluck('work_center_id')
                ->toArray();
            
            // Filter out work centers that have been recently used, if possible
            $availableWorkCenters = $allWorkCenters->filter(function ($workCenter) use ($recentWorkCenterIds) {
                return !in_array($workCenter->id, $recentWorkCenterIds);
            });
            
            // If no work centers are available after filtering, use all work centers
            if ($availableWorkCenters->isEmpty()) {
                $availableWorkCenters = $allWorkCenters;
            }
            
            // Select a random work center from the available ones
            $randomWorkCenter = $availableWorkCenters->random();
            $validatedData['work_center_id'] = $randomWorkCenter->id;

            // --- Robust Assignment ID Generation with Retry ---
            $maxRetries = 5;
            $created = false;
            $assignment = null;
            for ($i = 0; $i < $maxRetries; $i++) {
                $latestAssignment = WorkAssignment::orderBy('assignment_id', 'desc')->lockForUpdate()->first();
                $nextIdNum = ($latestAssignment) ? (int)substr($latestAssignment->assignment_id, 1) + 1 : 1;
                $validatedData['assignment_id'] = 'A' . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);
                try {
                    $assignment = WorkAssignment::create($validatedData);
                    $created = true;
                    break;
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23000) { // Duplicate entry
                        continue; // Retry
                    }
                    throw $e;
                }
            }
            if (!$created) {
                throw new \Exception('Could not generate a unique assignment ID after several attempts.');
            }

            // If AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Work assignment added successfully!',
                    'assignment' => $assignment
                ]);
            }

            // Fallback for non-AJAX
            return redirect()->route('staff_management.staff')
                             ->with('success_work_assignment', 'Work assignment added successfully!')
                             ->with('active_tab', 'work');

        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Validation failed.'
                ], 422);
            }
            // Redirect back with input and errors, also set a session flag to reopen the modal
            return redirect()->back()
                             ->withErrors($e->errors())
                             ->withInput()
                             ->with('open_work_assignment_modal', true) // Flag to reopen modal
                             ->with('active_tab', 'work'); // Keep work assignment tab active

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add work assignment: ' . $e->getMessage()
                ], 500);
            }
            // Catch any other unexpected errors
            return redirect()->back()
                             ->with('error_work_assignment', 'Failed to add work assignment: ' . $e->getMessage())
                             ->with('active_tab', 'work');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * Accepts assignment_id as string, not model binding.
     */
    public function edit($assignment_id)
    {
        $workAssignment = WorkAssignment::where('assignment_id', $assignment_id)->firstOrFail();
        return response()->json($workAssignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkAssignment $workAssignment)
    {
        $validatedData = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'role' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        // Select a random work center that hasn't been used recently if possible
        $allWorkCenters = WorkCenter::all();
        
        if ($allWorkCenters->isEmpty()) {
            return redirect()->back()->with('error', 'No work centers available.');
        }
        
        // Get the most recently assigned work centers (last 3)
        $recentWorkCenterIds = WorkAssignment::orderBy('created_at', 'desc')
            ->take(3)
            ->pluck('work_center_id')
            ->toArray();
        
        // Filter out work centers that have been recently used, if possible
        $availableWorkCenters = $allWorkCenters->filter(function ($workCenter) use ($recentWorkCenterIds) {
            return !in_array($workCenter->id, $recentWorkCenterIds);
        });
        
        // If no work centers are available after filtering, use all work centers
        if ($availableWorkCenters->isEmpty()) {
            $availableWorkCenters = $allWorkCenters;
        }
        
        // Select a random work center from the available ones
        $randomWorkCenter = $availableWorkCenters->random();
        $validatedData['work_center_id'] = $randomWorkCenter->id;

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
