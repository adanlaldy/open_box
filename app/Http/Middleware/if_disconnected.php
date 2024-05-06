<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class if_disconnected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if connected, redirect to inbox page
        if (auth()->check()) {
            return redirect('/inbox')->withErrors([
                'email' => "You must be disconnect to view this page.",
            ]);    
        }
        return $next($request);
    }
}
