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
    protected $table = "orders";
    protected $primaryKey = "id_orders";

    /**
     * @param int $month
     * @param int $year
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function collectDataForExports(int $month, int $year)
    {
        return $this->with(["service", "spareparts"])
                    ->select(["id_orders", "orders_id_jasa", "unique_id", "updated_at"])
                    ->whereMonth("orders.updated_at", $month)
                    ->whereYear("orders.updated_at", $year)
                    ->where("status_service", "terima")
                    ->whereNull("canceled_at")
                    ->get();
    }

    public function service()
    {
        return $this->hasOne(JasaModel::class, "id_jasa", "orders_id_jasa");
    }

    public function spareparts()
    {
        return $this->hasMany(OrderSparepartModel::class, "orders_spare_part_id_orders", "id_orders");
    }
}
