<?php

namespace App\Models\Exports\Excel;

use App\Models\Order\OrderModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderSparepartModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Exports\Excel
 */
class OrderSparepartModel extends Model
{
    protected $table = "service_spare_part";
    protected $primaryKey = "id_service_spare_part";

    /**
     * Collect data for exporter
     *
     * @param int $month
     * @param int $year
     * @return array
     */
    public function collectDataForExports(int $month, int $year)
    {
        return $this->select(["nama_spare_part", "jumlah", "harga_asli", "harga", "updated_at", "service_spare_part_id_service"])
                    ->with(["order:id_service,service_id_jasa,unique_id", "order.service:id_jasa,biaya_jasa"])
                    ->whereMonth("updated_at", $month)
                    ->whereYear("updated_at", $year)
                    ->get()
                    ->groupBy("order.unique_id")->toArray();
    }

    public function order()
    {
        return $this->belongsTo(OrderModel::class, "service_spare_part_id_service", "id_service");
    }
}
