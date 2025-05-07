<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorItemRequest extends FormRequest
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
             * ID Vendor
             * @example 4
             */
            'vendor_id'   => 'required|exists:vendors,id',
            /**
             * ID Barang/Item
             * @example 4
             */
            'item_id'     => 'required|exists:items,id',
            /**
             * Harga Sebelum
             * @example 45000
             */
            'price_before' => 'required|numeric',
            /**
             * Harga Sekarang
             * @example 50000
             */
            'price_now'    => 'required|numeric',
        ];
    }    
}
