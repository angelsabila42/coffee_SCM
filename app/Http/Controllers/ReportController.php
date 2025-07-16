<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QA;
class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activeTab = session('activeTab', 'QA'); // Default to QA tab if none specified
        return view('reports.admin', compact('activeTab'));
    }
}
