<?php

namespace App\Http\Requests\Suggestion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed text
 */
class SuggestionRequestInsert extends FormRequest
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
            "text.required"                 => "Isi saran harus diisi",
            "text.min"                      => "Isi saran minimal 8 karakter",
            "text.max"                      => "Isi saran maksimal 3000 karakter"
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
            "text"               => "required|string|min:8|max:3000"
        ];
    }
}
