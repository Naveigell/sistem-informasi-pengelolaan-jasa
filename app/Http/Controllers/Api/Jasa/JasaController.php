<?php

namespace App\Http\Controllers\Api\Jasa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Jasa\JasaRequestInsert;
use App\Http\Requests\Jasa\JasaRequestUpdate;
use App\Models\Jasa\JasaModel;
use Illuminate\Http\Request;

class JasaController extends Controller {

    /**
     * @var JasaModel $jasa
     */
    private $jasa;

    public function __construct()
    {
        $this->jasa = new JasaModel();
    }

    /**
     * Retrieve all jasa (service)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll()
    {
        return json([
            "service" => JasaModel::all()
        ]);
    }

    /**
     * This function will automatically activate or deactivate jasa (service)
     * If the field value is 1 it will change to 0 or vice versa
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Request $request)
    {
        $id = $request->id;
        $updated = $this->jasa->activation($id);

        if ($updated)
            return json(["message" => "Status jasa berhasil diganti"], 204);

        return error(null, [
            "message"   => "Terjadi masalah saat mengubah status jasa"
        ]);
    }

    /**
     * Update jasa
     *
     * @param JasaRequestUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(JasaRequestUpdate $request)
    {
        $fields     = (object) $request->only(["id", "name", "description", "type", "price"]);
        $updated    = $this->jasa->updateJasa($fields);
        return json([$fields]);
    }

    /**
     * Insert new jasa (service)
     *
     * @param JasaRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(JasaRequestInsert $request)
    {
        $fields     = (object) $request->only(["name", "description", "type", "price"]);
        $id         = $this->jasa->createJasa($fields);

        $data   = $this->jasa->getSingleData($id);

        if (!$id) {
            return error(null, [
                "server"      => "Tambah jasa gagal"
            ], 500);
        }

        return json([
            "message"   => "Jasa berhasil ditambahkan",
            "data"      => $data
        ]);
    }

    /**
     * Delete jasa
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->jasa->deleteJasa($id);
        return json([], null, 204);
    }
}
