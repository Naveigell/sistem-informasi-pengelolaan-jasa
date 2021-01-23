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

    /**
     * Get images list
     *
     * @param $id
     * @return array
     */
    public function getImages($id)
    {
        return $this->select(["picture"])->where("foto_spare_part_id_spare_part", $id)->pluck("picture")->toArray();
    }

    /**
     * Delete images by sparepart id
     *
     * @param $id
     * @return int
     */
    public function deleteLastImages($id)
    {
        return $this->where("foto_spare_part_id_spare_part", $id)->delete();
    }
}
