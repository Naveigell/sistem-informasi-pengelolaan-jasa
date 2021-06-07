<?php

namespace App\Http\Requests\User\Account\Biodata;

use Illuminate\Foundation\Http\FormRequest;

class BiodataUpdateRequest extends FormRequest
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
            "alamat.required"                       => "Alamat harus diisi",
            "alamat.min"                            => "Panjang karakter alamat minimal 8",
            "alamat.max"                            => "Panjang karakter alamat maksimal 100",

            "email.required"                        => "Email harus diisi",
            "email.email"                           => "Format email salah",
            "email.min"                             => "Panjang karakter email minimal 6",
            "email.max"                             => "Panjang karakter email maksimal 255",

            "jenis_kelamin.required"                => "Jenis kelamin harus diisi",
            "jenis_kelamin.in"                      => "Jenis kelamin harus antara laki - laki atau perempuan",

            "name.required"                         => "Nama harus diisi",
            "name.min"                              => "Panjang karakter nama minimal 6",
            "name.max"                              => "Panjang karakter nama maksimal 60",

            "nomor_hp.required"                     => "Nomor hp harus diisi",
            "nomor_hp.numeric"                      => "Nomor hp harus berupa angka",
            "nomor_hp.digits_between"               => "Panjang karakter nomor hp harus antara 7 hingga 17",

            "username.required"                     => "Username harus diisi",
            "username.min"                          => "Username minimal memiliki 6 karakter",
            "username.max"                          => "Username maksimal memiliki 40 karakter",
            "username.regex"                        => "Username hanya boleh memiliki angka, huruf, underscore dan titik",
            "username.unique"                       => "Username sudah ada yang mengambil",
            "username.no_space"                     => "Username tidak boleh memiliki spasi",
            "username.lowercase"                    => "Username tidak boleh memiliki huruf besar",
            "username.at_least_one_character"       => "Username minimal memiliki 1 huruf",
            "username.first_letter_must_alphabet"   => "Huruf pertama username harus berupa huruf",
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
            "alamat"            => "required|string|min:6|max:100",
            "email"             => "required|string|email|min:6|max:255",
            "jenis_kelamin"     => "required|string|in:Laki - laki,Perempuan",
            "name"              => "required|string|min:6|max:60",
            "nomor_hp"          => "required|numeric|digits_between:9,17",
            "username"          => "required|string|min:6|max:40|unique:users|regex:/^[a-z0-9_.]+$/|at_least_one_character|first_letter_must_alphabet|no_space|lowercase"
        ];
    }
}
