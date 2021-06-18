<?php

namespace App\Models\User\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/**
 * Class BiodataModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\User\Account
 */
class BiodataModel extends Model
{
    protected $table = "biodata";
    protected $primaryKey = "id_biodata";

    /**
     * @param $id string|int
     * @return BiodataModel|BiodataModel[]|\Illuminate\Database\Eloquent\Collection|Model|object get first biodata
     */
    public function retrieveBiodata($id){
        return $this->select(["jenis_kelamin", "nomor_hp", "profile_picture", "alamat", "name", "username", "email", "instansi"])
                    ->join("users", "biodata_id_users", "=", "id_users")
                    ->where("biodata_id_users", $id)->first();
    }

    /**
     * @param $id
     * @return BiodataModel|Model|object|null get first image profile
     */
    public function retrieveProfilePicture($id) {
        return $this->select(["profile_picture"])->where("biodata_id_users", $id)->first();
    }

    /**
     * @param $id int|string
     * @param $filename string
     * @return int
     */
    public function updateProfilePicture($id, string $filename)
    {
        return $this->where("biodata_id_users", $id)->update([
            "profile_picture"       => $filename
        ]);
    }

    /**
     * Create new biodata
     *
     * @param $id
     * @param object $data
     * @return bool
     */
    public function createBiodata($id, object $data)
    {
        return $this->insert([
            "biodata_id_users"      => $id,
            "jenis_kelamin"         => $data->gender,
            "nomor_hp"              => property_exists($data, 'phone') ? $data->phone : null,
            "instansi"              => property_exists($data, 'company') ? $data->company : null,
            "profile_picture"       => $data->avatar,
            "alamat"                => property_exists($data, 'address') ? $data->address : null,
            "created_at"            => now(),
            "updated_at"            => now()
        ]);
    }

    /**
     * @param $id_users string
     * @param $alamat string
     * @param $email string
     * @param $jenis_kelamin string
     * @param $name string
     * @param $nomor_hp string
     * @param $username string
     * @param $company string
     * @return int return an http status code
     */
    public function updateBiodata($id_users, $alamat, $email, $jenis_kelamin, $name, $nomor_hp, $username, $company) {

        DB::beginTransaction();

        try {
            $biodata = $this->where("biodata_id_users", $id_users)->update([
                "alamat"            => $alamat,
                "jenis_kelamin"     => $jenis_kelamin,
                "nomor_hp"          => $nomor_hp,
                "instansi"          => $company
            ]);

            $account = DB::table('users')->where("id_users", $id_users)->update([
                "name"      => $name,
                "username"  => $username,
                "email"     => $email
            ]);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            $code = $exception->errorInfo[1];
            if ($code == "1062") {
                return 409;
            }
        }

        return 200;
    }
}
