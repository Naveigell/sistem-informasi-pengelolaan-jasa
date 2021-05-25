<?php

namespace App\Http\Controllers\Api\Complaint;

use App\Helpers\Arrays\Arrays;
use App\Helpers\Regex\RegexHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint\ComplaintRequestInsert;
use App\Http\Requests\Complaint\ComplaintRequestPaginate;
use App\Interfaces\Time\TimeSentences;
use App\Models\Complaint\ComplaintModel;
use App\Models\Order\OrderModel;
use Illuminate\Support\Collection;

class ComplaintController extends Controller implements TimeSentences
{
    private ComplaintModel $complaint;
    private OrderModel $order;
    private $auth;

    public function __construct()
    {
        $this->complaint    = new ComplaintModel();
        $this->auth         = auth("user");
        $this->order        = new OrderModel();
    }

    /**
     * Save complaint
     *
     * @param ComplaintRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveComplaint(ComplaintRequestInsert $request)
    {
        $technician = $this->order->getTechnicianIdByServiceIdAndUserId($request->id, $this->auth->id());
        if ($technician == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        $saved = $this->complaint->saveComplaint($request->id, $this->auth->id(), $technician->orders_id_teknisi, $request->text);
        if ($saved) {
            return json([
                "complaint"                 => [
                    "isi"                   => $request->text,
                    "dikerjakan_teknisi"    => 0
                ]
            ]);
        }
        return error(null, ["message" => "Terjadi error saat mengirim komplain"]);
    }

    /**
     * Retrieve complaint
     *
     * @param ComplaintRequestPaginate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll(ComplaintRequestPaginate $request)
    {
        $data = $this->complaint->retrieveAll(
            $this->auth->user()->role == "user" ? $this->auth->id() : null,
            $this->auth->user()->role == "teknisi" ? $this->auth->id() : null,
            $this->auth->user()->role,
            $request->next == "true",
            $request->id
        );

        $data = Arrays::replaceKey([
            "id_pengaduan"              => "id",
            "pengaduan_id_users"        => "user_id",
            "isi"                       => "content",
            "tipe"                      => "type",
        ], $data instanceof Collection ? $data->toArray() : $data);

        $data = collect($data)->map(function ($item) {
            $item["created_at_sentences"]   = $item["created_at"] == null ? null : $this->toSentences(new \DateTime($item["created_at"]));
            $item["content"]                = RegexHelper::toContent($item["content"]);

            return $item;
        })->toArray();

        $data = collect($data)->map(function ($item) {
            if (!empty($item["user"])) {
                $item["user"] = Arrays::replaceKey([
                    "id_users"  => "id"
                ], $item["user"]);
            }

            return $item;
        });

        return json(["complaints" => $data]);
    }

    /**
     * Retrieve single complaint data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function retrieve($id)
    {
        $data = $this->complaint->retrieve(
            $id,
            $this->auth->user()->role == "user" ? $this->auth->id() : null,
            $this->auth->id()
        );

        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        $data = collect($data);

        $data = Arrays::replaceKey([
            "id_pengaduan"          => "id",
            "pengaduan_id_users"    => "user_id",
            "isi"                   => "content",
            "balasan"               => "reply"
        ], $data->toArray());

        $data["user"] = Arrays::replaceKey([
            "id_users"              => "id"
        ], $data["user"]);

        $data["user"]["biodata"] = Arrays::replaceKey([
            "id_biodata"            => "id",
            "biodata_id_users"      => "user_id",
        ], $data["user"]["biodata"]);

        $data["created_at_sentences"] = $data["created_at"] == null ? null : $this->toSentences(new \DateTime($data["created_at"]));
        $data["user"]["biodata"]["profile_picture"] = user_picture($data["user"]["biodata"]["profile_picture"]);

        return json(["complaint" => $data]);
    }

    /**
     * Do accept, by user
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function doUserAccept($id)
    {
        $updated = $this->complaint->doUserAccept($id, $this->auth->id());
        if ($updated) {
            return json([], null, 204);
        }
        return error(null, ["message" => "Gagal menyimpan data"]);
    }

    /**
     * Do accept, by admin
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function doAdminAccept($id)
    {
        $updated = $this->complaint->doAdminAccept($id);
        if ($updated) {
            return json([], null, 204);
        }
        return error(null, ["message" => "Gagal menyimpan data"]);
    }

    /**
     * Do complaint, by technician
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function doComplaint($id)
    {
        $updated = $this->complaint->doComplaint($id, $this->auth->id());
        if ($updated) {
            return json([], null, 204);
        }
        return error(null, ["message" => "Gagal menyimpan data"]);
    }

    /**
     * Return a sentences from date time
     *
     * @param \DateTime $time
     * @return string
     */
    public function toSentences(\DateTime $time): string
    {
        try {
            $diff = (new \DateTime(now()))->diff($time);
            if ($diff->d == 0) {
                return ($diff->h < 10 ? "0".$diff->h : $diff->h).":".($diff->i < 10 ? "0".$diff->i : $diff->i);
            }

            setlocale(LC_ALL, 'IND');
            return strftime("%B %d", $time->getTimestamp());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
