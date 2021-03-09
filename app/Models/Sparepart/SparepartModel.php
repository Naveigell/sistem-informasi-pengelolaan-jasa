<?php

namespace App\Models\Sparepart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class SparepartModel
 * @mixin \Illuminate\Database\Query\Builder
 * @package App\Models\Sparepart
 */
class SparepartModel extends Model
{
    protected $table = "spare_part";
    protected $primaryKey = "id_spare_part";

    /**
     * Insert then get id for foto_spare_part
     *
     * @param $data
     * @return int
     */
    public function createSparepart($data)
    {
        return $this->insertGetId([
            "nama_spare_part"       => $data->name,
            "deskripsi"             => $data->description,
            "tipe"                  => $data->type == "pc" ? "pc/komputer" : $data->type,
            "stok"                  => $data->stock,
            "harga"                 => $data->price
        ]);
    }

    /**
     * Delete sparepart by given id
     *
     * @param $id
     * @return int
     */
    public function deleteSparepart($id)
    {
        return $this->where("id_spare_part", $id)->delete();
    }

    /**
     * Update sparepart data
     *
     * @param $id
     * @param $data
     * @return int
     */
    public function updateSparepart($id, $data)
    {
        return $this->where("id_spare_part", $id)->update([
            "nama_spare_part"           => $data->name,
            "deskripsi"                 => $data->description,
            "tipe"                      => $data->type == "pc" ? "pc/komputer" : $data->type,
            "stok"                      => $data->stock,
            "harga"                     => $data->price
        ]);
    }

    /**
     * Get sparepart lists
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSparePartList() {
        return $this->with("images")->select(["id_spare_part", "nama_spare_part AS nama", "tipe", "stok", "harga"])->paginate(12);
    }

    /**
     * return [
     *      "id_foto_spare_part AS id",
     *      "foto_spare_part_id_spare_part",
     *      "picture"
     * ]
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images(){
        return $this->hasMany(FotoSparepartModel::class, "foto_spare_part_id_spare_part", "id_spare_part")->select(["id_foto_spare_part AS id", "foto_spare_part_id_spare_part", "picture"]);
    }

    /**
     * @param mixed|string $q
     * @param null|string $t
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($q, $t = null) {
        $query = $this->select(["id_spare_part", "nama_spare_part AS nama", "tipe", "stok", "harga"])
//                    ->whereRaw("MATCH(nama_spare_part) AGAINST(? IN BOOLEAN MODE)", array($q))
//                    ->whereRaw("MATCH(nama_spare_part) AGAINST("%value" IN BOOLEAN MODE)", array($q))
                    ->orWhere(function ($query) use ($q, $t) {
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
                            $query->orWhere("nama_spare_part", "LIKE", "%$merges%");
                        }

                    });

        // type is optional,
        if ($t != null) {
            $query->where("tipe", $t);
        }

        return $query->paginate(12);
    }
}
