<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesCartRequest extends FormRequest
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
        $rules = [
            'product_id' => 'required|exists:products,id',
            'unit_price' => 'required|numeric|min:0',
            'quantity'   => 'required|numeric|min:1',
            // 'sub_total' is not needed as input; it should be calculated in the backend
        ];

        // For updates (PUT), you may skip validating `product_id` if it is not being updated
        if ($this->isMethod('put')) {
            $rules['product_id'] = 'sometimes|exists:products,id';
        }

        return $rules;
    }

}
