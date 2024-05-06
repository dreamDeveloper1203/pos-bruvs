<form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($product)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($product) ? $product->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="nameHelp" class="form-text">Provide a name to the resource.</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
            @isset($product)
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            @else
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            @endisset
        </select>
        @error('category')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categoryHelp" class="form-text">Select to which category the item is assigned.</div>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="barcode" class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" id="barcode"
                value="{{ old('barcode', isset($product) ? $product->barcode : '') }}">
            @error('barcode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div id="barcodeHelp" class="form-text">Define the barcode value. Focus the cursor here before scanning
                    the product.</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="sku" class="form-label">SKU <span class="small text-muted fw-normal">Stock keeping
                    unit</span></label>
            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" id="sku"
                value="{{ old('sku', isset($product) ? $product->sku : '') }}">
            @error('sku')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div id="skuHelp" class="form-text">Define a unique SKU value for the product.</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="sale_price" class="form-label">Sale Price ({{ config('app.currency') }})</label>
            <input type="number" step="0.1" min="0" name="sale_price"
                class="form-control @error('sale_price') is-invalid @enderror" id="sale_price"
                value="{{ old('sale_price', isset($product) ? $product->sale_price : 0) }}">
            @error('sale_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div id="salePriceHelp" class="form-text">Define the regular selling price.</div>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label for="discount_price" class="form-label">Discount Price ({{ config('app.currency') }})</label>
            <input type="number" step="0.1" min="0" name="discount_price"
                class="form-control @error('discount_price') is-invalid @enderror" id="discount_price"
                value="{{ old('discount_price', isset($product) ? $product->discount_price : 0) }}">
            @error('discount_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div id="discountPriceHelp" class="form-text">Define the on discount price.</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="cost" class="form-label">Cost ({{ config('app.currency') }})</label>
        <input type="number" step="0.1" min="0" name="cost" class="form-control @error('cost') is-invalid @enderror"
            id="cost" value="{{ old('cost', isset($product) ? $product->cost : 0) }}">
        @error('cost')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="costHelp" class="form-text">Define the how much the product cost</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="sort_order" class="form-label">Sort Order</label>
        <input type="number" step="1" min="1" name="sort_order"
            class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
            value="{{ old('sort_order', isset($product) ? $product->sort_order : 1) }}">
        @error('sort_order')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="sortOrderHelp" class="form-text">Define the sort order of the product</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
            rows="5">{{ old('description', isset($product) ? $product->description : null) }}</textarea>
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>



    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
            @isset($product)
                <option value="available" @if ($product->is_active) selected @endif>On Sale</option>
                <option value="unavailable" @if (!$product->is_active) selected @endif>Hidden</option>
            @else
                <option value="available">On Sale</option>
                <option value="unavailable">Hidden</option>
            @endisset
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="statusHelp" class="form-text">Define wether the product is available for sale.</div>
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
            <div id="imageHelp" class="form-text">Choose an image to add on the product</div>
        @enderror
    </div>



    <div class="mb-5 text-center">
        <div class="mb-3">
            @isset($product)
                <img src="{{ $product->image_url }}" height="250"
                    class="object-fit-cover border rounded  @if (!$product->image_path) d-none @endif"
                    alt="{{ $product->name }}" id="image-preview">
            @else
                <img src="#" height="250" class="object-fit-cover border rounded  d-none" alt="image" id="image-preview">
            @endisset
        </div>
        @isset($product)
            @if ($product->image_path)
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
            {{ isset($product) ? 'Update' : 'create' }}
        </button>
    </div>
</form>

@isset($product)
    <div class="modal" id="removeCategoryImageModal" tabindex="-1" aria-labelledby="removeCategoryImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="removeCategoryImageModalLabel">Are You Sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('products.image.destroy', $product) }}" method="POST" role="form">
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
                                class="btn btn-link w-100 m-0 text-black btn-lg text-decoration-none rounded-0 border-start">
                                Remove Image
                            </button>
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
