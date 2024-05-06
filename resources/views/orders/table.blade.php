<div class=" table-responsive">
    <table class="table table-hover table-bordered table-striped table-sm small">
        <thead>
            <tr>
                <th class="text-muted small fw-normal">Order Number</th>
                <th class="text-muted small fw-normal">Customer</th>
                <th class="text-muted small fw-normal">Table</th>
                <th class="text-muted small fw-normal">Cost</th>
                <th class="text-muted small fw-normal">Discount</th>
                <th class="text-muted small fw-normal">Profit</th>
                <th class="text-muted small fw-normal">Delivery Charge</th>
                <th class="text-muted small fw-normal">Subtotal</th>
                <th class="text-muted small fw-normal">Total</th>
                <th class="text-muted small fw-normal">Paid</th>
                <th class="text-muted small fw-normal">Change</th>
                <th class="text-muted small fw-normal">Owe</th>
                <th class="text-muted small fw-normal">Created At</th>
                <th class="text-muted small fw-normal"></th>
            </tr>
        </thead>
        <tbody class="border-top-0">
            @foreach ($orders as $order)
                <tr>
                    <td class="align-middle">
                        {{ $order->number }}
                    </td>
                    <td class="align-middle">
                        {{ is_null($order->customer) ? '-' : $order->customer_name }}
                    </td>
                    <td class="align-middle">
                        {{ $order->table_name_view }}

                        @if ($order->has_table_status)
                            @if ($order->table_status_pending)
                                <span class="badge bg-warning rounded-pill">Pending</span>
                            @else
                                <span class="badge bg-success rounded-pill">Checkd Out</span>
                            @endif
                        @endif

                    </td>
                    <td class="align-middle">
                        {{ $order->cost_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->discount_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->profit_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->delivery_charge_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->subtotal_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->total_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->tender_amount_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->change_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->owe_view }}
                    </td>
                    <td class="align-middle">
                        {{ $order->created_at_view }}
                    </td>
                    <td class="align-middle">
                        <div class="dropdown d-flex">
                            <button class="btn btn-link ms-auto text-black p-0" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end animate slideIn shadow-sm p-0"
                                aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('orders.show', $order) }}">
                                        <i class="bi bi-eye me-2"></i> Show
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('orders.edit', $order) }}">
                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" target="_blank"
                                        href="{{ route('orders.print', $order) }}">
                                        <i class="bi bi-printer me-2"></i> Print Receipt
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                                @if ($order->has_table)
                                    @if ($order->has_table_status)
                                        @if ($order->table_status_pending)
                                            <li>
                                                <a class="dropdown-item py-2"
                                                    href="{{ route('orders.status.checked_out', $order) }}">
                                                    <i class="bi bi-check-circle me-2"></i> Mark as Checked Out
                                                </a>
                                            </li>
                                        @else
                                            <a class="dropdown-item py-2"
                                                href="{{ route('orders.status.pending', $order) }}">
                                                <i class="bi bi-hourglass me-2"></i> Mark as Pending
                                            </a>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider m-0">
                                        </li>
                                    @endif
                                @endif

                                <li>
                                    <a class="dropdown-item py-2" href="#">
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                            id="form-{{ $order->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                                                onclick="submitDeleteForm('{{ $order->id }}')">
                                                <i class="bi bi-trash me-2"></i> Delete
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
@push('script')
    <script>
        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            const password = "{{ $password }}"

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#6473f4',
            //     cancelButtonColor: '#d93025',
            //     confirmButtonText: 'Delete!'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         form.submit();
            //     } else {
            //         topbar.hide();
            //     }
            // });

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                input: 'password',
                inputAttributes: {
                    placeholder: 'Password',
                    autocomplete: 'off',
                    required: true
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6473f4',
                cancelButtonColor: '#d93025',
                confirmButtonText: 'Delete!',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value == password) {
                        form.submit();
                    } else {
                        Swal.fire('Wrong password provided', 'Authentication failed', 'error')
                    }
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
