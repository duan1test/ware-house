<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|email:rfc,dns|max:255|unique:contacts,email',
            'phone' => 'nullable|regex:/^[0-9]+$/|digits_between:10,15',
            'details' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('attributes.contact.name'),
            'email' => __('attributes.user.email'),
            'phone' => __('attributes.user.phone'),
            'details' => __('attributes.item.details'),
        ];
    }
}
