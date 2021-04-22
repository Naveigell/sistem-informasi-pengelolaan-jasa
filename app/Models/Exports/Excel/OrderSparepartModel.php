<?php

namespace App\Models\Exports\Excel;

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
     * @return OrderSparepartModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function collectDataForExports(int $month, int $year)
    {
        return $this->select(["nama_spare_part", "jumlah", "harga_asli", "harga", "updated_at"])
                    ->whereMonth("updated_at", $month)
                    ->whereYear("updated_at", $year)->get();
    }
}
