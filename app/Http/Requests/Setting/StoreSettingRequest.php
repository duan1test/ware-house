<?php

namespace App\Http\Requests\Setting;

use App\Rules\LocaleLength;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'name'           => ['required', 'max:255'],
            'currency_code'  => 'required|size:3',
            'weight_unit'    => 'nullable|string',
            'over_selling'   => 'nullable|boolean',
            'track_weight'   => 'nullable|boolean',
            'language'       => 'required|string',
            'sidebar_style'  => 'required|in:full,dropdown',
            'per_page'       => 'required|in:10,15,25,50,100',
            'default_locale' => ['required', new LocaleLength()],
            'fraction'       => 'required|integer|min:0|in:0,1,2,3,4',
            'reference'      => 'required|string|in:ai,ulid,uuid,uniqid',
        ];
    }

    public function attributes()
    {
        return [
            'name'              => __('attributes.settings.name'),
            'currency_code'     => __('attributes.settings.currency_code_key'),
            'default_locale'    => __('attributes.settings.default_locale_key'),
            'language'          => __('attributes.settings.language_key'),
            'reference'         => __('attributes.settings.reference_key'),
            'per_page'          => __('attributes.settings.per_page_key'),
            'sidebar_style'     => __('attributes.settings.sidebar_style'),
            'fraction'          => __('attributes.settings.fraction_key'),
        ];
    }
}
