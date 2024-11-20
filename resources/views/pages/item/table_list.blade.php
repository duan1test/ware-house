<div class="table-responsive">
    <table class="table table-hover" id="items-table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 5%" scope="col">{{ __('attributes.item.photo') }}</th>
                <th style="width: 20%" scope="col">{{ __('attributes.role.name') }}</th>
                <th style="width: 20%" scope="col">{{ __('attributes.item.options') }}</th>
                <th style="width: 20%" scope="col">{{ __('attributes.item.variants') }}</th>
                <th style="width: 20%" scope="col">{{ __('attributes.item.relations') }}</th>
                <th style="width: 15%" scope="col">{{ __('attributes.item.stock') }}</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            @if ($items->total() > 0)
                @foreach ($items as $item)
                    <tr data-id="{{ $item->id }}" class="clickable-row">
                        <td class="text-center">
                            <span class="img-row img-item">
                                <img src="{{ $item->getPhoto() }}" alt="avatar" class="user-img me-2">
                            </span>
                        </td>
                        <td class="p-3" scope="row">
                            <div class="max-w-60">
                                <div class="fw-bold text-dark text-wrap">{{ $item->name }}</div>
                                    <div>{{ __('attributes.item.code') }}: <span class="fw-bold text-dark">{{ $item->code }}</span></div>

                                    @if ($item->sku)
                                        <div>{{ __('attributes.item.sku') }}:
                                            <span class="text-dark">{{ $item->sku }}</span></div>
                                    @endif

                                    @if ($item->symbology)
                                        <div>{{ __('attributes.item.barcode_symbology') }}:
                                            <span class="text-dark">{{ $item->symbology }}</span>
                                        </div>
                                    @else
                                        <div>
                                            {{ __('attributes.item.barcode_symbology') }}:
                                            <span class="text-dark">CODE128</span>
                                        </div>
                                    @endif

                                    @if ($item->deleted_at)
                                        <i class="bx bx-trash text-danger"></i>
                                    @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                {{ __('attributes.item.track_weight') }}
                                <i
                                    class='fw-bold bx bx-{{ $item->track_weight ? 'check' : 'x' }} text-{{ $item->track_weight ? 'success' : 'danger' }}'></i>
                            </div>
                            <div>
                                {{ __('attributes.item.track_quantity') }}
                                <i
                                class='fw-bold bx bx-{{ $item->track_quantity ? 'check' : 'x' }} text-{{ $item->track_quantity ? 'success' : 'danger' }}'></i>
                            </div>
                            @if ($item->track_quantity)
                                <div>{{ __('attributes.item.alert_quantity') }}: <span class="text-dark"> {{ formatNumber((float)$item->alert_quantity) }}</span></div>
                            @endif
                        </td>
                        <td>
                            @if ($item->variants && $item->has_variants == 1)
                            <div class="w-48">
                                @foreach ($item->variants as $variant)
                                    <div class="whitespace-normal">
                                        <span class="fw-bold text-dark">
                                            {{ $variant['name'] }}:
                                        </span>

                                        @foreach ($variant['option'] as $option)
                                            {{ $option }}@if (!$loop->last),@endif
                                        @endforeach

                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </td>

                        <td>
                            @if ($item->category)
                                <div>
                                    <span class="text-dark">{{ $item->category->name }}</span></div>
                            @endif
                            @if ($item->unit)
                                <div>{{ __('attributes.item.unit') }}:
                                    <span class="text-dark">{{ $item->unit->name }}</span></div>
                            @endif
                        </td>
                        <td>
                            <div class="pe-14 py-4 w-56 whitespace-nowrap">
                                <div class="w-full flex flex-col items-center justify-between text-right">
                                    @if ($item->track_weight == true)
                                        <div class="w-full flex items-center justify-between">
                                            <span class="text-gray-600">{{ __('attributes.item.weight') }}: </span>
                                            <span class="font-bold text-black">
                                                @php
                                                    $weight = (float)0.00;
                                                    foreach ($item->stock as $key => $value) {
                                                        $weight += (float)$value->weight;
                                                    }
                                                    echo formatNumber($weight);
                                                @endphp
                                            </span>
                                        </div>
                                    @endif
                                    <div class="w-full flex items-center justify-between">
                                        <span class="text-gray-600">{{ __('attributes.item.quantity') }}: </span>
                                        <span class="font-bold text-black">
                                            @php
                                                $quantity = (float)0.00;
                                                foreach ($item->stock as $key => $value) {
                                                    $quantity += (float)$value->quantity;
                                                }
                                                echo formatNumber($quantity);
                                            @endphp
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-evenly">
                                <a title="{{__('common.trail')}}" class="px-2 btn hover-color hover-info event-stop" href="{{ route('items.trail', [$item->id, 'q' => $filters['search'], 'trashed' => $filters['trashed']]) }}">
                                    <i class='bx bx-list-ul event-stop'></i>
                                </a>

                                <a title="{{__('common.detail')}}" class="px-2 btn hover-color hover-info event-stop" href="{{ route('items.show', [$item->id, 'q' => $filters['search'], 'trashed' => $filters['trashed']]) }}">
                                    <i class='bx bx-file-blank event-stop'></i>
                                </a>

                                <a title="{{__('common.edit')}}" class="px-2 btn hover-color hover-warning event-stop" href="{{ route('items.edit', [$item->id, 'q' => $filters['search'], 'trashed' => $filters['trashed']]) }}">
                                    <i class='bx bx-edit-alt event-stop'></i>
                                </a>

                                @if ($item->deleted_at)
                                    <form action="{{ route('items.restore', $item->id) }}" method="POST" class="d-inline" id="form-restore-{{ $item->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button title="{{__('common.restore')}}" type="button" data-id="{{ $item->id }}" class="px-2 btn hover-color hover-warning form-restore">
                                            <i class="fa-solid fa-arrow-rotate-left fs-6"></i>
                                        </button>
                                    </form>

                                    <button title="{{__('common.soft-delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $item->id }}" data-permanent="true">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                @else
                                    <button title="{{__('common.delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $item->id }}" data-permanent="false">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="6">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="row justify-content-between align-items-center mt-2">
    @if ($items->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'total' => $items->total(),
            ]) }}
        </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $items->links() }}
        </div>
    </div>
</div>
