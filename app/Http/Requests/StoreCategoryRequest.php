<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
//        dd($this->all());
        return [
            'title'         => 'required|string',
            'thumbnail'     =>  ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:20000'],
            'parent_category_id'   => 'nullable|exists:categories,id',
            'position_no'   => 'nullable|integer',
            'status'        => 'required|in:1,0'
        ];
    }
}
