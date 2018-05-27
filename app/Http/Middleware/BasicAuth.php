<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Support\Facades\Config;

class BasicAuth extends AuthenticateWithBasicAuth
{
    /**
     * Overrides Laravel auth basic middleware, to use
     * username field and not email
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->header('Authorization') === env('SANDBOX_AUTHORIZATION')) {
            Config::set('database.connections.mysql.database', env('DB_DATABASE_SANDBOX'));
        }

        return $this->auth->guard('api-auth')->basic('username') ?: $next($request);
    }
}
