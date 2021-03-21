<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\Times\Time;
use App\Http\Controllers\Controller;
use App\Models\Order\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new OrderModel;
    }

    /**
     * Take a number of orders by latest id
     *
     * @param $number
     * @return \Illuminate\Http\JsonResponse
     */
    public function takeFromLast($number)
    {
        return json(["orders" => $this->addTimeSentences($this->order->takeFromLast($number)->collect())]);
    }

    /**
     * Return total count of orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalOrders()
    {
        return json(["total" => OrderModel::all()->count()]);
    }

    /**
     * Add time sentences into array, example: 1 menit yang lalu, 1 jam yang lalu, etc
     *
     * @param Collection $collection
     * @return Collection
     */
    private function addTimeSentences(Collection $collection)
    {
        return $collection->map(function ($item, $index){
            $item["created_at_sentences"] = (new Time())->toSentences($item["created_at"]);
            return $item;
        });
    }
}
