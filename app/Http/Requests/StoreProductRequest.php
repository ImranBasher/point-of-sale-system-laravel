<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{

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
        $productId = $this->route('product');

        if ($this->isMethod('post')) {
            return [
                'title'             => 'required|string|max:255',
                'short_description' => 'nullable|string|max:500',
                'long_description'  => 'nullable|string',
                'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id'       => 'required|array',
                'category_id.*'     => 'exists:categories,id',

                'brand_id'          => 'required|exists:brands,id',
                'status'            => 'required|in:1,0',
                'images'            => 'nullable|array',
                'images.*'          => 'image|mimes:jpeg,jpg,png|max:20000',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) { // Update operation
            return [
                'title'             => 'required|string|max:255',
//                'slug'              => 'nullable|string|max:255|unique:products,slug,' . $productId,
//                'sku'               => 'required|string|max:255|unique:products,sku,' . $productId,
                'short_description' => 'nullable|string|max:500',
                'long_description'  => 'nullable|string',
                'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id'          => 'required|exists:categories,id',
                'brand_id'          => 'required|exists:brands,id',
                'status'            => 'required|in:1,0',
                'images'            => 'nullable|array',
                'images.*'          => 'image|mimes:jpeg,jpg,png|max:20000',
            ];
        }

        return [];
    }

}
