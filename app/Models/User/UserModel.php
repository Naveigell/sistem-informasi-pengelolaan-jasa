<?php

namespace App\Models\User;

use App\Models\User\Account\BiodataModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\User
 */
class UserModel extends Model
{
    protected $table = "users";
    private $role = "pelanggan";

    public function getUsersList()
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])->where("role", $this->role)->paginate(12);
    }

    public function biodata()
    {
        return $this->hasOne(BiodataModel::class, "biodata_id_users", "id_users")->select(["id_biodata", "biodata_id_users", "jenis_kelamin", "nomor_hp", "instansi", "alamat", "profile_picture"]);
    }

    public function total()
    {
        return $this->where("role", $this->role)->count();
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
     * Get id by email
     *
     * @param $email
     * @return UserModel|Model|object|null
     */
    public function getIdByEmail($email)
    {
        return $this->select(["id_users"])->where([
            "email" => $email,
            "role"  => $this->role
        ])->first();
    }

    /**
     * Retrieve user by username
     *
     * @param $username
     * @return UserModel|Model|object|null
     */
    public function retrieveByUsername($username)
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "email"])->where([
            "role" => $this->role,
            "username" => $username
        ])->first();
    }

    /**
     * Search user email, to take to form
     *
     * @param $email
     * @return UserModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchEmail($email)
    {
        return $this->select(["id_users", "email", "name"])->with(["biodata:id_biodata,biodata_id_users,nomor_hp,alamat"])->whereRaw("email LIKE ? AND role = ?", ["%$email%", $this->role])->take(5)->get();
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

    /**
     * Get username by id
     *
     * @param $id
     * @return UserModel|Model|object|null
     */
    public function getUsernameById($id)
    {
        return $this->select(["username"])->where("id_users", $id)->first();
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteUser($id)
    {
        return $this->where("role", $this->role)->where("id_users", $id)->delete();
    }
}
