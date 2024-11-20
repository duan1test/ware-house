<div class="table-responsive">
    <table class="table @if ($checkins->total() > 0)  table-hover @endif" id="transfer-table">
        <thead>
          <tr>
              <th scope="col">{{ __('attributes.checkin.checkin') }}</th>
              <th scope="col">{{ __('attributes.adjustment.relation') }}</th>
              <th scope="col">{{ __('attributes.adjustment.detail') }}</th>
          </tr>
        </thead>
        <tbody>
            @if ($checkins->total() > 0)        
                @foreach ($checkins as $checkin)    
                    <tr class="clickable-row" data-id="{{ $checkin->id }}">
                        <td scope="row">
                            <div class="">
                                <span class="">{{ __('attributes.checkin.ref') }}:</span>
                                <span class="ms-1 text-black whitespace-normal">{{ $checkin->reference }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="">{{ __('attributes.transfer.date') }}:</span>
                                <span class="ms-1 text-black">
                                    {{ \Carbon\Carbon::parse($checkin->date)->format('d/m/Y') }}
                                </span>
                            </div>
                            @if ($checkin->draft == 1)
                                <div class="mt-2">
                                    <span class="">{{ __('attributes.transfer.draft') }}:</span>
                                    <span class="ms-1 h-4 w-4 text-success" style="">
                                        <i class="bx bx-check"></i>
                                    </span>
                                </div>
                            @endif
                            @if ($checkin->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <span class="">{{__('attributes.checkin.contact')}}:</span>
                                <span class="text-black ms-1">{{ $checkin->contact->name ?? '' }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="">{{__('attributes.adjustment.warehouse')}}:</span>
                                <span class="text-black ms-1">{{ $checkin->warehouse->name ?? '' }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="">{{__('attributes.adjustment.user')}}:</span>
                                <span class="text-black ms-1">{{ $checkin->user->name ?? '' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="max-w-[400px] whitespace-normal text-black line-clamp-3">
                                <p class="w-full">{{ $checkin->details }}</p>
                            </div>
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
    @if ($checkins->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $checkins->firstItem(),
                'to' => $checkins->lastItem(),
                'total' => $checkins->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $checkins->links() }}
        </div>
    </div>
</div>