<?php

namespace App\Models\Order;

use App\Models\Sparepart\FotoSparepartModel;
use Illuminate\Database\Eloquent\Model;

class OrderSparepartModel extends Model
{
    protected $table = "service_spare_part";
    protected $primaryKey = "id_service_spare_part";

    public function images()
    {
        return $this->hasMany(FotoSparepartModel::class, "foto_spare_part_id_spare_part", "service_spare_part_id_spare_part");
    }
}
