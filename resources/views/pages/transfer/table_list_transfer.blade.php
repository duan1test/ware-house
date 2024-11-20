<div class="table-responsive">
    <table class="table @if ($transfers->total() > 0)  table-hover @endif" id="transfer-table">
        <thead>
          <tr>
              <th scope="col">{{ __('attributes.transfer.transfer') }}</th>
              <th scope="col">{{ __('attributes.transfer.relations') }}</th>
              <th scope="col">{{ __('attributes.transfer.details') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @if ($transfers->total() > 0)        
                @foreach ($transfers as $transfer)    
                    <tr class="clickable-row" data-id="{{ $transfer->id }}">
                        <td scope="row">
                            <div class="">
                                <span class="">{{ __('attributes.transfer.ref') }}:</span>
                                <span class="ms-1 text-black whitespace-normal">{{ $transfer->reference }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="">{{ __('attributes.transfer.date') }}:</span>
                                <span class="ms-1 text-black">
                                    {{ \Carbon\Carbon::parse($transfer->date)->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($transfer->draft == 1)
                                <div class="mt-2">
                                    <span class="">{{ __('attributes.transfer.draft') }}:</span>
                                    <span class="ms-1 h-4 w-4 text-success" style="">
                                        <i class="bx bx-check"></i>
                                    </span>
                                </div>
                            @endif
                            @if ($transfer->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="">{{ __('attributes.transfer.warehouse_to') }}:</span>
                                <span class="text-black ms-1">{{ $transfer->toWarehouse->name }}</span>
                            </div>
                            <div class="d-flex mt-2">
                                <span class="">{{ __('attributes.transfer.warehouse_from') }}:</span>
                                <span class="text-black ms-1">{{ $transfer->fromWarehouse->name }}</span>
                            </div>
                            <div class="d-flex mt-2">
                                <span class="">{{ __('attributes.transfer.user') }}:</span>
                                <span class="text-black ms-1">{{ $transfer->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="max-w-[400px] whitespace-normal text-black line-clamp-3">
                                <p class="w-full">{{ $transfer->details }}</p>
                            </div>
                        </td> 
                        <td class="text-end">
                            <a title="{{__('common.detail')}}" class="px-2 btn hover-color hover-info event-stop" href="{{ route('transfers.show', [$transfer->id, ...$filters]) }}">
                                <i class='bx bx-file-blank event-stop'></i>
                            </a>
                            <a title="{{__('common.edit')}}" href="{{ route('transfers.edit', ['transfer' => $transfer->id, ...$filters]) }}" class="px-2 btn hover-color hover-warning event-stop">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            @if ($transfer->deleted_at)
                                <form action="{{ route('transfers.restore', $transfer->id) }}" method="POST" class="d-inline" id="form-restore-{{ $transfer->id }}">
                                    @csrf
                                    @method('PUT')
                                    <button title="{{__('common.restore')}}" type="button" data-id="{{ $transfer->id }}" class="px-2 btn hover-color hover-warning form-restore">
                                        <i class="fa-solid fa-arrow-rotate-left fs-6"></i>
                                    </button>
                                </form>

                                <button title="{{__('common.soft-delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $transfer->id }}" data-permanent="true">
                                    <i class='bx bx-trash'></i>
                                </button>
                            @else
                                <button title="{{__('common.delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $transfer->id }}" data-permanent="false">
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
    @if ($transfers->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $transfers->firstItem(),
                'to' => $transfers->lastItem(),
                'total' => $transfers->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $transfers->links() }}
        </div>
    </div>
</div>