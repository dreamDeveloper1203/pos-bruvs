<form action="{{ isset($vendor) ? route('vendors.update', $vendor) : route('vendors.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($vendor)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">Name*</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($vendor) ? $vendor->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="NameHelp" class="form-text">Provide the vendor name</div>
        @enderror
    </div>
    @include('inventory.vendors.partials.contact')
    @include('inventory.vendors.partials.address')
    @include('inventory.vendors.partials.others')

    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            {{ isset($vendor) ? 'Update' : 'create' }}
        </button>
    </div>
</form>
