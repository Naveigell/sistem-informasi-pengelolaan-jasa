<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function check() {
        $data = [
            "loggedin"      => auth('user')->check()
        ];

        return json($data);
    }
}
