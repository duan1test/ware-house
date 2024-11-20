<x-app-layout>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ handleRoute(route: 'units.index', options: $filters) }}">{{ __('common.unit.index') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $unit->name }} - {{ $unit->code }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <a href="{{ handleRoute(route: 'units.index', options: $filters) }}" class="me-2">
                    <i class='bx bx-arrow-back'></i>
                </a>
                <h5 class="page-title mt-3 mb-3">{{ __('common.unit.update') }} ({{$unit->name}})</h5>
            </div>
            @if ($unit->deleted_at)    
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
                    <div class="d-flex justify-content-between align-items-center alert alert-warning" role="alert">
                        <div class="flex justify-start items-center gap-2">
                            <i class="fa-solid fa-trash-can fa-circle-exclamation me-2"></i>
                            <span>{{ __('attributes.unit.soft_delete') }}</span>
                        </div>
                        <div class="d-flex justify-content-end">
                            <form method="POST" action="{{ route('units.restore',  ['unit' => $unit->id]) }}" style="margin-right: 10px;">
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
        <form method="POST" action="{{ route('units.update', $unit->id) }}" style="display: contents;" id="form-update-unit">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">           
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="input-container">
                            <label for="name" class="form-label">{{ __('attributes.unit.name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="{{ __('attributes.unit.name') }}" name="name" value="{{ old('name', $unit->name) }}">
                            @if ($errors->has('name'))
                                <div class="text-danger error-message">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="input-container">
                            <label for="code" class="form-label">{{ __('attributes.unit.code') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="{{ __('attributes.unit.code') }}" name="code" value="{{ old('code', $unit->code) }}">
                            @if ($errors->has('code'))
                                <div class="text-danger error-message">{{ $errors->first('code') }}</div>
                            @endif
                        </div>

                        <div class="input-container">
                            <label for="base_unit_id" class="form-label">{{ __('attributes.unit.base_unit') }}</label>
                            <select name="base_unit_id" class="form-select form-control choices" id="base_unit_id">
                                <option value="" placeholder>{{ __('common.select') }}</option>
                                @foreach ($units as $item)
                                    <option @if( old('base_unit_id', $unit->base_unit_id) == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('base_unit_id'))
                                <div class="text-danger error-message">{{ $errors->first('base_unit_id') }}</div>
                            @endif
                        </div>

                        <div id="additional-fields" style="display: none;">
                            <div class="input-container">
                                <label for="operator" class="form-label">{{ __('attributes.unit.operator') }}</label>
                                <select name="operator" class="form-select form-control choices" id="operator">
                                    <option value="" placeholder>{{ __('common.select') }}</option>
                                    <option value="*" @if (old('operator', $unit->operator) == '*') selected @endif>{{ __('attributes.unit.operator_sub.multiply') }}</option>
                                    <option value="/" @if (old('operator', $unit->operator) == '/') selected @endif>{{ __('attributes.unit.operator_sub.divide') }}</option>
                                    <option value="+" @if (old('operator', $unit->operator) == '+') selected @endif>{{ __('attributes.unit.operator_sub.plus') }}</option>
                                    <option value="-" @if (old('operator', $unit->operator) == '-') selected @endif>{{ __('attributes.unit.operator_sub.minus') }}</option>
                                </select>
                                @if ($errors->has('operator'))
                                    <div class="text-danger error-message">{{ $errors->first('operator') }}</div>
                                @endif
                            </div> 
                           
                            <div class="input-container">
                                <label class="form-label">
                                    {{ __('attributes.unit.operation_value') }}
                                </label>
                                @php
                                    $formatedOperationValue = old('operation_value', $unit->operation_value);
                                @endphp
                                <input name="operation_value" type="number" value="{{ $formatedOperationValue }}"
                                    class="form-control @error('operation_value') is-invalid @enderror"
                                    placeholder="{{ __('attributes.unit.operation_value') }}">
                                @error('operation_value')
                                    <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="formula-display" class="px-4 py-3 bg-blue-100 rounded" style="display: none;"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
        <div class="card-footer">
            <div class="m-3 d-flex justify-content-between">
                <form id="form-delete" action="{{ !$unit->deleted_at ? route('units.destroy', $unit->id) : route('units.destroy.permanently', $unit->id) }}" method="post">
                    @csrf
                    @method('delete')
                    @if (!$unit->deleted_at)
                       <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="false">
                        {{ __('common.unit.delete') }}
                        </button>
                    @else
                        <button type="button" class="btn-delete-item btn-delete btn btn-default text-danger py-2" data-permanent="true">
                            {{ __('common.permanently_delete') }}
                        </button>
                    @endif
                </form>
                <button type="button" class="btn btn-primary btn-update-unit text-capitalize">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
        <div id="form-delete"></div>
    </div>
    @push('js')
        <script type="module">
            $(document).ready(function() {
                $('.btn-update-unit').click(function() {
                    $('#form-update-unit').submit();
                });

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

            $('.btn-update-unit').click(function() {
                $('#form-update-unit').submit();
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
        </script>
    @endpush   
</x-app-layout>
