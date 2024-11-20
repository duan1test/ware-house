<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.warehouse.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.warehouse.index') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-filter mt-2 d-flex justify-content-between align-items-center" id="warehouse-filters">
                        <div class="table-search d-flex">
                            <div class="input-group input-group-sm">
                                <button title="{{__('common.filter')}}" class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class='bx bx-filter'></i></button></button>
                                <div class="dropdown-menu custom-dropdown-menu">
                                    <div class="p-4">
                                        <div>
                                            <label>{{ __('attributes.warehouse.status') }}</label>
                                            <select name="status" class="form-select form-control my-2">
                                                <option {{$filters['trashed'] =='with'?'selected':''}} selected value="with">{{ __('attributes.warehouse.with_trashed') }}</option>
                                                <option {{$filters['trashed'] =='without'?'selected':''}} value="without">{{ __('attributes.warehouse.not_trashed') }}</option>
                                                <option {{$filters['trashed'] =='only'?'selected':''}} value="only">{{ __('attributes.warehouse.only_trashed') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="{{ __('common.search') }}" name="search" aria-label="Text input with dropdown button">
                            </div>
                            <button title="{{__('common.reset')}}" class="ms-2 text-nowrap btn btn-default btn-sm btn-reset-filter">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </button>
                        </div>
            
                        <div class="btn-group">
                            <a class="btn-item" title="{{ __('common.warehouse.create') }}" href="{{ route('warehouses.create') }}">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a class="btn-item" title="{{ __('common.warehouse.import') }}" href="{{ route('warehouses.import') }}">
                                <i class="fa-solid fa-upload"></i>
                            </a>
                            <a class="btn-item" title="{{ __('common.warehouse.export') }}" href="{{ route('warehouses.export') }}">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <x-handle-ajax url="{{ route('api.warehouses.index') }}">
                    @include('pages.warehouse.table_list_warehouse', ['warehouses' => $warehouses])
                </x-handle-ajax>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function () {

                const handleAjax = () => {
                    const $searchEL = $('#warehouse-filters input[name=search]');
                    const $statusEL = $('#warehouse-filters select[name=status]');
                    const $resetEL = $('#warehouse-filters .btn-reset-filter');
                    
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

                    function filters(){
                        document.dispatchEvent(new CustomEvent("handleAjax_filters", {
                            detail: {
                                trashed:{
                                    name : 'trashed',
                                    value: $statusEL.val()
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
                        document.dispatchEvent(new CustomEvent("handleAjax_reset"));

                        closeFilter();
                    });

                    function closeFilter() {
                        $('#warehouse-filters .btn-show-filter').click();
                    }
                }
                handleAjax();
            });


        </script>
    @endpush
</x-app-layout>