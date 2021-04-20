<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\AuthRequestLogin;

class LoginController extends Controller
{
    /**
     * @param AuthRequestLogin $request
     * @return \Illuminate\Http\JsonResponse login for user
     */
    public function login(AuthRequestLogin $request) {
        $credentials = [
            "email"     => $request->email,
            "password"  => $request->password
        ];

        if (auth('user')->attempt($credentials, false)) {
            return json([$request->all(), auth('user')->check()]);
        }

        return error(null, [
            "email"     => ["Email atau password salah"]
        ], 404);
    }
}
