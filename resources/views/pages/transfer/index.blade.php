<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.transfer.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.transfer.index') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-filter mt-2 d-flex justify-content-between align-items-center" id="transfer-filters">
                        <div class="table-search d-flex">
                            <div class="input-group input-group-sm">
                                <button  title="{{__('common.filter')}}"  class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class='bx bx-filter'></i></button></button>
                                <div class="dropdown-menu custom-dropdown-menu">
                                    <div class="p-4">
                                        <div>
                                            <label>{{ __('attributes.transfer.status') }}</label>
                                            <select name="trashed" class="form-select form-control my-2">
                                                <option {{ $filters['trashed'] == 'with' ? 'selected' : '' }} selected value="with">{{ __('attributes.transfer.with_trashed') }}</option>
                                                <option {{ $filters['trashed'] == 'without' ? 'selected' : '' }} value="without">{{ __('attributes.transfer.not_trashed') }}</option>
                                                <option {{ $filters['trashed'] == 'only' ? 'selected' : '' }} value="only">{{ __('attributes.transfer.only_trashed') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div>
                                            <label>{{ __('attributes.transfer.draft') }}</label>
                                            <select name="draft" class="form-select form-control my-2">
                                                <option {{ $filters['draft'] == null ? 'selected' : '' }} selected value="">{{ __('attributes.transfer.not_draft') }}</option>
                                                <option {{ $filters['draft'] == 'no' ? 'selected' : '' }} value="no">{{ __('attributes.transfer.with_draft') }}</option>
                                                <option {{ $filters['draft'] == 'yes' ? 'selected' : '' }} value="yes">{{ __('attributes.transfer.only_draft') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" value="{{ $filters['q'] ?? '' }}" placeholder="{{ __('common.search') }}" name="search" aria-label="Text input with dropdown button">
                            </div>
                            <button title="{{__('common.reset')}}"  class="ms-2 text-nowrap btn btn-default btn-sm btn-reset-filter">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </button>
                        </div>
            
                        <div class="btn-group">
                            <a class="btn-item me-0" title="{{ __('common.transfer.create') }}" href="{{ route('transfers.create') }}">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <x-handle-ajax url="{{ route('transfers.index') }}">
                    @include('pages.transfer.table_list_transfer', ['transfers' => $transfers])
                </x-handle-ajax>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function () {
                const handleAjax = () => {
                    const $searchEL = $('#transfer-filters input[name=search]');
                    const $statusEL = $('#transfer-filters select[name=trashed]');
                    const $draftEL = $('#transfer-filters select[name=draft]');
                    const $resetEL = $('#transfer-filters .btn-reset-filter');
                    
                    let clearTimeOut = null;

                    // search
                    $searchEL.on('input', function(e) {
                        if (clearTimeOut) {
                            clearTimeout(clearTimeOut);
                        }
                        clearTimeOut = setTimeout(function() {
                            filters();
                        }, 300);
                    });

                    // filter
                    $statusEL.on('input', function(e) {
                        filters();
                    });

                    // draft
                    $draftEL.on('input', function(e) {
                        filters();
                    });

                    function filters(){
                        document.dispatchEvent(new CustomEvent("handleAjax_filters", {
                            detail: {
                                trashed:{
                                    name : 'trashed',
                                    value: $statusEL.val()
                                },
                                draft:{
                                    name : 'draft',
                                    value: $draftEL.val()
                                },
                                search: $searchEL.val()
                            }
                        }));

                        closeFilter();
                    }

                    // reset
                    $resetEL.on('click', function() {
                        $searchEL.val('');
                        $statusEL.prop('selectedIndex', 0);
                        $draftEL.prop('selectedIndex', 0);
                        document.dispatchEvent(new CustomEvent("handleAjax_reset"));

                        closeFilter();
                    });

                    function closeFilter() {
                        $('#transfer-filters .btn-show-filter').click();
                    }
                }
                handleAjax();

                $(document).on('click', '.event-stop', function (e) {
                    e.stopPropagation()
                });

                $(document).on('click', '.form-restore', function(e) {
                    e.stopPropagation()
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
                })

                $(document).on('click', '.soft-delete', function(e) {
                    e.preventDefault();
                    e.stopPropagation()
                    let button = $(this).closest('button[type="button"]');
                    let id = button.data('id');
                    let isPermanentDelete = button.data('permanent');
                    
                    let confirmMessage = isPermanentDelete 
                        ? '{{ __('common.confirm_permanent_delete') }}' 
                        : '{{ __('common.confirm_delete') }}';
                    
                    let htmlMessage = isPermanentDelete 
                        ? "{{ __('common.alert_permanent_delete') }}" 
                        : "";

                    let deleteFormHtml = `
                       <form id="swal-delete-form" method="POST" action="${isPermanentDelete ? '{{ route('transfers.destroy.permanently', ':id') }}'.replace(':id', id) : '{{ route('transfers.destroy', ':id') }}'.replace(':id', id)}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    `;

                    Swal.fire({
                        title: confirmMessage,
                        html: deleteFormHtml + htmlMessage,
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
                            $('#swal-delete-form').submit();
                        }
                    });
                });

                $(document).on('click', '.clickable-row', async function() {
                    const id = $(this).data('id');
                    let url = "{{ route('transfers.show', ['transfer' => ':id', 'json' => 1]) }}";
                    url = url.replace(":id", id);
                    
                    try {
                        const headers = {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        };
                        const response = await axios['get'](url, {
                            headers: headers
                        });
                        await response;
                        renderDetail(response.data);
                    } catch (e) {
                        console.log(e);
                    } 
                })

                function renderDetail(data) {
                    let htmlItem = '';
                    $.each(data.items, function (key, val) {
                        if(val.variations == null || val.variations.length == 0) {
                            htmlItem += 
                            `<tr class="group avoid border-b">
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2 text-start">${val.item.name} (${val.item.code})</td>
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2 text-center">
                                    ${ (data.setting.track_weight && data.setting.track_weight != 0) ? 
                                        (val.item.track_weight != 0 && val.weight != null ? 
                                        formatDecimalNumber(val.weight,data.setting.fraction,data.setting.default_locale) + ' ' + data.setting.weight_unit ?? 'kg' : '') : ''}</td>
                                <td class="group-hover:bg-gray-100 border-t px-6 py-2 text-center">${formatDecimalNumber(val.quantity,data.setting.fraction,data.setting.default_locale)} ${val?.unit?.code || ''}</td>
                            </tr>`;
                        }
                        else {
                            htmlItem += 
                            `<tr>
                                <td colspan="3" class="text-left font-bold group-hover:bg-gray-100 border-t px-6 py-2">${val.item.name} (${val.item.code})</td>
                            </tr>`;
                            const lengthVariation = val.variations.length;
                            const units = @json($units);
                            $.each(val.variations, function(index, variation) {
                                const last = val.variations[lengthVariation - 1] == variation;
                                let variantName = '';
                                $.each(variation.meta, function(i, d) {
                                    variantName += `${i} : <span class="fw-bold"> ${d} </span> , `;
                                })
                                variantName = variantName.replace(/, $/, '');
                                htmlItem +=
                                `<tr class="group avoid ${last ? 'border-b ' : ''}">
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-left">
                                        ${variantName}
                                    </td>
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-center">
                                        ${ (data.setting.track_weight && data.setting.track_weight != 0) ? 
                                            ((val.item.track_weight != 0 && variation.pivot.weight != null) ? 
                                            formatDecimalNumber(variation.pivot.weight,data.setting.fraction,data.setting.default_locale) + ' ' + (data.setting.weight_unit ?? 'kg'):'') : '' }</td>
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-center">${formatDecimalNumber(variation.pivot.quantity,data.setting.fraction,data.setting.default_locale)} ${units.find(unit => unit.id === variation.pivot.unit_id)?.code || ''}</td>
                                </tr>`;
                            })
                        }
                    });
                    let htmlAlert = '';
                    if(data.draft == 1) {
                        htmlAlert += `<div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-warning text-start fz-16">
                                                <i class="fa-solid fa-circle-exclamation me-2"></i>
                                                {{ __('common.adjustment.draft') }}
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    if(data.deleted_at != null) {
                        htmlAlert += `<div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-warning text-start fz-16">
                                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                                {{ __('attributes.transfer.soft_delete') }}
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    const html = `
                    <div class="card">
                        <div class="card-header d-flex align-items-center text-end normal-case">
                            <div class="d-flex flex-column w-100">
                                <span class="font-bold lh-lg">${data.from_warehouse.name} (${data.from_warehouse.code})</span>
                                <span class="lh-lg">${data.from_warehouse.address || ''}</span>
                                <span class="lh-lg">${data.from_warehouse.phone || ''}</span>
                                <span class="lh-lg">${data.from_warehouse.email || ''}</span>
                            </div>
                        </div>
                        <div class="card-body overflow-hidden">
                            ${htmlAlert}
                            <div class="d-flex flex-col justify-content-center align-items-center">
                                <p class="text-xl text-center uppercase font-bold">{{__('common.transfer.title')}}</p>
                                <img class="max-h-[100px]" id="barcode"></img>
                            </div>
                            <div class="row d-flex flex-row justify-content-center align-items-center mt-4">
                                <div class="col-6 d-flex flex-column text-start">
                                    <span class="fz-16 lh-lg">{{ __('attributes.transfer.date') }}: ${formatDate(data.date)}</span>
                                    <span class="fz-16 lh-lg">{{ __('attributes.transfer.ref') }}: ${data.reference}</span>
                                    <span class="fz-16 lh-lg">{{ __('attributes.transfer.create_at') }}: ${formatDate(data.created_at)}, ${formatTime(data.created_at)}</span>
                                </div>
                                <div class="col-6 d-flex flex-column text-start">
                                    <span class="fz-16 font-bold">{{ __('attributes.transfer.warehouse_to') }}:</span>
                                    <span class="fz-16 lh-lg"> ${data.to_warehouse.name} </span>
                                    <span class="fz-16 lh-lg"> ${data.to_warehouse.phone || ''} </span>
                                    <span class="fz-16 lh-lg"> ${data.to_warehouse.email || ''} </span>
                                </div>
                            </div>

                            <table class="w-full mt-8 mb-4">
                                <tr>
                                    <th class="fz-16 px-6 py-2 text-left">{{ __('attributes.transfer.items') }}</th>
                                    <th class="fz-16 px-6 py-2 w-40 text-center">
                                        {{ get_settings('track_weight') ? __('attributes.item.weight') : '' }}</th>
                                    <th class="fz-16 px-6 py-2 w-40 text-center">{{ __('attributes.item.quantity') }}</th>
                                </tr>
                                ${htmlItem}
                            </table>

                            <input type="file" class="filepond w-100 attachments" name="filepond" multiple>
                            <input type="file" id="attachments" name="attachments[]" multiple hidden>
                            <div class="line-clamp-3 text-start fz-16">
                                ${data.details ?? ''}
                            </div>
                        </div>
                    </div>
                    `;
                    Swal.fire({
                        title: `{{ __('common.transfer.detail') }} (${data.reference})`,
                        html: `
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                ${html}
                                </div>
                            </div>
                        `,
                        showCloseButton: true,
                        width: '60%',
                        padding: '1em',
                        showConfirmButton: false,
                        customClass: {
                            popup: 'popup-class-modal',
                            title: 'swal2-title-detail'
                        },
                    });

                    JsBarcode("#barcode", data.reference, {
                        format: 'CODE128',
                        lineColor: "#000000",
                        width: 2,
                        height: 100,
                        displayValue: true
                    });

                    if(data.attachments.length != 0){
                        const attachments = document.querySelector('input[name="filepond"]');

                        const pond = FilePond.create(attachments, {
                            labelIdle: `<div class="fz-14"><span class="cursor-pointer link-primary"> {{ __('common.warehouse.chose_file') }} </span> {{ __('common.warehouse.chose_file_end') }} <br> <p class="text-center text-secondary mt-2">{{ __('attributes.transfer.import_file') }}</p></div>`,
                            allowDrop:false,
                            allowBrowse:false,
                            allowMultiple: true,
                            labelIdle: '',
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
                        $.each(data.attachments, function (key, val) {
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
                        $(".filepond--list-scroller").addClass("top-66");
                        $(".filepond--list-scroller").addClass("h-100");
                        const lenghtFile = data.attachments.length;
                        $('.filepond--root').height(56*lenghtFile);
                    } else {
                        $('.attachments').hide();
                    }
                }

                function formatDate (date) {
                    const formattedDate = new Date(date).toLocaleDateString('vi-VN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    return formattedDate;
                }

                function formatTime (date) {
                    const formattedTime = new Date(date).toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });

                    return formattedTime;
                }
            });
        </script>
    @endpush
</x-app-layout>