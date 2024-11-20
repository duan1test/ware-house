<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ handleRoute(route: 'contacts.index', options: $filters) }}">{{ __('common.contact.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.contact.update') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ handleRoute(route: 'contacts.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.contact.update') }}</h5>
            </div>
            @if ($contact->deleted_at != null)
                <div class="row">
                    <div class="mt-3">
                        <div class="alert alert-warning d-flex flex-row justify-content-between align-items-center" role="alert">
                            <div class="flex justify-start items-center gap-2">
                                <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                                <span>{{ __('attributes.contact.soft_delete') }}</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <form method="POST" id="form-restore-{{ $contact->id }}" action="{{ route('contacts.restore',  ['contact' => $contact->id]) }}" style="margin-right: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" data-id="{{ $contact->id }}" class="btn btn-warning btn-sm form-restore">
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
            <form action="{{ route('contacts.update',$contact->id) }}" method="post" id="form-update-contact">
                @csrf
                @method('PUT')
                <div class=" mb-3">
                    <label class="form-label">
                        {{ __('attributes.contact.name') }}
                        <span class="text-danger" style="margin-top: 5px;"> *</span>
                    </label>
                    <input name="name" type="text" value="{{ old('name', $contact->name) }}"
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
                    <input name="email" type="text" value="{{ old('email', $contact->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('attributes.user.email') }}">
                    @error('email')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        {{ __('attributes.user.phone') }}
                    </label>
                    <input name="phone" type="text" value="{{ old('phone', $contact->phone) }}"
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="{{ __('attributes.user.phone') }}">
                    @error('phone')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('attributes.item.details') }}</label>
                    <textarea name="details" type="text" 
                        class="form-control @error('details') is-invalid @enderror">{{ old('details', $contact->details) }}</textarea>
                    @error('details')
                        <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div class="text-start">
                    <form id="form-delete" action="{{ !$contact->deleted_at ? route('contacts.destroy', $contact->id) : route('contacts.destroy.permanently', $contact->id) }}" method="post">
                        @csrf
                        @method('delete')
                            @if (!$contact->deleted_at)
                                <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="false">
                                    {{ __('common.delete') }} 
                                </button>
                            @else
                                <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="true">
                                    {{ __('common.delete') }}
                                </button>
                            @endif
                    </form>
                </div>
                <div class="text-end">
                    <button class="btn-update-contact btn btn-primary py-2">
                        {{ __('common.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function () {
                document.querySelector('.btn-update-contact').addEventListener('click', function() {
                    document.querySelector('#form-update-contact').submit();
                });

                $('.btn-delete-item').click(function(e) {
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
            });
        </script>
    @endpush
</x-app-layout>
