<x-app-layout>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">{{ __('common.items.index') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('common.items.trail') }} - {{ $item->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <a href="{{ route('items.index', ['q' => $filters->search, 'trashed' => $filters->trashed]) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.items.trail') }} - {{ $item->name }}</h5>
            </div>

            <div class="card-body">
                <div class="barcode d-flex justify-content-center">
                    <img id="barcode"></img>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('attributes.item.created_at') }}</th>
                                <th>{{ __('attributes.item.warehouse') }}</th>
                                <th>{{ __('attributes.item.variation') }}</th>
                                <th>{{ __('attributes.item.quantity') }}</th>
                                <th>{{ __('attributes.item.weight') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($trails->total() > 0)
                                @foreach ($trails as $trail)
                                    <tr>
                                        <td>
                                            <div>{{ $trail->created_at }}</div>
                                            <div>{{ $trail->type }} ({{ $trail->subject_id }})</div>
                                        </td>
        
                                        <td>{{ $trail->warehouse->name }}</td>
                                        <td>
                                            @if(isset($trail->variation['meta']))
                                                @foreach($trail->variation['meta'] as $key => $value)
                                                    {{ $key }}: <strong>{{ $value }}</strong>@if(!$loop->last), @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $trail->quantity . ' ' . ( $item->unit->code ?? '' )}}</td>
                                        <td>{{ $trail->weight }} kg</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">
                                        {{ __('common.no_data') }}
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                
                <div class="row justify-content-between align-items-center">
                    @if ($trails->total() > 0)
                        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
                            {{ __('common.paginate_info', [
                                'from' => $trails->firstItem(),
                                'to' => $trails->lastItem(),
                                'total' => $trails->total(),
                            ]) }}
                        </div>
                    @endif
                
                    <div class="col-12 col-md-6">
                        <div class="d-flex justify-content-center justify-content-md-end">
                            {{ $trails->links() }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</x-app-layout>