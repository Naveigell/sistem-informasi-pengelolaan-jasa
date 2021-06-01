<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 * @property mixed id_technician
 * @property mixed note
 */
class OrderRequestNote extends FormRequest
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
            "id.required"                           => "Id harus diisi",
            "id.min"                                => "Id minimal 1",

            "id_technician.required"               => "Id teknisi harus diisi",
            "id_technician.min"                    => "Id teknisi minimal 1",

            "note.min"                              => "Catatan minimal memiliki 7 karakter",
            "note.max"                              => "Catatan maksimal memiliki 6000 karakter"
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
            "note"              => "sometimes|min:7|max:6000",
            "id"                => "required|min:1",
            "id_technician"     => "sometimes|min:1"
        ];
    }
}
