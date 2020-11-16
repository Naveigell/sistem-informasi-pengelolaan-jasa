<?php

namespace App\Http\Requests\User\Account\Biodata;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePictureUpdateRequest extends FormRequest
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
     * Custom messages untuk rules
     * @return array
     */
    public function messages() {
        return [
            "image.required"          => "Image tidak boleh kosong",
            "image.mimes"             => "File yang disupport hanya .jpeg, .jpg dan .png",
            "image.max"               => "Ukuran image maksimal 10 MB"
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
            "image"   => "required|mimes:jpeg,jpg,png|max:10000"
        ];
    }
}
