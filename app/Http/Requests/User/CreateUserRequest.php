<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username|not_regex:/[\ ]+/',
            'password' => 'required|string|max:255|min:8',
            'confirm_password' => 'same:password',
            'phone' => 'nullable|regex:/^[0-9]+$/|digits_between:10,15|unique:users,phone',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'role' => 'required|exists:roles,id',
            'view_all' => 'nullable|boolean',
            'edit_all' => 'nullable|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('attributes.user.name'),
            'password' => __('attributes.user.password'),
            'confirm_password' => __('attributes.user.confirm_password'),
            'email' => __('attributes.user.email'),
            'username' => __('attributes.user.username'),
            'phone' => __('attributes.user.phone'),
            'warehouse_id' => __('attributes.user.warehouse'),
            'role' => __('attributes.user.roles'),
        ];
    }
}
