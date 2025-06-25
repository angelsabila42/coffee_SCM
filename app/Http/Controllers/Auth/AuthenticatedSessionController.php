<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
    {
        $request->authenticate();

        $request->session()->regenerate();

       // return redirect()->intended(route('category', absolute: false));
        $request->session()->forget('url.intended');
        //dd('here');
        return redirect()->route('home');

            $user = Auth::user();

    // // Check which table the user belongs to and redirect accordingly
    // if (\DB::table('staff')->where('email', $user->email)->exists()) {
    //     return redirect()->route('staff.dashboard'); // Define this route in web.php
    // }
    // if (\DB::table('vendor')->where('email', $user->email)->exists()) {
    //     return redirect()->route('vendor.dashboard'); // Define this route in web.php
    // }
    // if (\DB::table('importer')->where('email', $user->email)->exists()) {
    //     return redirect()->route('importer.dashboard'); // Define this route in web.php
    // }
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
