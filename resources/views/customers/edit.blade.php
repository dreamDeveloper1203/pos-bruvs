@extends('layouts.app')
@section('title', 'Edit Customer')

@section('content')
    <div class="mb-2">
        <a href="{{ route('customers.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Customer list
        </a>
    </div>
    <div class="h4 mb-2">Edit Customer</div>
    <div class="card w-100">
        <div class="card-body">
            @include('customers.partials.form')
        </div>
    </div>
@endsection
