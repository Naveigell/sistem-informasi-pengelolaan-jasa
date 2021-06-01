<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequestInsert extends FormRequest
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
            "name.required"                 => "Nama pelanggan harus diisi",
            "name.min"                      => "Panjang karakter nama minimal 4",
            "name.max"                      => "Panjang karakter nama maksimal 40",

            "email.required"                => "Email harus diisi",
            "email.min"                     => "Panjang karakter email minimal 8",
            "email.max"                     => "Panjang karakter email maksimal 255",

            "address.required"              => "Alamat pelanggan harus diisi",
            "address.min"                   => "Panjang karakter alamat minimal 8",
            "address.max"                   => "Panjang karakter alamat maksimal 100",

            "device_name.required"          => "Nama perangkat harus diisi",
            "device_name.min"               => "Panjang karakter perangkat minimal 4",
            "device_name.max"               => "Panjang karakter perangkat maksimal 50",

            "device_problem.required"       => "Keluhan harus diisi",
            "device_problem.min"            => "Panjang karakter keluhan minimal 8",
            "device_problem.max"            => "Panjang karakter keluhan maksimal 3000",

            "device_type.required"          => "Tipe perangkat harus diisi",
            "device_type.in"                => "Tipe perangkat harus diantara pc, hp dan printer",

            "device_brand.required"         => "Merk perangkat harus diisi",
            "device_brand.min"              => "Panjang karakter merk minimal 3",
            "device_brand.max"              => "Panjang karakter merk maksimal 70",

            "id_service.required"           => "Jenis jasa harus dipilih",
            "id_service.min"                => "Id jasa minimal 1"
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
            "name"                      => "required|string|min:4|max:40",
            "email"                     => "required|string|min:6|max:255",
            "address"                   => "required|string|min:8|max:90",
            "device_name"               => "required|string|min:4|max:50",
            "device_problem"            => "required|string|min:8|max:3000",
            "device_type"               => "required|string|in:pc,hp,printer",
            "device_brand"              => "required|string|min:3|max:70",

            "id_service"                => "required|min:1"
        ];
    }
}
