<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed old_password
 * @property mixed new_password
 */
class AuthRequestChangePassword extends FormRequest
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
            "old_password.required"                 => "Password lama harus diisi",
            "old_password.min"                      => "Password lama minimal memiliki 6 karakter",

            "new_password.required"                 => "Password baru harus diisi",
            "new_password.min"                      => "Password baru minimal memiliki 6 karakter",

            "repeat_new_password.required"          => "Ulangi password baru harus diisi",
            "repeat_new_password.min"               => "Ulangi password baru minimal memiliki 6 karakter",
            "repeat_new_password.same"              => "Ulangi password baru harus sama dengan password baru"
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
            "old_password"              => "required|string|min:6",
            "new_password"              => "required|string|min:6",
            "repeat_new_password"       => "required|string|min:6|same:new_password"
        ];
    }
}
