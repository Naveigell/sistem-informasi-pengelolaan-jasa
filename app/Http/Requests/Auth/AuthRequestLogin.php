<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequestLogin extends FormRequest
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
     * @return array|string[]
     */
    public function messages() {
        return [
            'email.required'            => 'Email harus diisi',
            'email.min'                 => 'Panjang email minimal 5 karakter',
            'email.email'               => 'Email tidak valid',

            'password.required'         => 'Password harus diisi',
            'password.min'              => 'Panjang karakter password minimal 6 karakter'
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
            'email'         => 'required|string|min:5|email',
            'password'      => 'required|string|min:6'
        ];
    }
}
