<?php

namespace App\Models\Exports\Excel;

use App\Models\Jasa\JasaModel;
use App\Models\Order\OrderSparepartModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Exports\Excel
 */
class OrderModel extends Model
{
    protected $table = "service";
    protected $primaryKey = "id_service";

    /**
     * @param int $month
     * @param int $year
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function collectDataForExports(int $month, int $year)
    {
        return $this->with(["service", "spareparts"])
                    ->select(["id_service", "service_id_jasa", "unique_id", "biaya_jasa"])
                    ->whereMonth("service.updated_at", $month)
                    ->whereYear("service.updated_at", $year)
                    ->where("status_service", "terima")
                    ->get();
    }

    public function service()
    {
        return $this->hasOne(JasaModel::class, "id_jasa", "service_id_jasa");
    }

    public function spareparts()
    {
        return $this->hasMany(OrderSparepartModel::class, "service_spare_part_id_service", "id_service");
    }
}
