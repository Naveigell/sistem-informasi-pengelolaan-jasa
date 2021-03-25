<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\Times\Time;
use App\Helpers\Url\QueryString;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequestSearch;
use App\Models\Order\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    private $order;
    private const MAIN_PATH_URL = "/orders";
    private const SEARCH_PATH_URL = "/orders/search";

    public function __construct()
    {
        $this->order = new OrderModel;
    }

    public function retrieveAll($page = 1)
    {
        $page = (int) $page;

        set_current_page($page);

        $collections = $this->order->getOrderList();

        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_url   = $current_page - 1 > 0 && $current_page <= $last_page ? api_path_v1(self::MAIN_PATH_URL."/".($current_page - 1)) : null;
        $next_url       = $current_page < $last_page && $current_page > 0 ? api_path_v1(self::MAIN_PATH_URL."/".($current_page + 1)) : null;

        $data = [
            "total"         => $collections->total(),
            "pages"         => [
                "current_page"      => $current_page,
                "last_page"         => $last_page,
                "per_page"          => $collections->perPage(),
                "current_url"       => $current_url,
                "previous_url"      => $previous_url,
                "next_url"          => $next_url,
                "uri"               => api_path_v1(self::MAIN_PATH_URL)
            ],
            "orders"    => $this->addTimeSentences(collect($collections->items())),
        ];

        return json($data);
    }

    public function search(Request $request)
    {
        $page   = (int) $request->get("p");

        if (!$request->id) {
            return $this->retrieveAll($page);
        }

        set_current_page($page);

        $collections = $this->order->search($request->id);
        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_page  = $current_page - 1 > 0 && $current_page <= $last_page ? $current_page - 1 : null;
        $next_page      = $current_page < $last_page && $current_page > 0 ? $current_page + 1 : null;

        $next_url       = QueryString::parse([
            "id"        => $request->id,
            "page"      => $next_page
        ]);

        $previous_url   = QueryString::parse([
            "id"        => $request->id,
            "page"      => $previous_page
        ]);

        $data = [
            "total"         => $collections->total(),
            "pages"         => [
                "current_page"      => $current_page,
                "last_page"         => $last_page,
                "per_page"          => $collections->perPage(),
                "previous_url"      => api_path_v1(self::SEARCH_PATH_URL.$previous_url),
                "next_url"          => api_path_v1(self::SEARCH_PATH_URL.$next_url),
                "uri"               => api_path_v1(self::MAIN_PATH_URL)
            ],
            "orders"    => $this->addTimeSentences(collect($collections->items())),
        ];

        return json($data);
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
