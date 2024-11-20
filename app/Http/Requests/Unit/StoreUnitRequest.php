<?php

namespace App\Http\Requests\Unit;

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
        return [
            'name'            => ['required', 'max:255'],
            // 'details'         => 'nullable',
            'operation_value' => ['nullable', 'numeric'],
            'operator'        => ['nullable', 'in:+,-,*,/'],
            'base_unit_id'    => ['nullable', 'exists:units,id'],
            'code'            => ['required', 'alpha_num', 'max:50', 'unique:units,code,' . optional($this->route('unit'))->id],
        ];
    }

    public function attributes()
    {
        return [
            'name'              => __('attributes.unit.name'),
            'operation_value'   => __('attributes.unit.operation_value'),
            'base_unit_id'      => __('attributes.unit.base_unit_id'),
            'code'              => __('attributes.unit.code'),
        ];
    }
}
