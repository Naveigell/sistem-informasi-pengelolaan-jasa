<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Url\QueryString;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequestInsert;
use App\Http\Requests\Admin\AdminRequestSearch;
use App\Models\Admin\AdminModel;
use App\Models\User\Account\BiodataModel;
use App\Traits\Files\FilesHandler;
use App\Traits\Random;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    use FilesHandler, Random;

    private AdminModel $admins;
    private BiodataModel $biodata;

    private $auth;

    private const MAIN_PATH_URL = "/admins";
    private const SEARCH_PATH_URL = "/admins/search";

    public function __construct()
    {
        $this->admins   = new AdminModel();
        $this->biodata  = new BiodataModel();

        $this->auth     = auth("user");
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
     * Search Admin by name
     *
     * @param AdminRequestSearch $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(AdminRequestSearch $request)
    {
        $query  = $request->get("q");
        $page   = (int) $request->get("p");

        set_current_page($page);

        $collections    = $this->admins->search($query);
        $admins         = $this->collectAdmin(collect($collections->items()));

        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_page  = $current_page - 1 > 0 && $current_page <= $last_page ? $current_page - 1 : null;
        $next_page      = $current_page < $last_page && $current_page > 0 ? $current_page + 1 : null;

        $next_url       = QueryString::parse([
            "q"     => $query,
            "p"     => $next_page
        ]);

        $previous_url   = QueryString::parse([
            "q"     => $query,
            "p"     => $previous_page
        ]);

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
            "admins"        => $admins,
            "search"        => true
        ];

        return json($data);
    }

    /**
     * Delete admin
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $image = $this->biodata->retrieveProfilePicture($id);
            $delete = $this->admins->deleteAdmin($id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Hapus admin gagal"], 500);
        }

        try {
            if ($delete && $image != null) {
                // image is not an array, so we add it into an array
                $this->deleteMultipleImages("/img/users", [$image->profile_picture]);
            }
        } catch (\Exception $exception) {}

        return json([], null, 204);
    }

    /**
     * Retrieve admin data by username
     *
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveByUsername($username)
    {
        $data = $this->admins->retrieveByUsername($username);
        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        // add full url into profile picture
        $data->biodata->profile_picture = user_picture($data->biodata->profile_picture);

        return json($data);
    }

    /**
     * Create new Admin
     *
     * @param AdminRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AdminRequestInsert $request)
    {
        $data = (object) $request->only(["name", "username", "email", "gender"]);
        $data->avatar = $this->randomStringImage().".png";

        $defaultImagePath = public_path("/img/users/default/placeholder.png");

        if (file_exists($defaultImagePath)) {
            if (File::copy($defaultImagePath, public_path("/img/users/$data->avatar"))) {

                DB::beginTransaction();
                try {

                    $id = $this->admins->insertAdmin($data);
                    $this->biodata->createBiodata($id, $data);

                    DB::commit();

                    return json(["message" => "Tambah admin berhasil"], null, 201);
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            }
        }

        return error(null, ["server" => "Terjadi masalah saat menambah teknisi"]);
    }

    /**
     * Collect and edit some adnins data from database
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
