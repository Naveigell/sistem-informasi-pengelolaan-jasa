<?php

namespace App\Models\Order;

use App\Models\Sparepart\FotoSparepartModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderSparepartModel extends Model
{
    protected $table = "orders_spare_part";
    protected $primaryKey = "id_orders_spare_part";

    public function images()
    {
        return $this->hasMany(FotoSparepartModel::class, "foto_spare_part_id_spare_part", "orders_spare_part_id_spare_part");
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
     * Get sparepart by id sparepart
     *
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public function retrieveSparepartByIdOrder($id)
    {
        return $this->select(["id_orders_spare_part", "orders_spare_part_id_orders", "jumlah", "orders_spare_part_id_spare_part"])->where("orders_spare_part_id_orders", $id)->get();
    }

    /**
     * Retrieve total income from 6 month ago
     *
     * @return array
     */
    public function retrieveTotalIncomeFromLast6Months()
    {
        $arr = [];
        for ($i = 6; $i >= 1; $i--) {
            DB::statement("SET sql_mode = ''");

            $date = Carbon::now()->subMonths($i);
            $result = $this->select([
                DB::raw("SUM(orders_spare_part.harga) AS harga"), "orders_spare_part.id_orders_spare_part", "orders.id_orders",
                DB::raw("MONTH(orders_spare_part.updated_at) AS bulan"),
                DB::raw("YEAR(orders_spare_part.updated_at) AS tahun")
            ])
            ->join("orders", "orders_spare_part.orders_spare_part_id_orders", "=", "orders.id_orders")
            ->where("orders.status_service", "terima")
            ->whereMonth("orders.updated_at", $date->toArray()["month"])
            ->whereYear("orders.updated_at", $date->toArray()["year"])->sum(DB::raw("harga * jumlah"));

            array_push($arr, (int) $result);
        }
        return $arr;
    }

    /**
     * Delete sparepart
     *
     * @param $id_service
     * @return mixed
     */
    public function deleteSparepart($id_service)
    {
        return $this->where("orders_spare_part_id_orders", $id_service)->delete();
    }
}
