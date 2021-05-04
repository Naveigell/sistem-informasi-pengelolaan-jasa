<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Admin
 */
class AdminModel extends Model
{
    protected $table = "users";
    private $role = "admin";

    public function total()
    {
        return $this->where("role", $this->role)->count();
    }
}
