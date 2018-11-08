<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Master')) {
                return route('home');
            } elseif (auth()->user()->hasRole('Vendedor')) {
                return route('sales.create', ['opt' => 'high']);
            } elseif (auth()->user()->hasRole('Despachador')) {
                return route('deliveries.index');
            } else {
                return route('users.index');
            }
        }

        return $next($request);
    }
}
