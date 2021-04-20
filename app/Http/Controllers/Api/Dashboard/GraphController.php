<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Graph\GraphDataInterface;
use App\Interfaces\Graph\GraphProcessInterface;
use App\Models\Order\OrderSparepartModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraphController extends Controller implements GraphDataInterface, GraphProcessInterface
{
    private OrderSparepartModel $orderSparepart;

    public function __construct()
    {
        $this->orderSparepart = new OrderSparepartModel();
    }

    /**
     * Retrieve graph data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveData()
    {
        return $this->process();
    }

    /**
     * Create labels for graph
     *
     * @return mixed
     */
    public function labels(): array
    {
        $labels = [];
        for ($i = 6; $i >= 1; $i--) {
            $date = Carbon::now()->subMonths($i);
            array_push($labels, strftime("%B", $date->getTimestamp())." ".$date->toArray()["year"]);
        }

        return $labels;
    }

    /**
     * Create datasets for graph
     *
     * @return mixed
     */
    public function datasets(): array
    {
        $data = $this->orderSparepart->retrieveTotalIncomeFromLast6Months();

        return [
            [
                "label"             => "Pemasukan",
                "borderColor"       => "rgb(54, 162, 235)",
                "backgroundColor"   => "rgba(54, 162, 235, 0.2)",
                "borderWidth"       => 1,
                "data"              => $data,
                "lineTension"       => 0.3
            ]
        ];
    }

    /**
     * Convert of graph data
     */
    public function process()
    {
        return json([
            "graph"                 => [
                "data"              => [
                    "labels"        => $this->labels(),
                    "datasets"      => $this->datasets()
                ],
                "options"           => $this->options()
            ]
        ]);
    }

    /**
     * Create options for graph
     *
     * @return array
     */
    public function options(): array
    {
        return [
            "responsive"                    => true,
            "maintainAspectRatio"           => false,
            "scales"                        => [
                "xAxes"                     => [
                    [
                        "gridLines"         => [
                            "display"       => false
                        ]
                    ]
                ],
                "yAxes"                     => [
                    [
                        "gridLines"         => [
                            "display"       => false
                        ],
                        "ticks"             => [
                            "beginAtZero"   => 0
                        ]
                    ]
                ]
            ],
            "tooltips"                      => [
                "enabled"                   => true,
                "mode"                      => "single"
            ]
        ];
    }
}
