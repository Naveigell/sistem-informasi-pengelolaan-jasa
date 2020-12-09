<?php

namespace App\Models\Sparepart;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FotoSparepartModel
 * @mixin \Illuminate\Database\Query\Builder
 * @package App\Models\Sparepart
 */
class FotoSparepartModel extends Model
{
    protected $table = "foto_spare_part";
    protected $primaryKey = "id_foto_spare_part";

    public function sparepart(){
        return $this->belongsTo(SparepartModel::class,"id_spare_part", "foto_spare_part_id_spare_part");
    }

    /**
     * Create images for spareparts
     *
     * @param $id
     * @param $images
     * @return bool
     */
    public function createImages($id, $images)
    {
        $imgs = [];
        foreach ($images as $image) {
            $imgs[] = [
                "foto_spare_part_id_spare_part"     => $id,
                "picture"                           => $image
            ];
        }

        return $this->insert($imgs);
    }

    public function getImages($id)
    {
        $images = $this->select(["picture"])->where("foto_spare_part_id_spare_part", $id)->get();
        $data = [];

        foreach ($images as $image) {
            array_push($data, $image->picture);
        }

        return $data;
    }

    public function deleteLastImages($id)
    {
        return $this->where("foto_spare_part_id_spare_part", $id)->delete();
    }
}
