@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
    <div class="mb-2">
        <a href="{{ route('categories.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Category list
        </a>
    </div>
    <div class="h4 mb-2">Edit Category</div>
    <div class="card w-100">
        <div class="card-body">
            @include('categories.partials.form')
        </div>
    </div>
@endsection



