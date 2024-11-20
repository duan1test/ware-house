<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($this->category),
            ],
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|string|max:255',
        ];
    }

    public function attributes():array
    {
        return [
            'code' => __('attributes.category.code'),
            'name' => __('attributes.category.name'),
            'parent_id' => __('attributes.category.parent_id'),
        ];
    }

    protected function passedValidation()
    {
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }
}
