<html>

<head>
    <title>Order Receipt {{ $order->number }}</title>
</head>

<body>
    <div style="margin-bottom: 1.5rem;text-align: center !important;">
        <div style="font-size: 1.50rem;">The Bruvs</div>
        <div style="font-size: 0.875em;">Zahlé - Baalbek Hwy, Lebanon</div>
        <div style="font-size: 0.875em;">+961 70 615 556</div>
        <div style="font-size: 0.875em;">info@the-bruvs.net</div>
        <div style="font-size: 0.875em;">www.the-bruvs.net</div>
    </div>

    <div style="text-align: center !important;margin-bottom: 0.5rem !important;">Receipt № {{ $order->number }}</div>
    <div style="margin-bottom: 1.5rem;text-align: center !important;">{{ $order->date_view }}</div>

    <div style="margin-bottom: 1.5rem">
        @foreach ($order->order_details as $detail)
            <div style="display: flex">
                <div>{{ $detail->product_name }} (x{{ $detail->quantity }})</div>
                <div style="margin-left: auto">{{ $detail->view_total }}</div>
            </div>
            <hr />
        @endforeach
    </div>

    <div style="display: flex;font-weight: 700">
        <div>Subtotal:</div>
        <div style="margin-left: auto">{{ $order->subtotal_view }}</div>
    </div>
    @if ($order->discount > 0)
        <div style="display: flex;font-weight: 700">
            <div>Discount:</div>
            <div style="margin-left: auto">{{ $order->discount_view }}</div>
        </div>
    @endif
    @if ($order->delivery_charge > 0)
        <div style="display: flex;font-weight: 700">
            <div>Delivery Charge:</div>
            <div style="margin-left: auto">{{ $order->delivery_charge_view }}</div>
        </div>
    @endif
    @if ($order->tax_rate > 0)
        <div style="display: flex;font-weight: 700">
            <div>Tax.Amount:</div>
            <div style="margin-left: auto">{{ currency_format($order->tax_amount) }}</div>
        </div>
        <div style="display: flex;font-weight: 700">
            <div>TVA {{ $order->tax_rate }}%:</div>
            <div style="margin-left: auto">{{ currency_format($order->vat) }}</div>
        </div>
    @endif
    <div style="display: flex;font-weight: 700">
        <div>Total:</div>
        <div style="margin-left: auto">{{ $order->total_view }}</div>
    </div>
    <div style="display: flex;font-weight: 700">
        <div>Paid:</div>
        <div style="margin-left: auto">{{ $order->tender_amount_view }}</div>
    </div>
    {{-- <div style="display: flex;font-weight: 700">
        <div>Change:</div>
        <div style="margin-left: auto">{{ $order->change_view }}</div>
    </div> --}}

    @if ($order->remarks)
        <hr>
        <div style="margin-top: 1.5rem !important;">
            <div>Remarks</div>
            <div>{{ $order->remarks }}</div>
        </div>
    @endif
    {{-- <div style="text-align: center !important;margin-bottom: 1rem !important;margin-top: 1.5rem !important;">
        {{ $order->date_view }} {{ $order->time_view }}
    </div> --}}
    <div style="text-align: center !important;margin-top: 1rem !important;">It's a pleasure to serve you ❤️</div>
</body>

</html>







<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
