<?php

namespace App\Http\Controllers\Api\Technician;

use App\Helpers\Url\QueryString;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technician\TechnicianRequestInsert;
use App\Http\Requests\Technician\TechnicianRequestResetPassword;
use App\Http\Requests\Technician\TechnicianRequestSearch;
use App\Http\Requests\Technician\TechnicianRequestUpdate;

use App\Models\Auth\AuthModel;
use App\Models\Technician\TechnicianModel;
use App\Models\User\Account\BiodataModel;

use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Traits\Files\FilesHandler;
use App\Traits\Random;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    use FilesHandler, Random;

    /**
     * All models initiate here
     */
    private $technicians;
    private $biodata;
    private $auth;

    private const MAIN_PATH_URL = "/technicians";
    private const SEARCH_PATH_URL = "/technicians/search";

    public function __construct(){
        $this->technicians = new TechnicianModel;
        $this->biodata = new BiodataModel;
        $this->auth = new AuthModel;
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

        $collections = $this->technicians->getTechnicianList();
        $technicians = $this->collectTechnician(collect($collections->items()));

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
            "technicians" => $technicians
        ]);
    }

    /**
     * Search Technician by name
     *
     * @param TechnicianRequestSearch $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(TechnicianRequestSearch $request){
        $query  = $request->get("q");
        $page   = (int) $request->get("p");

        set_current_page($page);

        $collections    = $this->technicians->search($query);
        $technicians    = $this->collectTechnician(collect($collections->items()));

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
            "technicians"    => $technicians,
            "search"        => true
        ];

        return json($data);
    }

    /**
     * Create new Technician
     *
     * @param TechnicianRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(TechnicianRequestInsert $request)
    {
        $data = (object) $request->only(["name", "username", "email", "gender"]);
        $data->avatar = $this->randomStringImage().".png";

        $defaultImagePath = public_path("/img/users/default/placeholder.png");

        if (file_exists($defaultImagePath)) {
            if (File::copy($defaultImagePath, public_path("/img/users/$data->avatar"))) {

                DB::beginTransaction();
                try {

                    $id = $this->technicians->insertTechnican($data);
                    $this->biodata->createBiodata($id, $data);

                    DB::commit();

                    return json(["message" => "Tambah teknisi berhasil"], null, 201);
                } catch (\Exception $exception) {
                    DB::rollBack();
                }
            }
        }

        return error(null, ["server" => "Terjadi masalah saat menambah teknisi"]);
    }

    /**
     * Retrieve technician data by username
     *
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveByUsername($username)
    {
        $data = $this->technicians->retrieveByUsername($username);
        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        // add full url into profile picture
        $data->biodata->profile_picture = user_picture($data->biodata->profile_picture);

        return json($data);
    }

    /**
     * Reset technician password, the password will automatically turn into '123456'
     *
     * @param TechnicianRequestResetPassword $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(TechnicianRequestResetPassword $request)
    {
        $username = auth("user")->user()->username;

        $data = $this->auth->getPasswordByUsername($username);

        if ($data == null) {
            return error(null, ["message" => "Terjadi masalah saat mengecek password"]);
        } else if (Hash::check($request->password, $data->password)) {
            return json([
                $this->technicians->updatePasswordByUsername($request->username)
            ], null, 204);
        }

        return error(null, ["password" => ["Password yang anda masukkan salah"]], 422);
    }

    /**
     * Update technician data (from admin), not by technician itself
     *
     * @param TechnicianRequestUpdate $request
     * @return \Illuminate\Http\JsonResponse|string|string[]
     */
    public function update(TechnicianRequestUpdate $request)
    {
        try {
            $id = $this->technicians->getIdByUsername($request->username_before);
            if ($id == null) {
                return error(null, ["message" => "Data yang dimasukkan salah"], 400);
            }

            $this->technicians->updateDataByUsername($request->username_before, (object) $request->only(["name", "username"]));
            $this->technicians->updateTechnicianBiodata($id->id_users, (object) $request->only(["address", "gender", "phone"]));
            DB::commit();

            return json(["message" => "Data teknisi berhasil diubah"], null, 204);
        } catch (QueryException $exception) {
            DB::rollBack();

            list(, $code, $message) = $exception->errorInfo;
            if ($code == 1062) {
                $preg = preg_replace_callback("/^Duplicate entry '(.*)' for key '(.*)'$/", function ($data) {
                    return $data[2];
                }, $message);

                // check if column has username or nomor,
                // if they have it, add it into $data array
                $data = [];
                if (strpos($preg, "username") !== false) {
                    $data["username"] = ["Username sudah digunakan"];
                } else if (strpos($preg, "nomor") !== false) {
                    $data["phone"] = ["Nomor hp sudah digunakan"];
                }

                return error(null, $data, 409);
            }

            return error(null, ["message" => "Terjadi masalah saat mengubah biodata"]);
        }
    }

    /**
     * Delete sparepart
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $image = $this->biodata->retrieveProfilePicture($id);
            $delete = $this->technicians->deleteTechnician($id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Hapus teknisi gagal"], 500);
        }

        try {
            if ($delete && $image != null) {
                // image is not an array, so we add it into an array
                $this->deleteMultipleImages("/img/users", [$image->profile_picture]);
            }
        } catch (\Exception $exception) {}

        return json($image, null, 204);
    }

    /**
     * Collect and edit some technicians data from database
     *
     * @param Collection $collection
     * @return Collection
     */
    private function collectTechnician(Collection $collection) : Collection {
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
