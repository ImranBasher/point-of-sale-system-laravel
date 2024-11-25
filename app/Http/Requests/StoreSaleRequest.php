<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
       // dd($this->all());
        return [
//           'supplier_id'      => 'required|exists:users,id',
            'customer_id'       => 'required|exists:users,id',
            'sub_total'         => 'required|numeric|min:0',
            'discount_type'     => 'nullable|string|in:0,1,2',
            'discount_value'    => 'nullable|numeric|min:0',
            'discount_amount'   => 'nullable|numeric|min:0',
            'shipping_amount'   => 'nullable|numeric|min:0',
            'vat_amount'        => 'nullable|numeric|min:0',
            'tax_amount'        => 'nullable|numeric|min:0',
            'grand_total'       => 'required|numeric|min:0',
            'total_quantity'    => 'required|integer|min:1',
            'paid_amount'       => 'required|numeric|min:0',
            'payment_status'    => 'required|string|in:0,1',
            'status'            => 'required|string|in:0,1',
            'product_ids'       => 'required|array|min:1', // Ensure product_id is an array and has at least one item
            'product_ids.*'     => 'required|integer|exists:products,id',

            'sales_cart_ids'    => 'required|array|min:1',
            'sales_cart_ids.*'  => 'required|integer|exists:sales_carts,id',
        ];
    }
}
