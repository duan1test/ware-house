<div class="mt-6 px-3 w-full lg:w-1/2 variant_items" data-key="{{ $key }}">
    <div class="p-4 bg-gray-100 shadow rounded-md">
        <div class="flex items-start flex-column parent-js-add-option">
            <div class="col-span-12 sm:col-span-4 relative mb-2 flex-1">
                <label class="font-medium text-gray-700">
                    <span> {{ __('common.items.variant_name') . ' ' . $key }} </span>
                </label>
            </div>
            <div class="col-span-12 relative mb-2 w-100">
                <div class="d-flex">
                    <input class="form-control" type="text" onkeyup="checkValue('error-variants.{{ $key }}.name')" id="error-variants.{{ $key }}.name" onkeyup="checkValue('error-variants.'{{ $key }}'.name')" name="variants[{{ $key }}][name]" placeholder="{{ __('common.items.variant_name') . $key }}" value="{{ $name }}" />
                    <div class="rounded d-flex flex-row ms-3" style="background-color: #6c757d; border-color: #6c757d">
                        <button type="button" class="btn btn-secondary js-add-option">
                            <i class="fa-solid fa-plus fs-6"></i>
                        </button>
                        <button type="button" class="btn btn-secondary js-remove-option">
                            <i class="fa-solid fa-minus fs-6"></i>
                        </button>
                    </div>
                </div>
                <div class="error-variants.{{ $key }}.name hidden text-danger" style="margin-top: 5px;"></div>
            </div>
        </div>
        <div class="flex flex-wrap items-start -mx-2 variant-options">
            @php
                echo $variantOptions;
            @endphp
        </div>
    </div>
</div>
