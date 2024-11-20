<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.unit.create') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="page-title mt-3 mb-3">{{ __('common.unit.create') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('units.store') }}" method="post" id="form-create-unit">
                @csrf
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="input-container">
                        <label class="form-label">
                            {{ __('attributes.unit.name') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input name="name" id="name" type="text" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ __('attributes.unit.name') }}">
                        @error('name')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="input-container">
                        <label class="form-label">
                            {{ __('attributes.unit.code') }}
                            <span class="text-danger" style="margin-top: 5px;"> *</span>
                        </label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}"
                            class="form-control @error('code') is-invalid @enderror"
                            placeholder="{{ __('attributes.unit.code') }}">
                        @error('code')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="input-container">
                        <label class="form-label">
                            {{ __('attributes.unit.base_unit') }}
                        </label>

                        <select id="base_unit_id" name="base_unit_id"
                            class="form-select form-control choices @error('base_unit_id') is-invalid @enderror">
                            <option value="" placeholder>{{ __('common.select') }}</option>
                            @foreach ($units as $unit)
                                <option @if (old('base_unit_id') == $unit->id) selected @endif value="{{ $unit->id }}">
                                    {{ $unit->name }} ({{ $unit->code }})</option>
                            @endforeach
                        </select>
                        @error('base_unit_id')
                            <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="additional-fields" style="display: none;">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.unit.operator') }}
                            </label>
                            <select name="operator" id="operator" 
                                class="form-select form-control choices @error('operator') is-invalid @enderror">
                                <option  value="">{{ __('common.select') }}</option>
                                <option {{old('operator')=='*'?'selected':''}} value="*">{{ __('attributes.unit.operator_sub.multiply') }}</option>
                                <option {{old('operator')=='/'?'selected':''}} value="/">{{ __('attributes.unit.operator_sub.divide') }}</option>
                                <option {{old('operator')=='+'?'selected':''}} value="+">{{ __('attributes.unit.operator_sub.plus') }}</option>
                                <option {{old('operator')=='-'?'selected':''}} value="-">{{ __('attributes.unit.operator_sub.minus') }}</option>
                            </select>
                            @error('operator')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label class="form-label">
                                {{ __('attributes.unit.operation_value') }}
                            </label>
                            <input name="operation_value" type="number" value="{{ old('operation_value') }}"
                                class="form-control @error('operation_value') is-invalid @enderror"
                                placeholder="{{ __('attributes.unit.operation_value') }}">
                            @error('operation_value')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="formula-display" class="px-4 py-3 bg-blue-100 rounded" style="display: none;"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn-store-unit btn btn-primary py-2">
                    {{ __('common.create') }}
                </button>
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            $('.btn-store-unit').on('click', function() {
                $('#form-create-unit').submit();
            });

            $(document).ready(function() {
                $('#base_unit_id').on('change', function() {
                    if ($(this).val()) {
                        $('#additional-fields').slideDown(); 
                    } else {
                        $('#additional-fields').slideUp(); 
                    }
                });
        
                if ($('#base_unit_id').val()) {
                    $('#additional-fields').show(); 
                }

                function updateFormula() {
                    let baseUnitText = $('#base_unit_id option:selected').text().trim();
                    let operator = $('#operator').val();
                    let operationValue = $('input[name="operation_value"]').val();
                    let name = $('#name').val();
                    let code = $('#code').val();

                    let formula = '';
                    
                    if (baseUnitText && operator && operationValue) {
                        formula = `${baseUnitText} ${operator} ${operationValue} = ${name}`;
                        if (code) {
                            formula += ` (${code})`;
                        }
                        $('#formula-display').show(); 
                        $('#formula-display').text(formula);
                    } else {
                        $('#formula-display').hide();
                    }
                    
                }

                $('#base_unit_id, #operator, input[name="operation_value"], #name, #code').on('change keyup', function() {
                    updateFormula();
                });

                updateFormula();
            });
        </script>
    @endpush
</x-app-layout>
