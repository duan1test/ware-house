<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreWarehouseRequest extends FormRequest
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
            'code'      => 'required|unique:warehouses|string|max:255',
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|regex:/^[0-9]+$/|digits_between:10,15',
            'email'     => 'nullable|email:filter|max:255',
            'address'   => 'nullable|max:255',
            'logo'      => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'active'    => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'      => __('attributes.warehouse.code'),
            'name'      => __('attributes.warehouse.name'),
            'phone'     => __('attributes.warehouse.phone'),
            'email'     => __('attributes.warehouse.email'),
            'address'   => __('attributes.warehouse.address'),
            'logo'      => __('attributes.warehouse.logo'),
        ];
    }

    protected function passedValidation()
    {
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }
}
