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

            "email.required"                        => "Email harus diisi",
            "email.min"                             => "Email minimal memiliki 6 karakter",
            "email.max"                             => "Email maksimal memiliki 255 karakter",
            "email.email"                           => "Format email tidak valid",

            "gender.required"                       => "Jenis kelamin harus diisi",
            "gender.in"                             => "Jenis kelamin harus antara laki - laki dan perempuan",

            "phone.required"                        => "Nomor telepon harus diisi",
            "phone.min"                             => "Panjang nomor telepon minimal 7",
            "phone.max"                             => "Panjang nomor telepona maksimal 17",

            "company.min"                           => "Panjang instansi/perusahaan minimal 4",
            "company.max"                           => "Panjang instansi/perusahaan maksimal 70",

            "address.required"                      => "Alamat harus diisi",
            "address.min"                           => "Alamat minimal memiliki 8 karakter",
            "address.max"                           => "Alamat maksimal memiliki 100 karakter"
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
            "username"      => "required|string|min:6|max:40|unique:users|regex:/^[a-z0-9_.]+$/|at_least_one_character|first_letter_must_alphabet|no_space|lowercase",
            "email"         => "required|string|min:6|email",
            "gender"        => "required|string|in:Laki - laki,Perempuan",
            "phone"         => "required|string|min:7|max:17",
            "company"       => "sometimes|string|min:4|max:70",
            "address"       => "required|string|min:8|max:100",
        ];
    }
}
