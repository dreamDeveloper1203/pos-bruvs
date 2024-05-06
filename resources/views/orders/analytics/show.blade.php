@extends('layouts.app')
@section('title', 'Orders Analytics')

@section('content')
    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Order list
        </a>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('orders.analytics.total-sales', ['cardTitle' => 'Sales in the last 12 months'])
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-orders', ['cardTitle' => 'Orders in the last 12 months'])
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-profit')
        </div>
        <div class="col-md-6">
            @include('orders.analytics.total-cost')
        </div>
    </div>
@endsection
