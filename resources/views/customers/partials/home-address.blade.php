<div class="row">
    <div class="col-md-12 mb-2 text-muted small">HOME ADDRESS</div>
    <div class="col-md-12 mb-3">
        <label for="street_address" class="form-label">Street Address</label>
        <input type="text" name="street_address" class="form-control @error('street_address') is-invalid @enderror"
            id="street_address"
            value="{{ old('street_address', isset($customer) ? $customer->street_address : '') }}">
        @error('street_address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="street_addressHelp" class="form-text">Provide the customer Street Address</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="city"
            value="{{ old('city', isset($customer) ? $customer->city : '') }}">
        @error('city')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="cityHelp" class="form-text">Provide the customer City</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="state" class="form-label">State</label>
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" id="state"
            value="{{ old('state', isset($customer) ? $customer->state : '') }}">
        @error('state')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="stateHelp" class="form-text">Provide the customer State</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        @include('customers.partials.home-address-country')
    </div>

    <div class="col-md-6 mb-3">
        <label for="zip_code" class="form-label">Zip Code</label>
        <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code"
            value="{{ old('zip_code', isset($customer) ? $customer->zip_code : '') }}">
        @error('zip_code')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="zip_codeHelp" class="form-text">Provide the customer Zip Code</div>
        @enderror
    </div>
</div>
