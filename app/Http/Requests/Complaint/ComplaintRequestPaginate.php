<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed next
 * @property mixed id
 */
class ComplaintRequestPaginate extends FormRequest
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
            "id"            => "sometimes|min:1",
            "next"          => "sometimes|in:true,false",
        ];
    }
}
