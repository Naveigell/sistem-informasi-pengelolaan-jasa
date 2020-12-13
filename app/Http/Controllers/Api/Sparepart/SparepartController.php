<?php

namespace App\Http\Controllers\Api\Sparepart;

use App\Http\Controllers\Controller;
use App\Models\Sparepart\FotoSparepartModel;
use App\Models\Sparepart\SparepartModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Traits\Files\FilesHandler;

use App\Http\Requests\Sparepart\SparepartRequestInsert;
use App\Http\Requests\Sparepart\SparepartRequestSearch;
use App\Http\Requests\Sparepart\SparepartRequestUpdate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class SparepartController
 * @package App\Http\Controllers\Api\Sparepart
 */
class SparepartController extends Controller {
    use FilesHandler;

    /**
     * @var string
     */
    private const MAIN_PATH_URL = "/spareparts";
    private const SEARCH_PATH_URL = "/spareparts/search";

    /**
     * @var SparepartModel App\Models\Sparepart\SparepartModel
     */
    private SparepartModel $sparePartModel;

    /**
     * @var FotoSparepartModel App\Models\Sparepart\FotoSparepartModel
     */
    private FotoSparepartModel $fotoSparepartModel;

    public function __construct() {
        $this->sparePartModel = new SparepartModel();
        $this->fotoSparepartModel = new FotoSparepartModel();
    }

    /**
     * Create a new sparepart
     *
     * @param SparepartRequestInsert $request
     * @return JsonResponse
     */
    public function insert(SparepartRequestInsert $request)
    {
        $files      = $request->file("images");
        $images     = $this->storeMultipleImages(public_path("/img/spareparts"), $files);

        // cast to object
        $data = (object) $request->only(["name", "description", "type", "stock", "price"]);

        DB::beginTransaction();
        try {

            $id = $this->sparePartModel->createSparepart($data);
            $this->fotoSparepartModel->createImages($id, $images);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Tambah sparepart gagal"], 500);
        }

        return json(["sparepart" => "Sparepart berhasil ditambah"]);
    }

    /**
     * Retrieve sparepart data by pages, pages are optional, default is 1
     *
     * @param int $pages
     * @return JsonResponse
     */
    public function retrieveAll($pages = 1){
        $pages = (int) $pages;

        set_current_page($pages);

        $collections    = $this->sparePartModel->getSparePartList();
        $spareparts     = $this->collectSpareparts(collect($collections->items()));

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
            "spareparts"    => $spareparts->toArray(),
        ];

        return json($data);
    }

    public function update(SparepartRequestUpdate $request)
    {
        $files      = $request->file("images");
        $images     = $this->storeMultipleImages(public_path("/img/spareparts"), $files);

        // cast to object
        $data = (object) $request->only(["name", "description", "type", "stock", "price"]);
        $id = $request->get("id");

        DB::beginTransaction();
        try {

            // update sparepart data and create a new images, then delete
            // the last images
            $this->sparePartModel->updateSparepart($id, $data);
            $lastImages = $this->fotoSparepartModel->getImages($id);
            $deleted = $this->fotoSparepartModel->deleteLastImages($id);
            $this->fotoSparepartModel->createImages($id, $images);

            if ($deleted) {
                $this->deleteMultipleImages("/img/spareparts", $lastImages);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Tambah sparepart gagal"], 500);
        }

        return json(["sparepart" => "Sparepart berhasil diubah"]);
    }

    /**
     * Retrieve a single sparepart by id
     *
     * @param $id
     * @return JsonResponse
     */
    public function retrieve($id)
    {
        $spareparts[]   = $this->sparePartModel->with("images")->find($id, ["id_spare_part", "nama_spare_part", "deskripsi", "tipe", "stok", "harga"]);
        $sparepart      = $this->collectSpareparts(collect($spareparts))->toArray()[0];

        return json(["sparepart" => $sparepart]);
    }

    /**
     * Delete sparepart
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $images = $this->fotoSparepartModel->getImages($id);
            $delete = $this->sparePartModel->deleteSparepart($id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return error(null, ["server" => "Hapus sparepart gagal"], 500);
        }

        if ($delete) {
            $this->deleteMultipleImages("/img/spareparts", $images);
        }

        return json(null, null, 204);
    }

    /**
     * Search sparepart by query as q or by type as t and set page
     * of each retrieve
     *
     * @param SparepartRequestSearch $request
     * @return JsonResponse
     */
    public function search(SparepartRequestSearch $request){
        $query  = $request->get("q");
        // set the type to komputer/pc if the type just pc
        $type   = $request->get("t") == "pc" ? "pc/komputer" : $request->get("t");
        $page   = (int) $request->get("p");

        set_current_page($page);

        error_log($type);

        $collections    = $this->sparePartModel->search($query, $type);
        $spareparts     = $this->collectSpareparts(collect($collections->items()));

        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_page  = $current_page - 1 > 0 && $current_page <= $last_page ? $current_page - 1 : null;
        $next_page      = $current_page < $last_page && $current_page > 0 ? $current_page + 1 : null;

        $next_url       = $this->queryString([
            "q"     => $query,
            "t"     => $type === "pc/komputer" ? "pc" : $type,
            "p"     => $next_page
        ]);

        $previous_url   = $this->queryString([
            "q"     => $query,
            "t"     => $type === "pc/komputer" ? "pc" : $type,
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
            "spareparts"    => $spareparts,
            "search"        => true
        ];

        return json($data);
    }

    /**
     * Collect the spareparts pagination
     *
     * @param Collection $collection
     * @return Collection
     */
    private function collectSpareparts(Collection $collection) : Collection {
        $spareparts     = $collection->map(function ($item) {

            // casting the item to object if the type is array
            if (gettype($item) == "array")
                $item = (object) $item;

            // remove "foto_spare_part_id_spare_part" into "sparepart_id"
            // and add url link into picture
            foreach ($item->images as $image) {
                $image["sparepart_id"] = $image->foto_spare_part_id_spare_part;
                unset($image["foto_spare_part_id_spare_part"]);

                $image["picture"] = sparepart_picture($image["picture"]);
            }

            $item["id"] = $item->id_spare_part;
            unset($item["id_spare_part"]);

            return $item;
        });

        return $spareparts;
    }

    /**
     * Create a params for url by given array, example
     * $array = [
     *      "a" => "foo",
     *      "b" => "bar",
     *      "c"
     * ]
     *
     * will be ?a=foo&b=bar
     * c will ignore because c didn't have a value
     *
     * @param array $querystring
     * @return string
     */
    private function queryString(array $querystring = []) : string{

        $keys = array_keys($querystring);
        $query = "";
        foreach ($keys as $key) {

            if (!is_string($key)) {
                unset($querystring[$key]);
            }
        }

        $keys = array_keys($querystring);
        for ($i = 0; $i < count($keys); $i++) {

            if ($querystring[$keys[$i]] == null) continue;

            // insert & between key and value
            // example a=foo&b=1
            $query .= $keys[$i]."=".$querystring[$keys[$i]];
            if ($i < count($keys) - 1) {
                if ($querystring[$keys[$i + 1]] !== null) {
                    $query .= "&";
                }
            }
        }

        return "?".$query;
    }
}
