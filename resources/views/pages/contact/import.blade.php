<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.contact.title_import') }}</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.contact.title_import') }}</h5>
            <div class="text-secondary page-description mb-3">{{ __('common.contact.text_import') }}</div>
        </div>

        <form style="display: contents;" method="POST" action="{{ route('contacts.import.save') }}" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div>
                        @csrf
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="input-container">
                                <div class="drop-zone text-center p-3">
                                    <div class="">
                                        <i class="bx bx-file"></i>
                                    </div>
                                    <label for="formFile" class="form-label">
                                        <span class="cursor-pointer link-primary">{{ __('common.contact.chose_file') }}</span>
                                        <input type="file" id="formFile" name="excel" class="d-none">
                                    </label>
                                    <span>{{ __('common.contact.chose_file_end') }}</span>
                                    <div class="file-name d-flex justify-content-center mt-3">
                                        <p class="m-0">
                                            <i class="bx bx-plus"></i>
                                        </p>
                                    </div>
                                    <p class="text-center text-secondary mt-3">{{ __('common.contact.import_columns', [
                                        'columns' => __('attributes.contact.name') . ', ' . __('attributes.contact.email') . ', ' . __('attributes.contact.phone'). ', ' . __('attributes.contact.details')
                                    ]) }}</p>
                                    <p class="text-center text-secondary">{{ __('common.contact.import_data', [
                                        'columns' => __('attributes.contact.email') . ', ' . __('attributes.contact.name')
                                    ]) }}</p>
                                    @error('excel')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @if (Session::has('download'))
                                        <a href="{{ Session::get('download') }}" class="text-danger link-primary lh-2">{{ __('common.contact.download') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end my-3">
                    <button type="submit" class="btn btn-primary">{{ __('common.warehouse.submit_import') }}</button>
                </div>
            </div>
        </form>

    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        
    </div>

    @push('js')
        <script type="module">
            $(document).ready(function() {
                const dropZone = $('.drop-zone');
                const fileInput = $('#formFile');
                const fileNameSpan = dropZone.find('.file-name p');

                const updateFileName = (files) => {
                    if (files.length) {
                        const fileName = files[0].name;
                        fileNameSpan.text(fileName);
                    }
                };

                dropZone.on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.addClass('dragover');
                });

                dropZone.on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.removeClass('dragover');
                });

                dropZone.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.removeClass('dragover');
                    updateFileName(e.originalEvent.dataTransfer.files);
                    fileInput[0].files = e.originalEvent.dataTransfer.files;
                });

                fileInput.on('change', function(e) {
                    updateFileName(e.target.files);
                });

                $('.link-primary').on('click', function(e){
                    e.stopPropagation();
                })
                
                dropZone.on('click', function(e) {
                    if (e.target !== fileInput[0]) {
                        fileInput.trigger('click');
                    }
                });
            });

        </script>
    @endpush
</x-app-layout>