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
     * Split a same code to a part
     *
     * @return OrderModel
     */
    private function main()
    {
        return $this->with(["technician"])->select(["id_service", "unique_id", "created_at", "status_service", "nama_pemilik", "service_id_teknisi"])->orderBy("id_service", "DESC");
    }

    /**
     * Get order lists
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrderList()
    {
        return $this->main()->paginate(12);
    }

    /**
     * search by unique id
     *
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($id, $status)
    {
        $where = $this->checkWhereClause("unique_id", $id, []);
        $where = $this->checkWhereClause("status_service", $status, $where);

        return $this->main()->where($where)->paginate(12);
    }

    private function checkWhereClause($key, $value, $arr)
    {
        if ($value != null) {
            $arr[$key] = $value;
        }

        return $arr;
    }

    /**
     * Take some latest orders
     *
     * @param $number
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function takeFromLast($number)
    {
        return $this->main()->take($number)->get();
    }
}
