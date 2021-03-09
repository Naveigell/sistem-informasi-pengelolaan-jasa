<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth.global')->only(['sessionData']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse check if user has logged in
     */
    public function check() {
        $data = [
            "loggedin"      => auth('user')->check()
        ];

        return json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse get session data from user if user has logged in
     */
    public function sessionData() {
        $user = auth('user')->user();

        return json([
            "name"          => $user->name,
            "username"      => $user->username,
            "role"          => $user->role
        ]);
    }
}
