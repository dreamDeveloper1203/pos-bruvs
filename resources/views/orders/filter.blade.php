@extends('layouts.app')
@section('title', 'Orders Filter')

@section('content')
    <div class="mb-3">
        <div class="h4 mb-1">Order Filter</div>
        <a href="{{ route('orders.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Order list
        </a>
    </div>
    @if (!$orders->isEmpty())
        <div class="card w-100 mb-3">
            <div class="card-body">
                <div class=" table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Total Orders:</td>
                            <td>{{ $totalOrders }}</td>
                        </tr>
                        <tr>
                            <td>Total Cost:</td>
                            <td>{{ $totalCost }}</td>
                        </tr>
                        <tr>
                            <td>Total Sold:</td>
                            <td>{{ $totalSold }}</td>
                        </tr>
                        <tr class=" alert-success">
                            <td>Total Profit:</td>
                            <td>{{ $totalProfile }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('orders.analytics.total-sales', ['cardTitle' => 'Sales'])
            </div>
            <div class="col-md-6">
                @include('orders.analytics.total-orders', ['cardTitle' => 'Orders'])
            </div>
        </div>
    @endif
    <div class="card w-100">
        <div class="card-body">

            @if ($orders->isEmpty())
                <div class="text-center">
                    <div class="mb-2">There is nothing to display! Try changing the filter.</div>
                    @include('orders.filter-button')
                </div>
            @else
                @include('orders.table')
            @endif
            <div>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @include('orders.search-modal')
@endsection
