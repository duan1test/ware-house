<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('common.role.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.role.update') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('roles.index') }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title my-3">{{ __('common.role.update') }}</h5>
            </div>
            @if ($role->deleted_at)
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center alert alert-warning" role="alert">
                            <div class="flex justify-start items-center gap-2">
                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                <span>{{ __('attributes.role.soft_delete') }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <form method="POST" action="{{ route('roles.restore',  ['role' => $role->id]) }}" style="margin-right: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning btn-sm">
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
            <form id="form-update-role" action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="type" value="role">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">
                                {{ __('attributes.role.name') }}
                                <span class="text-danger"> *</span>
                            </label>
                            <input value="{{ old('name', $role->name) }}" type="text" name="name"
                                class="form-control" placeholder="{{ __('attributes.role.name') }}">
                            @error('name')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div
                class="text-end d-flex @if (!$role->deleted_at) justify-content-between @else justify-content-between @endif">
                @if (!$role->deleted_at)
                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn-delete-role btn btn-default text-danger py-2">{{ __('common.delete') }}</button>
                    </form>
                @else
                    <form action="{{ route('roles.destroy.permanently', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn-delete-role btn-delete btn btn-default text-danger py-2" data-permanent="true">
                            {{ __('common.delete') }}
                        </button>
                    </form>
                @endif
                <button class="btn-update-role btn btn-primary py-2">{{ __('common.save') }}</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h5 class="page-title my-3">{{ __('common.permission.update') }}</h5>
            <div class="d-flex gap-3 page-title my-3">
                <input type="checkbox" id="permissions" class="full-permission form-check-input">
                <label for="permissions">{{ __('common.permission.select_all') }}</label>
            </div>
        </div>
        <div class="card-body">
            <form id="form-update-permission" action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="type" value="permission">
                <div>
                    @foreach ($permissions as $key => $item)
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                {{ ucwords($translationMap[$key] ?? $key) }}
                            </label>
                            <div class="d-flex flex-wrap">
                                @foreach ($item as $key => $permission)
                                    <div class="form-check col-md-3 col-6">
                                        <input name="permissions[]" value="{{ $key }}"
                                            class="permission form-check-input ml-0" type="checkbox"
                                            @if ($role->permissions->where('id', $key)->count() > 0) checked @endif
                                            id="checkPermission_{{ $key }}">
                                        <label class="form-check-label ml-2"
                                            for="checkPermission_{{ $key }}">{{ $permission }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end d-flex justify-content-between">
                <button class="btn-update-permission btn btn-primary py-2">{{ __('common.save') }}</button>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">
            $(document).ready(function () {
                // update role
                $('.btn-update-role').click(function() {
                    $('#form-update-role').submit();
                });
            
                // update permission
                $('.btn-update-permission').click(function() {
                    $('#form-update-permission').submit();
                });
            
                // delete role
                $('.btn-delete-role').click(function() {
                    const form = this.closest('form');
                    let button = $(this).closest('button[type="button"]');
                    let isPermanentDelete = button.data('permanent');
                
                    let htmlMessage = isPermanentDelete 
                            ? "{{ __('common.alert_permanent_delete') }}" 
                            : "";
                
                    showConfirm(`{{ __('common.confirm_delete') }}`, function() {
                        form.submit();
                    }, {
                        icon: "warning",
                        html: htmlMessage,
                        reverseButtons: true,
                        confirmButtonText: "{{ __('common.swal_button.confirm') }}",
                        cancelButtonText: "{{ __('common.swal_button.cancel') }}",
                    });
                });
            
                // full permission
                $('.full-permission').click(function() {
                    $('#form-update-permission').closest('form').find('input[name="permissions[]"]').prop('checked', $('.full-permission').is(':checked'));
                });
            
                function countChecked() {
                    var n = $( "#form-update-permission input:checked" ).length;
                    
                    if (n == 50) {
                        $('.full-permission').prop('checked',true);
                    }else{
                        $('.full-permission').prop('checked',false);
                    }
                    
                };
            
                $( "input[type=checkbox]" ).on( "click", function(){
                    countChecked();
                });
            
                countChecked();
            });
        </script>
    @endpush
</x-app-layout>
