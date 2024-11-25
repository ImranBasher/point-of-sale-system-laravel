<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOriginRequest extends FormRequest
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
        /**
         * Detailed Description:
         * Purpose of $this->route('id'):
         *
         * When handling HTTP requests in Laravel, you often define routes that include parameters, like /origins/{id}.
         * When you want to update a resource (such as an "origin" in this case), you need to know which specific resource (by id) is being updated.
         * $this->route('id') fetches the id value directly from the route parameter of the current HTTP request.
         * Where It Is Used:
         *
         * This is commonly used inside a FormRequest class to customize validation rules for update operations.
         * For example, in your StoreOriginRequest or any similar FormRequest, you can use this approach to get the ID of the origin being updated.
         * How It Works:
         *
         * When you visit a route like /origins/2/edit, the id in the URL (2 in this case) is available as a route parameter.
         * $this->route('id') extracts this parameter, allowing you to use it within your validation logic.
         */
        $originId = $this->route('origin');

        if ($this->isMethod('post')) { // Store operation
            return [
                'origin_name' => 'required|string|max:255|unique:origins,origin_name',
                'status' => 'required|in:0,1',
            ];
        }
        if ($this->isMethod('put') || $this->isMethod('patch')) { // Update operation
            return [
                'origin_name' => 'required|string|max:255|unique:origins,origin_name,' . $originId,
                'status' => 'required|in:0,1',
            ];
        }
        return [];
    }
}
