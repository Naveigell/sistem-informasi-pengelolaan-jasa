<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class TechnicianRequestResetPassword extends FormRequest
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
            "username.required"         => "Username harus diisi",
            "username.min"              => "Panjang karakter username minimal 6",

            "password.required"         => "Password harus diisi",
            "password.min"              => "Panjang karakter password minimal 6"
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
            "username"  => "required|string|min:6",
            "password"  => "required|string|min:6",
        ];
    }
}
