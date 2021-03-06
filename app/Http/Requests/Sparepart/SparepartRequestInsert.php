<?php

namespace App\Http\Requests\Sparepart;

use Illuminate\Foundation\Http\FormRequest;

class SparepartRequestInsert extends FormRequest
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
            "name.required"             => "Nama sparepart harus diisi",
            "name.min"                  => "Panjang karakter nama minimal 7",
            "name.max"                  => "Panjang karakter nama maksimal 70",

            "part_number.min"           => "Panjang karakter part number minimal 3",
            "part_number.max"           => "Panjang karakter part number maksimal 50",

            "serial_number.min"         => "Panjang karakter serial number minimal 3",
            "serial_number.max"         => "Panjang karakter serial number maksimal 50",

            "description.required"      => "Deskripsi harus diisi",
            "description.min"           => "Panjang karakter deskripsi minimal 10",
            "description.max"           => "Panjang karakter deskripsi maksimal 3000",

            "type.required"             => "Tipe sparepart harus diisi",
            "type.in"                   => "Tipe sparepart harus antara pc, hp atau printer",

            "stock.required"            => "Stok sparepart harus diisi",
            "stock.integer"             => "Stok harus berupa angka",
            "stock.min"                 => "Stok sparepart minimal berjumlah 1",
            "stock.max"                 => "Stok sparepart maksimal berjumlah 65000",

            "price.required"            => "Harga sparepart harus diisi",
            "price.integer"             => "Harga harus berupa angka",
            "price.min"                 => "Harga sparepart minimal berjumlah 1",
            "price.max"                 => "harga sparepart maksimal berjumlah 300.000.000",

            "real_price.required"       => "Harga asli sparepart harus diisi",
            "real_price.integer"        => "Harga asli harus berupa angka",
            "real_price.min"            => "Harga asli sparepart minimal berjumlah 1",
            "real_price.max"            => "Harga asli sparepart maksimal berjumlah 300.000.000",
            "real_price.lt"             => "Harga asli tidak boleh melebihi atau sama dengan harga jual",

            "images.required"           => "Foto sparepart harus diisi",
            "images.array"              => "Foto sparepart harus berupa array",
            "images.min"                => "Jumlah foto minimal 1",
            "images.max"                => "Jumlah foto maksimal 5",

            "images.*.required"         => "Foto harus diisi",
            "images.*.mimes"            => "Hanya diperbolehkan ekstensi .jpg, .png, .jpeg",
            "images.*.max"              => "Ukuran foto maksimal 10MB atau 10.000KB"
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
            "name"              => "required|string|min:7|max:70",
            "part_number"       => "sometimes|string|min:3|max:50",
            "serial_number"     => "sometimes|string|min:3|max:50",
            "description"       => "required|string|min:10|max:3000",
            "type"              => "required|in:pc,hp,printer",
            "stock"             => "required|integer|min:1|max:65000",
            "price"             => "required|integer|min:1|max:300000000",
            "real_price"        => "required|integer|min:1|max:300000000|lt:price",
            "images"            => "required|array|min:1|max:5",
            "images.*"          => "required|mimes:jpg,png,jpeg|max:10000"
        ];
    }
}
