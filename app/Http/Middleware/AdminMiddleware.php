<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Staff;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
        $staff = Staff::where('email', $user->email)->first();
        $admin =$staff->is_admin;

        if($admin){
             return $next($request);
        }
        else{
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
       
    }
}
