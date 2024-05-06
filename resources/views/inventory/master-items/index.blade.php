@extends('layouts.app')
@section('title', 'Inventory Items')

@section('content')
    <div class="mb-2 d-flex">
        <h4 class="mb-3">Inventory Items</h4>
    </div>
    <div class="card w-100">
        <div class="card-body">
            <div class=" table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-muted small fw-normal">Item Name</th>
                            <th class="text-muted small fw-normal">Unit</th>
                            <th class="text-muted small fw-normal">In Stock</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($items as $item)
                            <tr>
                                <td class="align-middle">{{ $item->name }} </td>
                                <td class="align-middle">{{ $item->unit_view }}</td>
                                <td class="align-middle">{{ $item->in_stock_view }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="">
                {{ $items->withQueryString()->links() }}
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
