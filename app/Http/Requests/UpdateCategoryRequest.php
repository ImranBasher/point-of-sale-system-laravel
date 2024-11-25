<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:categories,title,'.$this->category->id,
            'parent_category_id' => 'nullable|exists:categories,id',
            'position_no' => 'nullable|integer',
            'thumbnail' =>  ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:20000'],
            'status' => 'required|in:1,0',
            'created_by_id' => 'nullable|exists:users,id',
            'updated_by_id' => 'nullable|exists:users,id',
        ];
    }
}
