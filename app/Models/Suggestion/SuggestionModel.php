<?php

namespace App\Models\Suggestion;

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
     * Retrieve all suggestions
     *
     * @param $id
     * @return SuggestionModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function retrieveAll($id)
    {
        return $this->select(["id_pengaduan", "pengaduan_id_users", "isi", "tipe", "created_at"])->where([
            "pengaduan_id_users"    => $id,
            "tipe"                  => $this->type
        ])->orderBy("id_pengaduan", "DESC")->get();
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
     * @return SuggestionModel|Model|object|null
     */
    public function retrieveSingle($id, $id_users)
    {
        return $this->where([
            "id_pengaduan"          => $id,
            "pengaduan_id_users"    => $id_users
        ])->select(["id_pengaduan", "pengaduan_id_users", "isi", "created_at"])->first();
    }
}
