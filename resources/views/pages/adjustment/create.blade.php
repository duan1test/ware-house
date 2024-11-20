<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.adjustment.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.adjustment.create') }}</h5>
        </div>
        <form method="POST" action="{{ route('adjustments.store') }}" id="form-create" style="display: contents;" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">           
                    @csrf
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
                                {{ __('attributes.adjustment.ref') }}
                            </label>
                            <input type="text" onkeyup="checkValue('error-reference')" value="{{ old('reference') }}" id="error-reference" class="form-control" placeholder="{{ __('attributes.adjustment.ref') }}" name="reference">
                            <div class="error-reference text-danger error-message hidden"></div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-type" class="form-label">{{ __('attributes.adjustment.type') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select name="type" id="error-type" onchange="checkValue('error-type')" class="choices w-full">
                                <option value="" disabled selected hidden>{{ __('attributes.adjustment.type') }}</option>
                                <option value="Damage" >{{ __('common.adjustment.damage') }}</option>
                                <option value="Addition" >{{ __('common.adjustment.addition') }}</option>
                                <option value="Subtraction" >{{ __('common.adjustment.subtraction') }}</option>
                            </select>
                            <div class="error-type text-danger error-message hidden"></div>
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
                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == old('warehouse_id') ? 'selected' : '' }}>{{ $warehouse->name }} ({{ $warehouse->code }})</option> 
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
                                        <tbody class="instruct">
                                            <tr>
                                                <td colspan="5" class="text-black">{{ __('common.transfer.instruct') }}</td>
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
                            <input type="file" class="filepond w-100 hidden" name="filepond" multiple>
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
                            <textarea name="details" id="details" class="form-control">{{ old('details') }}</textarea>
                        </div>

                        <div class="form-check form-switch input-container d-flex p-0 align-items-center">
                            <label class="switch">
                                <input type="checkbox" name="draft" {{ old('draft') == 1 ? 'checked' : '' }} value="1"  id="draft">
                                <span class="slider round"></span>
                            </label>              
                            <label class="switch-label" for="draft">{{ __('attributes.transfer.draft') }}</label>            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end m-3">
                    <button type="button" class="btn-create-item btn btn-primary text-capitalize">{{ __('common.create') }}</button>
                </div>
            </div>
        </form>

    </div>
    
    @push('js')
        <script type="module">
            $(document).ready(function () {
                const attachments = document.querySelector('input[name="filepond"]');

                const pond = FilePond.create(attachments, {
                    labelIdle: `<div class="fz-14"><span class="cursor-pointer link-primary"> {{ __('common.warehouse.chose_file') }} </span> {{ __('common.warehouse.chose_file_end') }} <br> <p class="text-center text-secondary mt-2">{{ __('attributes.transfer.import_file') }}</p></div>`,
                    instantUpload: false,
                    allowMultiple: true,
                });
                
                $('#form-create').on('submit', function(event) {
                    event.preventDefault();

                    const dt = new DataTransfer();
                    pond.getFiles().forEach(fileItem => {
                        dt.items.add(fileItem.file);
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
                    
                    var trackWeight = (isWeight == '1' && hasVariant == '1' )
                    ? `<input value="1" type="number" name="items[${itemId}][selected][variations][:variantId][weight]" class="form-control" required>` 
                    : (hasVariant == '0' && isWeight == '1' ? `<input value="1" type="number" name="items[${itemId}][weight]" class="form-control" required>` : '');
                    
                    if($(this).data('hasvariant') && isVariants) {
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
                                
                                let childVariant = '';
                                $.each(variant, function(key, value) {
                                    let options = '';
                                    $.each(value.option, function (index, val) {
                                        options += `<option value="${val}">${val}</option>`;
                                    });
                                    childVariant += `@include('pages.adjustment.elements.child_variant', ['variantOption' => '${options}', 'name' => '${value.name}'])`;
                                });
                                const html = `@include('pages.adjustment.elements.alert_variant', ['childVariant' => '${childVariant}'])`;
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
                                        actions: 'pe-4 w-100 justify-content-end '
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
                                        htmlVariants = htmlVariants.replace(/,$/, '');
                                        if (!objChild[itemId]) {
                                            objChild[itemId] = [];
                                        }
                                        if (!objChild[itemId].includes(sel) && !$(`#item-${itemId}`).length) {
                                            let a= ''; let b = '';
                                            const variants = `@include('pages.adjustment.elements.item_variant', ['unitHtml' => '${unitHtml}','variantId' => '${variantId}', 'id' => '${itemId}', 'htmlVariants' => '${htmlVariants}', 'trackWeight' => '${trackWeight}', 'variantString' => '${sel}'])`;
                                            row += `@include('pages.adjustment.elements.item_together', ['hasSer' => '${hasSerial}', 'hasVar' => '${hasVariant}', 'itemId' => '${itemId}', 'htmlVariant' => '${variants}', 'name' => '${itemName}'])`;
                                            objChild[itemId].push(sel);
                                        }
                                        if(!objChild[itemId].includes(sel) && $(`#item-${itemId}`).length) {
                                            row += `@include('pages.adjustment.elements.item_variant', ['unitHtml' => '${unitHtml}','variantId' => '${variantId}', 'id' => '${itemId}', 'htmlVariants' => '${htmlVariants}', 'trackWeight' => '${trackWeight}', 'variantString' => '${sel}'])`;
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
                        if(!objParent[itemId]){
                            objParent[itemId] = [];
                        }
                        if(!objParent[itemId].includes(`${itemName}`)) {
                            row += `@include('pages.adjustment.elements.item_alone', ['unitHtml' => '${unitHtml}','hasSer' => '${hasSerial}', 'hasVar' => '${hasVariant}', 'name' => '${itemName}', 'id' => '${itemId}', 'trackWeight' => '${trackWeight}', 'variantString' => '${itemName}'])`;
                            $itemsTableEL.append(row);
                            objParent[itemId].push(`${itemName}`);
                        }
                        checkItems();
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
                    checkItems()
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

                $('.btn-create-item').on('click', function() {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adjustments.store') }}",
                        data: $('#form-create').serialize(),
                        success: function(response){
                            if (response.success) {
                                $('#form-create').submit();
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

