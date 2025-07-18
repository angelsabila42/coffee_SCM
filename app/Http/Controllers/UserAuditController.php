<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImporterRecentActivities;
use App\Models\User;

class UserAuditController extends Controller
{
    /**
     * Display user audit logs (login/logout activities)
     */
    public function index(Request $request)
    {
        $query = ImporterRecentActivities::with('user')
            ->whereIn('type', ['login', 'logout'])
            ->orderByDesc('created_at');

        // Apply filters if provided
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('activity_type')) {
            $query->where('type', $request->activity_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(15);

        // Get users for filter dropdown
        $users = User::orderBy('name')->get();

        // Get activity statistics
        $stats = [
            'total_logins' => ImporterRecentActivities::where('type', 'login')->count(),
            'total_logouts' => ImporterRecentActivities::where('type', 'logout')->count(),
            'unique_users' => ImporterRecentActivities::whereIn('type', ['login', 'logout'])->distinct('user_id')->count('user_id'),
            'today_logins' => ImporterRecentActivities::where('type', 'login')->whereDate('created_at', today())->count(),
        ];

        return view('admin.user-audits.index', compact('activities', 'users', 'stats'));
    }

    /**
     * Show detailed audit information for a specific activity
     */
    public function show($id)
    {
        $activity = ImporterRecentActivities::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'activity' => $activity
        ]);
    }
}
