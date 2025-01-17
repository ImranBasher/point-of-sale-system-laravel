<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesFilterRequest extends FormRequest
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
            'customer_id'   => 'nullable',
            'product_id'    =>  'nullable|exists:sales_products,product_id',
            'start_date'    => 'nullable|date|date_format:Y-m-d',
            'end_date'      => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }
}
