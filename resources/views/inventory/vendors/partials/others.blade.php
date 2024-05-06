<div class="mb-3">
    <label for="notes" class="form-label">Notes</label>
    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', isset($vendor) ? $vendor->notes : '') }}</textarea>

    @error('notes')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
