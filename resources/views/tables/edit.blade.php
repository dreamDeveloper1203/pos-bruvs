@extends('layouts.app')
@section('title', 'Edit Table')

@section('content')
    <div class="mb-2">
        <a href="{{ route('tables.index') }}" class="link-primary text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i>Back to Table list
        </a>
    </div>
    <div class="h4 mb-2">Edit Table</div>
    <div class="card w-100">
        <div class="card-body">
            @include('tables.partials.form')
        </div>
    </div>
@endsection
