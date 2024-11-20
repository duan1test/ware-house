<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWarehouseRequest extends FormRequest
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
                Rule::unique('warehouses')->ignore($this->warehouse),
            ],
            'name' => 'required|string|max:255',
            'phone' => 'nullable|regex:/^[0-9]+$/|digits_between:10,15',
            'email' => 'nullable|email:filter|max:255',
            'address' => 'nullable|max:255',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'photo_removed' => 'nullable',
        ];
    }

    protected function passedValidation()
    {
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.warehouse.code'),
            'name' => __('attributes.warehouse.name'),
            'phone' => __('attributes.warehouse.phone'),
            'email' => __('attributes.warehouse.email'),
            'address' => __('attributes.warehouse.address'),
            'logo' => __('attributes.warehouse.logo'),
        ];
    }
}
