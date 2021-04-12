<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed spareparts
 */
class OrderRequestSaveSparepart extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "spareparts"            => "required|array",
            "spareparts.*.id"       => "required|integer|min:1",
            "spareparts.*.jumlah"   => "required|integer|min:1|max:65365",

            "id"                    => "required|integer|min:1"
        ];
    }
}
