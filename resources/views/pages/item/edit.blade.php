<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">{{ __('common.items.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.items.update') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ $filters['prv'] ?  url()->previous() : handleRoute(route: 'items.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.items.update') }} ({{$item->code}})</h5>
            </div>
            @if ($item->deleted_at)
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center alert alert-warning" role="alert">
                            <div class="flex justify-start items-center gap-2">
                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                <span>{{ __('attributes.item.soft_delete') }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <form method="POST" action="{{ route('items.restore',  ['item' => $item->id]) }}" style="margin-right: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        {{ __('common.restore') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('items.update', $item->id) }}" method="post" id="form-update-item"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mb-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-name" class="form-label">
                                {{ __('attributes.item.name') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="name" id="error-name" onkeyup="checkValue('error-name')" type="text" value="{{ old('name', $item->name) }}" class="form-control" placeholder="{{ __('attributes.item.name') }}">
                            <div class="text-danger error-message error-name hidden" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-code" class="form-label">
                                {{ __('attributes.item.code') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="code" id="error-code" onkeyup="checkValue('error-code')" type="text" value="{{ old('code', $item->code) }}" class="form-control" placeholder="{{ __('attributes.item.code') }}">
                            <div class="error-code hidden text-danger error-message" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-symbology" class="form-label">
                                {{ __('attributes.item.barcode_symbology') }}
                            </label>
                            @if (count($barcodes) == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="symbology" class="form-control">
                            @else
                                <select name="symbology" id="error-symbology" onchange="checkValue('error-symbology')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($barcodes as $each)
                                        <option {{ old('symbology', $item->symbology) == $each->id ? 'selected' : '' }} value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="error-symbology hidden text-danger error-message" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-sku" class="form-label">
                                {{ __('attributes.item.sku') }}
                            </label>
                            <input name="sku" type="text" id="error-sku" onkeyup="checkValue('error-sku')" value="{{ old('sku', $item->sku) }}" class="form-control" placeholder="{{ __('attributes.item.sku') }}">
                            <div class="text-danger error-sku hidden error-message" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-details" class="form-label">
                                {{ __('attributes.item.details') }}
                            </label>
                            <textarea name="details" id="error-details" onkeyup="checkValue('error-details')" class="form-control">{{ old('details', $item->details) }}</textarea>
                            <div class="error-details hidden error-message text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <div class="form-check">
                                <input {{ old('track_weight', $item->track_weight) ? 'checked' : '' }} name="track_weight" value="1" class="form-check-input ml-0" type="checkbox" id="check_track_weight">
                                <label class="form-check-label ml-2" for="check_track_weight">{{ __('attributes.item.track_weight') }}</label>
                            </div>

                            <div class="form-check mt-3">
                                <input {{ old('track_quantity', $item->track_quantity) ? 'checked' : '' }} name="track_quantity" value="1" class="form-check-input ml-0" type="checkbox" id="check_track_quantity">
                                <label class="form-check-label ml-2" for="check_track_quantity">{{ __('attributes.item.track_quantity') }}</label>
                            </div>

                            <div class="custom-collapse collapse mt-3 {{ old('track_quantity', $item->track_quantity) ? 'show' : '' }}" id="collapseTrackQuantity">
                                <label for="error-alert_quantity" class="form-label">
                                    {{ __('attributes.item.alert_quantity_stock_on') }}
                                </label>
                                <input name="alert_quantity" id="error-alert_quantity" onkeyup="checkValue('error-alert_quantity')" type="number" value="{{ old('alert_quantity', $item->alert_quantity) }}" class="form-control alert_quantity" placeholder="{{ __('attributes.item.alert_quantity_stock_on') }}" >
                                <div class="error-alert_quantity hidden text-danger" style="margin-top: 5px;"></div>
                            </div>

                            <div class="form-check mt-3">
                                <input {{ old('has_variants', $item->has_variants) ? 'checked' : '' }} name="has_variants" value="1" class="form-check-input ml-0" type="checkbox" id="check_has_variants">
                                <label class="form-check-label ml-2" for="check_has_variants">{{ __('attributes.item.has_variants') }}</label>
                                <div class="text-yellow-600 ms-2">{{ __('attributes.item.variant_alert') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-category_id" class="form-label">
                                {{ __('attributes.item.category') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            @if (count($categories) == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="category_id"
                                    class="form-control">
                            @else
                                <select name="category_id" id="error-category_id" onchange="checkValue('error-category_id')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($categories as $each)
                                        @if (!$each->parent_id)
                                            <option {{ old('category_id', $item->category_id) == $each->id ? 'selected' : '' }} value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                            <div class="error-category_id hidden text-danger error-message" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-unit_id" class="form-label">
                                {{ __('attributes.item.unit') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            @if ($units->count() == 0)
                                <input placeholder="{{ __('common.no_data') }}" readonly type="text" name="unit_id"
                                    class="form-control">
                            @else
                                <select name="unit_id" id="error-unit_id" onchange="checkValue('error-unit_id')" class="form-select form-control choices">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($units as $each)
                                        <option {{ old('unit_id', $item->unit_id) == $each->id ? 'selected' : '' }} value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="error-unit_id hidden text-danger error-message" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-rack_location" class="form-label">
                                {{ __('attributes.item.rack_location') }}
                            </label>
                            <input name="rack_location" id="error-rack_location" onkeyup="checkValue('error-rack_location')" type="text" value="{{ old('rack_location', $item->rack_location) }}" class="form-control" placeholder="{{ __('attributes.item.rack_location') }}">
                            <div class="error-rack_location hidden error-message text-danger" style="margin-top: 5px;">\</div>
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.item.photo') }}
                            </label>
                            <div class="input-group cursor-pointer custom-input-file">
                                <span class="input-group-text">{{ __('common.select_file') }}</span>
                                <div class="form-control file-message" data-nofile="{{ __('common.no_file_selected') }}">
                                    {{ __('common.no_file_selected') }}
                                </div>
                            </div>
                            <input name="photo" type="file" value="{{ old('photo', $item->photo) }}" id="formFile"
                                class="d-none" accept=".jpg, .jpeg, .png">
                            <input type="hidden" name="photo_removed" id="photo_removed" value="0">
                            <div class="error-photo text-danger" style="margin-top: 5px;"></div>
                        </div>

                        <div class="input-container">
                            <p class="form-label">{{ __('attributes.warehouse.preview_logo') }}</p>
                            <div class="img-container d-flex justify-content-center">
                                <div class="img-preview">
                                    @if (isset($item->photo))
                                        <img id="previewImage" src="{{ '/storage/'. $item->photo }}" alt="">
                                        <button type="button" class="btn-remove-image">
                                            <i class='bx bxs-x-circle'></i>
                                        </button>
                                    @else
                                        <img id="previewImage" src="{{ asset('assets/images/icons/defautl-img.png') }}" alt="">
                                        <button type="button" class="btn-remove-image d-none">
                                            <i class='bx bxs-x-circle'></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="variant-elements">
                        <div class="input-container">
                            <div class="mt-3" id="collapse_variant">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <span class="fw-bold fs-5">{{ __('common.items.variant') }}</span>
                                        <div class="rounded" style="background-color: #198fed; border-color: #198fed;">
                                            <button class="btn btn-info js-add-variant" type="button"><i class="fa-solid fa-plus fs-6"></i></button>
                                            <button class="btn btn-info js-remove-variant" type="button"><i class="fa-solid fa-minus fs-6"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="flex flex-wrap items-start -mx-3" id="variant_list">
                                            @if (!empty(old('variants', $item->variants)) && is_array(old('variants', $item->variants)))
                                                @foreach (old('variants', $item->variants) as $key => $variant)
                                                    @php
                                                        $htmlOptions = '';
                                                        foreach ($variant['option'] as $index => $option) {
                                                            $htmlOptions .= view('pages.item.elements.variant_option', ['key' => ($index + 1), 'keyVariant' => $key, 'name' => $option? $option:''])->render();
                                                        }
                                                    @endphp
                                                    @include('pages.item.elements.variant_edit', ['key' => $key, 'variantOptions' => $htmlOptions, 'name' => $variant['name']])
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
            <div class="text-end d-flex justify-content-between">
                <form action="{{ route('items.destroy', $item->id) }}" method="post">
                    @csrf
                    @method('delete')
                    @if (!$item->deleted_at)
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="false">
                            {{ __('common.delete') }}
                        </button>
                    @else
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="true">
                            {{ __('common.delete') }}
                        </button>
                    @endif
                </form>
                <button class="btn-update-item btn btn-primary py-2">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function () {
                
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
                    $("#photo_removed").val(1);
                    $(".btn-remove-image").addClass("d-none");
                });

                displayAlertQuantity();

                // update
                $('.btn-update-item').on('click', function() {
                    $.ajax({ 
                        type: "POST",
                        url: "{{ route('items.update', $item->id) }}",
                        data: $('#form-update-item').serialize(),
                        success: function(response){
                            $('#form-update-item').submit();
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

                // delete
                $('.btn-delete-item').click(function(e) {
                    const form = this.closest('form');
                    let button = $(this).closest('button[type="button"]');
                    let isPermanentDelete = button.data('permanent');

                    let htmlMessage = isPermanentDelete 
                        ? "{{ __('common.alert_permanent_delete') }}" 
                        : "";

                    showConfirm(`{{ __('common.confirm_delete') }}`, function() {
                        form.submit();
                    }, {
                        icon: "warning",
                        html: htmlMessage,
                        reverseButtons: true,
                        confirmButtonText: "{{ __('common.swal_button.confirm') }}",
                        cancelButtonText: "{{ __('common.swal_button.cancel') }}",
                    });
                });

                $('[name="track_quantity"]').on('change', function () {
                    displayAlertQuantity();
                });

                $('.custom-input-file').on('click', function () {
                   $(this).parent().find('input[type="file"]').trigger('click');
                });

                $('input[type="file"]').on('change', function () {
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
                if($('[name="has_variants"]').is(':checked')) {
                    collapseVariant.show();
                }
                else {
                    collapseVariant.hide();
                }
            }

            $('#check_has_variants').on('change', async () => {
                displayCollapseVariant();
                const isExist = $('.variant_items').length;
                if(isExist == 0) {
                    appendVariantItem();
                }
            });

            function appendVariantItem()
            {
                const key = $('.variant_items').last().data('key') || 0;
                const html = `@include('pages.item.elements.variant', ['key' => '${key + 1}'])`;
                $('#variant_list').append(html);
            }

            $('.js-add-variant').on('click', () => {
                appendVariantItem();
            });

            $('.js-remove-variant').on('click', () => {
                $('.variant_items').last().remove();
            });

            $(document).on('click', '.js-add-option', function () {
                let parentContainer = $(this).closest('.parent-js-add-option');
                let keyVariantItems = $(this).closest('.variant_items').data('key');
                let variantOptions = parentContainer.siblings('.variant-options');
                const key = variantOptions.find('.variant-option').last().data('key') || 0;
                const html = `@include('pages.item.elements.variant_option', ['key' => '${key + 1}', 'keyVariant' => '${keyVariantItems}'])`;
                variantOptions.append(html);
            });

            $(document).on('click', '.js-remove-option', function () {
                let parentContainer = $(this).closest('.parent-js-add-option');
                let variantOptions = parentContainer.siblings('.variant-options');
                variantOptions.find('.variant-option').last().remove();
            });

            $('.alert_quantity').on('change keyup', function (){
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
