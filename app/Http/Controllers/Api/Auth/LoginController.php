<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {

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
