<x-app-layout>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">{{ __('common.items.index') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('common.items.detail') }}</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="w-100 d-flex align-items-center">
                    <a href="{{ handleRoute(route: 'items.index', options: $filters) }}" class="me-2">
                        <i class='bx bx-arrow-back'></i>
                    </a>
                    <h5 class="page-title mt-3 mb-3">{{ __('common.items.detail') }}</h5>
                </div>
                <div class="me-2">
                    <a href="#" class="item-detail-edit rounded-circle p-2 event-print" title="{{ __('common.print') }}">
                        <i class="fa-solid fa-print"></i>
                    </a>
                </div>
                <div>
                    <a href="{{ handleRoute('items.edit', $item->id, $filters, true) }}" class="item-detail-edit rounded-circle p-2" title="{{ __('common.items.update') }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>
            </div>
            <div class="card-body overflow-hidden printable">
                <table>
                    <tr>
                        <td class="px-6 py-2 text-start whitespace-nowrap w-auto">
                            <img src="{{ $item->getPhoto() }}" alt="avatar" class=" object-fit-cover block w-24 h-24 rounded-sm mr-2 -my-2">
                        </td>
                        <td class="px-6  text-start"><img id="barcode"></img></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.name') }}</td>
                        <td class="px-6 ">
                            <strong>
                                {{ $item->name ?? ''}}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.sku') }}</td>
                        <td class="px-6 ">{{ $item->sku }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.category') }}</td>
                        <td class="px-6 ">{{ $item->category->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.rack_location') }}</td>
                        <td class="px-6 ">{{ $item->rack_location }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.unit') }}</td>
                        <td class="px-6 ">{{ $item->unit->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.track_serial') }}</td>
                        <td class="px-6 ">
                            @if ($item->track_serial)
                                <i class="bx bx-check bx-sm"></i>
                            @else
                                <i class="bx bx-x bx-sm"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.track_weight') }}</td>
                        <td class="px-6 ">
                            @if ($item->track_weight)
                                <i class="bx bx-check bx-sm"></i>
                            @else
                                <i class="bx bx-x bx-sm"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.track_quantity') }}</td>
                        <td class="px-6 ">
                            @if ($item->track_quantity)
                                <i class="bx bx-check bx-sm"></i>
                            @else
                                <i class="bx bx-x bx-sm"></i>
                            @endif
                        </td>
                    </tr>
                    @if ($item->has_variants)
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.variants') }}</td>
                            <td class="px-6 ">
                                @foreach ($item->variants as $variant)
                                    <strong>
                                        {{ $variant['name'] }}:
                                    </strong>

                                    @foreach ($variant['option'] as $option)
                                        {{ $option }}@if (!$loop->last),@endif
                                    @endforeach

                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td class="px-6 py-2 whitespace-nowrap">{{ __('attributes.item.details') }}</td>
                        <td class="px-6 ">{{ $item->details }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @foreach ($stocksGroupedByWarehouse as $stock)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card warehouse-card overflow-hidden">
                <div class="card-header d-flex align-items-center">
                    <span >{{ $stock[0]->warehouse->name ?? '' }} ({{$stock[0]->warehouse->code}})</span>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{__('attributes.item.quantity')}}</th>
                           <th class="text-end">
                            @php
                                $quantity = (float)0.00;
                                $weight = (float)0.00;
                                foreach ($stock as $key => $value) {
                                    if($item->has_variants == false) {
                                        $quantity += (float)$value->quantity;
                                        $weight += (float)$value->weight;
                                        break;
                                    }

                                    if($value->variation != null) {
                                        $quantity += (float)$value->quantity;
                                        $weight += (float)$value->weight;
                                    }
                                }
                                echo formatNumber($quantity).' '.$item->unit->code;
                                if ($item->track_weight) {
                                    echo ' ('.formatNumber($weight).' '.$weightUnit .')';
                                }
                            @endphp
                           </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stock as $each)
                            @if(!is_null($each->variation))
                                <tr>
                                    <td>
                                        @if(isset($each->variation->meta))
                                            @php
                                                $meta = $each->variation->meta;
                                                $metaDetails = [];
                                                foreach ($meta as $key => $value) {
                                                    $metaDetails[] = "{$key}: {$value}";
                                                }
                                                echo implode(', ', $metaDetails);
                                            @endphp
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        {{ $each->quantity}} {{$item->unit->code}}
                                        @if ($item->track_weight)
                                           ({{$each->weight}} {{ $weightUnit ?? 'kg' }})
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    @push('js')
        <script type="module">
            JsBarcode("#barcode", '{{ $item->code }}', {
                format: '{{ $item->symbology }}',
                lineColor: "#000000",
                width: 2,
                height: 100,
                displayValue: true
            });
        </script>
    @endpush
</x-app-layout>
