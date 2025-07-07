<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransporterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
         if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }
        $Transporter = Transporter::where('email', $user->email)->exists();

        if( $Transporter) {
            // User is authenticated and is a transporter
            return $next($request);
        }
        else {
            // User is not authenticated or not a transporter
            return redirect()->back()->withInput()->with('error', 'You must be logged in as a transporter to access this page.');
        }
      
    }
}
