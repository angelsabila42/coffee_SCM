<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Middleware\AsMiddleware;


//#[AsMiddleware(alias:'aut')]

class AutMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // You can add custom logic here if needed
        if (!Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
