@extends('layouts.app')
@section('title', $vendor->name)

@section('content')
    <div class="mb-2">
        <a href="{{ route('vendors.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to vendor list
        </a>
    </div>
    <div class="h4 mb-2">{{ $vendor->name }}</div>
    <div class="card w-100">
        <div class="card-body">
            <div>{{ $vendor->email }}</div>
            <div>{{ $vendor->telephone }}</div>
            <div>{{ $vendor->mobile }}</div>
            <div>{{ $vendor->fax }}</div>
            <div>{{ $vendor->street_address }}</div>
            <div>{{ $vendor->city }}</div>
            <div>{{ $vendor->state }}</div>
            <div>{{ $vendor->country }}</div>
            <div>{{ $vendor->zip_code }}</div>
            <div>{{ $vendor->notes }}</div>
        </div>
    </div>
@endsection
