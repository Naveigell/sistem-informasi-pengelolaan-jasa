<?php

namespace App\Http\Requests\Jasa;

use Illuminate\Foundation\Http\FormRequest;

class JasaRequestUpdate extends FormRequest
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
            "id.required"           => "Id harus diisi",
            "id.integer"            => "Id harus berupa angka",
            "id.min"                => "Id minimal 1",

            "name.required"         => "Nama jasa harus diisi",
            "name.min"              => "Panjang karakter jasa minimal 3",
            "name.max"              => "Panjang karakter jasa minimal 30",

            "description.required"  => "Deskripsi harus diisi",
            "description.min"       => "Panjang karakter deskripsi minimal 5",
            "description.max"       => "Panjang karakter deskripsi minimal 255",

            "type.required"         => "Tipe jasa harus diisi",
            "type.in"               => "Tipe jasa harus diantara pc, printer atau hp",

            "price.required"        => "Harga jasa harus diisi",
            "price.integer"         => "Harus berupa angka",
            "price.min"             => "Harga jasa minimal 1",
            "price.max"             => "Harga jasa minimal 99.999.999",
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
            "name"          => "required|string|min:3|max:30",
            "description"   => "required|string|min:5|max:255",
            "type"          => "required|string|in:pc,printer,hp",
            "price"         => "required|integer|min:1|max:99999999"
        ];
    }
}
