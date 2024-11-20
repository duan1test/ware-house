<?php

namespace App\Http\Requests;

use App\Helpers\CheckOverSelling;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AdjustmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'details'       => 'nullable',
            'attachments'   => 'nullable',
            'draft'         => 'nullable|boolean',
            'attachments.*' => 'mimes:' . env('ATTACHMENT_EXTS', 'jpg,png,pdf,docx,xlsx,zip'),

            'date'         => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type'         => 'required|in:Damage,Addition,Subtraction',
            'reference'    => 'nullable|max:50|unique:adjustments,reference,' . optional($this->route('adjustment'))->id,

            'items'                      => 'required|array|min:1',
            'items.*.id'                 => 'nullable',
            'items.*.adjustment_item_id' => 'nullable',
            'items.*.has_serials'        => 'nullable',
            'items.*.has_variants'       => 'nullable',
            'items.*.quantity'           => 'required|numeric',
            'items.*.old_quantity'       => 'nullable|numeric',
            'items.*.item_id'            => 'required|exists:items,id',
            'items.*.unit_id'            => 'nullable|exists:units,id',
            'items.*.selected'           => 'nullable|array|required_if:items.*.has_variants,1',
            'items.*.weight'             => 'nullable|numeric|required_if:items.*.track_weight,1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->setImplicitAttributesFormatter(function ($attribute) {
            $attributes = explode('.', $attribute);
            if ('items' == $attributes[0]) {
                if ($attributes[2]) {
                    return __('Item') . ' ' . ((int) $attributes[1] + 1) . ' ' . __($attributes[2]) . ' ' . (isset($attributes[3]) ? ((int) $attributes[3] + 1) : '');
                }
                return __('Item') . ' ' . ((int) $attributes[1] + 1);
            } elseif ('attachments' == $attributes[0]) {
                return __('attributes.transfer.attachment') . ' ' . ((int) $attributes[1] + 1);
            }
            return $attributes;
        });
    }

    protected function passedValidation()
    {
        $data = $this->validateItem($this->input('items'));
        if (!$this->input('draft') && 'Addition' != $this->input('type') && !get_settings('over_selling')) {
            $error = (new CheckOverSelling())->check($data, $this->input('warehouse_id'));
            if ($error) {
                throw ValidationException::withMessages($error);
            }
        }
        if ($this->ajax()) {
            throw new HttpResponseException(response()->json(['success' => true]));
        }
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['items'] = $this->validateItem($data['items']);
        return $data;
    }

    protected function validateItem($data)
    {
        foreach ($data as &$item) {
            if (isset($item['selected']['variations']) && is_array($item['selected']['variations']) 
                && count($item['selected']['variations']) === 1 && array_key_exists(0, $item['selected']['variations']) 
                && is_null($item['selected']['variations'][0])
            ) {
                $item['selected']['variations'] = [];
            }
        }
        return $data;
    }

    public function attributes()
    {
        return [
            'details'           => __('attributes.transfer.details'),
            'attachments'       => __('attributes.transfer.attachment'),
            'draft'             => __('attributes.transfer.draft'),
            'date'              => __('attributes.transfer.date'),
            'warehouse_id'      => __('attributes.adjustment.warehouse'),
            'reference'         => __('attributes.adjustment.ref'),
            'items'             => __('attributes.transfer.items'),
            'items.*.quantity'  => __('attributes.adjustment.quantity'),
            'items.*.item_id'   => __('attributes.transfer.items'),
            'type'              => __('attributes.adjustment.type'),
        ];
    }
}
