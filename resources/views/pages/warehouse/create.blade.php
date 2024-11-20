<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.warehouse.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.warehouse.create') }}</h5>
        </div>
        <form method="POST" id="form-create" action="{{ route('warehouses.store') }}" style="display: contents;" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                        @csrf
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="input-container">
                                <label for="error-code" class="form-label">{{ __('attributes.warehouse.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="error-code" onkeyup="checkValue('error-code')" class="form-control" placeholder="{{ __('attributes.warehouse.code') }}" value="{{old('code')}}" name="code">
                                <div class="error-code hidden text-danger error-message"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-name" class="form-label">{{ __('attributes.warehouse.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="error-name" onkeyup="checkValue('error-name')" class="form-control" placeholder="{{ __('attributes.warehouse.name') }}" value="{{old('name')}}" name="name">
                                <div class="error-name hidden text-danger error-message"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-phone" class="form-label">{{ __('attributes.warehouse.phone') }}</label>
                                <input type="text" id="error-phone" onkeyup="checkValue('error-phone')" class="form-control" placeholder="{{ __('attributes.warehouse.phone') }}" value="{{old('phone')}}" name="phone">
                                <div class="error-phone hidden text-danger error-message"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-email" class="form-label">{{ __('attributes.warehouse.email') }}</label>
                                <input type="text" id="error-email" onkeyup="checkValue('error-email')" class="form-control" placeholder="{{ __('attributes.warehouse.email') }}" value="{{old('email')}}" name="email">
                                <div class="error-email text-danger error-message hidden"></div>
                            </div>

                            <div class="form-check form-switch input-container d-flex p-0 align-items-center">
                                <label class="switch">
                                    <input type="checkbox" name="active" value="1" id="status">
                                    <span class="slider round"></span>
                                </label>              
                                <label class="switch-label" for="status">{{ __('attributes.warehouse.active') }}</label>            
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="input-container">
                                <label for="error-address" class="form-label">{{ __('attributes.warehouse.address') }}</label>
                                <textarea onkeyup="checkValue('error-address')" class="form-control" id="error-address" name="address">{{old('address')}}</textarea>
                                <div class="error-address hidden text-danger error-message"></div>
                            </div>

                            <div class="input-container">
                                <label for="formFile" class="form-label">{{ __('attributes.warehouse.logo') }}</label>
                                <input class="form-control" type="file" id="formFile" name="logo" accept="image/png, image/jpg, image/jpeg" >
                                @if ($errors->has('logo'))
                                    <div class="text-danger error-message">{{ $errors->first('logo') }}</div>
                                @endif
                            </div>

                            <div class="input-container">
                                <p class="form-label">{{ __('attributes.warehouse.preview_logo') }}</p>
                                <div class="img-container d-flex justify-content-center">
                                    <div class="img-preview">
                                        <img id="previewImage" src="{{ getDefaultWarehouseImage() }}" alt="">
                                        <button type="button" class="btn-remove-image d-none">
                                            <i class='bx bxs-x-circle'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end m-3">
                    <button type="button" class="btn-create-warehouse btn btn-primary text-capitalize">{{ __('common.create') }}</button>
                </div>
            </div>
        </form>

    </div>
    
    @push('js')
        <script type="module">
            $(document).ready(function () {
                $('.btn-create-warehouse').on('click', function() {
                    $.ajax({ 
                        type: "POST",
                        url: "{{ route('warehouses.store') }}",
                        data: $('#form-create').serialize(),
                        success: function(response){
                            if (response.success) {
                                $('#form-create').submit();
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

                $('#formFile').change(function(e) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('.img-preview img').attr('src', e.target.result);
                        $('.img-preview').show();
                        $(".btn-remove-image").removeClass("d-none")
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $('.btn-remove-image').on('click', function() {
                    $('#previewImage').attr('src', '{{ getDefaultWarehouseImage() }}');
                    var fileMessage = $('.custom-input-file .file-message');
                    fileMessage.html(fileMessage.data('nofile')); 
                    $('#formFile').val('');
                    $(".btn-remove-image").addClass("d-none")
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

