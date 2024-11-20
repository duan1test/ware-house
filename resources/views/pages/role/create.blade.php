<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.role.create') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title my-3">{{ __('common.role.create') }}</h5>
        </div>
        <div class="card-body">
            <form id="form-create-role" action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">
                                {{ __('attributes.role.name') }}
                                <span class="text-danger"> *</span>
                            </label>
                            <input value="{{ old('name') }}" type="text" name="name" class="form-control"
                                placeholder="{{ __('attributes.role.name') }}">
                            @error('name')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-role btn btn-primary py-2">{{ __('common.create') }}</button>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.querySelector('.btn-store-role').addEventListener('click', function() {
                document.querySelector('#form-create-role').submit();
            });
        </script>
    @endpush
</x-app-layout>
