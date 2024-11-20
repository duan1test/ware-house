<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.contact.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.contact.create') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('contacts.store') }}" method="post" id="form-create-contact">
                @csrf
                <div class=" mb-3">
                    <label class="form-label">
                        {{ __('attributes.contact.name') }}
                        <span class="text-danger" style="margin-top: 5px;"> *</span>
                    </label>
                    <input name="name" type="text" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="{{ __('attributes.contact.name') }}">
                    @error('name')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class=" mb-3">
                    <label class="form-label">
                        {{ __('attributes.user.email') }}
                        <span class="text-danger" style="margin-top: 5px;"> *</span>
                    </label>
                    <input name="email" type="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('attributes.user.email') }}">
                    @error('email')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('attributes.user.phone') }}</label>
                    <input name="phone" type="text" value="{{ old('phone') }}"
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="{{ __('attributes.user.phone') }}">
                    @error('phone')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('attributes.item.details') }}</label>
                    <textarea name="details" type="text"
                        class="form-control @error('details') is-invalid @enderror">{{ old('details') }}</textarea>
                    @error('details')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-contact btn btn-primary py-2">
                    {{ __('common.create') }}
                </button>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            document.querySelector('.btn-store-contact').addEventListener('click', function() {
                document.querySelector('#form-create-contact').submit();
            });
        </script>
    @endpush
</x-app-layout>
