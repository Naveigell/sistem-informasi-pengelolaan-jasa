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
            "harga_asli"            => $data->real_price,
            "harga"                 => $data->price,
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
            "harga_asli"            => $data->real_price,
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
     * Search sparepart in Order Show, just technician can do this
     *
     * @param $query
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchSparepart($query, $type)
    {
        return $this->with(["images"])->select(["id_spare_part", "nama_spare_part", "harga", "stok"])->whereRaw("nama_spare_part LIKE ? AND tipe = ? AND stok > 0", ["%$query%", $type])->take(5)->get();
    }

    /**
     * Select sparepart by its ids
     *
     * @param $ids
     * @return \Illuminate\Support\Collection
     */
    public function selectInId($ids)
    {
        return $this->select([$this->primaryKey, "nama_spare_part", "stok", "tipe", "harga", "terjual"])->whereIn($this->primaryKey, $ids)->get();
    }

    /**
     * Update stock of spareparts
     *
     * @param string $query
     * @param array $data
     * @return int
     */
    public function updateStockSold(string $query, array $data)
    {
        return DB::statement($query, $data);
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
