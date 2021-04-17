<?php

namespace App\Http\Requests\Suggestion;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed reply
 */
class SuggestionRequestReply extends FormRequest
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
            "reply.required"                => "Balasan harus diisi",
            "reply.min"                     => "Jumlah karakter balasan minimal 8",
            "reply.max"                     => "Jumlah karakterbalasan maksimal 3000"
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
            "reply"               => "required|string|min:8|max:3000"
        ];
    }
}
