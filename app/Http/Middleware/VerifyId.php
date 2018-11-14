<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $id)
    {
        if(! Auth::check()) {
            return redirect('/login');
        } elseif($request->user()->id == $id) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You are not permitted to view that page.');
    }
}
