<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(! Auth::check()) {
            return redirect('/login');
        } elseif($role == 'ALL_PLAYERS') {
            if($request->user()->role === 'PLAYER' || $request->user()->role === 'STRING') {
                return $next($request);
            }
        } elseif($request->user()->role === $role) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not permitted to view that page.');
    }
}
