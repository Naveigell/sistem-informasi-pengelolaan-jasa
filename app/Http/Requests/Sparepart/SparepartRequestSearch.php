<?php

namespace App\Http\Requests\Sparepart;

use Illuminate\Foundation\Http\FormRequest;

class SparepartRequestSearch extends FormRequest
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

            "t.in"                  => "Tipe pencarian harus antara komputer/pc, handphone atau printer",

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
        // t = type
        // p = page
        return [
            "q"     => "required|string|min:1",
            "t"     => "sometimes|string|in:pc,hp,printer",
            "p"     => "sometimes|integer|min:1"
        ];
    }
}
