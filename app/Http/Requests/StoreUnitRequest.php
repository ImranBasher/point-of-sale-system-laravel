<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
        // Assuming 'unit' is the route parameter for updating
        $unitId = $this->route('unit');

        if ($this->isMethod('post')) { // Store operation
            return [
                'name' => 'required|string|max:255|unique:units,name', // Adjust to 'units' table and 'name' column
                'status' => 'required|in:0,1',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) { // Update operation
            return [
                'name' => 'required|string|max:255|unique:units,name,' . $unitId, // Adjust unique validation to exclude current ID
                'status' => 'required|in:0,1',
            ];
        }

        return [];
    }

}
