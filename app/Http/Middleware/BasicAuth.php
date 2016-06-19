<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;

class BasicAuth extends AuthenticateWithBasicAuth
{
    /**
     * Overrides Laravel auth basic middleware, to use
     * username field and not email
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        return $this->auth->guard($guard)->basic('username') ?: $next($request);
    }
}
