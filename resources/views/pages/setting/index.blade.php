<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.settings.setting') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.settings.setting') }}</h5>
            <p class="mt-1 text-gray-600" style="text-transform: none;">{{ __('common.settings.note') }}</p>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.store') }}" method="post" id="form-store-setting" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.web_name') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="name" type="text" value="{{ old('name', $current['name'] ?? __('common.app_name')) }}" class="form-control 
                                @error('name') is-invalid @enderror" placeholder="{{ __('attributes.settings.web_name') }}">
                            @error('name')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.reference') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <select name="reference" id="reference" 
                                class="form-select form-control choices @error('reference') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('reference', $current['reference'] ?? '')=='ulid'?'selected':''}} value="ulid">{{ __('attributes.settings.ref_sub.ulid') }}</option>
                                <option {{old('reference', $current['reference'] ?? '')=='ai'?'selected':''}} value="ai">{{ __('attributes.settings.ref_sub.ai') }}</option>
                                <option {{old('reference', $current['reference'] ?? '')=='uniqid'?'selected':''}} value="uniqid">{{ __('attributes.settings.ref_sub.uniqid') }}</option>
                                <option {{old('reference', $current['reference'] ?? 'uuid')=='uuid'?'selected':''}} value="uuid">{{ __('attributes.settings.ref_sub.uuid') }}</option>
                            </select>
                            @error('reference')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.default_locale') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="default_locale" id="default_locale" type="text" value="{{ old('default_locale', $current['default_locale'] ?? 'ID') }}" 
                                class="form-control default_locale @error('default_locale') is-invalid @enderror" placeholder="{{ __('attributes.settings.default_locale') }}">
                            @error('default_locale')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.per_page') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <select name="per_page" id="per_page" 
                                class="form-select form-control choices @error('per_page') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('per_page', $current['per_page'] ?? '10')=='10'?'selected':''}} value="10">10</option>
                                <option {{old('per_page', $current['per_page'] ?? '')=='15'?'selected':''}} value="15">15</option>
                                <option {{old('per_page', $current['per_page'] ?? '')=='25'?'selected':''}} value="25">25</option>
                                <option {{old('per_page', $current['per_page'] ?? '')=='50'?'selected':''}} value="50">50</option>
                                <option {{old('per_page', $current['per_page'] ?? '')=='100'?'selected':''}} value="100">100</option>
                            </select>
                            @error('per_page')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container" style="min-height: auto">
                            <div class="form-check">
                                <input type="hidden" name="over_selling" value="0">
                                <input {{ old('over_selling', $current['over_selling'] ?? '') ? 'checked' : '' }} 
                                    name="over_selling" value="1" type="checkbox" class="form-check-input ml-0" id="check_over_selling">
                                <label class="form-check-label ml-2" for="check_over_selling">{{ __('attributes.settings.over_selling') }}</label>
                            </div>
                        </div>

                        <div class="input-container" style="min-height: auto">
                            <div class="form-check mt-3">
                                <input type="hidden" name="track_weight" value="0">
                                <input {{ old('track_weight', $current['track_weight'] ?? '') ? 'checked' : '' }} 
                                    name="track_weight" value="1" 
                                    class="form-check-input ml-0" type="checkbox" id="check_track_weight">
                                <label class="form-check-label ml-2 form-label" for="check_track_weight">{{ __('attributes.settings.track_weight') }}</label>
                            </div>
                        </div>

                        <div class="input-container weight_unit d-none">
                            <label class="form-label">
                                {{ __('attributes.settings.weight_unit') }}
                            </label>
                            <input name="weight_unit" type="text" value="{{ old('weight_unit', $current['weight_unit'] ?? 'kg') }}" 
                                class="form-control @error('weight_unit') is-invalid @enderror" placeholder="{{ __('attributes.settings.weight_unit') }}">
                            @error('weight_unit')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.language') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <select name="language" id="language" 
                                class="form-select form-control choices @error('language') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('language', $current['language'] ?? 'vi')=='vi'?'selected':''}} value="vi">{{ __('attributes.settings.language_sub.vi') }}</option>
                                <option {{old('language', $current['language'] ?? '')=='en'?'selected':''}} value="en">{{ __('attributes.settings.language_sub.en') }}</option>
                            </select>
                            @error('language')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.currency_code') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <input name="currency_code" type="text" value="{{ old('currency_code', $current['currency_code'] ?? 'USD') }}" class="form-control @error('currency_code') is-invalid @enderror" placeholder="{{ __('attributes.settings.currency_code') }}">
                            @error('currency_code')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.settings.fraction') }}
                            </label>
                            <select name="fraction" id="fraction" 
                                class="form-select form-control choices @error('fraction') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('fraction', $current['fraction'] ?? '')=='0'?'selected':''}} value="0">0</option>
                                <option {{old('fraction', $current['fraction'] ?? '')=='1'?'selected':''}} value="1">1</option>
                                <option {{old('fraction', $current['fraction'] ?? '2')=='2'?'selected':''}} value="2">2</option>
                                <option {{old('fraction', $current['fraction'] ?? '')=='3'?'selected':''}} value="3">3</option>
                                <option {{old('fraction', $current['fraction'] ?? '')=='4'?'selected':''}} value="4">4</option>
                            </select>
                            @error('fraction')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-container sidebar_style">
                            <label class="form-label">
                                {{ __('attributes.settings.sidebar_style') }}
                                <span class="text-danger" style="margin-top: 5px;"> *</span>
                            </label>
                            <select name="sidebar_style" id="sidebar_style" 
                                class="form-select form-control choices @error('sidebar_style') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('sidebar_style', $current['sidebar_style'] ?? '')=='full'?'selected':''}} value="full">{{ __('attributes.settings.sidebar_style_sub.full') }}</option>
                                <option {{old('sidebar_style', $current['sidebar_style'] ?? 'dropdown')=='dropdown'?'selected':''}} value="dropdown">{{ __('attributes.settings.sidebar_style_sub.dropdown') }}</option>
                            </select>
                            @error('sidebar_style')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-setting btn btn-primary py-2">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.settings.preview') }}</h5>
            <p class="mt-1 text-gray-600" style="text-transform: none;">{{ __('common.settings.formart_date_number') }}</p>
        </div>
        <div class="card-body">
            <div class="border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500">{{ __('common.settings.number') }}</dt>
                        <dd id="numberField" class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">20000000.5</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500">{{ __('common.settings.date') }}</dt>
                        <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2" id="formattedDate"></dd>
                    </div>
                    <div class="bg-white px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="font-medium text-gray-500">{{ __('common.settings.datetime') }}</dt>
                        <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2" id="formattedDateTime"></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $(() => {
                var trackWeight = '{{ get_settings('track_weight') }}';
                $('.btn-store-setting').on('click', function() {
                    $('#form-store-setting').submit();
                });

                if(trackWeight == 1) {
                    $('.weight_unit').removeClass('d-none');
                } else {
                    $('.weight_unit').addClass('d-none');
                }

                displayFormattedDate('formattedDate', 'default_locale', false);
                displayFormattedDate('formattedDateTime', 'default_locale', true);
            });

            $('#check_track_weight').on('change', function() {
                if (this.checked) {
                    $('.weight_unit').removeClass('d-none');
                } else {
                    $('.weight_unit').addClass('d-none');
                }
            })

            $('.default_locale, #fraction').on('change', function() {
                displayFormattedNumber('numberField', 'default_locale', 'fraction');
            })

            $('.default_locale').on('change', function() {
                displayFormattedDate('formattedDate', 'default_locale');
                displayFormattedDate('formattedDateTime', 'default_locale', true);
            })

            function displayFormattedDate(elementId, localeId, datetime = true) 
            {
                var locale = $('#' + localeId).val();
                var currentDate = currentDate = new Date();
                var formattedDate;
                if (datetime) {
                    formattedDate = currentDate.toLocaleString(locale, {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true              
                    });
                } else {
                    formattedDate = currentDate.toLocaleDateString(locale, {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }

                $('#' + elementId).text(formattedDate);
            }
            
            function displayFormattedNumber(elementId, localeId, fractionId) {
                var locale = $('#' + localeId).val();

                var numberText = $('#' + elementId).text();

                var cleanedNumber = numberText.replace(/\./g, '').replace(',', '.');

                var number = parseFloat(cleanedNumber);

                var fraction = parseInt($('#' + fractionId).val(), 10);

                var formattedNumber = number.toFixed(fraction);

                $('#' + elementId).text(formattedNumber);
            }
            $(document).ready(function() {
                displayFormattedNumber('numberField', 'default_locale', 'fraction');
            });
        </script>
    @endpush
</x-app-layout>
