<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
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
        $vendor = Vendor::where('email', $user->email)->exists();

        if ( $vendor) {
            // User is authenticated and is a vendor
            return $next($request);
        } else {
            // User is not authenticated or not a vendor
            return redirect()->back()->with('error', 'You must be logged in as a vendor to access this page.');
        }
    
    }
}
