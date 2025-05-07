<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
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
            /**
             * Kode Vendor unik
             * @example "V04"
             */
            'code' => 'required|string|max:255',
            /**
             * Nama Vendor
             * @example "Vendor 4"
             */
            'name' => 'required|string|max:255',
        ];
    }    
}
