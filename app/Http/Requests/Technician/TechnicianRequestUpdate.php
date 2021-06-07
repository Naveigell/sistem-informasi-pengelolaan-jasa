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
            "name.required"                         => "Nama harus diisi",
            "name.min"                              => "Nama minimal memiliki 4 karakter",
            "name.max"                              => "Nama maksimal memiliki 60 karakter",

            "username.required"                     => "Username harus diisi",
            "username.min"                          => "Username minimal memiliki 6 karakter",
            "username.max"                          => "Username maksimal memiliki 40 karakter",
            "username.regex"                        => "Username hanya boleh memiliki angka, huruf, underscore dan titik",
            "username.unique"                       => "Username sudah ada yang mengambil",
            "username.no_space"                     => "Username tidak boleh memiliki spasi",
            "username.lowercase"                    => "Username tidak boleh memiliki huruf besar",
            "username.at_least_one_character"       => "Username minimal memiliki 1 huruf",
            "username.first_letter_must_alphabet"   => "Huruf pertama username harus berupa huruf",

            "username_before.required"              => "Username sebelumnya harus diisi",
            "username_before.min"                   => "Username sebelumnya minimal memiliki 4 karakter",
            "username_before.max"                   => "Username sebelumnya maksimal memiliki 40 karakter",

//            "email.required"        => "Email harus diisi",
//            "email.min"             => "Email minimal memiliki 6 karakter",
//            "email.max"             => "Email maksimal memiliki 255 karakter",
//            "email.email"           => "Email tidak valid",

            "gender.required"                       => "Jenis kelamin harus diisi",
            "gender.in"                             => "Jenis kelamin harus antara laki - laki dan perempuan",

            "address.required"                      => "Alamat harus diisi",
            "address.min"                           => "Alamat minimal memiliki 4 karakter",
            "address.max"                           => "Alamat maksimal memiliki 100 karakter",

            "phone.required"                        => "Nomor telepon harus diisi",
            "phone.numeric"                         => "Nomor telepon harus berupa angka",
            "phone.digits_between"                  => "Panjang karakter nomor hp harus antara 9 hingga 17"
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
            "id"                => "required|integer|min:1",
            "name"              => "required|string|min:6|max:60",
            "username"          => "required|string|min:6|max:40|unique:users|regex:/^[a-z0-9_.]+$/|at_least_one_character|first_letter_must_alphabet|no_space|lowercase",
            "username_before"   => "required|string|min:6|max:40",
//            "email"     => "required|string|min:6|max:255|email",
            "gender"            => "required|string|in:Laki - laki,Perempuan",
            "address"           => "required|string|min:4|max:100",
            "phone"             => "required|numeric|digits_between:9,17"
        ];
    }
}
