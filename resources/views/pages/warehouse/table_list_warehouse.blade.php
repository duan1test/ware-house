<div class="table-responsive">
    <table class="table @if ($warehouses->total() > 0)  table-hover @endif" id="warehouse-table">
        <thead>
          <tr>
            <th scope="col">{{ __('attributes.warehouse.name') }}</th>
            <th scope="col">{{ __('attributes.warehouse.contact') }}</th>
            <th scope="col">{{ __('attributes.warehouse.address') }}</th>
            <th scope="col" class="text-center">{{ __('attributes.warehouse.status') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @if ($warehouses->total() > 0)        
                @foreach ($warehouses as $warehouse)    
                    <tr>
                        <td scope="row">
                            <div class="d-flex align-items-center justify-content-start">
                                <span class="img-row">
                                    <img src="{{ $warehouse->getLogo() }}" alt="">
                                </span>
                                <span class="">{{ $warehouse->name }} ({{ $warehouse->code }})</span>
                                @if ($warehouse->deleted_at)     
                                    <span class="ms-1"><i class="bx bx-trash text-danger"></i></span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="">{{ $warehouse->phone }}</div>
                            <div class="">{{ $warehouse->email }}</div>
                        </td>
                        <td>{{ $warehouse->address }}</td>
                        <td  class="text-center">
                            @if ($warehouse->active > 0 )
                                <div class="badge badge-success">
                                    <i class="bx bx-check" style="color: #fff"></i> 
                            @else
                                <div class="badge badge-danger">
                                    <i class="bx bx-x" style="color: #fff"></i> 
                            @endif
                                    <span>{{ $warehouse->getActiveLabel() }}</span>
                                </div>
                        </td>
                        <td class="text-end data-link">
                            <a title="{{__('common.edit')}}" class="btn hover-color hover-warning" href="{{ route('warehouses.show', ['warehouse'=>$warehouse->id, ...$filters]) }}">
                                <i class='bx bx-edit-alt' ></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="cursor: auto;">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="row justify-content-between align-items-center">
    @if ($warehouses->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $warehouses->firstItem(),
                'to' => $warehouses->lastItem(),
                'total' => $warehouses->total(),
            ]) }}
        </div>
    @endif
    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $warehouses->links() }}
        </div>
    </div>
</div>