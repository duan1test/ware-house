<div class="table-responsive">
    <table class="table @if ($adjustments->total() > 0)  table-hover @endif" id="transfer-table">
        <thead>
          <tr>
              <th scope="col">{{ __('attributes.adjustment.adjustment') }}</th>
              <th scope="col">{{ __('attributes.adjustment.relation') }}</th>
              <th scope="col">{{ __('attributes.adjustment.detail') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @if ($adjustments->total() > 0)        
                @foreach ($adjustments as $adjustment)    
                    <tr class="clickable-row" data-id="{{ $adjustment->id }}">
                        <td scope="row">
                            <div class="">
                                <span class="">{{ __('attributes.adjustment.ref') }}:</span>
                                <span class="ms-1 text-black whitespace-normal">{{ $adjustment->reference }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="">{{ __('attributes.transfer.date') }}:</span>
                                <span class="ms-1 text-black">
                                    {{ \Carbon\Carbon::parse($adjustment->date)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="">Loại:</span>
                                <span class="ms-1 text-black">
                                    {{ adjustmentType($adjustment->type) }}
                                </span>
                            </div>
                            @if ($adjustment->draft == 1)
                                <div class="mt-2">
                                    <span class="">{{ __('attributes.transfer.draft') }}:</span>
                                    <span class="ms-1 h-4 w-4 text-success" style="">
                                        <i class="bx bx-check"></i>
                                    </span>
                                </div>
                            @endif
                            @if ($adjustment->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="">Kho:</span>
                                <span class="text-black ms-1">{{ $adjustment->warehouse->name }}</span>
                            </div>
                            <div class="d-flex mt-2">
                                <span class="">Người tạo:</span>
                                <span class="text-black ms-1">{{ $adjustment->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="max-w-[400px] whitespace-normal text-black line-clamp-3">
                                <p class="w-full">{{ $adjustment->details }}</p>
                            </div>
                        </td> 
                        <td class="text-end">
                            <a title="{{__('common.detail')}}" class="px-2 btn hover-color hover-info event-stop" href="{{ route('adjustments.show', [$adjustment->id, ...$filters]) }}">
                                <i class='bx bx-file-blank event-stop'></i>
                            </a>
                           <a title="{{__('common.edit')}}" href="{{ route('adjustments.edit', ['adjustment' => $adjustment->id, ...$filters]) }}" class="px-2 btn hover-color hover-warning event-stop">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            @if ($adjustment->deleted_at)
                                <form action="{{ route('adjustments.restore', $adjustment->id) }}" method="POST" class="d-inline" id="form-restore-{{ $adjustment->id }}">
                                    @csrf
                                    @method('PUT')
                                    <button title="{{__('common.restore')}}" type="button" data-id="{{ $adjustment->id }}" class="px-2 btn hover-color hover-warning form-restore">
                                        <i class="fa-solid fa-arrow-rotate-left fs-6"></i>
                                    </button>
                                </form>

                                <button title="{{__('common.soft-delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $adjustment->id }}" data-permanent="true">
                                    <i class='bx bx-trash'></i>
                                </button>
                            @else
                                <button title="{{__('common.delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $adjustment->id }}" data-permanent="false">
                                    <i class='bx bx-trash'></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center" style="cursor: auto;">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="row justify-content-between align-items-center mt-2">
    @if ($adjustments->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $adjustments->firstItem(),
                'to' => $adjustments->lastItem(),
                'total' => $adjustments->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $adjustments->links() }}
        </div>
    </div>
</div>