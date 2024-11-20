<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required_without:type|string|max:255',
            'email' => 'required_without:type|email:rfc,dns|max:255|unique:users,email,' . $this->user->id,
            'username' => 'required_without:type|string|max:255|not_regex:/[\ ]+/|unique:users,username,' . $this->user->id,
            'password' => 'required_with:type|string|max:255|min:8|confirmed',
            'phone' => 'nullable|regex:/^[0-9]+$/|digits_between:10,15|unique:users,phone,' . $this->user->id,
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'role' => 'required_without:type|exists:roles,id',
            'view_all' => 'nullable|boolean',
            'edit_all' => 'nullable|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('attributes.user.name'),
            'password' => __('attributes.user.password'),
            'email' => __('attributes.user.email'),
            'username' => __('attributes.user.username'),
            'phone' => __('attributes.user.phone'),
            'warehouse_id' => __('attributes.user.warehouse'),
            'role' => __('attributes.user.roles'),
        ];
    }
}
