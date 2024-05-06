<div class="row">
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
            value="{{ old('email', isset($vendor) ? $vendor->email : '') }}">
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="emailHelp" class="form-text">Provide the vendor email.</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile"
            value="{{ old('mobile', isset($vendor) ? $vendor->mobile : '') }}">
        @error('mobile')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="mobileHelp" class="form-text">Provide the vendor mobile number.</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
            id="telephone" value="{{ old('telephone', isset($vendor) ? $vendor->telephone : '') }}">
        @error('telephone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="telephoneHelp" class="form-text">Provide the vendor telephone number.</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="fax" class="form-label">Fax</label>
        <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" id="fax"
            value="{{ old('fax', isset($vendor) ? $vendor->fax : '') }}">
        @error('fax')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="faxHelp" class="form-text">Provide the vendor fax.</div>
        @enderror
    </div>

</div>
