@extends('layouts.app')
@section('title', 'Products')

@section('content')
    <div class="mb-2 d-flex">
        <h4 class="mb-3">Products</h4>
        <div class="ms-auto">
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                Create
            </a>
        </div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('products.index') }}" role="form">
                    <input type="text" name="search_query" value="{{ Request::get('search_query') }}"
                        class="form-control w-auto" placeholder="Search..." autocomplete="off">
                </form>
            </div>
            <div class=" table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-muted small fw-normal">Name</th>
                            <th class="text-muted small fw-normal">Category</th>
                            <th class="text-muted small fw-normal">Price</th>
                            <th class="text-muted small fw-normal">Sort Order</th>
                            <th class="text-muted small fw-normal">Status</th>
                            <th class="text-muted small fw-normal"></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle">
                                    <img src="{{ $product->image_url }}" class="rounded me-1" height="50"
                                        alt="{{ $product->name }}"> {{ $product->name }}
                                </td>
                                <td class="align-middle">{{ $product->category->name }}</td>
                                <td class="align-middle">
                                    <span
                                        class="@if ($product->has_discount) text-danger @endif">{{ $product->view_price }}</span>
                                </td>
                                <td class="align-middle">{{ $product->sort_order }}</td>
                                <td class="align-middle">
                                    <span class="badge rounded-pill {{ $product->status_badge_bg_color }}">
                                        {{ $product->status }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="dropdown d-flex">
                                        <button class="btn btn-link ms-auto text-black p-0" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('products.edit', $product) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <form action="{{ route('products.destroy', $product) }}"
                                                        method="POST" id="form-{{ $product->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                            onclick="submitDeleteForm('{{ $product->id }}')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6473f4',
                cancelButtonColor: '#d93025',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
