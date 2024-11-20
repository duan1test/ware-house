<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.category.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.category.create') }}</h5>
        </div>
        <form method="POST" id="form-category" action="{{ route('categories.store') }}" style="display: contents;" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">           
                        @csrf
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="input-container">
                                <label for="error-code" class="form-label">{{ __('attributes.category.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="error-code" onkeyup="checkValue('error-code')" class="form-control" placeholder="{{ __('attributes.category.code') }}" value="{{old('code')}}" name="code">
                                <div class="error-code text-danger error-message hidden"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-code" class="form-label">{{ __('attributes.category.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="error-name" onkeyup="checkValue('error-name')" class="form-control" placeholder="{{ __('attributes.category.name') }}" value="{{old('name')}}" name="name">
                                <div class="error-name text-danger error-message hidden"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-parent_id" class="form-label">{{ __('attributes.category.parent_id') }}</label>
                                <select name="parent_id" onchange="checkValue('error-parent_id')" class="form-select form-control choices" id="error-parent_id">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($categories as $category)
                                        <option {{old('parent_id')==$category->id?'selected':''}} value="{{ $category->id }}">{{ $category->name }} ({{ $category->code }})</option>
                                    @endforeach
                                </select>
                                <div class="error-parent_id hidden text-danger error-message"></div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end m-3">
                    <button type="button" class="btn-create-category btn btn-primary text-capitalize">{{ __('common.create') }}</button>
                </div>
            </div>
        </form>

    </div>
    
    @push('js')
        <script type="module">
            $(document).ready(function () {
                $('.btn-create-category').on('click', function() {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('categories.store') }}",
                        data: $('#form-category').serialize(),
                        success: function(response){
                            if (response.success) {
                                $('#form-category').submit();
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
                    }
                    reader.readAsDataURL(this.files[0]);
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

