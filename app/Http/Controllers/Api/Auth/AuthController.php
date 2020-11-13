<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth.global')->only(['sessionData']);
    }

    public function check() {
        $data = [
            "loggedin"      => auth('user')->check()
        ];

        return json($data);
    }

    public function sessionData() {
        $user = auth('user')->user();

        return json([
            "username"      => $user->username
        ]);
    }
}
