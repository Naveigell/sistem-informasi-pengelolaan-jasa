<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequestChangePassword;
use App\Models\Auth\AuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private AuthModel $auth;

    public function __construct() {
        $this->middleware('auth.global')->only(['sessionData']);

        $this->auth = new AuthModel();
    }

    /**
     * Check if user has logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check() {
        $data = [
            "loggedin"      => auth('user')->check()
        ];

        return json($data);
    }

    /**
     * Change password
     *
     * @param AuthRequestChangePassword $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(AuthRequestChangePassword $request)
    {
        $data = $this->auth->getPasswordById(auth("user")->id());
        if ($data == null) {
            return error(null, ["message" => "Password lama tidak ditemukan"], 404);
        }

        if (Hash::check($request->old_password, $data->password)) {
            $password = Hash::make($request->new_password);

            $updated = $this->auth->changePassword(auth("user")->id(), $password);
            if ($updated) {
                return json([], null, 204);
            }
            return json(null, ["message" => "Terjadi masalah saat mengubah password"]);
        }

        return error(null, ["old_password" => ["Password lama salah"]], 422);
    }

    /**
     * Get session data from user if user has logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sessionData() {
        $user = auth('user')->user();

        return json([
            "name"          => $user->name,
            "username"      => $user->username,
            "role"          => $user->role
        ]);
    }

    /**
     * Do logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth("user")->logout();

        return $this->check();
    }
}
