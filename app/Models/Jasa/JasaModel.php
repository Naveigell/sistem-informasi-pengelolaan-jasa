<?php

namespace App\Models\Jasa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class JasaModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Jasa
 */
class JasaModel extends Model
{
    protected $table = "jasa";
    protected $primaryKey = "id_jasa";
    public $timestamps = true;

    /**
     * Activation for jasa status
     *
     * @param $id
     * @return int
     */
    public function activation($id)
    {
        return $this->where("id_jasa", $id)->update([
            "aktif" => DB::raw("(CASE WHEN aktif = 1 THEN 0 ELSE 1 END)")
        ]);
    }

    public function updateJasa($data)
    {
        return $this->where("id_jasa", $data->id)->update([
            "nama_jasa"         => $data->name,
            "deskripsi"         => $data->description,
            "tipe"              => $data->type == "pc" ? "pc/komputer" : $data->type,
            "biaya_jasa"        => $data->price,
            "updated_at"        => now()
        ]);
    }

    /**
     * Create new jasa
     *
     * @param $data
     * @return int
     */
    public function createJasa($data)
    {
        return $this->insertGetId([
            "nama_jasa"         => $data->name,
            "deskripsi"         => $data->description,
            "tipe"              => $data->type == "pc" ? "pc/komputer" : $data->type,
            "biaya_jasa"        => $data->price,
            "created_at"        => now(),
            "updated_at"        => now()
        ]);
    }

    /**
     * Get single data
     *
     * @param $id
     * @return JasaModel|Model|object|null
     */
    public function getSingleData($id)
    {
        return $this->where("id_jasa", $id)->first();
    }

    /**
     * Delete jasa
     *
     * @param $id
     * @return mixed
     */
    public function deleteJasa($id)
    {
        return $this->where("id_jasa", $id)->delete();
    }
}
