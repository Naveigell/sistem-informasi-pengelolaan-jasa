<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Url\QueryString;
use App\Http\Controllers\Controller;

use App\Http\Requests\User\UserRequestInsert;
use App\Http\Requests\User\UserRequestSearch;

use App\Interfaces\History\MakeHistory;
use App\Models\History\HistoryModel;
use App\Models\User\Account\BiodataModel;
use App\Models\User\UserModel;

use App\Traits\Files\FilesHandler;
use App\Traits\Random;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserController extends Controller implements MakeHistory
{
    use FilesHandler, Random;

    private $user, $biodata, $history;

    private const MAIN_PATH_URL = "/users";
    private const SEARCH_PATH_URL = "/users/search";

    public function __construct()
    {
        $this->user = new UserModel;
        $this->biodata = new BiodataModel;
        $this->history = new HistoryModel;
    }

    /**
     * Retrieve users and limit it with pagination
     *
     * @param int $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll($page = 1)
    {
        $page = (int) $page;
        set_current_page($page);

        $collections    = $this->user->getUsersList();
        $users          = $this->collectUsers(collect($collections->items()));

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
            "users" => $users
        ]);
    }

    /**
     * Retrieve user data by username
     *
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveByUsername($username)
    {
        $data = $this->user->retrieveByUsername($username);
        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        // add full url into profile picture
        $data->biodata->profile_picture = user_picture($data->biodata->profile_picture);

        return json($data);
    }

    /**
     * Create new User
     *
     * @param UserRequestInsert $request
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function create(UserRequestInsert $request)
    {
        $data = (object) $request->only(["name", "username", "email", "gender", "phone", "company", "address"]);
        $data->avatar = $this->randomStringImage().".png";

        $defaultImagePath = public_path("/img/users/default/placeholder.png");

        if (file_exists($defaultImagePath)) {
            if (File::copy($defaultImagePath, public_path("/img/users/$data->avatar"))) {

                DB::beginTransaction();
                try {

                    $id = $this->user->insertUser($data);
                    $this->biodata->createBiodata($id, $data);

                    DB::commit();

                    return json(["message" => "Tambah teknisi user"], null, 201);
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            }
        }

        return error(null, ["server" => "Terjadi masalah saat menambah user"]);
    }

    /**
     * Delete user
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->createHistory([$id]);

            $image = $this->biodata->retrieveProfilePicture($id);
            $delete = $this->user->deleteUser($id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Hapus user gagal"], 500);
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
     * Search user email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEmail(Request $request)
    {
        return json([
            "users"         => $this->user->searchEmail($request->get("query"))
        ]);
    }

    /**
     * Search Users by name
     *
     * @param UserRequestSearch $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(UserRequestSearch $request){
        $query  = $request->get("q");
        $page   = (int) $request->get("p");

        set_current_page($page);

        $collections    = $this->user->search($query);
        $users          = $this->collectUsers(collect($collections->items()));

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
            "users"         => $users,
            "search"        => true
        ];

        return json($data);
    }

    /**
     * Collect and edit some users data from database
     *
     * @param Collection $collection
     * @return Collection
     */
    private function collectUsers(Collection $collection) : Collection {
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

    /**
     * Create history
     *
     * @param array $data
     */
    public function createHistory(array $data)
    {
        $username = auth("user")->user()->username;
        $id = auth("user")->id();

        $target = $this->user->getUsernameById($data[0]);
        $targetUsername = $target === null ? "" : $target->username;
        $this->history->createHistory("(Admin) $username with id '$id' do action [DELETE] to (Pelanggan) $targetUsername with id '$data[0]'");
    }
}
