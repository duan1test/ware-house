<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th style="width: 75%" scope="col">{{ __('attributes.role.name') }}</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
            @if ($roles->total() > 0)
                @foreach ($roles as $item)
                    <tr>
                        <td class="p-3" scope="row">
                            {{ $item->name }}
                            @if ($item->deleted_at)
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td class="text-center p-0">
                            @if ($item->name != 'Super Admin')
                                <div title="{{__('common.edit')}}" class="btn hover-color hover-warning" onclick="location.href='{{ route('roles.edit', $item->id) }}'">
                                    <i class='bx bx-edit-alt' ></i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="3">{{ __('common.no_data') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="row justify-content-between align-items-center">
    @if ($roles->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $roles->firstItem(),
                'to' => $roles->lastItem(),
                'total' => $roles->total(),
            ]) }}
        </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $roles->links() }}
        </div>
    </div>
</div>
