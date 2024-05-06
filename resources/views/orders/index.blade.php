@extends('layouts.app')
@section('title', 'Orders')

@section('content')
    <div class="mb-3">
        <div class="h4 mb-1">Orders</div>
        <div>
            <a class="btn btn-link p-0 m-0 text-decoration-none" href="{{ route('orders.analytics') }}">
                <i class="bi bi-graph-up-arrow me-2"></i> Show Analytics
            </a>
        </div>
    </div>


    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">


            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                    aria-controls="panelsStayOpen-collapseOne">
                    Orders Stats
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
                aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
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

                    <div class="card w-100 mb-3">
                        <div class="card-body">
                            <div class="card-title h5">Today ({{ date('j F') }})</div>
                            <div class=" table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Total Orders:</td>
                                        <td>{{ $totalOrdersToday }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Cost:</td>
                                        <td>{{ $totalCostToday }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Sold:</td>
                                        <td>{{ $totalSoldToday }}</td>
                                    </tr>
                                    <tr class=" alert-success">
                                        <td>Total Profit:</td>
                                        <td>{{ $totalProfileToday }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card w-100 mb-3">
                                <div class="card-body">
                                    <div class="card-title h5">This Month ({{ date('F') }})</div>
                                    <div class=" table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Total Orders:</td>
                                                <td>{{ $totalOrdersThisMonth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Cost:</td>
                                                <td>{{ $totalCostThisMonth }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Sold:</td>
                                                <td>{{ $totalSoldThisMonth }}</td>
                                            </tr>
                                            <tr class=" alert-success">
                                                <td>Total Profit:</td>
                                                <td>{{ $totalProfileThisMonth }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card w-100 mb-3">
                                <div class="card-body">
                                    <div class="card-title h5">This Year ({{ date('Y') }})</div>
                                    <div class=" table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Total Orders:</td>
                                                <td>{{ $totalOrdersThisYear }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Cost:</td>
                                                <td>{{ $totalCostThisYear }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Sold:</td>
                                                <td>{{ $totalSoldThisYear }}</td>
                                            </tr>
                                            <tr class=" alert-success">
                                                <td>Total Profit:</td>
                                                <td>{{ $totalProfileThisYear }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <div class="card w-100">
        <div class="card-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <form action="{{ route('orders.index') }}" role="form">
                        <input type="text" name="search_query" value="{{ Request::get('search_query') }}"
                            class="form-control w-100" placeholder="Search by order number or customer name..."
                            autocomplete="off">
                    </form>
                </div>
                <div class="col-6 d-flex mb-3">
                    @include('orders.filter-button')
                </div>
            </div>
            @include('orders.table')
            <div>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @include('orders.search-modal')
@endsection
