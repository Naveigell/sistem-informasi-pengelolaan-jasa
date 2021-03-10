<?php

namespace App\Models\Technician;

use App\Models\User\Account\BiodataModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * Class TechnicianModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Technician
 */
class TechnicianModel extends Model
{
    protected $table = "users";
    protected $primaryKey = "id_users";

    /**
     * Get technician list per 12
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTechnicianList()
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])->where("role", "teknisi")->paginate(12);
    }

    public function biodata()
    {
        return $this->hasOne(BiodataModel::class, "biodata_id_users", "id_users")->select(["id_biodata", "biodata_id_users", "jenis_kelamin", "nomor_hp", "alamat", "profile_picture"]);
    }

    /**
     * Retrieve technician by username
     *
     * @param $username
     * @return TechnicianModel|Model|object|null
     */
    public function retrieveByUsername($username)
    {
        return $this->with(["biodata"])->select(["id_users", "name", "username", "email"])->where([
            "role" => "teknisi",
            "username" => $username
        ])->first();
    }

    /**
     * Get technician id by username
     *
     * @param $username
     * @return TechnicianModel|Model|object|null
     */
    public function getIdByUsername($username)
    {
        return $this->select(["id_users"])->where("username", $username)->first();
    }

    /**
     * Update technician user data by username
     *
     * @param $username
     * @param object $data
     * @return int
     */
    public function updateDataByUsername($username, object $data)
    {
        return $this->where("username", $username)->update([
            "name"          => $data->name,
            "username"      => $data->username,
        ]);
    }

    /**
     * Update technician biodata
     *
     * @param $id
     * @param object $data
     * @return int
     */
    public function updateTechnicianBiodata($id, object $data)
    {
        return DB::table("biodata")->where("biodata_id_users", $id)->update([
            "jenis_kelamin"         => $data->gender,
            "alamat"                => $data->address,
            "nomor_hp"              => $data->phone
        ]);
    }

    /**
     * Update technician password by username
     *
     * @param $username
     * @return int
     */
    public function updatePasswordByUsername($username)
    {
        return $this->where([
            "username"      => $username,
            "role"          => "teknisi"
        ])->update([
            "password" => Hash::make("123456")
        ]);
    }

    /**
     * Insert technician
     *
     * @param object $data
     * @return int
     */
    public function insertTechnican(object $data)
    {
        return $this->insertGetId([
            "name"          => $data->name,
            "username"      => $data->username,
            "email"         => $data->email,
            "password"      => Hash::make(123456),
            "role"          => "teknisi",
            "created_at"    => now(),
            "updated_at"    => now()
        ]);
    }

    /**
     * Search technician by name
     *
     * @param $q
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($q){
        return $this->with(["biodata"])->select(["id_users", "name", "username", "role"])
                    ->where("role", "teknisi")->where(function ($query) use ($q) {
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
     * @param $id
     * @return int
     */
    public function deleteTechnician($id)
    {
        return $this->where("role", "teknisi")->where("id_users", $id)->delete();
    }
}
