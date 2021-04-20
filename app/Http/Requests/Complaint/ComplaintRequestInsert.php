<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed text
 * @property mixed id
 */
class ComplaintRequestInsert extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "text.required"             => "Komplain harus diisi",
            "text.min"                  => "Komplain minimal memiliki 6 karakter",
            "text.max"                  => "Komplain maksimal memiliki 3000 karakter",
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id"            => "required|integer|min:1",
            "text"          => "required|string|min:6|max:3000",
        ];
    }
}
