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
                DB::raw("SUM(service_spare_part.harga) AS harga"), "service_spare_part.id_service_spare_part", "service.id_service",
                DB::raw("MONTH(service_spare_part.updated_at) AS bulan"),
                DB::raw("YEAR(service_spare_part.updated_at) AS tahun")
            ])
            ->join("service", "service_spare_part.service_spare_part_id_service", "=", "service.id_service")
            ->where("service.status_service", "terima")
            ->whereMonth("service_spare_part.updated_at", $date->toArray()["month"])
            ->whereYear("service_spare_part.updated_at", $date->toArray()["year"])->sum("harga");

            array_push($arr, $result);
        }
        return $arr;
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
