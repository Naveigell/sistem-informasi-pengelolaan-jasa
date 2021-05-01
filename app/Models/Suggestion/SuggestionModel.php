<?php

namespace App\Models\Suggestion;

use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SuggestionModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\Suggestion
 */
class SuggestionModel extends Model
{
    protected $table = "pengaduan";
    protected $primaryKey = "id_pengaduan";

    private $type = "saran";

    /**
     * Retrieve all suggestions and paginate by the latest id
     *
     * @param $id_users
     * @param $role
     * @param $next
     * @param null $last_suggestion_id
     * @return SuggestionModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function retrieveAll($id_users, $role, $next, $last_suggestion_id = null)
    {
        $take = 15;
        $main = $this->select(["id_pengaduan", "pengaduan_id_users", "isi", "tipe", "created_at"])
                     ->orderBy("id_pengaduan", "DESC");

        if ($last_suggestion_id != null) {
            $main->where("id_pengaduan", "<=", $last_suggestion_id);
        }

        if ($role == "user") {
            return $main->where([
                "pengaduan_id_users"    => $id_users,
                "tipe"                  => $this->type
            ])->take($take)->get();
        } else {
            return $main->where([
                "tipe"                  => $this->type
            ])->take($take)->with(["user:id_users,name,username"])->get();
        }
    }

    /**
     * Delete suggestions
     *
     * @param $ids
     * @return mixed
     */
    public function deleteMultipleSuggestions($ids)
    {
        return $this->whereIn("id_pengaduan", $ids)->delete();
    }

    /**
     * Take total off suggestions
     *
     * @return int
     */
    public function total()
    {
        return $this->where("tipe", $this->type)->count();
    }

    /**
     * Reply suggestions
     *
     * @param $id
     * @param $reply
     * @return int
     */
    public function replySuggestion($id, $reply)
    {
        return $this->where([
            "id_pengaduan"              => $id,
        ])->whereNotNull("isi")->update([
            "balasan"                   => $reply
        ]);
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, "id_users", "pengaduan_id_users");
    }

    /**
     * Create suggestion
     *
     * @param $id
     * @param $text
     * @return bool
     */
    public function createSuggestion($id, $text)
    {
        return $this->insert([
            "pengaduan_id_users"        => $id,
            "isi"                       => $text,
            "tipe"                      => $this->type,
            "created_at"                => date("Y-m-d H:i:s"),
            "updated_at"                => date("Y-m-d H:i:s"),
        ]);
    }

    /**
     * Retrieve single
     *
     * @param $id
     * @param $id_users
     * @param $role
     * @return SuggestionModel|Model|object|null
     */
    public function retrieveSingle($id, $id_users, $role)
    {
        $main = $this->select(["id_pengaduan", "pengaduan_id_users", "isi", "balasan", "created_at"]);

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
}
