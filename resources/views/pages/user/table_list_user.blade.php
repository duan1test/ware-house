<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 40%;">{{ __('attributes.user.name') }}</th>
                <th style="width: 40%;">{{ __('attributes.user.email') }}</th>
                <th style="width: 10%;">{{ __('attributes.user.roles') }}</th>
                <th style="width: 10%;"></th>
            </tr>
        </thead>
        <tbody>
            @if ($users->total() > 0)
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <img src="{{ asset('assets/images/default_avatar.png') }}" alt="avatar"
                                class="user-img me-2">
                            {{ $user->name }}
                            @if ($user->deleted_at)
                                <span><i class="bx bx-trash text-danger"></i></span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->roles->first()->name ?? ''}}
                        </td>
                        <td class="text-end">
                            <a title="{{__('common.edit')}}" class="btn hover-color hover-warning" href="{{ route('users.show', ['user'=>$user->id, ...$filters]) }}">
                                <i class='bx bx-edit-alt' ></i>
                            </a>
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
    @if ($users->total() > 0)
        <div class="col-12 col-md-6 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
            {{ __('common.paginate_info', [
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
                'total' => $users->total(),
            ]) }}
        </div>
    @endif

    <div class="col-12 col-md-6">
        <div class="d-flex justify-content-center justify-content-md-end">
            {{ $users->links() }}
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
