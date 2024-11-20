<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateRoleRequest extends FormRequest
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
            'name' => 'required_if:type,role|string|max:255|unique:roles,name,' . $this->role->id,
            'permissions' => 'nullable|array',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('attributes.role.name'),
        ];
    }
}
