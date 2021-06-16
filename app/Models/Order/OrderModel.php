<?php

namespace App\Models\Order;

use App\Interfaces\Total\Countable;
use App\Models\Complaint\ComplaintModel;
use App\Models\Jasa\JasaModel;
use App\Models\Technician\TechnicianModel;
use App\Models\User\UserModel;
use App\Traits\DateTime\DateTimeRepeaterAndSanitizer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Order
 */
class OrderModel extends Model implements Countable
{
    use DateTimeRepeaterAndSanitizer;

    protected $table = "orders";
    protected $primaryKey = "id_orders";

    /**
     * Represent the enum field (status_service) in table, because i don't know how to get all
     * the value from it
     */
    const STATUS_SERVICE = ["menunggu", "dicek", "perbaikan", "selesai", "terima"];

    /**
     * Update service status
     *
     * @param $id_orders
     * @param $id
     * @param $role
     * @param $status
     * @param $arr
     * @return int
     */
    public function updateStatusService($id_orders, $id, $role, $status, $arr)
    {
        $where = ["id_orders" => $id_orders];

        if ($role == "teknisi") {
            $where["orders_id_teknisi"]    = $id;
        }

        return $this->where($where)->whereNotIn("status_service", $arr)->update([
            "status_service"        => $status,
            "updated_at"            => date("Y-m-d H:i:s")
        ]);
    }

    /**
     * Retrieve last finished total order
     * VERY VERY VERY VERY BAD CODE AND BAD PRACTICE, WILL FIX IT LATER
     *
     * @param $id_teknisi
     * @return array
     */
    public function retrieveTotalFinishedOrdersInLast7Months($id_teknisi)
    {
        $arr = [];
        for ($i = 7; $i >= 1; $i--){
            $date = Carbon::now()->subMonths($i)->toArray();
            $result = $this->whereMonth("updated_at", $date["month"])
                           ->whereYear("updated_at", $date["year"])
                           ->where("status_service", "terima")
                           ->where("orders_id_teknisi", $id_teknisi)->count();

            setlocale(LC_ALL, 'IND');

            array_push($arr, $result);
        }

        return $arr;
    }

    /**
     * Get data for order form
     *
     * @param $unique_id
     * @return OrderModel|Model|object|null
     */
    public function printOrder($unique_id)
    {
        return $this->with(["user:id_users,email", "user.biodata:id_biodata,biodata_id_users,nomor_hp"])
                    ->select(["unique_id", "nama_pelanggan", "orders_id_pelanggan", "alamat_pelanggan", "nama_perangkat", "keluhan", "jenis_perangkat", "merk"])
                    ->where("unique_id", $unique_id)->first();
    }

    /**
     * Get status service
     *
     * @param $id
     * @param $id_teknisi
     * @return OrderModel|Model|object|null
     */
    public function getOrderStatusById($id, $id_teknisi)
    {
        return $this->select([DB::raw("status_service AS status")])->where([
            "id_orders"            => $id,
            "orders_id_teknisi"    => $id_teknisi
        ])->first();
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

        /**
            SELECT *
            FROM (
                SELECT COUNT(id_service) AS total, status_service FROM service WHERE service_id_teknisi = 13 GROUP BY status_service
                UNION SELECT 0 AS total, 'menunggu' AS status_service
                UNION SELECT 0 AS total, 'dicek' AS status_service
                UNION SELECT 0 AS total, 'perbaikan' AS status_service
                UNION SELECT 0 AS total, 'selesai' AS status_service
                UNION SELECT 0 AS total, 'terima' AS status_service
            ) service
            GROUP BY status_service
         */

        /**
         * Pure Query
         *
         * SELECT status_service, updated_at, service_id_teknisi, COUNT(status_service) AS total, MONTH(updated_at) AS bulan
         * FROM service
         * WHERE (MONTH(updated_at) = 3? OR MONTH(updated_at) = 4?) AND YEAR(updated_at) = 2021? AND service_id_teknisi = 13?
         * GROUP BY status_service, bulan
         * ORDER BY bulan ASC, status_service ASC
         */
        return $this->select(["status_service", "updated_at", "orders_id_teknisi", DB::raw("COUNT(status_service) AS total"), DB::raw("MONTH(updated_at) AS bulan")])
                    ->where(function (\Illuminate\Database\Eloquent\Builder $query) {
                        $lastMonth = $this->repeatMonth(date("m") - 1);
                        $thisMonth = $this->repeatMonth(date("m"));

                        $query->whereMonth("updated_at", $lastMonth)
                              ->orWhereMonth("updated_at", $thisMonth);
                    })
                    ->whereYear("updated_at", date("Y"))
                    ->where("orders_id_teknisi", $id_teknisi)
                    ->groupBy("status_service", "bulan")
                    ->orderBy("bulan")
                    ->orderBy("status_service")
                    ->get();
    }

    public function technician()
    {
        return $this->hasOne(TechnicianModel::class, "id_users", "orders_id_teknisi")->select(["id_users", "name", "username", "role"])->where("role", "teknisi");
    }

    /**
     * Split a same code to a part
     *
     * @return OrderModel
     */
    private function main()
    {
        return $this->with([
            "technician",
            "user:id_users,name,email,username",
            "complaint:disetujui_pelanggan,id_pengaduan,isi,pengaduan_id_orders,dikerjakan_teknisi,tipe",
            "spareparts:id_orders_spare_part,orders_spare_part_id_orders,jumlah,harga"
        ])->select(["id_orders", "unique_id", "created_at", "status_service", "nama_pelanggan", "orders_id_teknisi", "orders_id_pelanggan", "canceled_at"])->orderBy("id_orders", "DESC");
    }

