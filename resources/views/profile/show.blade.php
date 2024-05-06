@extends('layouts.app')
@section('title', 'Profile')

@section('content')

    <div class="card w-100">
        <div class="card-body">
            <div class="card-title h4 mb-1">Profile Information</div>
            <div class="small text-muted mb-3">Change profile name and email address.</div>


            <form action="{{ route('profile.update') }}" method="POST" role="form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address*</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
