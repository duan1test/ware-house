<div class="table-responsive">
    <table class="table @if ($checkouts->total() > 0)  table-hover @endif" id="transfer-table">
        <thead>
          <tr>
              <th scope="col">{{ __('attributes.checkout.checkout') }}</th>
              <th scope="col">{{ __('attributes.adjustment.relation') }}</th>
              <th scope="col">{{ __('attributes.adjustment.detail') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @if ($checkouts->total() > 0)        
                @foreach ($checkouts as $checkout)    
                    <tr class="clickable-row" data-id="{{ $checkout->id }}">
                        <td scope="row">
                            <div class="">
                                <span class="">{{ __('attributes.checkout.ref') }}:</span>
                                <span class="ms-1 text-black whitespace-normal">{{ $checkout->reference }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="">{{ __('attributes.transfer.date') }}:</span>
                                <span class="ms-1 text-black">
                                    {{ \Carbon\Carbon::parse($checkout->date)->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($checkout->draft == 1)
                                <div class="mt-2">
                                    <span class="">{{ __('attributes.transfer.draft') }}:</span>
                                    <span class="ms-1 h-4 w-4 text-success" style="">
                                        <i class="bx bx-check"></i>
                                    </span>
                                </div>
                            @endif
                            @if ($checkout->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="">{{__('attributes.checkin.contact')}}:</span>
                                <span class="text-black ms-1">{{ $checkout->contact->name ?? '' }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="">{{__('attributes.adjustment.warehouse')}}:</span>
                                <span class="text-black ms-1">{{ $checkout->warehouse->name ?? '' }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="">{{__('attributes.adjustment.user')}}:</span>
                                <span class="text-black ms-1">{{ $checkout->user->name ?? '' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="max-w-[400px] whitespace-normal text-black line-clamp-3">
                                <p class="w-full">{{ $checkout->details }}</p>
                            </div>
                        </td> 
                        <td class="text-end">
                            <a title="{{__('common.detail')}}" class="btn hover-color hover-info event-stop" href="{{ route('checkouts.show', [$checkout->id, ...$filters]) }}">
                                <i class='bx bx-file-blank event-stop'></i>
                            </a>
                            <a title="{{__('common.edit')}}" href="{{ route('checkouts.edit', ['checkout' => $checkout->id, ...$filters]) }}" class="px-2 btn hover-color hover-warning event-stop">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            @if ($checkout->deleted_at)
                                <form action="{{ route('checkouts.restore', $checkout->id) }}" method="POST" class="d-inline" id="form-restore-{{ $checkout->id }}">
                                    @csrf
                                    @method('PUT')
                                    <button title="{{__('common.restore')}}" type="button" data-id="{{ $checkout->id }}" class="px-2 btn hover-color hover-warning form-restore">
                                        <i class="fa-solid fa-arrow-rotate-left fs-6"></i>
                                    </button>
                                </form>

                                <button title="{{__('common.soft-delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $checkout->id }}" data-permanent="true">
                                    <i class='bx bx-trash'></i>
                                </button>
                            @else
                                <button title="{{__('common.delete')}}" type="button" class="px-2 btn hover-color hover-danger soft-delete" data-id="{{ $checkout->id }}" data-permanent="false">
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
    @if ($checkouts->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $checkouts->firstItem(),
                'to' => $checkouts->lastItem(),
                'total' => $checkouts->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $checkouts->links() }}
        </div>
    </div>
</div>