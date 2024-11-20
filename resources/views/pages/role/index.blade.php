<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.role.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title my-3">{{ __('common.role.index') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-5">
                    <div id="filter-role" class="table-filter d-flex">
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
                                            <select data-default="{{ $filters['trashed'] }}" name="trashed"
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
                                <input value="{{ $filters['search'] }}" type="text" name="search" class="form-control" placeholder="{{ __('common.search') }}">
                            </div>
                        </div>
                        <button title="{{__('common.reset')}}" class="ms-2 btn btn-default btn-sm btn-reset-filter">
                            <i class="fa-solid fa-arrow-rotate-right"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12 col-md-7 text-end mt-md-0 mt-2">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm" title="{{ __('common.role.create') }}">
                        <i class='bx bx-plus'></i>
                    </a>
                </div>
            </div>

            <div class="mt-2">
                <x-handle-ajax url="{{ route('roles.index') }}">
                    @include('pages.role.table_list_role', ['roles' => $roles])
                </x-handle-ajax>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            const handleAjax = () => {
                const searchEL = $('#filter-role input[name=search]');
                const statusEL = $('#filter-role select[name=trashed]');
                const resetEL = $('#filter-role .btn-reset-filter');
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
                     statusEL.prop('selectedIndex', 2);
                     document.dispatchEvent(new CustomEvent("handleAjax_reset"));
                     
                     closeFilter();
                });

                function closeFilter() {
                    $('#filter-role .btn-show-filter').click();
                }
            }
            handleAjax();
        </script>
    @endpush
</x-app-layout>
