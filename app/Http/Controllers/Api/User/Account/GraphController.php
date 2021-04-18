<?php
namespace App\Http\Controllers\Api\User\Account;

use App\Helpers\Arrays\Arrays;
use App\Http\Controllers\Controller;
use App\Interfaces\Graph\GraphDataInterface;
use App\Interfaces\Graph\GraphProcessInterface;
use App\Models\Order\OrderModel;

class GraphController extends Controller implements GraphProcessInterface, GraphDataInterface
{
    private OrderModel $orders;
    private $auth;

    public function __construct()
    {
        $this->orders   = new OrderModel();
        $this->auth     = auth("user");
    }

    /**
     * Retrieve graph data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveData()
    {
        return $this->toData();
    }

    /**
     * Convert of graph data
     */
    public function toData()
    {
        return json([
            "graph"                 => [
                "data"              => [
                    "labels"        => $this->labels(),
                    "datasets"      => $this->datasets()
                ]
            ]
        ]);
    }

    /**
     * Create labels for graph
     *
     * @return mixed
     */
    public function labels(): array
    {
        return ["Sedang Dicek", "Perbaikan", "Selesai", "Pembayaran", "Terima"];
    }

    /**
     * Create datasets for graph
     *
     * @return mixed
     */
    public function datasets(): array
    {
        $data = $this->orders->retrieveTotalOrdersInLastAndThisMonth($this->auth->id());
        $data = Arrays::replaceKey([
            "status_service"            => "status",
            "service_id_teknisi"        => "teknisi_id",
            "bulan"                     => "month"
        ], $data->toArray());

        $data = collect($data)->groupBy("month")
                              ->map(function ($item) {
                                  return $item->pluck("total");
                              })
                              ->toArray();

        $lastMonth = $data[array_key_first($data)];
        $thisMonth = $data[array_key_last($data)];

        return [
            [
                "label"             => "Bulan sebelumnya",
                "borderColor"       => "rgb(255, 99, 132)",
                "backgroundColor"   => "rgba(255, 99, 132, 0.2)",
                "borderWidth"       => 1,
                "data"              => $lastMonth
            ],
            [
                "label"             => "Bulan ini",
                "borderColor"       => "rgb(54, 162, 235)",
                "backgroundColor"   => "rgba(54, 162, 235, 0.2)",
                "borderWidth"       => 1,
                "data"              => $thisMonth
            ]
        ];
    }
}
