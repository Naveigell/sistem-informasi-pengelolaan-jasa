<?php

namespace App\Http\Middleware\Auth;

use Illuminate\Http\Request;
use Closure;

class ShouldHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $role = auth("user")->user()->role;

        if (in_array($role, $roles)) {
            return $next($request);
        }

        return error(null, ["message" => "You don't have any access to this resources"], 401);
    }
}
