<?php

namespace App\Http\Middleware;

use App\Models\importerModel;
use Illuminate\Support\Facades\Auth;
use Closure;
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

        if($user && importerModel::where($user->email)-> exists()){
              return $next($request);
        }

      else  return redirect()->route('login')->with('error','you are not allowed to visit this page');
      
    }
}
