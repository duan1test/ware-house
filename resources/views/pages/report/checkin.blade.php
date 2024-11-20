<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.report.checkin') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="page-title mt-3 mb-3">{{ __('common.report.checkin') }}</h5>
                <button id="toggleFilter" title="{{ __('common.filters') }}" class="btn bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring focus:ring-gray-300 focus:border-gray-900 focus:shadow-outline-gray text-white btn-sm d-flex align-items-center justify-content-center mt-3 mb-3"><i class="fa-solid fa-sliders toggleFilter"></i></button>
            </div>
            <div class="" style="display: none;" id="filterFormContain" name="filterFormContain">
                <form action="" method="GET" {{ request()->all() ? 'block' : 'none' }} id="filterForm" name="filterForm">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.start_date') }}</label>
                            <input type="date" name="start_date" id="start_date" class="form form-control font-14 mt-1 mb-2" value="{{ old('start_date', request('start_date')) }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.end_date') }}</label>
                            <input type="date" name="end_date" id="end_date" class="form form-control font-14 mt-1 mb-2" value="{{ old('end_date', request('end_date')) }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.start_created_at') }}</label>
                            <input type="datetime-local" name="start_created_at" id="start_created_at" class="form form-control font-14 mt-1 mb-2" value="{{ old('start_created_at', request('start_created_at')) }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.end_created_at') }}</label>
                            <input type="datetime-local" name="end_created_at" id="end_created_at" class="form form-control font-14 mt-1 mb-2" value="{{ old('end_created_at', request('end_created_at')) }}">
                        </div>
                        <div class="col-3">
                            <label for="" class="font-medium font-14" >{{ __('attributes.checkin.ref') }}</label>
                            <input type="text" name="reference" id="reference" class="form form-control font-14 mt-1 mb-2" value="{{ old('reference', request('reference')) }}" placeholder="{{ __('attributes.checkin.ref') }}">
                        </div>
                        <div class="col-3 mt-1">
                            <label for="" class="font-medium font-14" >{{ __('attributes.checkin.contact') }}</label>
                            <select name="contact_id" id="contact" class="choices w-full mt-1 mb-2">
                                <option value="" disabled selected hidden>{{ __('attributes.checkin.contact') }}</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}" {{ old('contact_id', request('contact_id')) == $contact->id ? 'selected' : '' }} >{{ $contact->name }} ({{ $contact->code }})</option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-3 mt-1">
                            <label for="" class="font-medium font-14" >{{ __('attributes.checkin.warehouse') }}</label>
                            <select name="warehouse_id" id="warehouse" class="choices w-full mt-1 mb-2">
                                <option value="" disabled selected hidden>{{ __('attributes.checkin.warehouse') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ old('warehouse_id', request('warehouse_id')) == $warehouse->id ? 'selected' : '' }} >{{ $warehouse->name }} ({{ $warehouse->code }})</option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-3 mt-1">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.user') }}</label>
                            <select name="user_id" id="user_id" class="choices w-full mt-1 mb-2">
                                <option value="" disabled selected hidden>{{ __('common.report.select_user') }}</option>
                                    @foreach ($users as $user)
                                        <option {{ old('user_id',request('user_id')) == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-3 mt-1">
                            <label for="" class="font-medium font-14" >{{ __('attributes.transfer.category') }}</label>
                            <select name="category_id" id="category_id" class="choices w-full mt-1 mb-2">
                                <option value="" disabled selected hidden>{{ __('common.transfer.select_category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{ old('category_id',request('category_id')) == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" id="resetFilter" name="resetFilter" class="btn bg-gray-200 resetFilter">{{ __('attributes.transfer.reset') }}</button>
                        </div>
                        <div class="d-flex">
                            <div class="form-check form-check-inline mt-1">
                                <input type="checkbox" name="trashed" id="trashed" @if (request()->trashed == true)
                                    checked
                                @endif  
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 form-check-input">
                                <label class="form-check-label" for="trashed">{{ __('attributes.transfer.trashed') }}</label>
                            </div>
                            <div class="form-check form-check-inline mt-1">
                                <input type="checkbox" name="draft" id="draft" @if (request()->draft == true)
                                    checked
                                @endif   
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 form-check-input">
                                <label class="form-check-label" for="draft">{{ __('attributes.transfer.draft') }}</label>
                            </div>
                            <button type="submit" id="searchFilter" name="searchFilter" class="btn bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring focus:ring-gray-300 focus:border-gray-900 focus:shadow-outline-gray text-white btn-sm d-flex align-items-center justify-content-center searchFilter">{{ __('attributes.transfer.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="mt-1">
                <div>
                    @include('pages.report.table.table_list_checkin', ['checkins' => $checkins])
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            $('#filterForm').on('submit', function(event) {
                const inputs = $('#filterForm input, #filterForm select');

                inputs.each(function() {
                    if (!$(this).val() || $(this).val() === $(this).prop('defaultValue')) {
                        $(this).removeAttr('name');
                    }
                });
            });

            document.getElementById('toggleFilter').addEventListener('click', function() {
                var filterFormContain = document.getElementById('filterFormContain');
                if (filterFormContain.style.display === 'none') {
                    filterFormContain.style.display = 'block';
                } else {
                    filterFormContain.style.display = 'none';
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                var params = new URLSearchParams(window.location.search);

                var hasFilter = Array.from(params.keys()).some(function(key) {
                    return key !== 'page';
                });

                if (hasFilter) {
                    document.getElementById('filterFormContain').style.display = 'block';
                }
            });
                
            $('#resetFilter').on('click', function() {
                const baseUrl = "{{ route('reports.checkin') }}" + '?searchFilter';
                window.location.href = baseUrl;
            });
            
            $(document).ready(function () {
                $(document).on('click', '.clickable-row', async function() {
                    const id = $(this).data('id');
                    let url = "{{ route('checkins.show', ['checkin' => ':id', 'json' => 1]) }}";
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
                                        ((val.item.track_weight != 0 && val.weight != null) ? 
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
                                            variation.pivot.weight + ' ' + (data.setting.weight_unit ?? 'kg'):'') : '' }</td>
                                    <td class="group-hover:bg-gray-100 px-6 py-2 text-center">${variation.pivot.quantity} ${units.find(unit => unit.id === variation.pivot.unit_id)?.code || ''}</td>
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
                                                {{ __('attributes.checkin.soft_delete') }}
                                            </div>
                                        </div>
                                    </div>`;
                    }
                    const html = `
                    <div class="card">
                        <div class="card-header d-flex align-items-center text-end normal-case">
                            <div class="d-flex flex-column w-100">
                                <span class="font-bold lh-lg">${data.warehouse.name} (${data.warehouse.code})</span>
                                <span class="lh-lg">${data.warehouse.address || ''}</span>
                                <span class="lh-lg">${data.warehouse.phone || ''}</span>
                                <span class="lh-lg">${data.warehouse.email || ''}</span>
                            </div>
                        </div>
                        <div class="card-body overflow-hidden">
                            ${htmlAlert}
                            <div class="d-flex flex-col justify-content-center align-items-center">
                                <p class="text-xl text-center uppercase font-bold">{{__('common.checkin.title')}}</p>
                                <img class="max-h-[100px]" id="barcode"></img>
                            </div>
                            <div class="row d-flex flex-row justify-content-center align-items-center mt-4">
                                <div class="col-6 d-flex flex-column text-start">
                                    <span class="fz-16 lh-lg">{{ __('attributes.transfer.date') }}: ${formatDate(data.date)}</span>
                                    <span class="fz-16 lh-lg">{{ __('attributes.checkin.ref') }}: ${data.reference}</span>
                                    <span class="fz-16 lh-lg">{{ __('attributes.transfer.create_at') }}: ${formatDate(data.created_at)}, ${formatTime(data.created_at)}</span>
                                </div>
                                <div class="col-6 d-flex flex-column text-start">
                                    <span class="fz-16 font-bold">{{ __('attributes.checkin.contact') }}:</span>
                                    <span class="fz-16 lh-lg"> ${data.contact.name} </span>
                                    <span class="fz-16 lh-lg"> ${data.contact.phone || ''} </span>
                                    <span class="fz-16 lh-lg"> ${data.contact.email || ''} </span>
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
                            <div class="mb-4 text-start attachments">
                                <label for="formFile" class="fz-16">
                                {{ __('attributes.transfer.attachment') }}
                                </label>
                               <input name="filepond" hidden>
                            </div>
                             <div class="line-clamp-3 text-start fz-16">
                                ${data.details ?? ''}
                            </div>
                        </div>
                    </div>
                    `;
                    Swal.fire({
                        title: `{{ __('common.checkin.detail') }} (${data.reference})`,
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

                    if (data.attachments.length !== 0) {                       
                        const attachments = document.querySelector('input[name="filepond"]');                        
                        const pond = FilePond.create(attachments,{
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
                        });
                        $.each(data.attachments, function (key, val) {
                            fetch(val.url)
                            .then(response => response.blob())
                            .then(blob => {
                                const file = new File([blob], val.title, { type: val.filetype })
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
                        })
                        $(".filepond--list-scroller").addClass("top-66");
                        $(".filepond--list-scroller").addClass("h-100");
                        const lenghtFile = data.attachments.length;
                        $('.filepond--root').height(56*lenghtFile);
                    }else{
                        $('.attachments').hide();
                    };

                    JsBarcode("#barcode", data.reference, {
                        format: 'CODE128',
                        lineColor: "#000000",
                        width: 2,
                        height: 100,
                        displayValue: true
                    });

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
