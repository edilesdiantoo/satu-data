<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBahanPanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_kabupaten_kota' => 'sometimes|required|exists:kabupaten,id', // Adjust the validation rule as necessary
            'id_komoditas' => 'sometimes|required|exists:komoditas,id', // Adjust the validation rule as necessary
            'harga' => 'required|numeric',
            'tanggal_survey' => 'required|date',
        ];
    }
}
