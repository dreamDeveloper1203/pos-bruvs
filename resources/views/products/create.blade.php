@extends('layouts.app')
@section('title', 'Create Product')

@section('content')
    <div class="mb-2">
        <a href="{{ route('products.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Product list
        </a>
    </div>
    <div class="mb-3">
        <div class="h4 mb-0">Create Product</div>
        <div class="small text-muted"> Add a new product on the system</div>
    </div>
    <div class="card w-100">
        <div class="card-body">
            @include('products.partials.form')
        </div>
    </div>
@endsection
