<?php

namespace App\Models\Complaint;

use App\Models\Order\OrderModel;
use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ComplaintModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Complaint
 */
class ComplaintModel extends Model
{
    protected $table = "pengaduan";
    protected $primaryKey = "id_pengaduan";

    private $type = "komplain";

    /**
     * Create complaint
     *
     * @param $id_service
     * @param $id_user
     * @param $id_teknisi
     * @param $content
     * @return bool
     */
    public function saveComplaint($id_service, $id_user, $id_teknisi, $content)
    {
        return $this->insert([
            "pengaduan_id_service"      => $id_service,
            "pengaduan_id_users"        => $id_user,
            "pengaduan_id_teknisi"      => $id_teknisi,
            "isi"                       => $content,
            "tipe"                      => $this->type
        ]);
    }

    /**
     * Check if order has not finished complaint
     *
     * @param $id_service
     * @param $id_teknisi
     * @return bool
     */
    public function orderHasComplaint($id_service)
    {
        return $this->where([
            "pengaduan_id_service"  => $id_service,
            "disetujui_user"        => 0
        ])->exists();
    }

    /**
     * Retrieve complaint
     *
     * @param $id_users
     * @param $id_teknisi
     * @param $role
     * @param $next
     * @param null $last_suggestion_id
     * @return ComplaintModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function retrieveAll($id_users, $id_teknisi, $role, $next, $last_suggestion_id = null)
    {
        $take = 15;
        $main = $this->select(["id_pengaduan", "pengaduan_id_users", "isi", "tipe", "dikerjakan_teknisi", "disetujui_user", "created_at"])
                     ->orderBy("id_pengaduan", "DESC");

        if ($last_suggestion_id != null) {
            $last_suggestion_id = $next ? $last_suggestion_id : $last_suggestion_id + $take + 1;
            $main->where("id_pengaduan", "<", $last_suggestion_id);
        }

        if ($role == "user") {
            return $main->where([
                "pengaduan_id_users"    => $id_users,
                "tipe"                  => $this->type
            ])->take($take)->get();
        } else if ($role == "teknisi") {
            $main = $main->where([
                "tipe"                  => $this->type,
                "pengaduan_id_teknisi"  => $id_teknisi
            ]);
        }

        $main = $main->where([
            "tipe"                  => $this->type
        ]);

        return $main->take($take)->with(["user:id_users,name,username"])->get();
    }

    /**
     * Do accept, by user
     *
     * @param $id
     * @param $id_user
     * @return int
     */
    public function doAccept($id, $id_user)
    {
        return $this->where([
            "id_pengaduan"              => $id,
            "pengaduan_id_users"        => $id_user,
            "tipe"                      => $this->type
        ])->update([
            "disetujui_user"            => 1
        ]);
    }

    /**
     * Do complaint, by technician
     *
     * @param $id
     * @param $id_teknisi
     * @return int
     */
    public function doComplaint($id, $id_teknisi)
    {
        return $this->where([
            "id_pengaduan"              => $id,
            "pengaduan_id_teknisi"      => $id_teknisi,
            "tipe"                      => $this->type
        ])->update([
            "dikerjakan_teknisi"        => 1
        ]);
    }

    /**
     * Retrieve single complaint data
     *
     * @param $id
     * @param $id_users
     * @param $role
     * @return ComplaintModel|Model|object|null
     */
    public function retrieve($id, $id_users, $role)
    {
        $main = $this->with(["order:unique_id,id_service"])->select(["id_pengaduan", "pengaduan_id_users", "pengaduan_id_service", "isi", "balasan", "disetujui_user", "dikerjakan_teknisi", "created_at"]);

        if ($role == "user") {
            return $main->where([
                "id_pengaduan"          => $id,
                "pengaduan_id_users"    => $id_users,
                "tipe"                  => $this->type
            ])->first();
        } else {
            return $main->where([
                "id_pengaduan"          => $id,
                "tipe"                  => $this->type
            ])->with(["user:id_users,name,username,email", "user.biodata:id_biodata,biodata_id_users,profile_picture"])->first();
        }
    }

    public function order()
    {
        return $this->belongsTo(OrderModel::class, "pengaduan_id_service", "id_service");
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, "id_users", "pengaduan_id_users");
    }
}
