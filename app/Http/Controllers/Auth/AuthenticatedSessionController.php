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
use App\Models\ImporterModel as Importer;
use App\Models\Vendor;
use App\Models\Transporter;

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
    public function store(LoginRequest $request)//: RedirectResponse
    {
        Log::info('LOGIN store() hit by user: ' . Auth::user()?->email);

        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();

        if(Importer::where('email', $user->email)->exists()){
            Log::info('Redirecting importer');
            return redirect()->route('importer.dashboard');
        }

        elseif(Vendor::where('email', $user->email)->exists()){
            Log::info('Redirecting vendor');
            return redirect()->route('vendor.home');
        }

        elseif(Transporter::where('email', $user->email)->exists()){
            Log::info('Redirecting transporter');
            return redirect()->route('transporter.dashboard');
        }
        
        else {
            return redirect()->route('importer.dashboard');
        }
        // return redirect()->route('index')
        //     ->with('status', 'You are logged in successfully!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
