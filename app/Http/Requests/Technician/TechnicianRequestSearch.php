<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class TechnicianRequestSearch extends FormRequest
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

    public function messages()
    {
        return [
            "q.required"            => "Input nama harus diisi",
            "q.min"                 => "Input nama harus memiliki karakter minimal 1",

            "p.integer"             => "Page harus berupa angka",
            "p.min"                 => "Page minimal 1"
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // q = query
        // p = page
        return [
            "q"     => "required|string|min:1",
            "p"     => "sometimes|integer|min:1"
        ];
    }
}
