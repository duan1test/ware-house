<div class="mt-4 px-2 w-1/2 variant-option" data-key="{{ $key }}">
    <div class="col-span-6 sm:col-span-4 relative mb-2">
    <label class="font-medium text-gray-700">
            <span>{{ __('common.items.option') . ' ' . $key }}</span>
        </label>
        <input class="form-control block w-full mt-1" onkeyup="checkValue('error-variants.{{ $keyVariant }}.option.{{ $key }}')" id="error-variants.{{ $keyVariant }}.option.{{ $key }}" onkeyup="checkValue('error-variants.{{ $keyVariant }}.option.{{ $key }}')" name="variants[{{ $keyVariant }}][option][{{ $key }}]" type="text" placeholder="{{ __('common.items.option') . ' ' . $key }}" value="{{ $name ?? '' }}">
          <div class="error-variants.{{ $keyVariant }}.option.{{ $key }} hidden text-danger" style="margin-tp: 5px;"></div>
    </div>
</div>
