<?php

namespace App\Http\Controllers\Api\Suggestion;

use App\Helpers\Arrays\Arrays;
use App\Helpers\Regex\RegexHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Suggestion\SuggestionRequestDelete;
use App\Http\Requests\Suggestion\SuggestionRequestInsert;
use App\Http\Requests\Suggestion\SuggestionRequestPaginate;
use App\Http\Requests\Suggestion\SuggestionRequestReply;
use App\Interfaces\Time\TimeSentences;
use App\Models\Suggestion\SuggestionModel;
use Illuminate\Support\Collection;

class SuggestionController extends Controller implements TimeSentences
{
    private SuggestionModel $suggestions;
    private $auth;

    public function __construct()
    {
        $this->suggestions = new SuggestionModel;
        $this->auth = auth("user");
    }

    /**
     * Retrieve all messages
     *
     * @param SuggestionRequestPaginate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll(SuggestionRequestPaginate $request)
    {
        $data = $this->suggestions->retrieveAll(
            $this->auth->id(),
            $this->auth->user()->role,
            $request->next == "true",
            $request->id
        );

        $data = Arrays::replaceKey([
            "id_pengaduan"              => "id",
            "pengaduan_id_pelanggan"    => "user_id",
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

        return json(["suggestions" => $data]);
    }

    /**
     * Reply suggestion (just admin can do this)
     *
     * @param SuggestionRequestReply $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function replySuggestion(SuggestionRequestReply $request, $id)
    {
        $replied = $this->suggestions->replySuggestion($id, $request->reply);
        if ($replied) {
            return json([
                "reply"         => $request->reply
            ]);
        }
        return error(null, ["message" => "Terjadi masalah saat mengirim balasan"]);
    }

    /**
     * Delete multiple suggestions
     *
     * @param SuggestionRequestDelete $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMultipleSuggestions(SuggestionRequestDelete $request)
    {
        $deleted = $this->suggestions->deleteMultipleSuggestions($request->ids);
        if ($deleted) {
            return json(null, null, 204);
        }

        return error(null, ["message" => "Terjadi masalah saat menghapus saran"]);
    }

    /**
     * Retrieve single suggestion
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveSingle($id)
    {
        $data = $this->suggestions->retrieveSingle($id, $this->auth->user()->role == "pelanggan" ? $this->auth->id() : null, $this->auth->id());

        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        $data = collect($data);

        $data = Arrays::replaceKey([
            "id_pengaduan"              => "id",
            "pengaduan_id_pelanggan"    => "user_id",
            "isi"                       => "content",
            "balasan"                   => "reply"
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

        return json(["suggestion" => $data]);
    }

    /**
     * Store new suggestion
     *
     * @param SuggestionRequestInsert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SuggestionRequestInsert $request)
    {
        $saved = $this->suggestions->createSuggestion($this->auth->id(), $request->text);
        if (!$saved) {
            return error(null, ["message" => "Terjadi kesalahan saat mengirim saran"]);
        }

        return json([], null, 204);
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
