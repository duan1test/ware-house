<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 20%;">{{ __('attributes.unit.name') }}</th>
                <th style="width: 20%;">{{ __('attributes.unit.code') }}</th>
                <th style="width: 20%;">{{ __('attributes.unit.base_unit') }}</th>
                <th style="width: 20%;">{{ __('attributes.unit.formula') }}</th>
                <th style="width: 20%;"></th>
            </tr>
        </thead>
        <tbody>
            @if ($units->total() > 0)
                @foreach ($units as $unit)
                    <tr>
                        <td>
                            {{ $unit->name }}
                            @if ($unit->deleted_at)     
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>{{ $unit->code }}</td>
                        <td>
                            {{ $unit->baseUnit ? $unit->baseUnit->name . ' (' . $unit->baseUnit->code . ')' : '' }}
                        </td>
                        <td>
                            @if ($unit->baseUnit)
                                <span class="unit-formula">
                                    {{ $unit->baseUnit->name }} ({{ $unit->baseUnit->code }}) 
                                    {{ $unit->operator ? $unit->operator : '' }}
                                    {{ fmod($unit->operation_value, 1) == 0 ? (int) $unit->operation_value : number_format($unit->operation_value, 2) }} =
                                    {{ $unit->name }} ({{ $unit->code }})
                                </span>
                            @else
                                <span></span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a title="{{__('common.edit')}}" class="btn hover-color hover-warning" href="{{ route('units.edit', ['unit'=>$unit->id, ...$filters]) }}">
                                <i class='bx bx-edit-alt' ></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="5">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


<div class="row justify-content-between align-items-center">
    @if ($units->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $units->firstItem(),
                'to' => $units->lastItem(),
                'total' => $units->total(),
            ]) }}
        </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $units->links() }}
        </div>
    </div>
</div>
@push('js')
    <script>
        function redirect(url) {
            location.href = url;
        }
    </script>
@endpush
