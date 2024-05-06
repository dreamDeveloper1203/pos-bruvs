@extends('layouts.app')
@section('title', 'Sales Report')

@section('content')
    <div class="card w-100">
        <div class="card-body">
            <div class=" card-title h3">Sales Report</div>
            <div class="table-responsive">
                <table class="table table-hover" id="sales-table">
                    <thead>
                        <tr>
                            <th class="text-muted small fw-normal">Date</th>
                            <th class="text-muted small fw-normal">Items Sold</th>
                            <th class="text-muted small fw-normal">Total Sales</th>
                            <th class="text-muted small fw-normal">Total Profit</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach ($sales as $sale)
                            <tr class=" clicable-cell"
                                onclick="window.location='{{ route('sales.show', $sale->createdAt) }}';">
                                <td class="align-middle py-3">{{ $sale->date }}</td>
                                <td class="align-middle py-3">{{ $sale->total_sold }}</td>
                                <td class="align-middle py-3">{{ currency_format($sale->total) }}</td>
                                <td class="align-middle py-3">{{ currency_format($sale->total - $sale->total_cost) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                {{ $sales->links() }}
            </div>
        </div>
    </div>

@endsection
