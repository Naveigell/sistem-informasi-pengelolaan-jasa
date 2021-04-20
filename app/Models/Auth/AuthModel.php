<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Auth
 */
class AuthModel extends Model {
    protected $table = "users";

    /**
     * Get password by username
     *
     * @param $username
     * @return AuthModel|Model|object|null
     */
    public function getPasswordByUsername($username)
    {
        return $this->select(["password"])->where("username", $username)->first();
    }

    /**
     * Get password by users id
     *
     * @param $id
     * @return AuthModel|Model|object|null
     */
    public function getPasswordById($id)
    {
        return $this->select(["password"])->where("id_users", $id)->first();
    }

    /**
     * Change password
     *
     * @param $id
     * @param $password
     * @return int
     */
    public function changePassword($id, $password)
    {
        return $this->where("id_users", $id)->update([
            "password"      => $password
        ]);
    }
}
