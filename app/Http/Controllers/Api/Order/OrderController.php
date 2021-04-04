<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\Arrays\Arrays;
use App\Helpers\Times\Time;
use App\Helpers\Url\QueryString;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequestInsert;
use App\Http\Requests\Order\OrderRequestSearch;
use App\Models\Order\OrderModel;
use App\Models\User\UserModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    private $order, $user;
    private const MAIN_PATH_URL = "/orders";
    private const SEARCH_PATH_URL = "/orders/search";

    public function __construct()
    {
        $this->order = new OrderModel;
        $this->user  = new UserModel;
    }

    /**
     * Retrieve some orders
     *
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
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
            "orders"        => $this->addTimeSentences(collect($collections->items())),
            "search"        => false
        ];

        return json($data);
    }

    /**
     * Retrieve single order by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieve($id)
    {
        $data = $this->order->retrieve($id);
        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        $data = $data->toArray();

        $data["spareparts"] = Arrays::replaceKey([
            "service_spare_part_id_service"     => "service_id",
            "service_spare_part_id_spare_part"  => "spare_part_id",
            "id_service_spare_part"             => "id",
            "nama_spare_part"                   => "nama"
        ], $data["spareparts"]);

        $data["spareparts"] = $this->replaceSparepartImagesKey($data["spareparts"]);

        $data["user"] = Arrays::replaceKey([
            "id_users"      => "id"
        ], $data["user"]);

        $data["technician"] = Arrays::replaceKey([
            "id_users"      => "id"
        ], $data["technician"]);

        $data = Arrays::replaceKey([
            "id_service"            => "id",
            "service_id_teknisi"    => "teknisi_id",
            "service_id_user"       => "user_id",
            "jenis_perangkat"       => "jenis",
            "status_service"        => "status",
            "alamat_pemilik"        => "alamat"
        ], $data);

        return json(["order" => $data]);
    }

    /**
     * Replace some keys in sparepart images and insert
     * sparepart picture url
     *
     * @param array $spareparts
     * @return array
     */
    private function replaceSparepartImagesKey(array $spareparts)
    {
        foreach ($spareparts as &$sparepart) {
            for ($i = 0; $i < count($sparepart["images"]); $i++) {
                $sparepart["images"][$i] = Arrays::replaceKey([
                    "id_foto_spare_part"                => "id",
                    "foto_spare_part_id_spare_part"     => "sparepart_id",
                ], $sparepart["images"][$i]);

                $sparepart["images"][$i]["picture"] = sparepart_picture($sparepart["images"][$i]["picture"]);
            }
        }

        return $spareparts;
    }

    /**
     * Delete order by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $deleted = $this->order->deleteOrder($id);
        if (!$deleted) {
            return error(null, ["server" => "Hapus order gagal"], 500);
        }
        return json(null, null, 204);
    }

    /**
     * Create a query string with additional data
     *
     * @param $id
     * @param $status
     * @param $page
     * @return string
     */
    private function createQueryString($id, $status, $page)
    {
        $arr = [];

        if ($id != null) {
            $arr["id"] = $id;
        }

        if ($status != null) {
            $arr["status"] = $status;
        }

        $arr["page"] = $page;

        return QueryString::parse($arr);
    }

    /**
     * Create new order
     *
     * @param OrderRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(OrderRequestInsert $request)
    {
        $user = $this->user->getIdByEmail($request->email);
        if ($user == null) {
            return error(null, ["message" => "Email tidak ditemukan, silakan membuat email"]);
        }

        try {

            $created = $this->order->createOrder($user->id_users, strtoupper(uniqid()), (object) $request->all());
            if ($created) {
                return json(null, null, 204);
            }

        } catch (QueryException $exception) {}

        return error(null, ["message" => "Terjadi masalah pada server"]);
    }

    /**
     * Search order by id
     *
     * @param OrderRequestSearch $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(OrderRequestSearch $request)
    {
        $page   = (int) $request->get("page");

        if (!$request->id && !$request->status) {
            return $this->retrieveAll($page);
        }

        if ($request->status == "all") $request->status = null;

        set_current_page($page);

        $collections = $this->order->search($request->id, $request->status);
        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_page  = $current_page - 1 > 0 && $current_page <= $last_page ? $current_page - 1 : null;
        $next_page      = $current_page < $last_page && $current_page > 0 ? $current_page + 1 : null;

        $next_url       = $this->createQueryString($request->id, $request->status, $next_page);
        $previous_url   = $this->createQueryString($request->id, $request->status, $previous_page);

        $data = [
            "total"         => $collections->total(),
            "pages"         => [
                "current_page"      => $current_page,
                "last_page"         => $last_page,
                "per_page"          => $collections->perPage(),
                "current_url"       => $current_url,
                "previous_url"      => api_path_v1(self::SEARCH_PATH_URL.$previous_url),
                "next_url"          => api_path_v1(self::SEARCH_PATH_URL.$next_url),
                "uri"               => api_path_v1(self::MAIN_PATH_URL)
            ],
            "orders"        => $this->addTimeSentences(collect($collections->items())),
            "search"        => true
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
            $item["created_at_sentences"] = $item["created_at"] == null ? "-" : (new Time())->toSentences($item["created_at"]);
            return $item;
        });
    }
}
