@extends('layouts.app')
@section('title', 'The Bruvs POS')

@section('content')
    <div class="row">

        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/cashier.webp') }}" height="100" class="mb-3" alt="cashier">
                    <h3>POS</h3>
                    <a href="{{ route('pos.show') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/inbox.webp') }}" height="100" class="mb-3" alt="inbox">
                    <h3>Orders</h3>
                    <a href="{{ route('orders.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/chart.webp') }}" height="100" class="mb-3" alt="chart">
                    <h3>Reports</h3>
                    <a href="{{ route('orders.analytics') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/growth.webp') }}" height="100" class="mb-3" alt="growth">
                    <h3>Sales Report</h3>
                    <a href="{{ route('sales.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/shipping.webp') }}" height="100" class="mb-3" alt="shipping">
                    <h3>Stock Management</h3>
                    <a href="{{ route('stocks.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/cart.webp') }}" height="100" class="mb-3" alt="cart">
                    <h3>Inventory Items</h3>
                    <a href="{{ route('master-items.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/salesman.webp') }}" height="100" class="mb-3" alt="salesman">
                    <h3>Vendors</h3>
                    <a href="{{ route('vendors.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/trash.webp') }}" height="100" class="mb-3" alt="trash">
                    <h3>Waste Management</h3>
                    <a href="{{ route('wastes.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/delivery.webp') }}" height="100" class="mb-3" alt="delivery">
                    <h3>Delivery Charge Report</h3>
                    <a href="{{ route('delivery-charge.show') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/square.webp') }}" height="100" class="mb-3" alt="square">
                    <h3>Categories</h3>
                    <a href="{{ route('categories.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/box.webp') }}" height="100" class="mb-3" alt="box">
                    <h3>Products</h3>
                    <a href="{{ route('products.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div> --}}
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/table.webp') }}" height="100" class="mb-3" alt="table">
                    <h3>Tables</h3>
                    <a href="{{ route('tables.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/group.webp') }}" height="100" class="mb-3" alt="group">
                    <h3>Customers</h3>
                    <a href="{{ route('customers.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/gear.webp') }}" height="100" class="mb-3" alt="gear">
                    <h3>Settings</h3>
                    <a href="{{ route('settings.show') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/profile.webp') }}" height="100" class="mb-3" alt="profile">
                    <h3>User Manager</h3>
                    <a href="{{ route('users.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/user.webp') }}" height="100" class="mb-3" alt="user">
                    <h3>Profile</h3>
                    <a href="{{ route('profile.show') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/lock.webp') }}" height="100" class="mb-3" alt="lock">
                    <h3>Change Password</h3>
                    <a href="{{ route('password.show') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/info.webp') }}" height="100" class="mb-3" alt="info">
                    <h3>About</h3>
                    <a href="{{ route('about') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-stretch">
            <div class="card w-100 clicable-cell">
                <div class="card-body text-center">
                    <img src="{{ asset('images/webp/logout.webp') }}" height="100" class="mb-3" alt="logout">
                    <h3>Logout</h3>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();"
                        class="stretched-link"></a>
                    <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
