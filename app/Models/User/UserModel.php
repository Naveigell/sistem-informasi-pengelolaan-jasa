<?php

namespace App\Models\User;

use App\Models\User\Account\BiodataModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\User
 */
class UserModel extends Model
{
    protected $table = "users";
    private $role = "user";

    public function getUsersList()
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])->where("role", $this->role)->paginate(12);
    }

    public function biodata()
    {
        return $this->hasOne(BiodataModel::class, "biodata_id_users", "id_users")->select(["id_biodata", "biodata_id_users", "jenis_kelamin", "nomor_hp", "alamat", "profile_picture"]);
    }

    /**
     * Insert user
     *
     * @param object $data
     * @return int
     */
    public function insertUser(object $data)
    {
        return $this->insertGetId([
            "name"          => $data->name,
            "username"      => $data->username,
            "email"         => $data->email,
            "password"      => Hash::make(123456),
            "role"          => $this->role,
            "created_at"    => now(),
            "updated_at"    => now()
        ]);
    }

    /**
     * Search users by it's name
     *
     * @param $q
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($q){
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])
            ->where("role", $this->role)->where(function ($query) use ($q) {
                // explode the array
                $queryArray = explode(" ", $q);
                for ($i = 0; $i < count($queryArray); $i++) {
                    $merges = "";
                    // then merge the array, example
                    // "blue phone casing", will be
                    // "blue phone casing", "blue phone", "blue"
                    for ($j = 0; $j <= $i; $j++) {
                        $merges .= $queryArray[$j];

                        if ($j < $i) {
                            $merges .= " ";
                        }
                    }
                    $query->orWhere("name", "LIKE", "%$merges%");
                }

            })->paginate(12);
    }
}
