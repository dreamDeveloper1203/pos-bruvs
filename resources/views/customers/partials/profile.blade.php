<div class="row">
    <div class="col-md-12 mb-2 text-muted small">PROFILE</div>
    <div class="col-md-12 mb-3">
        <label for="name" class="form-label">Name*</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($customer) ? $customer->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="NameHelp" class="form-text">Provide the customer name</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="birthday" class="form-label">Birthday</label>
        <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror" id="birthday"
            value="{{ old('birthday', isset($customer) ? $customer->birthday : '') }}">
        @error('birthday')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="NameHelp" class="form-text">Provide the customer birthday</div>
        @enderror
    </div>


    <div class="col-md-6 mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
            @isset($customer)
                <option value="" @if (is_null($customer->gender)) selected @endif></option>
                <option value="male" @if ($customer->is_male) selected @endif>Male</option>
                <option value="female" @if (!$customer->is_female) selected @endif>Female</option>
            @else
                <option value="" selected></option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            @endisset
        </select>
        @error('gender')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="genderHelp" class="form-text">Provide the customer gender</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        @include('customers.partials.civil-status')
    </div>

    <div class="col-md-6 mb-3">
        @include('customers.partials.nationality')
    </div>

</div>
