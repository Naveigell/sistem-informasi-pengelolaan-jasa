<?php

namespace App\Http\Requests\Exporter\Excel;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed month
 * @property mixed year
 */
class FinanceRequestCreate extends FormRequest
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
            "month.required"                    => "Bulan harus diisi",
            "month.min"                         => "Bulan minimal 1",
            "month.max"                         => "Bulan maksimal 12",

            "year.required"                     => "Tahun harus diisi",
            "year.min"                          => "Tahun minimal 2018"
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
            "month"         => "required|min:1|max:12",
            "year"          => "required"
        ];
    }
}
