<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


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
        return [
            'code'      => 'required|unique:categories|string|max:255',
            'name'      => 'required|string|max:255',
            'parent_id' => 'nullable|string|max:255',
        ];
    }

    protected function passedValidation()
    {
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }

    public function attributes():array
    {
        return [
            'code' => __('attributes.category.code'),
            'name' => __('attributes.category.name'),
            'parent_id' => __('attributes.category.parent_id'),
        ];
    }
}
