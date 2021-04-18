<?php

namespace App\Models\Order;

use App\Models\Technician\TechnicianModel;
use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderModel extends Model
{
    protected $table = "service";
    protected $primaryKey = "id_service";

    /**
     * Represent the enum field (status_service) in table, because i don't know how to get all
     * the value from it
     */
    const STATUS_SERVICE = ["menunggu", "dicek", "perbaikan", "selesai", "pembayaran", "terima"];

    /**
     * Update service status
     *
     * @param $id_service
     * @param $id_teknisi
     * @param $status
     * @param $arr
     * @return int
     */
    public function updateStatusService($id_service, $id_teknisi, $status, $arr)
    {
        return $this->where([
            "id_service"            => $id_service,
            "service_id_teknisi"    => $id_teknisi,
            "updated_at"            => date("Y-m-d H:i:s")
        ])->whereNotIn("status_service", $arr)->update([
            "status_service"        => $status
        ]);
    }

    /**
     * Get total of status service of last and this month, to convert it to graph
     *
     * @param $id_teknisi
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function retrieveTotalOrdersInLastAndThisMonth($id_teknisi)
    {
        DB::statement("SET sql_mode = ''");

        return $this->select(["status_service", "updated_at", "service_id_teknisi", DB::raw("COUNT(status_service) AS total"), DB::raw("MONTH(updated_at) AS bulan")])
                    ->where(function (\Illuminate\Database\Eloquent\Builder $query) {
                        $query->whereMonth("updated_at", date("m") - 1)
                              ->orWhereMonth("updated_at", date("m"));
                    })
                    ->whereYear("updated_at", date("Y"))
                    ->where("service_id_teknisi", $id_teknisi)
                    ->groupBy("status_service", "bulan")
                    ->orderBy("bulan")
                    ->orderBy("status_service")
                    ->get();
    }

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
     * @param null $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrderList($id = null)
    {
        if ($id == null) {
            return $this->main()->paginate(12);
        }
        return $this->main()->where("service_id_teknisi", $id)->orWhere("status_service", "menunggu")->paginate(12);
    }

    /**
     * Take order, just technician can do this
     *
     * @param $id_service
     * @param $id_teknisi
     * @return int
     */
    public function takeOrder($id_service, $id_teknisi)
    {
        return $this->where([
            "id_service"            => $id_service,
            "status_service"        => "menunggu"
        ])->update([
            "service_id_teknisi"    => $id_teknisi,
            "status_service"        => DB::raw("status_service + 1")
        ]);
    }

    /**
     * Check if this order belongs to technician
     *
     * @param $id
     * @param $id_teknisi
     * @return bool
     */
    public function isOrderBelongsToTechnician($id, $id_teknisi)
    {
        return $this->where([
            "id_service"            => $id,
            "service_id_teknisi"    => $id_teknisi
        ])->exists();
    }

    /**
     * Search by unique id or status service
     *
     * @param $id
     * @param $status
     * @param null $teknisi_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($id, $status, $teknisi_id = null)
    {
        $where = $this->addWhereClause("unique_id", $id, []);
        $where = $this->addWhereClause("status_service", $status, $where);

        if ($status != "menunggu") {
            $where = $this->addWhereClause("service_id_teknisi", $teknisi_id, $where);
        }

        return $this->main()->where($where)->paginate(12);
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, "id_users", "service_id_user");
    }

    /**
     * Retrieve single order
     *
     * @param $unique_id
     * @return OrderModel|Model|object|null
     */
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
    private function addWhereClause($key, $value, $arr)
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
     * @param null $id
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function takeFromLast($number, $id = null)
    {
        // check if technician or admin
        if ($id == null) {
            return $this->main()->take($number)->get();
        }
        return $this->main()->where("service_id_teknisi", $id)->take($number)->get();
    }
}
