<?php

namespace App\Models\Order;

use App\Models\Technician\TechnicianModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderModel extends Model
{
    protected $table = "service";

    public function technician()
    {
        return $this->hasOne(TechnicianModel::class, "id_users", "service_id_teknisi")->select(["id_users", "name", "username", "role"])->where("role", "teknisi");
    }

    /**
     * Take some latest orders
     *
     * @param $number
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function takeFromLast($number)
    {
        return $this->with(["technician"])->select(["id_service", "unique_id", "created_at", "status_service", "nama_pemilik", "service_id_teknisi"])->orderBy("id_service", "DESC")->take($number)->get();
    }
}
