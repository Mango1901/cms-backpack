<?php

namespace App\Http\Middleware;

use Closure;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('impersonate') && backpack_user()->hasRole('Admin')) {
            backpack_auth()->onceUsingId($request->session()->get('impersonate'));
        }

        return $next($request);
    }
}
