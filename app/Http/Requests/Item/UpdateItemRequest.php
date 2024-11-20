<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItemRequest extends FormRequest
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
            "name"                  => 'required|string|max:255',
            "category_id"           => 'required',
            "code"                  => 'required|string|max:255|unique:items,code,' . optional($this->route('item'))->id,
            "unit_id"               => 'required|exists:units,id',
            "symbology"             => 'nullable',
            "rack_location"         => 'nullable|string|max:255',
            "sku"                   => 'nullable|string|max:255|unique:items,sku,' . optional($this->route('item'))->id,
            "photo"                 => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            "details"               => 'nullable|string',
            "alert_quantity"        => 'nullable|numeric|regex:/^-?\d{1,11}(\.\d{0,2})?$/',
            "track_weight"          => 'nullable|boolean',
            "track_quantity"        => 'nullable|boolean',
            'variants'              => 'nullable|array',
            'variants.*.option'     => 'array',
            'variants.*.name'       => 'required_if:has_variants,true',
            'variants.*.option.*'   => 'required_if:has_variants,true',
            'has_variants'          => 'nullable|boolean',
            'photo_removed'         => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            "name"              => __('attributes.item.name'),
            "category_id"       => __('attributes.item.category'),
            "code"              => __('attributes.item.code'),
            "unit_id"           => __('attributes.item.unit'),
            "symbology"         => __('attributes.item.barcode_symbology'),
            "rack_location"     => __('attributes.item.rack_location'),
            "sku"               => __('attributes.item.sku'),
            "photo"             => __('attributes.item.photo'),
            "details"           => __('attributes.item.details'),
            "alert_quantity"    => __('attributes.item.alert_quantity'),
            "track_weight"      => __('attributes.item.track_weight'),
            "track_quantity"    => __('attributes.item.track_quantity'),
            "variants.*.name"   => __('attributes.item.variant_name'),
            "variants.*.option.*"=> __('attributes.item.options'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->setImplicitAttributesFormatter(function ($attribute) {
            $attributes = explode('.', $attribute);
            if ('variants' == $attributes[0]) {
                if ($attributes[2]) {
                    return 'variant ' . ((int) $attributes[1] + 1) . ' ' . $attributes[2] . ' ' . (isset($attributes[3]) ? ((int) $attributes[3] + 1) : '');
                }
                return 'variant ' . ((int) $attributes[1] + 1);
            } elseif ('attachments' == $attributes[0]) {
                return 'attachments ' . ((int) $attributes[1] + 1);
            }
            return $attributes;
        });
    }

    protected function passedValidation()
    {
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }
}
