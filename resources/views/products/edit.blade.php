@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
    <div class="mb-2">
        <a href="{{ route('products.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Product list
        </a>
    </div>
    <div class="h4 mb-2">Edit Product</div>
    <div class="card w-100">
        <div class="card-body">
            @include('products.partials.form')
        </div>
    </div>
@endsection
