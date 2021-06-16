<?php

namespace App\Http\Controllers\Api\Sparepart;

use App\Http\Controllers\Controller;
use App\Interfaces\History\MakeHistory;
use App\Models\History\HistoryModel;
use App\Models\Sparepart\FotoSparepartModel;
use App\Models\Sparepart\SparepartModel;
use Illuminate\Http\JsonResponse;

use App\Traits\Files\FilesHandler;

use App\Http\Requests\Sparepart\SparepartRequestInsert;
use App\Http\Requests\Sparepart\SparepartRequestSearch;
use App\Http\Requests\Sparepart\SparepartRequestUpdate;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Helpers\Url\QueryString;

/**
 * Class SparepartController
 * @package App\Http\Controllers\Api\Sparepart
 */
class SparepartController extends Controller implements MakeHistory {
    use FilesHandler;

    /**
     * @var string
     */
    private const MAIN_PATH_URL = "/spareparts";
    private const SEARCH_PATH_URL = "/spareparts/search";

    /**
     * @var SparepartModel App\Models\Sparepart\SparepartModel
     */
    private SparepartModel $sparepart;

    private HistoryModel $history;

    /**
     * @var FotoSparepartModel App\Models\Sparepart\FotoSparepartModel
     */
    private FotoSparepartModel $fotoSparepart;

    public function __construct() {
        $this->history = new HistoryModel();
        $this->sparepart = new SparepartModel();
        $this->fotoSparepart = new FotoSparepartModel();
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
        $data = (object) $request->only(["name", "description", "type", "stock", "real_price", "price", "part_number", "serial_number"]);

        DB::beginTransaction();
        try {

            $id = $this->sparepart->createSparepart($data);
            $this->fotoSparepart->createImages($id, $images);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            error_log($exception->getMessage());

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

        $collections    = $this->sparepart->getSparePartList();
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
        $data = (object) $request->only(["name", "description", "type", "stock", "real_price", "price", "part_number", "serial_number"]);
        $id = $request->get("id");

        DB::beginTransaction();
        try {

            // update sparepart data and create a new images, then delete
            // the last images
            $this->sparepart->updateSparepart($id, $data);
            $lastImages = $this->fotoSparepart->getImages($id);
            $deleted = $this->fotoSparepart->deleteLastImages($id);
            $this->fotoSparepart->createImages($id, $images);

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
        $spareparts[]   = $this->sparepart->with("images")->find($id, ["id_spare_part", "nama_spare_part", "deskripsi", "tipe", "stok", "part_number", "serial_number", "harga_asli", "harga"]);
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
            $this->createHistory([$id]);

            $images = $this->fotoSparepart->getImages($id);
            $delete = $this->sparepart->deleteSparepart($id);

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
        $query      = $request->get("q");
        // set the type to komputer/pc if the type just pc
        $type       = $request->get("t") == "pc" ? "pc/komputer" : $request->get("t");
        $page       = (int) $request->get("p");
        $orderBy    = $request->get("o");

        set_current_page($page);

        $collections    = $this->sparepart->search($query == null ? "" : $query, $type, $orderBy);
        $spareparts     = $this->collectSpareparts(collect($collections->items()));

        $current_page   = $collections->currentPage();
        $last_page      = $collections->lastPage();

        $current_url    = \request()->url();
        $previous_page  = $current_page - 1 > 0 && $current_page <= $last_page ? $current_page - 1 : null;
        $next_page      = $current_page < $last_page && $current_page > 0 ? $current_page + 1 : null;

        $next_url       = QueryString::parse([
            "q"     => $query,
            "t"     => $type === "pc/komputer" ? "pc" : $type,
            "p"     => $next_page
        ]);

        $previous_url   = QueryString::parse([
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
        return $collection->map(function ($item) {

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

        $target = $this->sparepart->getNameById($data[0]);
        $targetName = $target === null ? "" : $target->nama_spare_part;
        $this->history->createHistory("(Admin) $username with id '$id' do action [DELETE] to spare part '$targetName' with id '$data[0]'");
    }
}
