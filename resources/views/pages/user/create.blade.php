<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.user.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.user.create') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post" id="form-create-user">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.name') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="name" type="text" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.name') }}">
                        @error('name')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('attributes.user.password') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.password') }}">
                        @error('password')
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
                        <input name="username" type="text" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.username') }}">
                        @error('username')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('attributes.user.confirm_password') }}</label>
                        <input name="confirm_password" type="password"
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.confirm_password') }}">
                        @error('confirm_password')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ __('attributes.user.email') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="email" type="text" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.email') }}">
                        @error('email')
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
                                    <option @if (old('warehouse_id') == $key) selected @endif
                                        value="{{ $key }}">
                                        {{ $warehouse }}</option>
                                @endforeach
                            </select>
                        @endif
                        @error('warehouse_id')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('attributes.user.phone') }}</label>
                        <input name="phone" type="text" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="{{ __('attributes.user.phone') }}">
                        @error('phone')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            {{ __('attributes.user.roles') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <select name="role"
                            class="form-select form-control choices @error('role') is-invalid @enderror">
                            <option value="" placeholder>{{ __('common.select') }}</option>
                            @foreach ($roles as $key => $role)
                                <option @if (old('role') == $key) selected @endif value="{{ $key }}">
                                    {{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row d-none">
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            {{ __('attributes.user.permissions') }}
                        </label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check me-4">
                                <input @if (old('view_all', false)) checked @endif class="form-check-input"
                                    type="checkbox" value="1" id="view_all_checkbox" name="view_all">
                                <label class="ml-2 form-check-label"
                                    for="view_all_checkbox">{{ __('common.can_view_all_record') }}</label>
                            </div>

                            <div class="form-check me-4">
                                <input @if (old('edit_all', false)) checked @endif class="form-check-input"
                                    type="checkbox" value="1" id="edit_all_checkbox" name="edit_all">
                                <label class="ml-2 form-check-label"
                                    for="edit_all_checkbox">{{ __('common.can_edit_all_record') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-user btn btn-primary py-2">
                    {{ __('common.create') }}
                </button>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.querySelector('.btn-store-user').addEventListener('click', function() {
                document.querySelector('#form-create-user').submit();
            });
        </script>
    @endpush
</x-app-layout>
