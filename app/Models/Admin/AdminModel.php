<?php

namespace App\Models\Admin;

use App\Models\User\Account\BiodataModel;
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
    protected $primaryKey = "id_users";

    public function total()
    {
        return $this->where("role", $this->role)->count();
    }

    public function getAdminList()
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])->where("role", $this->role)->paginate(12);
    }

    public function biodata()
    {
        return $this->hasOne(BiodataModel::class, "biodata_id_users", "id_users")->select(["id_biodata", "biodata_id_users", "jenis_kelamin", "nomor_hp", "alamat", "profile_picture"]);
    }
}
