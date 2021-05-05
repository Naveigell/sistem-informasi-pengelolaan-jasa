<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    private AdminModel $admins;

    private const MAIN_PATH_URL = "/admins";
    private const SEARCH_PATH_URL = "/admins/search";

    public function __construct()
    {
        $this->admins = new AdminModel();
    }

    /**
     * Retrieve by page
     *
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll($page = 1)
    {
        $page = (int) $page;
        set_current_page($page);

        $collections = $this->admins->getAdminList();
        $admins      = $this->collectAdmin(collect($collections->items()));

        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_url   = $current_page - 1 > 0 && $current_page <= $last_page ? api_path_v1(self::MAIN_PATH_URL."/".($current_page - 1)) : null;
        $next_url       = $current_page < $last_page && $current_page > 0 ? api_path_v1(self::MAIN_PATH_URL."/".($current_page + 1)) : null;

        return json([
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
            "admins"        => $admins
        ]);
    }

    /**
     * Collect and edit some technicians data from database
     *
     * @param Collection $collection
     * @return Collection
     */
    private function collectAdmin(Collection $collection) : Collection {
        return $collection->map(function ($item) {

            // casting the item to object if the type is array
            if (gettype($item) == "array")
                $item = (object) $item;

            // remove "biodata_id_users" into "user_id"
            // and add url link into profile picture
            $biodata = &$item->biodata; // get the address of variable
            $biodata["id"] = $biodata->id_biodata;
            $biodata["user_id"] = $biodata->biodata_id_users;
            $biodata["profile_picture"] = url("/")."/img/users/".$biodata->profile_picture;

            unset($biodata["id_biodata"]);
            unset($biodata["biodata_id_users"]);

            $item["id"] = $item->id_users;
            unset($item["id_users"]);

            return $item;
        });
    }
}
