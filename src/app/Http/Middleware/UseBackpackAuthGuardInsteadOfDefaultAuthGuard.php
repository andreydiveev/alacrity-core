<?php

namespace Alacrity\Core\app\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UseBackpackAuthGuardInsteadOfDefaultAuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        app('auth')->setDefaultDriver(config('alacrity.core.guard'));

        return $next($request);
    }
}
