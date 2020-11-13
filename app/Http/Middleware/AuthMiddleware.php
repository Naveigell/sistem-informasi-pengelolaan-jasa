<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        // jika user belum login
        if (!auth('user')->check()) {
            return error(null, [
                "user"      => ["Tidak bisa mengambil data"]
            ], 401);
        }

        return $next($request);
    }
}
