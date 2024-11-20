<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.items.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.items.create') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('items.store') }}" method="post" id="form-create-item" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.name') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="name" id="error-name" onkeyup="checkValue('error-name')" type="text" value="{{ old('name') }}" class="form-control" placeholder="{{ __('attributes.item.name') }}">
                            <div class="error-name hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.code') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="code" id="error-code" onkeyup="checkValue('error-code')" type="text" value="{{ old('code') }}" class="form-control" placeholder="{{ __('attributes.item.code') }}">
                            <div class="error-code hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.barcode_symbology') }}
                            </label>
                            @if (count($barcodes) == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="symbology" class="form-control">
                            @else
                                <select name="symbology" id="error-symbology" onchange="checkValue('error-symbology')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($barcodes as $item)
                                        <option {{ old('symbology') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="text-danger error-symbology hidden" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.sku') }}
                            </label>
                            <input name="sku" id="error-sku" onchange="checkValue('error-sku')" type="text" value="{{ old('sku') }}" class="form-control" placeholder="{{ __('attributes.item.sku') }}">
                            <div class="error-sku hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.details') }}
                            </label>
                            <textarea name="details" id="error-details" onchange="checkValue('error-details')" class="form-control">{{ old('details') }}</textarea>
                            <div class="error-details hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container" style="min-height: auto">
                            <div class="form-check">
                                <input {{ old('track_weight') ? 'checked' : '' }} name="track_weight" value="1" class="form-check-input ml-0" type="checkbox" id="check_track_weight">
                                <label class="form-check-label ml-2" for="check_track_weight">{{ __('attributes.item.track_weight') }}</label>
                            </div>
                        </div>

                        <div class="input-container" style="min-height: auto">
                            <div class="form-check mt-3">
                                <input {{ old('track_quantity') || !old('isChecked') ? 'checked' : '' }} name="track_quantity" value="1" class="form-check-input ml-0" type="checkbox" id="check_track_quantity">
                                <input type="text" value="1" hidden name="isChecked">
                                <label class="form-check-label ml-2" for="check_track_quantity">{{ __('attributes.item.track_quantity') }}</label>
                            </div>

                            <div class="custom-collapse collapse mt-3 {{ old('track_quantity') ? 'show' : '' }}" id="collapseTrackQuantity">
                                <label class="form-label">
                                    {{ __('attributes.item.alert_quantity_stock_on') }}
                                </label>
                                <input name="alert_quantity" type="number" id="error-alert_quantity" onclick="checkValue('error-alert_quantity')" value="{{ old('alert_quantity') }}" class="form-control alert_quantity" placeholder="{{ __('attributes.item.alert_quantity_stock_on') }}">
                                <div class="text-danger error-alert_quantity hidden" style="margin-top: 5px;"></div>
                            </div>
                        </div>

                        <div class="input-container" style="min-height: auto">
                            <div class="form-check">
                                <input name="has_variants" value="1" class="form-check-input ml-0" {{old('has_variants')?'checked':''}} type="checkbox" id="check_has_variants">
                                <label class="form-check-label ml-2" for="check_has_variants">{{ __('attributes.item.has_variants') }}</label>
                                <div class="text-yellow-600 ms-2">{{ __('attributes.item.variant_alert') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.category') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            @if (count($categories) == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="category_id" class="form-control">
                            @else
                                <select name="category_id" id="error-category_id" onchange="checkValue('error-category_id')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($categories as $item)
                                        @if (!$item->parent_id)
                                            <option {{ old('category_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                            <div class="error-category_id hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.unit') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            @if ($units->count() == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="unit_id" class="form-control">
                            @else
                                <select name="unit_id" id="error-unit_id" onchange="checkValue('error-unit_id')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($units as $item)
                                        <option {{ old('unit_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="error-unit_id hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.rack_location') }}
                            </label>
                            <input name="rack_location" id="error-rack_location" onkeyup="checkValue('error-rack_location')" type="text" value="{{ old('rack_location') }}" class="form-control" placeholder="{{ __('attributes.item.rack_location') }}">
                            <div class="error-rack_location text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.photo') }}
                            </label>
                            <div class="input-group cursor-pointer custom-input-file">
                                <span class="input-group-text">{{ __('common.select_file') }}</span>
                                <div class="form-control file-message"
                                    data-nofile="{{ __('common.no_file_selected') }}">
                                    {{ __('common.no_file_selected') }}
                                </div>
                            </div>
                            <input name="photo" type="file" value="{{ old('photo') }}" id="formFile" class="d-none" accept=".jpg, .jpeg, .png">
                            <div class="error-photo hidden text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <p class="form-label">{{ __('attributes.warehouse.preview_logo') }}</p>
                            <div class="img-container d-flex justify-content-center">
                                <div class="img-preview position-relative">
                                    <img id="previewImage" src="{{ getDefaultWarehouseImage() }}" alt="">
                                    <button type="button" class="btn-remove-image d-none">
                                        <i class='bx bxs-x-circle'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="variant-elements">
                        <div class="input-container" style="min-height: auto">
                            <div class="mt-3" id="collapse_variant">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="fw-bold fs-5">{{ __('common.items.variant') }}</span>
                                        <div class="rounded"
                                            style="background-color: #198fed; border-color: #198fed;">
                                            <button class="btn btn-info js-add-variant" type="button"><i class="fa-solid fa-plus fs-6"></i></button>
                                            <button class="btn btn-info js-remove-variant" type="button"><i class="fa-solid fa-minus fs-6"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        {{-- Variant list --}}
                                        <div class="flex flex-wrap items-start -mx-3" id="variant_list">
                                            @if (!empty(old('variants', $item->variants)) && is_array(old('variants', $item->variants)))
                                                @foreach (old('variants') as $key => $variant)
                                                    @php
                                                        $htmlOptions = '';
                                                        foreach ($variant['option'] as $index => $option) {
                                                            $htmlOptions .= view('pages.item.elements.variant_option', ['key' => $index + 1,'keyVariant' => $key,'name' => $option?$option:'',])->render();
                                                        }
                                                    @endphp
                                                    @include('pages.item.elements.variant_edit', ['key' => $key,'variantOptions' => $htmlOptions,'name' => $variant['name'],
                                                    ])
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-item btn btn-primary py-2">
                    {{ __('common.create') }}
                </button>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(() => {
                $('#formFile').change(function(e) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('.img-preview img').attr('src', e.target.result);
                        $('.img-preview').show();
                        $(".btn-remove-image").removeClass("d-none")
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $('.btn-remove-image').on('click', function() {
                    $('#previewImage').attr('src', '{{ getDefaultWarehouseImage() }}');
                    var fileMessage = $('.custom-input-file .file-message');
                    fileMessage.html(fileMessage.data('nofile')); 
                    $('#formFile').val('');
                    $(".btn-remove-image").addClass("d-none")
                });

                displayAlertQuantity();

                $('.btn-store-item').on('click', function() {
                    $.ajax({ 
                        type: "POST",
                        url: "{{ route('items.store') }}",
                        data: $('#form-create-item').serialize(),
                        success: function(response){
                            $('#form-create-item').submit();
                        },
                        error: function(error) {
                            var errors = error.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $('[class *= "error-' + key + '"]').text(value[0]);
                                    $('[class *= "error-' + key + '"]').show();
                                    $('[id *= "error-' + key + '"]').addClass('is-invalid');
                                });
                            }
                        }
                    });
                });

                $('[name="track_quantity"]').on('change', function() {
                    displayAlertQuantity();
                });

                $('.custom-input-file').on('click', function() {
                    $(this).parent().find('input[type="file"]').trigger('click');
                });

                $('input[type="file"]').on('change', function() {
                    const fileMessage = $('.custom-input-file .file-message');

                    if (this.files.length > 0) {
                        fileMessage.html(this.files[0].name);
                        return;
                    }

                    fileMessage.html(fileMessage.data('nofile'));
                });

                function displayAlertQuantity() {
                    const collapseTrackQuantity = $('#collapseTrackQuantity');
                    if ($('[name="track_quantity"]').is(':checked')) {
                        collapseTrackQuantity.addClass('show');
                    } else {
                        collapseTrackQuantity.removeClass('show');
                    }
                }
            });

            displayCollapseVariant();

            function displayCollapseVariant() {
                const collapseVariant = $('#collapse_variant');
                if ($('[name="has_variants"]').is(':checked')) {
                    collapseVariant.show();
                } else {
                    collapseVariant.hide();
                }
            }

            $('#check_has_variants').on('change', async () => {
                displayCollapseVariant();
                const isExist = $('.variant_items').length;
                if (isExist == 0) {
                    appendVariantItem();
                }
            });

            $('.js-add-variant').on('click', () => {
                appendVariantItem();
            });

            function appendVariantItem() {
                const key = $('.variant_items').last().data('key') || 0;
                const html = `@include('pages.item.elements.variant', ['key' => '${key + 1}'])`;
                $('#variant_list').append(html);
            }

            $('.js-remove-variant').on('click', () => {
                $('.variant_items').last().remove();
            });

            $(document).on('click', '.js-add-option', function() {
                let parentContainer = $(this).closest('.parent-js-add-option');
                let keyVariantItems = $(this).closest('.variant_items').data('key');
                let variantOptions = parentContainer.siblings('.variant-options');
                const key = variantOptions.find('.variant-option').last().data('key') || 0;
                const html = `@include('pages.item.elements.variant_option', [
                    'key' => '${key + 1}',
                    'keyVariant' => '${keyVariantItems}',
                ])`;
                variantOptions.append(html);
            });

            $(document).on('click', '.js-remove-option', function() {
                let parentContainer = $(this).closest('.parent-js-add-option');
                let variantOptions = parentContainer.siblings('.variant-options');
                variantOptions.find('.variant-option').last().remove();
            });

            $('.alert_quantity').on('change keyup', function() {
                const num = $(this).val();
                const regex = /^-?\d{1,11}(\.\d{0,2})?$/;
                if (num.startsWith('-') && num.length > 1) {
                    if (!/^\d/.test(num.substring(1))) {
                        num = '-' + num.substring(1).replace(/[^0-9.]/g, '');
                    }
                } else {
                    num = num.replace(/[^0-9.-]/g, '');
                }
                if (regex.test(num)) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).val(num.slice(0, -1));
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            })
        </script>
        <script>
            function checkValue(class_name){
                    $('[class *= "' + class_name + '"]').hide();
                    $('[id *= "' + class_name + '"]').removeClass('is-invalid');
                }
        </script>
    @endpush
</x-app-layout>
