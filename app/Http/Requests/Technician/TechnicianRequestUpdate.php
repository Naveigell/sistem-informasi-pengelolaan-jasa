<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class TechnicianRequestUpdate extends FormRequest
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
            "name.required"         => "Nama harus diisi",
            "name.min"              => "Nama minimal memiliki 4 karakter",
            "name.max"              => "Nama maksimal memiliki 60 karakter",

            "username.required"     => "Username harus diisi",
            "username.min"          => "Username minimal memiliki 4 karakter",
            "username.max"          => "Username maksimal memiliki 40 karakter",

            "email.required"        => "Email harus diisi",
            "email.min"             => "Email minimal memiliki 6 karakter",
            "email.max"             => "Email maksimal memiliki 255 karakter",
            "email.email"           => "Email tidak valid",

            "gender.required"       => "Jenis kelamin harus diisi",
            "gender.in"             => "Jenis kelamin harus antara laki - laki dan perempuan",

            "address.required"      => "Alamat harus diisi",
            "address.min"           => "Alamat minimal memiliki 4 karakter",
            "address.max"           => "Alamat maksimal memiliki 100 karakter",

            "phone.required"        => "Nomor telepon harus diisi",
            "phone.numeric"         => "Nomor telepon harus berupa angka",
            "phone.digits_between"  => "Panjang karakter nomor hp harus antara 9 hingga 17"
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
            "id"        => "required|integer|min:1",
            "name"      => "required|string|min:4|max:60",
            "username"  => "required|string|min:4|max:40",
            "email"     => "required|string|min:6|max:255|email",
            "gender"    => "required|string|in:Laki - laki, Perempuan",
            "address"   => "required|string|min:4|max:100",
            "phone"     => "required|numeric|digits_between:9,17"
        ];
    }
}
