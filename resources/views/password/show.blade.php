@extends('layouts.app')
@section('title', 'Change Password')

@section('content')

    <div class="card w-100">
        <div class="card-body">
            <div class="card-title h4 mb-1">Change Password</div>
            <div class="small text-muted mb-3">Make sure your account is using a long, random password to stay secure.</div>


            <form action="{{ route('password.update') }}" method="POST" role="form">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror" id="current_password">
                    @error('current_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password"
                        class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                    @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="new_password_confirmation"
                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                        id="new_password_confirmation">
                    @error('new_password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>

@endsection
