<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryModel
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App\Models\History
 */
class HistoryModel extends Model
{
    protected $table = "history";
    protected $primaryKey = "id_history";

    /**
     * Create history for any action
     *
     * @param string $content
     */
    public function createHistory(string $content)
    {
        // add try catch, we dont care if history has inserted or not
        try {
            $this->insert([
                "content"       => $content,
                "created_at"    => date("Y-m-d H:i:s"),
                "updated_at"    => date("Y-m-d H:i:s"),
            ]);
        } catch (\Exception $exception) {}
    }
}
