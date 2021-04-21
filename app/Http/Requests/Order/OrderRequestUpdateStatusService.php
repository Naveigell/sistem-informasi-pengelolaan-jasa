<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed status
 * @property mixed id
 */
class OrderRequestUpdateStatusService extends FormRequest
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
            "id.required"                   => "Id tidak boleh kosong",
            "id.integer"                    => "Id harus berupa angka",
            "id.min"                        => "Id minimal 1",

            "status.required"               => "Status tidak boleh kosong",
            "status.in"                     => "Status harus diantara menunggu, dicek, perbaikan, selesai, pembayaran dan terima"
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
            "status"            => "required|in:menunggu,dicek,perbaikan,selesai,pembayaran,terima"
        ];
    }
}
