@extends('layouts.app')
@section('title', 'Order ' . $order->number)

@section('content')
    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i> Back to Order list
        </a>
    </div>
    <div class="d-flex mb-3">
        <div>
            <div class="h4 mb-1">
                Order {{ $order->number }}
                @if ($order->has_table)
                    (Table: {{ $order->table_name_view }})
                @endif
            </div>
            <div class="mb-1">
                {{ $order->date_view }} {{ $order->time_view }}
            </div>

        </div>
        <div class="ms-auto">
            <a class="btn btn-primary" href=" {{ route('orders.edit', $order) }}">
                <i class="bi bi-pencil-square me-2"></i> Edit
            </a>
            <a class="btn btn-primary" target="_blank" href=" {{ route('orders.print', $order) }}">
                <i class="bi bi-printer me-2"></i> Print Receipt
            </a>
        </div>
    </div>
    @if ($order->remarks)
        <div class="card w-100 mb-3">
            <div class="card-body">
                <div class="fw-bold">Remarks</div>
                <div> {{ $order->remarks }}</div>
            </div>
        </div>
    @endif


    @if ($order->has_customer)
        <div class="card w-100 mb-3">
            <div class="card-body">
                <div class="card-title h4">Customer</div>
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td width="50%">Name</td>
                            <td width="50%">{{ $order->customer->name }}</td>
                        </tr>
                        <tr>
                            <td width="50%">Email</td>
                            <td width="50%">{{ $order->customer->email }}</td>
                        </tr>
                        <tr>
                            <td width="50%">Mobile</td>
                            <td width="50%">{{ $order->customer->mobile }}</td>
                        </tr>
                        <tr>
                            <td width="50%">Telephone</td>
                            <td width="50%">{{ $order->customer->telephone }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="card w-100 mb-3">
        <div class="card-body">
            <div class="card-title h4">Payment</div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td width="50%">Subtotal</td>
                                <td width="50%">{{ $order->subtotal_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Delivery Charge</td>
                                <td width="50%">{{ $order->delivery_charge_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Discount</td>
                                <td width="50%">{{ $order->discount_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Tax.Amount</td>
                                <td width="50%">{{ currency_format($order->tax_amount) }}</td>
                            </tr>
                            <tr>
                                <td width="50%">TVA {{ $order->tax_rate }}%</td>
                                <td width="50%">{{ currency_format($order->vat) }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td width="50%">Total</td>
                                <td width="50%">{{ $order->total_view }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td width="50%">Paid</td>
                                <td width="50%">{{ $order->tender_amount_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Change</td>
                                <td width="50%">{{ $order->change_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Owe</td>
                                <td width="50%">{{ $order->owe_view }}</td>
                            </tr>
                            <tr>
                                <td width="50%">Cost</td>
                                <td width="50%">{{ $order->cost_view }}</td>
                            </tr>
                            <tr class=" alert-success">
                                <td width="50%">Profit</td>
                                <td width="50%">{{ $order->profit_view }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="card w-100 mb-3">
        <div class="card-body">
            <div class="card-title h4">Order Details</div>
            <table class="table table-hover">
                <thead>
                    <th class="text-muted small fw-normal">Product</th>
                    <th class="text-muted small fw-normal">Price</th>
                    <th class="text-muted small fw-normal">Quantity</th>
                    <th class="text-muted small fw-normal">Total Price</th>
                </thead>
                <tbody class="border-top-0">
                    @foreach ($order->order_details as $detail)
                        <tr>
                            <td class="align-middle">
                                <img src="  {{ $detail->product_image_url }}" alt="{{ $detail->product_name }}"
                                    height="50" class="me-2 rounded-3">
                                {{ $detail->product_name }}
                            </td>
                            <td class="align-middle">{{ $detail->view_price }}</td>
                            <td class="align-middle">{{ $detail->quantity }}</td>
                            <td class="align-middle">{{ $detail->view_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
