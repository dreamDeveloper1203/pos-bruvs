<form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
    method="POST" enctype="multipart/form-data" role="form">
    @csrf
    @isset($category)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($category) ? $category->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categoryNameHelp" class="form-text">Provide a name to the resource.</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" step="1" min="1" name="sort_order" class="form-control @error('name') is-invalid @enderror"
            id="sort_order" value="{{ old('sort_order', isset($category) ? $category->sort_order : 1) }}">
        @error('sort_order')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categorySortOrderHelp" class="form-text">Define the sort order of the product</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
            @isset($category)
                <option value="available" @if ($category->is_active) selected @endif>Visible</option>
                <option value="unavailable" @if (!$category->is_active) selected @endif>Hidden</option>
            @else
                <option value="available">Visible</option>
                <option value="unavailable">Hidden</option>
            @endisset
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categoryStatusHelp" class="form-text">If assigned to Hidden, all products assigned to this
                category, won't
                appear at the POS.</div>
        @enderror
    </div>

    <div class="mb-5">
        <label for="image" class="form-label">Image</label>
        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="image-input"
            accept="image/png, image/jpeg">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categoryImageHelp" class="form-text">Choose an image to add on the category</div>
        @enderror
    </div>

    <div class="mb-5 text-center">
        <div class="mb-3">
            @isset($category)
                <img src="{{ $category->image_url }}" height="250"
                    class="object-fit-cover border rounded  @if (!$category->image_path) d-none @endif"
                    alt="{{ $category->name }}" id="image-preview">
            @else
                <img src="#" height="250" class="object-fit-cover border rounded  d-none" alt="image" id="image-preview">
            @endisset
        </div>
        @isset($category)
            @if ($category->image_path)
                <div class="mb-3">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#removeCategoryImageModal">
                        Remove Image
                    </button>
                </div>
            @endif
        @endisset

    </div>

    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            {{ isset($category) ? 'Update' : 'create' }}
        </button>
    </div>
</form>

@isset($category)
    <div class="modal" id="removeCategoryImageModal" tabindex="-1" aria-labelledby="removeCategoryImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="removeCategoryImageModalLabel">Are You Sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.image.destroy', $category) }}" method="POST" role="form">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        You can not undo this action!
                    </div>
                    <div class="row p-0 m-0 border-top">
                        <div class="col-6 p-0">
                            <button type="button"
                                class="btn btn-link w-100 m-0 text-danger btn-lg text-decoration-none rounded-0 border-end"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-6 p-0">
                            <button type="submit"
                                class="btn btn-link w-100 m-0 text-black btn-lg text-decoration-none rounded-0 border-start">Remove
                                Image</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endisset
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("image-input").onchange = function() {
                previewImage(this, document.getElementById("image-preview"))
            };
        });
    </script>
@endpush
