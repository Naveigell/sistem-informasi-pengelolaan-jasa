<?php

namespace App\Http\Controllers\Api\Suggestion;

use App\Helpers\Arrays\Arrays;
use App\Helpers\Regex\RegexHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Suggestion\SuggestionRequestInsert;
use App\Interfaces\Rolable;
use App\Interfaces\TimeSentences;
use App\Models\Suggestion\SuggestionModel;
use App\Traits\Roles;

class SuggestionController extends Controller implements TimeSentences
{
    use Roles;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveAll()
    {
        $data = [];
        if ($this->auth->user()->role == "user") {
            $data = $this->suggestions->retrieveAll($this->auth->id());
        }

        $data = Arrays::replaceKey([
            "id_pengaduan"              => "id",
            "pengaduan_id_users"        => "user_id",
            "isi"                       => "content",
            "tipe"                      => "type",
        ], $data->toArray());

        $data = collect($data)->map(function ($item) {
            $item["created_at_sentences"]   = $item["created_at"] == null ? null : $this->toSentences(new \DateTime($item["created_at"]));
            $item["content"]                = RegexHelper::toContent($item["content"]);

            return $item;
        })->toArray();

        return json(["suggestions" => $data]);
    }

    /**
     * Retrieve single suggestion
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieveSingle($id)
    {
        $data = $this->suggestions->retrieveSingle($id, $this->auth->id());

        if ($data == null) {
            return error(null, ["message" => "Data tidak ditemukan"], 404);
        }

        $data = Arrays::replaceKey([
            "id_pengaduan"          => "id",
            "pengaduan_id_users"    => "user_id",
            "isi"                   => "content"
        ], $data->getAttributes());

        $data["created_at_sentences"] = $data["created_at"] == null ? null : $this->toSentences(new \DateTime($data["created_at"]));

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
