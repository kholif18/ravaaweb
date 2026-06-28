<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AdminAuthenticate extends Middleware
{
    /**
     * Always use the admin guard for authentication.
     */
    protected function authenticate($request, array $guards)
    {
        parent::authenticate($request, ['admin']);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * We redirect admin guard unauthenticated users to the admin login route.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
