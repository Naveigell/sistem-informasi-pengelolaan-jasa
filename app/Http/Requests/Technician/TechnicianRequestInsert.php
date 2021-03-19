<?php

namespace App\Http\Requests\Technician;

use App\Helpers\Regex\RegexHelper;
use Illuminate\Foundation\Http\FormRequest;

class TechnicianRequestInsert extends FormRequest
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

            "email.required"                => "Email harus diisi",
            "email.min"                     => "Email minimal memiliki 6 karakter",
            "email.max"                     => "Email maksimal memiliki 255 karakter",
            "email.email"                   => "Format email tidak valid",

            "gender.required"               => "Jenis kelamin harus diisi",
            "gender.in"                     => "Jenis kelamin harus antara laki - laki dan perempuan"
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
            "username"      => "required|string|min:6|max:40|no_space",
            "email"         => "required|string|min:6|email",
            "gender"        => "required|string|in:Laki - laki,Perempuan"
        ];
    }

//    protected function prepareForValidation()
//    {
//        $data = $this->request->all();
//        $data["username"] = RegexHelper::removeSpace($this->request->get("username"));
//
//        $this->replace($data);
//    }
}
