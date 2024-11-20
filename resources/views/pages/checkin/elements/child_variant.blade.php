<div class="d-flex flex-column align-items-start mt-2 col-6">
    <label for="name">
        {{ $name }}
        <span class="text-danger">*</span>
    </label>
    <select data-name="{{ $name }}" class="form-select form-control child-variant">
        {{ $variantOption }}
    </select>
    <span class="help-block has-error text-danger fs-6 error-pay-category"></span>
</div>