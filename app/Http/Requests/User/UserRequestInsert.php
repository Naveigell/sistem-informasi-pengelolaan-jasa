<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestInsert extends FormRequest
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
     * @return array
     */
    public function messages()
    {
        return [
            "name.required"                 => "Nama harus diisi",
            "name.min"                      => "Nama minimal memiliki 4 karakter",
            "name.max"                      => "Nama maksimal memiliki 60 karakter",

            "username.required"             => "Username harus diisi",
            "username.min"                  => "Username minimal memiliki 6 karakter",
            "username.max"                  => "Username maksimal memiliki 40 karakter",
            "username.no_space"             => "Username tidak boleh memiliki spasi",
            "username.lowercase"            => "Username tidak boleh memiliki huruf besar",

            "email.required"                => "Email harus diisi",
            "email.min"                     => "Email minimal memiliki 6 karakter",
            "email.max"                     => "Email maksimal memiliki 255 karakter",
            "email.email"                   => "Format email tidak valid",

            "gender.required"               => "Jenis kelamin harus diisi",
            "gender.in"                     => "Jenis kelamin harus antara laki - laki dan perempuan",

            "phone.required"                => "Nomor telepon harus diisi",
            "phone.min"                     => "Panjang nomor telepon minimal 7",
            "phone.max"                     => "Panjang nomor telepona maksima 17",

            "address.required"              => "Alamat harus diisi",
            "address.min"                   => "Alamat minimal memiliki 8 karakter",
            "address.max"                   => "Alamat maksimal memiliki 100 karakter"
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
            "name"          => "required|string|min:4|max:60",
            "username"      => "required|string|min:6|max:40|no_space|lowercase",
            "email"         => "required|string|min:6|email",
            "gender"        => "required|string|in:Laki - laki,Perempuan",
            "phone"         => "required|string|min:7|max:17",
            "address"       => "required|string|min:8|max:100"
        ];
    }
}
