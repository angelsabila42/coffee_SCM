<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\ImporterModel;
use App\Models\Staff;
use App\Models\Vendor;
use App\Models\Transporter;
use App\Models\ImporterRecentActivities;
use Carbon\Carbon;

//use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {   // dd('LOGIN store() hit');
        
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();

      // Log::info('LOGIN store() hit by user: ' . $user->email);

        $staff = Staff::where('email', $user->email)->first();
        if($staff){
            $admin = $staff->is_admin;
        if ($admin) {
            Log::info('Redirecting admin');
            return redirect()->route('admin.home');
        }
        // Store login time in session for duration calculation
        $request->session()->put('login_time', now());

        // Log login activity for importers
        $this->logImporterActivity($user, 'login', 'User logged in successfully', [
            'login_time' => now()->format('Y-m-d H:i:s'),
            'ip_address' => $request->ip(),
            'user_agent' => substr($request->header('User-Agent'), 0, 100) // Limit user agent length
        ]);


        }

        if(ImporterModel::where('email', $user->email)->exists()){
            //::info('Redirecting importer');
            return redirect()->route('importer.dashboard');
        }

        if(Vendor::where('email', $user->email)->exists()){
           // Log::info('Redirecting vendor');
            return redirect()->route('vendor.home');
        } 

        if(Transporter::where('email', $user->email)->exists()){
           // Log::info('Redirecting transporter');
            return redirect()->route('transporter.dashboard');
        }

        
    //Log::warning('⚠️ None of the role-based redirects matched. Falling back to welcome.');

            return redirect('/welcome')
                ->with('status', 'You are logged in successfully!');
        
        // return redirect()->route('index')
        //     ->with('status', 'You are logged in successfully!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Log logout activity for importers before logging out
        if ($user) {
            $this->logImporterActivity($user, 'logout', 'User logged out successfully', [
                'logout_time' => now()->format('Y-m-d H:i:s'),
                'ip_address' => $request->ip(),
                'session_duration' => $this->calculateSessionDuration($request)
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    /**
     * Log activity for importer users
     */
    private function logImporterActivity($user, $type, $title, $data = [])
    {
        // Check if user is an importer
        if (ImporterModel::where('email', $user->email)->exists()) {
            ImporterRecentActivities::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'data' => $data,
                'ip_address' => request()->ip()
            ]);
        }
    }
    
    /**
     * Calculate session duration if possible
     */
    private function calculateSessionDuration(Request $request)
    {
        $sessionStart = $request->session()->get('login_time');
        if ($sessionStart) {
            $start = Carbon::parse($sessionStart);
            $end = now();
            return $start->diffForHumans($end, true);
        }
        return 'Unknown';
    }
}
