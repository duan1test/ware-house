<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ handleRoute(route: 'categories.index', options: $filters) }}">{{ __('common.category.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }} - {{ $category->code }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ handleRoute(route: 'categories.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.category.update') }} ({{$category->name}})</h5>
            </div>
            @if ($category->deleted_at)    
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                    <div class="d-flex justify-content-between align-items-center alert alert-warning" role="alert">
                        <div class="flex justify-start items-center gap-2">
                            <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                            <span>{{ __('attributes.category.soft_delete') }}</span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <form method="POST" action="{{ route('categories.restore',  ['category' => $category->id]) }}" style="margin-right: 10px;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ __('common.restore') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <form method="POST" id="form-category" action="{{ route('categories.update', $category->id) }}" style="display: contents;">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">           
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="input-container">
                                <label for="error-code" class="form-label">{{ __('attributes.category.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="error-code" onkeyup="checkValue('error-code')" class="form-control" placeholder="{{ __('attributes.category.code') }}" name="code" value="{{ old('code',$category->code) }}">
                                <div class="error-code text-danger error-message hidden"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-name" class="form-label">{{ __('attributes.category.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="name" onkeyup="checkValue('error-name')" class="form-control" placeholder="{{ __('attributes.category.name') }}" name="name" value="{{ old('name',$category->name) }}">
                                <div class="error-name text-danger error-message hidden"></div>
                            </div>

                            <div class="input-container">
                                <label for="error-parent_id" class="form-label">{{ __('attributes.category.parent_id') }}</label>
                                <select name="parent_id" onchange="checkValue('error-parent_id')" class="form-select form-control choices" id="error-parent_id">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    @foreach ($categories as $item)
                                        <option @if( old('parent_id',$category->parent_id) == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                    @endforeach
                                </select>
                                <div class="error-parent_id text-danger error-message hidden"></div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="m-3 d-flex justify-content-between">
                    @if ($category->deleted_at)
                        <button type="button" class="btn btn-delete btn-delete-category">
                            {{ __('common.delete') }}
                        </button>
                    @else
                        <button type="button" class="btn btn-delete btn-delete-category">
                            {{ __('common.delete') }}
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary btn-update-category text-capitalize">
                        {{ __('common.save') }}
                    </button>
                </div>
            </div>
        </form>
        <div id="form-delete"></div>
    </div>
    @push('js')
        <script type="module"> 
            $(document).ready(function () {
                $('.btn-update-category').on('click', function() {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('categories.update', $category->id) }}",
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

                $('.btn-delete-category').click(function() {
                    let form = $(this).closest('form');
                    let id = "{{ $category->id }}";
                    let isPermanentDelete = "{{ $category->deleted_at }}";
                    let confirmMessage = isPermanentDelete 
                        ? '{{ __('common.confirm_permanent_delete') }}' 
                        : '{{ __('common.confirm_delete') }}';
                    
                    let htmlMessage = isPermanentDelete 
                        ? "{{ __('common.alert_permanent_delete') }}" 
                        : "";

                    showConfirm(confirmMessage, function() {
                        if (isPermanentDelete) {
                            let url = "{{ route('categories.destroy.permanently', ['category' => ':id'])}}";
                            url = url.replace(':id', id);
                            form.attr('action', url);
                        } else {
                            let url = "{{ route('categories.destroy', ['category' => ':id'])}}";
                            url = url.replace(':id', id); 
                            form.attr('action', url);
                        }
                        
                        let csrfToken = $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        });

                        let methodField = $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        });

                        form.append(csrfToken, methodField);
                        $('#form-delete').append(form);
                        form.submit();
                    }, {
                        icon: 'warning',
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

