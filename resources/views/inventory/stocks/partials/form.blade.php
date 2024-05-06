<form action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data" role="form">
    @csrf
    <div class="mb-3">
        <label for="name"  class="form-label">Inventory Item Name*</label>
        <input type="text" name="name" list="items-list" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name') }}" autocomplete="off">
        <datalist id="items-list">
            @foreach ($masterItems as $item)
                <option value="{{ $item->name }}">
            @endforeach
        </datalist>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="NameHelp" class="form-text">Provide the item name</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="unit" class="form-label">Unit*</label>
        <select name="unit" id="unit" class="form-select  @error('unit') is-invalid @enderror">
            @foreach ($units as $unit)
                <option value="{{ $unit->base_unit }}">
                    {{ strtolower($unit->base_unit) }} ({{ $unit->name }})
                </option>
            @endforeach
        </select>
        @error('unit')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity*</label>
        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
            id="quantity" value="{{ old('quantity') ?? 0 }}">
        @error('quantity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="total_price" class="form-label">Total Price (LL)*</label>
        <input type="number" name="total_price" class="form-control @error('total_price') is-invalid @enderror"
            id="total_price" value="{{ old('total_price') ?? 0 }}">
        @error('total_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="vendor" class="form-label">Vendor <small class=" text-muted fw-normal">optional</small></label>
        <select name="vendor" id="vendor" class="form-select @error('vendor') is-invalid @enderror">
            <option value=""></option>
            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
            @endforeach
        </select>
        @error('vendor')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">Notes<small class=" text-muted fw-normal">optional</small></label>
        <textarea name="notes" id="notes"class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            Add To Stock
        </button>
    </div>
</form>
