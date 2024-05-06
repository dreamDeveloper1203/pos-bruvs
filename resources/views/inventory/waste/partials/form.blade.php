<form action="{{ route('wastes.store') }}" method="POST" enctype="multipart/form-data" role="form">
    @csrf
    <div class="mb-3">
        <label for="item" class="form-label">Inventory Item*</label>
        <select name="item" id="item" class="form-control @error('item') is-invalid @enderror">
            @foreach ($masterItems as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
        @error('item')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
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
        <label for="notes" class="form-label">Notes <small class=" text-muted fw-normal">optional</small> </label>
        <textarea name="notes" id="notes"class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            Add To Waste
        </button>
    </div>
</form>