    /**
     * Get order lists
     *
     * @param $id
     * @param $role
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrderList($id, $role)
    {
        $main = $this->main()->whereNotNull("orders_id_pelanggan");
        // if user is admin
        if ($role == "admin") {
            return $main->paginate(12);
        } else if ($role == "pelanggan") { // if user is normal user
            return $main->where("orders_id_pelanggan", $id)->paginate(12);
        }
        // if user is a technician
        return $main->where("orders_id_teknisi", $id)
                            ->orWhere("status_service", "menunggu")
                            ->paginate(12);
    }

    /**
     * Cancel order
     *
     * @param $id
     * @return int
     */
    public function cancel($id)
    {
        return $this->whereNull("canceled_at")->where("id_orders", $id)->update([
            "canceled_at"   => now()
        ]);
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
            "id_orders"            => $id_service,
            "status_service"        => "menunggu"
        ])->update([
            "orders_id_teknisi"    => $id_teknisi,
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
            "id_orders"            => $id,
            "orders_id_teknisi"    => $id_teknisi
        ])->exists();
    }

    /**
     * Get technician id, (just the id)
     *
     * @param $id_service
     * @param $id_user
     * @return OrderModel|Model|object|null
     */
    public function getTechnicianIdByServiceIdAndUserId($id_service, $id_user)
    {
        return $this->select(["orders_id_teknisi"])->where([
            "id_orders"             => $id_service,
            "orders_id_pelanggan"   => $id_user
        ])->first();
    }

    /**
     * Search by unique id or status service
     *
     * @param $id
     * @param $status
     * @param null $teknisi_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($id, $status, $teknisi_id = null, $user_id = null)
    {
        $where = $this->addWhereClause("unique_id", $id, []);
        $where = $this->addWhereClause("status_service", $status, $where);

        if ($user_id != null) {
            $where = $this->addWhereClause("orders_id_pelanggan", $user_id, $where);
        } else if ($status != "menunggu" && $teknisi_id != null) {
            $where = $this->addWhereClause("orders_id_teknisi", $teknisi_id, $where);
        }

        return $this->main()->where($where)->paginate(12);
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, "id_users", "orders_id_pelanggan");
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
            "spareparts:orders_spare_part_id_orders,orders_spare_part_id_spare_part,id_orders_spare_part,nama_spare_part,jumlah,harga,part_number,serial_number",
            "spareparts.images:id_foto_spare_part,foto_spare_part_id_spare_part,picture",
            "technician",
            "complaint:disetujui_pelanggan,id_pengaduan,isi,pengaduan_id_orders,dikerjakan_teknisi,tipe,disetujui_admin",
            "service:id_jasa,nama_jasa,tipe,biaya_jasa"
        ])
        ->select(["id_orders", "orders_id_jasa", "orders_id_teknisi", "orders_id_pelanggan", "nama_pelanggan", "alamat_pelanggan", "nama_perangkat", "keluhan", "jenis_perangkat", "merk", "status_service", "note", "canceled_at"])
        ->where("unique_id", $unique_id)->first();
    }

    /**
     * Update note in order
     *
     * @param $id
     * @param $id_teknisi
     * @param null $note
     * @return int
     */
    public function updateNote($id, $id_teknisi, $note = null)
    {
        $query = $this->where("id_orders", $id);
        if ($id_teknisi != null) {
            $query = $query->where("orders_id_teknisi", $id_teknisi);
        }

        return $query->update([
            "note"  => $note
        ]);
    }

    public function service()
    {
        return $this->hasOne(JasaModel::class, "id_jasa", "orders_id_jasa");
    }

    public function spareparts()
    {
        return $this->hasMany(OrderSparepartModel::class, "orders_spare_part_id_orders", "id_orders");
    }

    public function complaint()
    {
        return $this->hasOne(ComplaintModel::class, "pengaduan_id_orders", "id_orders");
    }

    /**
     * Delete order by id
     *
     * @param $id
     * @return mixed
     */
    public function deleteOrder($id)
    {
        return $this->where("id_orders", $id)->delete();
    }

    /**
     * Get unique id
     *
     * @param $id
     * @return OrderModel|Model|object|null
     */
    public function getUniqueIdById($id)
    {
        return $this->select(["unique_id"])->where("id_orders", $id)->first();
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
            "orders_id_pelanggan"                       => $id_user,
            "orders_id_jasa"                            => $data->id_service,
            "unique_id"                                 => $unique_id,
            "nama_pelanggan"                            => $data->name,
            "alamat_pelanggan"                          => $data->address,
            "nama_perangkat"                            => $data->device_name,
            "keluhan"                                   => $data->device_problem,
            "jenis_perangkat"                           => $data->device_type == "pc" ? "pc/komputer" : $data->device_type,
            "merk"                                      => $data->device_brand,
            "created_at"                                => now(),
            "updated_at"                                => now()
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
     * @param null $role
     * @return OrderModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function takeFromLast($number, $id = null, $role = null)
    {
        // check if technician or admin
        if ($role == "admin") {
            return $this->main()->take($number)->get();
        } else if ($role == "teknisi") {
            return $this->main()->where("orders_id_teknisi", $id)->take($number)->get();
        }
        return $this->main()->where("orders_id_pelanggan", $id)->take($number)->get();
    }

    /**
     * Count the total of data
     *
     * @param $id
     * @param $role
     * @return mixed
     */
    public function total($id, $role)
    {
        if ($role === "pelanggan") {
            return $this->where("orders_id_pelanggan", $id)->count();
        } else if ($role === "teknisi") {
            return $this->where("orders_id_teknisi", $id)->count();
        }
        return $this->count();
    }
}
