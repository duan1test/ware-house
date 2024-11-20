<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.unit.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.unit.index') }}</h5>
        </div>

        <div class="card-body">
            <div class="row flex justify-between">
                <div class="col-12 col-md-5">
                    <div class="table-filter d-flex justify-content-between align-items-center" id="unit-filter">
                        <div class="table-search d-flex">
                            <div class="input-group input-group-sm">
                                <button title="{{__('common.filter')}}" class="btn-show-filter btn btn-light dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class='bx bx-filter'></i></button>
                                <div class="dropdown-menu custom-dropdown-menu">
                                    <div class="p-4">
                                        <div>
                                            <label>{{ __('attributes.unit.status') }}</label>
                                            <select name="status" class="form-select form-control my-2">
                                                <option {{$filters['trashed'] =='with'?'selected':''}} value="with">{{ __('attributes.unit.with_trashed') }}</option>
                                                <option {{$filters['trashed'] =='without'?'selected':''}} value="without">{{ __('attributes.unit.not_trashed') }}</option>
                                                <option {{$filters['trashed'] =='only'?'selected':''}} value="only">{{ __('attributes.unit.only_trashed') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input value="{{ $filters['q'] ?? '' }}" name="search" type="text"
                                    class="form-control"
                                    placeholder="{{ __('common.search') }}">
                            </div>
                            <button title="{{__('common.reset')}}" class="ms-2 text-nowrap btn btn-default btn-sm btn-reset-filter">
                                <i class="fa-solid fa-arrow-rotate-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 text-end mt-md-0 btn-group">
                    <a class="btn-item" href="{{ route('units.create') }}"  title="{{ __('common.unit.create') }}">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <a class="btn-item" title="{{ __('common.unit.import') }}" href="{{ route('units.import') }}">
                        <i class="fa-solid fa-upload"></i>
                    </a>
                    <a class="btn-item" title="{{ __('common.unit.export') }}" href="{{ route('units.export') }}">
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
            </div>
            <div class="mt-2">
                <x-handle-ajax url="{{ route('units.index') }}">
                    @include('pages.unit.table_list_unit', ['units' => $units])
                </x-handle-ajax>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            $(document).ready(function () {
                const handleAjax = () => {
                    const searchEL = $('#unit-filter input[name=search]');
                    const statusEL = $('#unit-filter select[name=status]');
                    const resetEL = $('#unit-filter .btn-reset-filter');
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
                        $('#unit-filter .btn-show-filter').click();
                    }
                }
                handleAjax();
            });
        </script>
    @endpush
</x-app-layout>
