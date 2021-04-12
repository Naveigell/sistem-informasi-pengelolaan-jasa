<?php

namespace App\Models\Order;

use App\Models\Sparepart\FotoSparepartModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderSparepartModel extends Model
{
    protected $table = "service_spare_part";
    protected $primaryKey = "id_service_spare_part";

    public function images()
    {
        return $this->hasMany(FotoSparepartModel::class, "foto_spare_part_id_spare_part", "service_spare_part_id_spare_part");
    }

    /**
     * @param $spareparts
     * @return bool
     */
    public function saveSparepart($spareparts)
    {
        return $this->insert($spareparts);
    }

    /**
     * Delete sparepart
     *
     * @param $id_service
     * @param $id_sparepart
     * @return mixed
     */
    public function deleteSparepart($id_service, $id_sparepart)
    {
        return $this->where("service_spare_part_id_service", $id_service)->whereIn("service_spare_part_id_spare_part", $id_sparepart)->delete();
    }
}
