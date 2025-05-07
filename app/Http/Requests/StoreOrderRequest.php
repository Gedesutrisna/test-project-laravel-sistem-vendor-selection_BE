<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
             * Tanggal order dilakukan
             * @example "2025-6-05"
             */
            'date_order' => 'required|string',
            /**
             * Nomor order unik
             * @example "ORD-00123"
             */
            'no_order' => 'required|string',
            /**
             * ID Vendor
             * @example 4
             */
            'vendor_id' => 'required|exists:vendors,id',
            /**
             * ID Barang/Item
             * @example 4
             */
            'item_id' => 'required|exists:items,id',
        ];
    }
}
