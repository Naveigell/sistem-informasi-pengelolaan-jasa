<?php

namespace App\Models\Order;

use App\Models\Technician\TechnicianModel;
use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderModel extends Model
{
    protected $table = "service";
    protected $primaryKey = "id_service";

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

    public function user()
    {
        return $this->hasOne(UserModel::class, "id_users", "service_id_user");
    }

    public function retrieve($unique_id)
    {
        return $this->with([
            "user:id_users,name,email",
            "spareparts:service_spare_part_id_service,service_spare_part_id_spare_part,id_service_spare_part,nama_spare_part,jumlah,harga",
            "spareparts.images:id_foto_spare_part,foto_spare_part_id_spare_part,picture",
            "technician"
        ])
        ->select(["id_service", "service_id_teknisi", "service_id_user", "nama_pemilik", "alamat_pemilik", "nama_perangkat", "keluhan", "jenis_perangkat", "merk", "status_service"])
        ->where("unique_id", $unique_id)->first();
    }

    public function spareparts()
    {
        return $this->hasMany(OrderSparepartModel::class, "service_spare_part_id_service", "id_service");
    }

    /**
     * Delete order by id
     *
     * @param $id
     * @return mixed
     */
    public function deleteOrder($id)
    {
        return $this->where("id_service", $id)->delete();
    }

    /**
     * Create new order
     *
     * @param $data
     * @return bool
     */
    public function createOrder($id_user, $unique_id, object $data)
    {
        return $this->insert([
            "service_id_user"                       => $id_user,
            "unique_id"                             => $unique_id,
            "nama_pemilik"                          => $data->name,
            "alamat_pemilik"                        => $data->address,
            "nama_perangkat"                        => $data->device_name,
            "keluhan"                               => $data->device_problem,
            "jenis_perangkat"                       => $data->device_type == "pc" ? "pc/komputer" : $data->device_type,
            "merk"                                  => $data->device_brand,
            "created_at"                            => now(),
            "updated_at"                            => now()
        ]);
    }

    /**
     * Add where clause
     *
     * @param $key
     * @param $value
     * @param $arr
     * @return mixed
     */
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
