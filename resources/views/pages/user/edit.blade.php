<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ handleRoute(route: 'users.index', options: $filters) }}">{{ __('common.user.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }} - {{ $user->username }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
           <div class="d-flex align-items-center">
                <a href="{{ handleRoute(route: 'users.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.user.update') }} ({{$user->name}})</h5>
           </div>
            @if ($user->deleted_at != null)
            <div class="row">
                <div class="mt-3">
                    <div class="alert alert-warning d-flex flex-row justify-content-between align-items-center" role="alert">
                        <div class="flex justify-start items-center gap-2">
                            <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                            <span>{{ __('attributes.user.soft_delete') }}</span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <form method="POST" id="form-restore-{{ $user->id }}" action="{{ route('users.restore',  ['user' => $user->id]) }}" style="margin-right: 10px;">
                                @csrf
                                @method('PUT')
                                <button type="button" data-id="{{ $user->id }}" class="btn btn-warning btn-sm form-restore">
                                    {{ __('common.restore') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post" id="form-update-user">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.name') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.name') }}">
                        @error('name')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('attributes.user.email') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="email" type="text" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.email') }}">
                        @error('email')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.username') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="username" type="text" value="{{ old('username', $user->username) }}"
                            class="form-control @error('username') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.username') }}">
                        @error('username')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('attributes.user.phone') }}</label>
                        <input name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.phone') }}">
                        @error('phone')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.roles') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        @php
                            $myRole = $user->roles->first();
                        @endphp
                        <select name="role" class="form-select form-control choices @error('role') is-invalid @enderror">
                            <option value="" placeholder>{{ __('common.select') }}</option>
                            @foreach ($roles as $key => $role)
                                <option @if (old('role', $myRole->id) == $key) selected @endif value="{{ $key }}">
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('attributes.user.warehouse') }}</label>
                        @if (count($warehouses) == 0)
                            <input type="text" readonly name="warehouse_id" placeholder="{{ __('common.no_data') }}"
                                class="form-control">
                        @else
                            <select name="warehouse_id"
                                class="form-select form-control choices @error('warehouse_id') is-invalid @enderror">
                                <option value="" placeholder>{{ __('common.select') }}</option>
                                @foreach ($warehouses as $key => $warehouse)
                                    <option @if (old('warehouse_id', $user->warehouse_id) == $key) selected @endif
                                        value="{{ $key }}">{{ $warehouse }}</option>
                                @endforeach
                            </select>
                        @endif
                        @error('warehouse_id')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-none">
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            {{ __('attributes.user.permissions') }}
                        </label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check me-4">
                                <input @if (old('view_all', $user->view_all)) checked @endif class="form-check-input"
                                    type="checkbox" value="1" id="view_all_checkbox" name="view_all">
                                <label class="form-check-label ml-2"
                                    for="view_all_checkbox">{{ __('common.can_view_all_record') }}</label>
                            </div>

                            <div class="form-check me-4">
                                <input @if (old('edit_all', $user->edit_all)) checked @endif class="form-check-input"
                                    type="checkbox" value="1" id="edit_all_checkbox" name="edit_all">
                                <label class="form-check-label ml-2"
                                    for="edit_all_checkbox">{{ __('common.can_edit_all_record') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div class="text-start">
                    <form action="{{ !$user->deleted_at ? route('users.destroy', $user->id) : route('users.destroy.permanently', $user->id) }}" method="post">
                        @csrf
                        @method('delete')
                        @if (!$user->deleted_at)
                            <button type="button" data-permanent="false" 
                                class="btn-delete-user btn btn-default py-2 text-danger">{{ __('common.delete') }}
                            </button>
                        @else
                            <button type="button" data-permanent="true" 
                                class="btn-delete-user btn btn-default py-2 text-danger">{{ __('common.delete') }}
                            </button>
                        @endif
                    </form>
                </div>
                <div class="text-end">
                    <button class="btn-update-user btn btn-primary py-2">{{ __('common.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.user.update_password') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post" id="form-update-user-password">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="password">
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.password') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input type="password" name="password" value="{{ old('password') }}"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.password') }}">
                        @error('password')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('attributes.user.confirm_password') }}</label>
                        <input name="password_confirmation" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.confirm_password') }}">
                        @error('password_confirmation')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <div class="text-end">
                    <button class="btn-update-user btn btn-primary py-2">{{ __('common.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            // update user
            $('.btn-update-user').click(function() {
                const form = $(this).closest('.card').find('#form-update-user,#form-update-user-password');
                form.submit();
            });

            // delete user
            $('.btn-delete-user').click(function() {
                const form = $(this).closest('form');
                let button = $(this).closest('button[type="button"]');
                let isPermanentDelete = button.data('permanent');
                let htmlMessage = isPermanentDelete 
                    ? "{{ __('common.alert_permanent_delete') }}" 
                    : "";

                showConfirm("{{ __('common.confirm_delete') }}", function() {
                    form.submit();
                }, {
                    icon: "warning",
                    html: htmlMessage,
                    reverseButtons: true,
                    confirmButtonText: "{{ __('common.swal_button.confirm') }}",
                    cancelButtonText: "{{ __('common.swal_button.cancel') }}",
                });
            });

            $('.form-restore').on('click', function(){
                const id = $(this).data('id');
                Swal.fire({
                    title: '{{ __('common.confirm_restore') }}',
                    showCancelButton: true,
                    icon: "warning",
                    reverseButtons: true,
                    confirmButtonText: "{{ __('common.swal_button.confirm') }}",
                    cancelButtonText: "{{ __('common.swal_button.cancel') }}",
                    customClass: {
                        title: 'd-flex',
                        actions: 'w-100 justify-content-center'
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#form-restore-${id}`).submit();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
