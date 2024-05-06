@extends('layouts.app')
@section('title', ' Add To Waste')

@section('content')
    <div class="mb-2">
        <a href="{{ route('wastes.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Waste Management
        </a>
    </div>
    <div class="h4 mb-2">Add To Waste</div>
    <div class="card w-100">
        <div class="card-body">
            @include('inventory.waste.partials.form')
        </div>
    </div>
@endsection
