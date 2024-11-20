<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.category.index') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.category.index') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-filter mt-2 d-flex justify-content-between align-items-center" id="category-filters">
                        <div class="table-search d-flex">
                            <div class="input-group input-group-sm">
                                <button title="{{__('common.filter')}}" class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class='bx bx-filter'></i></button></button>
                                <div class="dropdown-menu custom-dropdown-menu">
                                    <div class="p-4">
                                        <div class="mb-4">
                                            <label>{{ __('attributes.category.parent_id') }}</label>
                                            <select class="form-select my-2" id="inputGroupSelect02" name="parent_id">
                                                <option value="all">{{ __('attributes.category.all') }}</option>
                                                @foreach ($allCategories as $category)
                                                    <option {{$filters['parents'] == $category->id?'selected':''}} value="{{ $category->id }}">{{ $category->name }} ({{ $category->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label>{{ __('attributes.category.status') }}</label>
                                            <select name="trashed" class="form-select my-2">
                                                <option {{$filters['trashed'] =='with'?'selected':''}} selected value="with">{{ __('attributes.category.with_trashed') }}</option>
                                                <option {{$filters['trashed'] =='without'?'selected':''}} value="without">{{ __('attributes.category.not_trashed') }}</option>
                                                <option {{$filters['trashed'] =='only'?'selected':''}} value="only">{{ __('attributes.category.only_trashed') }}</option>
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
                            <a class="btn-item" title="{{ __('common.category.create') }}" href="{{ route('categories.create') }}">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a class="btn-item" title="{{ __('common.category.import') }}" href="{{ route('categories.import') }}">
                                <i class="fa-solid fa-upload"></i>
                            </a>
                            <a class="btn-item" title="{{ __('common.category.export') }}" href="{{ route('categories.export') }}">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <x-handle-ajax url="{{ route('categories.index') }}">
                    @include('pages.category.table_list_category', ['categories' => $categories])
                </x-handle-ajax>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function () {

                const handleAjax = () => {
                    const $searchEL = $('#category-filters input[name=search]');
                    const $statusEL = $('#category-filters select[name=trashed]');
                    const $resetEL = $('#category-filters .btn-reset-filter');
                    const $parentEl = $('#inputGroupSelect02');
                    let clearTimeOut = null;

                    // parent
                    $parentEl.on('input', function(e) {
                        filters();
                    })

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
                                parent:{
                                    name : 'parent_id',
                                    value: $parentEl.val()
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
                        $parentEl.prop('selectedIndex', 0);
                        document.dispatchEvent(new CustomEvent("handleAjax_reset"));

                        closeFilter();
                    });

                    function closeFilter() {
                        $('#category-filters .btn-show-filter').click();
                    }
                }
                handleAjax();
            });


        </script>
    @endpush
</x-app-layout>