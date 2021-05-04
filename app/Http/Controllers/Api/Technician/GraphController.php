<?php


namespace App\Http\Controllers\Api\Technician;


use App\Http\Requests\Technician\TechnicianRequestGraph;
use App\Interfaces\Graph\GraphDataInterface;
use App\Interfaces\Graph\GraphProcessInterface;
use App\Models\Order\OrderModel;
use Carbon\Carbon;

class GraphController implements GraphProcessInterface, GraphDataInterface
{
    private OrderModel $orders;
    private $id;

    public function __construct()
    {
        $this->orders = new OrderModel();
    }

    /**
     * Retrieve graph data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieve($id)
    {
        $this->id = $id;
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
        for ($i = 7; $i >= 1; $i--) {
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
        $data = $this->orders->retrieveTotalFinishedOrdersInLast7Months($this->id);

        return [
            [
                "label"             => "Keberhasilan",
                "borderColor"       => "rgb(54, 162, 235)",
                "backgroundColor"   => "rgba(54, 162, 235, 0.2)",
                "borderWidth"       => 1,
                "data"              => $data,
                "lineTension"       => 0.3
            ]
        ];
    }

    /**
     * Create options for graph
     *
     * @return array
     */
    public function options(): array
    {
        return [];
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
                ]
            ]
        ]);
    }
}
