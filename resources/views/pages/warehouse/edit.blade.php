<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ handleRoute(route: 'warehouses.index', options: $filters) }}">{{ __('common.warehouse.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $warehouse->name }} - {{ $warehouse->code }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ handleRoute(route: 'warehouses.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title my-3">{{ __('common.warehouse.update') }} ({{$warehouse->name}})</h5>
            </div>
            @if ($warehouse->deleted_at)    
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                    <div class="d-flex justify-content-between align-items-center alert alert-warning" role="alert">
                        <span>
                            {{ __('attributes.warehouse.soft_delete') }}
                        </span>
                        <div class="d-flex justify-content-end">
                            <form method="POST" action="{{ route('warehouses.restore',  ['warehouse' => $warehouse->id]) }}" style="margin-right: 10px;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ __('common.warehouse.restore') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <form method="POST" id="form-update" action="{{ route('warehouses.update', $warehouse->id) }}" style="display: contents;" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="card-body"> 
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-code" class="form-label">{{ __('attributes.warehouse.code') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="error-code" onkeyup="checkValue('error-code')" class="form-control" value="{{ old('code',$warehouse->code) }}" placeholder="{{ __('attributes.warehouse.code') }}" name="code" >
                            <div class="error-code hidden text-danger error-message"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-name" class="form-label is-invalid">{{ __('attributes.warehouse.name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="error-name" onkeyup="checkValue('error-name')" class="form-control" value="{{ old('name',$warehouse->name) }}" placeholder="{{ __('attributes.warehouse.name') }}" name="name">
                            <div class="error-name hidden text-danger error-message"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-phone" class="form-label">{{ __('attributes.warehouse.phone') }}</label>
                            <input type="text" id="error-phone" onkeyup="checkValue('error-phone')" class="form-control" value="{{ old('phone',$warehouse->phone) }}" placeholder="{{ __('attributes.warehouse.phone') }}" name="phone">
                            <div class="error-phone hidden text-danger error-message"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-email" class="form-label">{{ __('attributes.warehouse.email') }}</label>
                            <input type="text" id="error-email" onkeyup="checkValue('error-email')" class="form-control" value="{{ old('email',$warehouse->email) }}" placeholder="{{ __('attributes.warehouse.email') }}" name="email">
                            <div class="error-email hidden text-danger error-message"></div>
                        </div>
                        
                        <div class="form-check form-switch input-container d-flex p-0 align-items-center">
                            <label class="switch">
                                <input type="checkbox" name="status" {{ $warehouse->active ? 'checked' : ''}} value="1" id="status">
                                <span class="slider round"></span>
                            </label>              
                            <label class="switch-label" for="status">{{ __('attributes.warehouse.active') }}</label>            
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="error-address" class="form-label">{{ __('attributes.warehouse.address') }}</label>
                            <textarea onkeyup="checkValue('error-address')" class="form-control" id="error-address" name="address">{{ old('address',$warehouse->address) }}</textarea>
                            <div class="error-address hidden text-danger error-message"></div>
                        </div>

                        <div class="input-container">
                            <label for="error-formFile" class="form-label">{{ __('attributes.warehouse.logo') }}</label>
                            <input class="form-control" type="file" id="formFile" name="logo" accept="image/png, image/jpg, image/jpeg" >
                            <input type="hidden" name="photo_removed" id="photo_removed" value="0">
                            <div class="error-formFile hidden text-danger error-message"></div>
                        </div>

                        <div class="input-container">
                            <p class="form-label">{{ __('attributes.warehouse.preview_logo') }}</p>
                            <div class="img-container d-flex justify-content-center">
                                <div class="img-preview">
                                    <img id="previewImage" src="{{ $warehouse->getLogo() }}" alt="">
                                    @if ($warehouse->getLogo() != asset('assets/images/icons/defautl-img.png'))
                                        <button type="button" class="btn-remove-image">
                                            <i class='bx bxs-x-circle'></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn-remove-image">
                                        <i class='bx bxs-x-circle'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <div class="card-footer">
            <div class="m-3 d-flex justify-content-between">
                <form id="form-delete" action="{{ !$warehouse->deleted_at ? route('warehouses.destroy', $warehouse->id) : route('warehouses.destroy.permanently', $warehouse->id) }}" method="post">
                    @csrf
                    @method('delete')
                    @if (!$warehouse->deleted_at)
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="false">
                            {{ __('common.delete') }}
                        </button>
                    @else
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="true">
                            {{ __('common.delete') }}
                        </button>
                    @endif
                </form>
                <button type="button" class="btn btn-primary btn-update-warehouse text-capitalize">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>

    @push('js')
        <script type="module">    
            $(document).ready(function () {
                $('.btn-update-warehouse').on('click', function() {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('warehouses.update', $warehouse->id) }}",
                        data: $('#form-update').serialize(),
                        success: function(response){
                            if (response.success) {
                                $('#form-update').submit();
                            }
                        },
                        error: function(error) {
                            var errors = error.responseJSON.errors;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    $('.error-' + key).text(value[0]);
                                    $('.error-' + key).show();
                                    $('#error-' + key).addClass('is-invalid');
                                });
                            }
                        }
                    });
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

                $('#formFile').change(function(e) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('.img-preview img').attr('src', e.target.result);
                        $('.img-preview').show();
                        $(".btn-remove-image").removeClass("d-none");
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $('.btn-remove-image').on('click', function() {
                    $('#previewImage').attr('src', '{{ getDefaultWarehouseImage() }}');
                    var fileMessage = $('.custom-input-file .file-message');
                    fileMessage.html(fileMessage.data('nofile')); 
                    $('#formFile').val('');
                    $("#photo_removed").val(1);
                    $(".btn-remove-image").addClass("d-none");
                });
            });
        </script>
        <script>
            function checkValue(class_name){
                    $('.' + class_name).hide();
                    $('#' + class_name).removeClass('is-invalid');
                }
        </script>
    @endpush   
</x-app-layout>
