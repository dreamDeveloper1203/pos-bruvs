<form action="{{ isset($table) ? route('tables.update', $table) : route('tables.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($table)
        @method('PUT')
    @endisset
    <div class="mb-4">
        <label for="name" class="form-label">Table Name*</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            id="name" value="{{ old('name', isset($table) ? $table->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="NameHelp" class="form-text">Provide the table name, ex. T№1</div>
        @enderror

    </div>


    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            {{ isset($table) ? 'Update' : 'create' }}
        </button>
    </div>
</form>
