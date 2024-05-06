@extends('layouts.app')
@section('title', 'Edit Vendor')

@section('content')
    <div class="mb-2">
        <a href="{{ route('vendors.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to vendor list
        </a>
    </div>
    <div class="h4 mb-2">Edit Vendor</div>
    <div class="card w-100">
        <div class="card-body">
            @include('inventory.vendors.partials.form')
        </div>
    </div>
@endsection
