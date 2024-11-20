<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('checkins.index') }}">{{ __('common.checkin.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.checkin.edit') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header flex-column d-flex">
            <div class="d-flex align-items-center">
                <a href="{{ $filters['prv'] ?  url()->previous() : handleRoute(route: 'checkins.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.checkin.edit') }} ({{$checkin->reference}})</h5>
            </div>
            @if ($checkin->deleted_at != null)
                <div class="row">
                    <div class="mt-3">
                        <div class="alert alert-warning d-flex flex-row justify-content-between align-items-center" role="alert">
                            <div class="flex justify-start items-center gap-2">
                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                <span>{{ __('attributes.checkin.soft_delete') }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <form method="POST" id="form-restore-{{ $checkin->id }}" action="{{ route('checkins.restore',  ['checkin' => $checkin->id]) }}" style="margin-right: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" data-id="{{ $checkin->id }}" class="btn btn-warning btn-sm form-restore">
                                        {{ __('common.restore') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <form method="POST" id="form-update" action="{{ route('checkins.update',$checkin->id) }}" style="display: contents;" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">       
                    @csrf
                    @method('PUT')
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-date" class="form-label">{{ __('attributes.transfer.date') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="error-date" onchange="checkValue('error-date')" class="form-control" value="{{ old('date', \Carbon\Carbon::now()->toDateString()) }}" placeholder="{{ __('attributes.transfer.date') }}" name="date">
                            <div class="error-date text-danger error-message hidden"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-reference" class="form-label">
                                {{ __('attributes.checkin.ref') }}
                            </label>
                            <input type="text" onkeyup="checkValue('error-reference')" value="{{ old('reference',$checkin->reference) }}" id="error-reference" class="form-control" placeholder="{{ __('attributes.checkin.ref') }}" name="reference">
                            <div class="error-reference text-danger error-message hidden"></div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-contact_id" class="form-label">{{ __('attributes.checkin.contact') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select name="contact_id" onchange="checkValue('error-contact_id')" id="error-contact_id" class="choices w-full">
                                <option value="" disabled selected hidden>{{ __('attributes.checkin.contact') }}</option>
                                @foreach ($contacts as $contact)
                                    <option {{ old('contact_id',$checkin->contact_id) == $contact->id ? 'selected' : '' }} value="{{ $contact->id }}" >{{ $contact->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-contact_id text-danger error-message hidden"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-warehouse_id" class="form-label">{{ __('attributes.adjustment.warehouse') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select name="warehouse_id" onchange="checkValue('error-warehouse_id')" id="error-warehouse_id" class="choices w-full">
                                @if (auth()->user()->warehouse_id)
                                    @foreach ($warehouses as $warehouse)
                                        @if (auth()->user()->warehouse_id == $warehouse->id)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }} ({{ $warehouse->code }})</option> 
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" disabled selected hidden>{{ __('attributes.adjustment.warehouse') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == old('warehouse_id', $checkin->warehouse_id) ? 'selected' : '' }}>{{ $warehouse->name }} ({{ $warehouse->code }})</option> 
                                    @endforeach
                                @endif
                            </select>
                            <div class="error-warehouse_id text-danger error-message hidden"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="items" class="form-label">{{ __('attributes.transfer.items') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="search" id="items" class="form-control" placeholder="{{ __('attributes.transfer.search_item') }}">
                            
                            <div id="search-results" class="list-group"></div>
                            
                            <div class="alert alert-danger text-danger error-message error-items.* error-items mt-4 w-100 hidden"></div>

                            <div class="card mt-2">
                                <div class="table-responsive">
                                    <table id="items-table" class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <i class="fa-solid fa-trash row-delete-first"></i>
                                                </th>
                                                <th>{{ __('attributes.item.name') }}</th>
                                                <th>{{ __('attributes.item.weight') }}</th>
                                                <th>{{ __('attributes.item.quantity') }}</th>
                                                <th>{{ __('attributes.item.unit') }}</th>
                                            </tr>
                                        </thead>
                                        @foreach ($checkin->items as $item)
                                            @php
                                                $w = $item->item->track_weight;
                                                $v = $item->item->has_variants;
                                                $i = $item->item->id;
                                                $trackWeight = ($w == true && $v == true )
                                                ? "<input value=':weight' type='number' name='items[$i][selected][variations][:variantId][weight]' class='form-control' required>" 
                                                : ($v == false && $w == true ? "<input value=':weight' type='number' name='items[$i][weight]' class='form-control' required>" : '');
                                            @endphp
                                            @if (is_null($item->variations) || $item->variations->isEmpty())
                                                @php
                                                    $trackWeight = str_replace(':weight', $item->weight, $trackWeight);
                                                    $unitHtml = "";
                                                    $unitId = $item->unit_id;
                                                    foreach ($units as $unit ){
                                                        if ($item->item->unit_id == $unit->id) {
                                                            $unitHtml .= '<option value="'.$unit->id.'">'.$unit->name.'</option>';
                                                            if ($unit->subunits != null) {
                                                                foreach ($unit->subunits as $subunit) {
                                                                    $unitHtml .= '<option '.( $subunit->id == $unitId?'selected':'').' value="'.$subunit->id.'">'.$subunit->name.'</option>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @include('pages.checkin.elements.item_alone', ['unitHtml' => $unitHtml, 'quantity' => $item->quantity, 'hasSer' => $item->item->has_serials, 'hasVar' => $item->item->has_variants, 'name' => ($item->item->name . ' (' . $item->item->code . ')'), 'id' => $item->item->id, 'trackWeight' => $trackWeight, 'variantString' => ($item->item->name . ' (' . $item->item->code . ')')])
                                            @else
                                                @include('pages.checkin.elements.item_together_render', ['quantity' => $item->quantity, 'hasSer' => $item->item->has_serials, 'hasVar' => $item->item->has_variants, 'itemId' => $item->item->id, 'htmlVariant' => '', 'name' => ($item->item->name . ' (' . $item->item->code . ')')])
                                                @foreach ($item->variations as $variant)
                                                    @php
                                                        $trackWeight = ($w == true && $v == true )
                                                        ? "<input value=':weight' type='number' name='items[$i][selected][variations][:variantId][weight]' class='form-control' required>" 
                                                        : ($v == false && $w == true ? "<input value=':weight' type='number' name='items[$i][weight]' class='form-control' required>" : '');
                                                        $sel = '';
                                                        $variantName = '';
                                                        foreach ($variant->meta as $key => $value) {
                                                            $sel .= $key . '-' . $value . '-';
                                                            $variantName .= $key . ': <span class="fw-bold">' . $value . '</span> , ';
                                                        }
                                                        $sel = preg_replace('/-$/', '', $sel);
                                                        $variantName = preg_replace('/, $/', '', $variantName);
                                                        $trackWeight = str_replace(':variantId', $variant->pivot->variation_id, $trackWeight);
                                                        $trackWeight = str_replace(':weight', $variant->pivot->weight, $trackWeight);
                                                        $unitHtml = "";
                                                        $unitId = $item->unit_id;
                                                        foreach ($units as $unit ){
                                                            if ($item->item->unit_id == $unit->id) {
                                                                $unitHtml .= '<option value="'.$unit->id.'">'.$unit->name.'</option>';
                                                                if ($unit->subunits != null) {
                                                                    foreach ($unit->subunits as $subunit) {
                                                                        $unitHtml .= '<option '.( $subunit->id == $unitId?'selected':'').' value="'.$subunit->id.'">'.$subunit->name.'</option>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @include('pages.checkin.elements.item_variant_render', ['unitHtml' => $unitHtml, 'quantity' => $variant->pivot->quantity, 'variantId' => $variant->id, 'id' => $item->item->id, 'htmlVariants' => $variantName, 'trackWeight' => $trackWeight, 'variantString' => $sel])
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <tbody class="instruct hidden">
                                            <tr>
                                                <td colspan="5" class="text-black">{{ __('common.checkin.instruct') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="input-container">
                            <label for="formFile" class="form-label">
                                {{ __('attributes.transfer.attachment') }}
                            </label>
                            <input type="file" class="filepond hidden" name="filepond" multiple>
                            <input type="file" id="attachments" name="attachments[]" multiple hidden>
                            @if ($errors->has('attachments.*'))
                                <div class="mt-4 w-100">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->getMessages() as $key => $messages)
                                                @if (Str::startsWith($key, 'attachments'))
                                                    @foreach ($messages as $message)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                        
                            @endif
                            
                            @if (Session::has('download'))
                                <a href="{{ Session::get('download') }}" class="text-danger lh-2">{{ __('common.warehouse.download') }}</a>
                            @endif
                        </div>
                        <div class="input-container">
                            <label for="formFile" class="form-label">
                                {{ __('attributes.transfer.details') }}
                            </label>
                            <textarea name="details" id="details" class="form-control">{{ old('details',$checkin->details) }}</textarea>
                        </div>

                        <div class="form-check form-switch input-container d-flex p-0 align-items-center">
                            <label class="switch">
                                <input type="checkbox" name="draft" {{ old('draft',$checkin->draft) == 1 ? 'checked' : '' }} value="1"  id="draft">
                                <span class="slider round"></span>
                            </label>              
                            <label class="switch-label" for="draft">{{ __('attributes.transfer.draft') }}</label>            
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-footer">
            <div class="text-end d-flex justify-content-between">
                <form id="form-delete" action="{{ !$checkin->deleted_at ? route('checkins.destroy', $checkin->id) : route('checkins.destroy.permanently', $checkin->id) }}" method="post">
                    @csrf
                    @method('delete')
                    @if (!$checkin->deleted_at)
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="false">
                            {{ __('common.delete') }}
                        </button>
                    @else
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="true">
                            {{ __('common.delete') }}
                        </button>
                    @endif
                </form>
                <button type="button" class="btn-update-item btn btn-primary text-capitalize">{{ __('common.save') }}</button>
            </div>
        </div>
    </div>
    
    @push('js')
        <script type="module">
            $(document).ready(function () {
                const attachments = document.querySelector('input[name="filepond"]');

                const pond = FilePond.create(attachments, {
                    labelIdle: `<div class="fz-14"><span class="cursor-pointer link-primary"> {{ __('common.warehouse.chose_file') }} </span> {{ __('common.warehouse.chose_file_end') }} <br> <p class="text-center text-secondary mt-2">{{ __('attributes.transfer.import_file') }}</p></div>`,
                    instantUpload: false,
                    allowMultiple: true,
                    onactivatefile: (file) => {
                        const filePath = file.getMetadata('path');
                        const fileName = file.getMetadata('title');
                        if (filePath) {
                            let urlDownload = "{{ route('download') }}";
                            urlDownload = `${urlDownload}?fp=${filePath}&fn=${fileName}`;
                            window.open(urlDownload, '_blank');
                        }
                    },
                    labelFileLoading: "{{ __('common.loading') }}",
                    labelTapToCancel: "{{ __('common.tap_to_cancel') }}"
                });

                const attachmentArray = @json($checkin->attachments);

                $.each(attachmentArray, function (key, val) {
                    fetch(val.url)
                    .then(response => response.blob())
                    .then(blob => {
                        const file = new File([blob], val.title, { type: val.filetype });

                        pond.addFile(file, {
                            metadata: {
                                size: val.filesize,
                                path: val.filepath,
                                title: val.title
                            },
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching file:', error);
                    });
                });
                
                $('#form-update').on('submit', function(event) {
                    event.preventDefault();
                    
                    const dt = new DataTransfer();
                    pond.getFiles().forEach(fileItem => {
                        const blob = fileItem.file;
        
                        const file = new File([blob], blob.name, {
                            type: blob.type,
                            lastModified: blob.lastModified
                        });
                        
                        dt.items.add(file);
                    });
                    const inputFile = $('#attachments').get(0);
                    inputFile.files = dt.files;

                    this.submit();
                })

                const $searchEL = $('#items');
                const $searchResultsEL = $('#search-results');
                const $itemsTableEL = $('#items-table');
                var objChild = [];
                var objParent = [];
                let clearTimeOut = null;

                const itemsJson = @json($checkin->items);
                $.each(itemsJson, function(key, val) {
                    let itemId = val.item.id;
                    initArrayKey([objChild, objParent], itemId);
                    $.each(val?.variations, function(index, value) {
                        let meta = '';
                        $.each(value.meta, function(id, va) {
                            meta += id + '-' + va + '-';
                        })
                        meta = meta.replace(/-$/, '');
                        objChild[itemId].push(meta);
                    });
                    if(val?.variations == null || val.variations.length == 0) {
                        const itemName = val?.item.name + ' (' + val?.item.code + ')';
                        objParent[itemId].push(itemName);
                    }
                });

                function initArrayKey(obj, key)
                {
                    $.each(obj, function(id, va){
                        if (!va[key]) {
                            va[key] = [];
                        }
                    });

                    return obj;
                }

                // Search items
                $searchEL.on('input', function (e) {
                    const query = e.target.value;
                    
                    if (query == '') {
                        $searchResultsEL.empty().hide();
                        return;
                    }

                    if (clearTimeOut) {
                        clearTimeout(clearTimeOut);
                    }

                    clearTimeOut = setTimeout(function () {
                        $.ajax({
                            url: "{{ route('items.search') }}",
                            type: "POST",
                            data: {
                                q: query,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                $searchResultsEL.empty().show();
                                if (data.length > 0) {
                                    data.forEach(function (item) {
                                        const isEmptyVariant = emptyVariant(item.variants);
                                        
                                        const result = `<div class="list-group-item" data-unitid="${item.unit_id}" data-variant="${isEmptyVariant}" data-hasvariants="${item.has_variants}" data-hasserials="${item.has_serials}" data-id="${item.id}" data-weight="${item.track_weight}" data-hasvariant="${item.has_variants}">${item.name} (${item.code})</div>`;
                                        $searchResultsEL.append(result);
                                    });
                                } else {
                                    $searchResultsEL.append('<div class="list-group-item no-data">{{ __('common.no_data') }}</div>');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error('Error:', textStatus, errorThrown);
                            }
                        });
                    }, 300);
                });

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

                $('.btn-update-item').on('click', function() {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('checkins.update',$checkin->id) }}",
                        data: $('#form-update').serialize(),
                        success: function(response){
                            if (response.success) {
                                $('#form-update').submit();
                            }
                        },
                        error: function(error) {
                            var errors = error.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    if(key.slice(0,6) == 'items.'){
                                        $('[class *= "error-items"]').text(value[0]);
                                        $('[class *= "error-items"]').show();
                                    }else{
                                        $('[class *= "error-' + key + '"]').text(value[0]);
                                        $('[class *= "error-' + key + '"]').show();
                                        $('[id *= "error-' + key + '"]').addClass('is-invalid');
                                    }
                                });
                            }
                        }
                    });
                });

                function emptyVariant(value)
                {
                    if (value === null || value.length == 0) {
                        return false;
                    }
                    const baseType = typeof value;
                    if (["object"].includes(baseType)) {
                        return true;
                    }
                    return false;
                }

                $(document).on('click', function (e) {
                    if (!$(e.target).closest('#items, #search-results').length) {
                        $searchResultsEL.hide();
                    }
                });

                $(document).on('click', '.list-group-item', function () {
                    if ($(this).hasClass('no-data')) {
                        return;
                    }
                    $('.instruct').hide(); 
                    let row = '';
                    const itemId = $(this).data('id');
                    const isWeight = $(this).data('weight') == true ? '1' : '0';
                    const hasVariant = $(this).data('hasvariants') == true ? '1' : '0';
                    const hasSerial = $(this).data('hasserials') == true ? '1' : '0';
                    const isVariants = $(this).data('variant');
                    const itemName = $(this).text();
                    const unitId = $(this).data('unitid');
                    const units = @json($units);
                    var unitHtml = ``;

                    $.each(units, function(key,val){
                        if (val.id == unitId) {
                            unitHtml += ` <option value="${ val.id }">${ val.name }</option>`;
                            if (val.subunits != null) {
                                $.each (val.subunits ,function(key,item){
                                    unitHtml += `<option ${item.id == unitId?'selected':''} value="${item.id}">${item.name}</option>`;
                                });
                            }
                        }
                    });
                    
                    initArrayKey([objChild, objParent], itemId);

                    var trackWeight = (isWeight == '1' && hasVariant == '1' )
                    ? `<input value="1" type="number" name="items[${itemId}][selected][variations][:variantId][weight]" class="form-control" required>` 
                    : (hasVariant == '0' && isWeight == '1' ? `<input value="1" type="number" name="items[${itemId}][weight]" class="form-control" required>` : '');
                    
                    if($(this).data('hasvariant') && isVariants) {
                        if(objParent[itemId]) {
                            $(`#item-${itemId}`).remove();
                        }
                        
                        $.ajax({
                            url: "{{ route('items.search') }}",
                            type: "POST",
                            data: {
                                id: $(this).data('id'),
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                const variant = data[0]?.variants;
                                const variations = data[0]?.variations;
                                const isTrachWeight = data[0].track_weight ? 1 : 0;
                                
                                let childVariant = '';
                                $.each(variant, function(key, value) {
                                    let options = '';
                                    $.each(value.option, function (index, val) {
                                        options += `<option value="${val}">${val}</option>`;
                                    });
                                    childVariant += `@include('pages.checkin.elements.child_variant', ['variantOption' => '${options}', 'name' => '${value.name}'])`;
                                });
                                const html = `@include('pages.checkin.elements.alert_variant', ['childVariant' => '${childVariant}'])`;
                                Swal.fire({
                                    title: "{{ __('common.sweat_alert.sweat_alert') }}",
                                    html: html,
                                    showCancelButton: true,
                                    cancelButtonText: "{{ __('common.sweat_alert.cancel') }}",
                                    confirmButtonText: "{{ __('common.sweat_alert.select') }}",
                                    showLoaderOnConfirm: true,
                                    reverseButtons: true,
                                    customClass: {
                                        title: 'd-flex',
                                        actions: 'w-100 justify-content-end pe-4'
                                    },
                                    preConfirm: async () => {
                                        let row = '';
                                        let sel = '';
                                        let htmlVariants = '';
                                        let objMeta = {};
                                        let variantId = '';
                                        const child = $('.child-variant');
                                        $.each(child, function(key, value) {
                                            sel += `${$(this).data('name')}-${$(this).val()}-`;
                                            htmlVariants += `${$(this).data('name')}: <span class="fw-bold">${$(this).val()}</span> , `;
                                            objMeta[$(this).data('name')] = $(this).val();
                                        });
                                        $.each(variations, function(key, val){
                                            const compare = areObjectsEqual(val.meta, objMeta);
                                            if(compare){
                                                variantId = val.id;
                                                return false;
                                            }
                                        });
                                        
                                        trackWeight = trackWeight.replace(':variantId', variantId);
                                        sel = sel.replace(/-$/, '');
                                        
                                        if (!objChild[itemId].includes(sel) && !$(`#item-${itemId}`).length) {
                                            let a= ''; let b = '';
                                            const variants = `@include('pages.checkin.elements.item_variant', ['unitHtml' => '${unitHtml}','variantId' => '${variantId}', 'id' => '${itemId}', 'htmlVariants' => '${htmlVariants}', 'trackWeight' => '${trackWeight}', 'variantString' => '${sel}'])`;
                                            row += `@include('pages.checkin.elements.item_together', ['trackWeight' => '${isTrachWeight}', 'hasSer' => '${hasSerial}', 'hasVar' => '${hasVariant}', 'itemId' => '${itemId}', 'htmlVariant' => '${variants}', 'name' => '${itemName}'])`;
                                            objChild[itemId].push(sel);
                                        }
                                        if(!objChild[itemId].includes(sel) && $(`#item-${itemId}`).length) {
                                            row += `@include('pages.checkin.elements.item_variant', ['unitHtml' => '${unitHtml}','variantId' => '${variantId}', 'id' => '${itemId}', 'htmlVariants' => '${htmlVariants}', 'trackWeight' => '${trackWeight}', 'variantString' => '${sel}'])`;
                                            objChild[itemId].push(sel);
                                        }
                                        return row;
                                    },
                                    allowOutsideClick: () => !Swal.isLoading()
                                })
                                    .then((result) => {
                                    if (result.isConfirmed && !$(`#item-${itemId}`).length) {
                                        $itemsTableEL.append(result.value);
                                    } else {
                                        $(`#item-${itemId}`).append(result.value);
                                    }
                                    checkItems();
                                    $searchResultsEL.hide();
                                    $searchEL.val('');
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error('Error:', textStatus, errorThrown);
                            }
                        });
                    } else {
                        if(!objParent[itemId].includes(`${itemName}`)) {
                            row += `@include('pages.checkin.elements.item_alone', ['unitHtml' => '${unitHtml}','hasSer' => '${hasSerial}', 'hasVar' => '${hasVariant}', 'name' => '${itemName}', 'id' => '${itemId}', 'trackWeight' => '${trackWeight}', 'variantString' => '${itemName}'])`;
                            $itemsTableEL.append(row);
                            objParent[itemId].push(`${itemName}`);
                            checkItems();
                        }
                        $searchResultsEL.hide();
                        $searchEL.val('');
                    }
                });

                function areObjectsEqual(obj1, obj2) {
                    const keys1 = Object.keys(obj1);
                    const keys2 = Object.keys(obj2);

                    if (keys1.length !== keys2.length) {
                        return false;
                    }

                    for (let key of keys1) {
                        if (obj1[key] !== obj2[key]) {
                            return false;
                        }
                    }

                    return true;
                }

                $(document).on('click', '.row-delete', function () {
                    const itemToRemove = $(this).closest('tr').data('variant');
                    const itemId = $(this).closest('tr').data('id');
                    const lengthChild = $(`.id-delete-${itemId}`).length;
                    
                    const indexChild = Array.isArray(objChild[itemId]) == true ? objChild[itemId].indexOf(itemToRemove) : -1;
                    const indexParent = Array.isArray(objParent[itemId]) == true ? objParent[itemId].indexOf(itemToRemove) : -1;
                    
                    if (indexChild !== -1) {
                        objChild[itemId].splice(indexChild, 1);
                    }
                    if (indexParent !== -1) {
                        objParent[itemId].splice(indexParent, 1);
                    }
                    if(lengthChild == 1) {
                        $(`#item-${itemId}`).remove();
                    } 
                    $(this).closest('tr').remove();
                    checkItems();
                });

                // Handle file input
                const dropZone = $('.drop-zone');
                const fileInput = $('#formFile');
                const fileNameSpan = dropZone.find('.file-name p');

                const updateFileName = (files) => {
                    if (files.length) {
                        const fileName = files[0].name;
                        fileNameSpan.text(fileName);
                    }
                };

                dropZone.on('dragover', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.addClass('dragover');
                });

                dropZone.on('dragleave', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.removeClass('dragover');
                });

                $('.link-primary').on('click', function(e){
                    e.stopPropagation();
                })

                dropZone.on('drop', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.removeClass('dragover');
                    updateFileName(e.originalEvent.dataTransfer.files);
                    fileInput[0].files = e.originalEvent.dataTransfer.files;
                });

                fileInput.on('change', function (e) {
                    updateFileName(e.target.files);
                });

                dropZone.on('click', function (e) {
                    if (e.target !== fileInput[0]) {
                        fileInput.trigger('click');
                    }
                });

                function checkItems(){
                    let itemCount = $('tbody').length;       
                    if(itemCount == 1){
                        $('.instruct').show();
                    }else{
                        $('.instruct').hide();
                        $('.error-items').hide();
                    }
                }

                $('.form-restore').on('click', function(){
                    const id = $(this).data('id');
                    Swal.fire({
                        title: '{{ __('common.confirm_restore') }}',
                        showCancelButton: true,
                        icon: "warning",
                        reverseButtons: true,
                        confirmButtonText: "{{ __('common.swal_button.confirm') }}",
                        cancelButtonText: "{{ __('common.swal_button.cancel') }}",
                        customClass: {
                            title: 'd-flex',
                            actions: 'w-100 justify-content-center'
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(`#form-restore-${id}`).submit();
                        }
                    });
                });
            });
        </script>
        <script>
            function checkValue(class_name){
                $('[class *= "' + class_name + '"]').hide();
                $('[id *= "' + class_name + '"]').removeClass('is-invalid');
            }
        </script>
    @endpush
</x-app-layout>

