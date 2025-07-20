<?php

namespace App\Http\Controllers;

use App\Models\QA;
use App\Models\Vendor;
use Illuminate\Http\Request;

class QAReportController extends Controller
{
    public function index()
    {
        // Redirect to reports view with QA tab active
        return redirect()->route('reports')->with('activeTab', 'QA');
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('qa.create-report', compact('vendors'));
    }

    public function store(Request $request)
    { 
        //  dd('the store method is accessed');
        $validated = $request->validate([           
             'date' => 'required|date',  // We'll map this to start_date
            'testers_initials' => 'required',
            'region' => 'required',
            'vendor_id' => 'required',
            'ref' => 'required',
            'crop_year' => 'required',         
               'screen_description' => 'nullable',
            'color' => 'required',
            'defects' => 'array',
            'defects.category1' => 'array|nullable',
            'defects.category2' => 'array|nullable',
            'defects.category3' => 'array|nullable',
            'fragrance' => 'required',
            'moisture_content' => 'required|numeric',
            'overall_impression' => 'required'
        ]);        // Process defects data
        $defects = $request->input('defects', []);
        
        // Remove empty values from defects arrays
        foreach (['category1', 'category2', 'category3'] as $category) {
            if (isset($defects[$category])) {
                $defects[$category] = array_filter($defects[$category]);
            }
        }        $report = QA::create([
            'reportID' => 'QA-' . date('Ymd-') . rand(1000, 9999),
            'date' => $validated['date'],
            'testers_initials' => $validated['testers_initials'],
            'region' => $validated['region'],
            'vendor_id' => $validated['vendor_id'],
            'ref' => $validated['ref'],
            'crop_year' => $validated['crop_year'],
            'screen_description' => $validated['screen_description'],
            'color' => $validated['color'],
            'defects' => $defects,
            'fragrance' => $validated['fragrance'],
            'moisture_content' => $validated['moisture_content'],
            'overall_impression' => $validated['overall_impression'],
            'status' => $request->input('save_draft') ? 'draft' : 'submitted'
        ]);        $message = $report->status === 'draft' ? 'Report saved as draft.' : 'Report submitted successfully.';
        return redirect()->route('qa.index')->with('success', $message);
    }

    public function show(QA $report)
    {
        return view('qa.show-report', compact('report'));
    }

    public function destroy(QA $report)
    {
        try {
            $reportID = $report->reportID; // Save the ID for the success message
            $report->delete();
            return redirect()->route('qa.index')->with('success', "QA Report {$reportID} has been deleted.");
        } catch (\Exception $e) {
            return redirect()->route('qa.index')->with('error', 'Error deleting the report. Please try again.');
        }
    }
}
