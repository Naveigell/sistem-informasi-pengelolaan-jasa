<?php

namespace App\Http\Controllers\Api\History;

use App\Http\Controllers\Controller;
use App\Models\History\HistoryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Retrieve all histories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll()
    {
        $histories = HistoryModel::all()->collect()->map(function ($item) {
            $created_at = Carbon::parse($item["created_at"])->format("d-m-Y H:i:s");
            $updated_at = Carbon::parse($item["updated_at"])->format("d-m-Y H:i:s");

            return [
                "id"            => $item["id_history"],
                "content"       => $item["content"],
                "created_at"    => $created_at,
                "updated_at"    => $updated_at
            ];
        })->toArray();

        return json(["histories" => $histories]);
    }
}
