@extends('layouts.app')
@section('title', 'Edit Stock')

@section('content')
    <div class="mb-2">
        <a href="{{ route('stocks.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Stock Management
        </a>
    </div>
    <div class="h4 mb-2">Edit Stock</div>
    <div class="card w-100">
        <div class="card-body">
            @include('inventory.stocks.partials.form')
        </div>
    </div>
@endsection
