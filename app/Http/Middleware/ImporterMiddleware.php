<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\ImporterModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImporterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $importer = ImporterModel::where('email', $user->email)->exists();

         if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }
        if ($importer) {
            // User is authenticated and is an importer
            return $next($request);
        }
        
        return redirect()->back()->with('error', 'You must be logged in as an importer to access this page.');
    }
}
