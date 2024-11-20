<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.items.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title my-3">{{ __('common.items.index') }}</h5>
        </div>
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex justify-content-between">
                        <div id="filter-item" class="table-filter d-flex">
                            <div class="table-search">
                                <div class="input-group input-group-sm">
                                    <button title="{{__('common.filter')}}" class="btn btn-light dropdown-toggle btn-show-filter" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-filter'></i>
                                    </button>
                                    <div class="dropdown-menu custom-dropdown-menu">
                                        <div class="p-4">
                                            <div>
                                                <label>{{ __('common.role.trashed') }}:</label>
                                                <select data-default="{{ $filters['trashed']}}" name="trashed"
                                                    class="form-select form-control my-2">
                                                    @foreach ($statusFilters as $key => $value)
                                                        <option @if (($filters['trashed'] ?? '') === $key) selected @endif
                                                            value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" name="search" class="form-control" placeholder="{{ __('common.search') }}">
                                </div>
                            </div>
                            <button title="{{__('common.reset')}}" class="ms-2 btn btn-default btn-sm btn-reset-filter">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </button>
                        </div>
                        
                        <div class="btn-group">
                            <a class="btn-item" href="{{ route('items.create') }}" title="{{ __('common.items.create') }}">
                                <i class='fa-solid fa-plus'></i>
                            </a>
        
                            <a class="btn-item" title="{{ __('common.items.import') }}" href="{{ route('items.import') }}">
                                <i class="fa-solid fa-upload"></i>
                            </a>

                            <a class="btn-item me-0" title="{{ __('common.items.export') }}" href="{{ route('items.export') }}">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <x-handle-ajax url="{{ route('items.index') }}">
                    @include('pages.item.table_list', ['items' => $items, 'filters' => $filters])
                </x-handle-ajax>
                <div id="form-delete"></div>
            </div>
            
        </div>
    </div>

    @push('js')
        <script type="module">
            const handleAjax = () => {
                const searchEL = $('#filter-item input[name=search]');
                const statusEL = $('#filter-item select[name=trashed]');
                const resetEL = $('#filter-item .btn-reset-filter');
                let clearTimeOut = null;

                // search
                searchEL.on('input', function(e) {
                    if (clearTimeOut) {
                        clearTimeout(clearTimeOut);
                    }
                    clearTimeOut = setTimeout(function() {
                        filters();
                    }, 300);
                });

                // filter
                statusEL.on('input', function(e) {
                    filters();
                });

                function filters(){
                    document.dispatchEvent(new CustomEvent("handleAjax_filters", {
                        detail: {
                            trashed:{
                                name : 'trashed',
                                value: statusEL.val()
                            },
                            search: searchEL.val()
                        }
                    }));

                    closeFilter();
                }

                // reset
                resetEL.on('click', function(e) {
                     searchEL.val('');
                     statusEL.prop('selectedIndex', 0);
                     document.dispatchEvent(new CustomEvent("handleAjax_reset"));
                     
                     closeFilter();
                });

                function closeFilter() {
                    $('#filter-item .btn-show-filter').click();
                }
            }
            handleAjax();

            $(document).ready(function() {
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
                       <form id="swal-delete-form" method="POST" action="${isPermanentDelete ? '{{ route('items.destroy.permanently', ':id') }}'.replace(':id', id) : '{{ route('items.destroy', ':id') }}'.replace(':id', id)}">
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

                $(document).on('click', '#items-table tbody tr', function(e) {
                    var itemId = $(this).data('id');

                    $.ajax({
                        url: '/items/api/' + itemId,
                        method: 'GET',
                        success: function(data) {
                            
                            let variantHtml = '';
                            
                            $.each(data?.item?.variants, function (key, value){
                                variantHtml += `
                                    <div class="whitespace-normal">
                                        <span class="fw-bold text-dark">
                                            ${value.name}:
                                        </span>
                                `;
                                let optionVa = '';
                                $.each(value.option, function(index, val) {
                                    optionVa += `${val}, `
                                })
                                optionVa = optionVa.replace(/,\s*$/, ''); 
                                
                                variantHtml += `${optionVa}</div>`
                            })

                            let variantHtmlF = variantHtml != '' ? `<tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.variants') }}</td>
                                            <td class="px-6  text-start">
                                                ${variantHtml}
                                            </td>
                                        </tr>` : '';
                            const urlPhoto = data.item.photo == null ? "{{ asset('assets/images/icons/defautl-img.png') }}" : `storage/${data.item.photo}`;
                            var itemHtml = `
                            <div class="card">
                                <div class="card-body px-0">
                                    <table>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap w-auto">
                                                <img src="${urlPhoto}" alt="avatar" class="block w-24 h-24 rounded-sm mr-2 -my-2 object-fit-cover">
                                            </td>
                                            <td class="px-6  text-start"><img id="barcode"></img></td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.name') }}</td>
                                            <td class="px-6  text-start">${data.item.name}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.sku') }}</td>
                                            <td class="px-6  text-start">${data.item.sku ?? ''}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.category') }}</td>
                                            <td class="px-6  text-start">${data.category ?? ''}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.rack_location') }}</td>
                                            <td class="px-6  text-start">${data.item.rack_location ?? ''}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.unit') }}</td>
                                            <td class="px-6  text-start">${data?.units?.name ?? ''}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.track_serial') }}</td>
                                            <td class="px-6  text-start">${data.item.track_serial ? '<i class="bx bx-check bx-sm"></i>' : '<i class="bx bx-x bx-sm"></i>'}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.track_weight') }}</td>
                                            <td class="px-6  text-start">${data.item.track_weight ? '<i class="bx bx-check bx-sm"></i>' : '<i class="bx bx-x bx-sm"></i>'}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.track_quantity') }}</td>
                                            <td class="px-6  text-start">${data.item.track_quantity ? '<i class="bx bx-check bx-sm"></i>' : '<i class="bx bx-x bx-sm"></i>'}</td>
                                        </tr>
                                        ${data.item.has_variants ? variantHtmlF : ''}
                                        <tr>
                                            <td class="px-6 py-2 text-start whitespace-nowrap">{{ __('attributes.item.details') }}</td>
                                            <td class="px-6  text-start">${data.item.details ?? ''}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            `;
                            var warehousesHtml = '';
                            
                            $.each(data.stocks, function(index, stock) { 
                                let quantity = 0;
                                let weight = 0;
                                
                                $.each(stock, function(i, each) {
                                    if(data.item.has_variants == false) {
                                        quantity += parseFloat(each.quantity);
                                        weight += parseFloat(each.weight);
                                        return false;
                                    }

                                    if(each.variation != null) {
                                        quantity += parseFloat(each.quantity);
                                        weight += parseFloat(each.weight);
                                    }
                                });
                                
                                var stockHtml = `
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="card warehouse-card">
                                            <div class="card-header d-flex align-items-center">
                                                <span>${stock[0]?.warehouse?.name ?? ''} (${stock[0]?.warehouse?.code ?? ''})</span>
                                            </div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start fz-16">{{__('attributes.item.quantity')}}</th>
                                                        <th class="text-end fz-16">
                                                           ${formatDecimalNumber(quantity,data.item.setting.fraction,data.item.setting.default_locale)} ${data?.units?.code ?? ''} ${data.item.track_weight?'('+ formatDecimalNumber(weight,data.item.setting.fraction,data.item.setting.default_locale)+' ' + data.weightUnit +')':''}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                                
                                $.each(stock, function(i, each) {
                                    if(each.variation == null) {
                                        return;
                                    }
                                    if(data.item.track_weight) {
                                        stockHtml += `
                                            <tr>
                                                <td class="text-start">${each.variation ? Object.entries(each.variation.meta).map(([key, value]) => `${key}: ${value}`).join(', ') : 'N/A'}</td>
                                                <td class="text-end">${formatDecimalNumber(each.quantity,data.item.setting.fraction,data.item.setting.default_locale)} ${data?.units?.code ?? ''} (${formatDecimalNumber(each.weight,data.item.setting.fraction,data.item.setting.default_locale) ?? ''} ${data.weightUnit ?? 'kg'})</td>
                                            </tr>
                                        `;
                                    } else {
                                        stockHtml += `
                                            <tr>
                                                <td class="text-start">${each.variation ? Object.entries(each.variation.meta).map(([key, value]) => `${key}: ${value}`).join(', ') : 'N/A'}</td>
                                                <td class="text-end">${formatDecimalNumber(each.quantity,data.item.setting.fraction,data.item.setting.default_locale)} ${data?.units?.code ?? ''}</td>
                                            </tr>
                                        `;
                                    }
                                });

                                stockHtml += `
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>`;
                                
                                warehousesHtml += stockHtml;
                            });

                            Swal.fire({
                                title: `{{ __('common.items.detail') }} (${data.item.name})`,
                                html: `
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        ${itemHtml}
                                        </div>
                                        ${warehousesHtml}
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

                            JsBarcode("#barcode", data.item.code, {
                                format: data.item.symbology || 'CODE128',
                                lineColor: "#000000",
                                width: 2,
                                height: 100,
                                displayValue: true
                            });
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });
            
            $(document).on('click', '.form-restore', function(e){
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

            $(document).on('click', '.event-stop', function (e) {
                e.stopPropagation()
            })
        </script>
        
    @endpush
</x-app-layout>
