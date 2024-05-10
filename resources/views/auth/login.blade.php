@extends('layouts.app')
@push('style')
    <style>
        body {
            background-image: url(https://the-bruvs.wmktech.net/images/webp/hero_footer.webp)
        }
    </style>
@endpush
@section('content')
    <div class="container vh-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
                @include('layouts.alerts')
                <div class="card w-100 rounded-4" style="background-color: rgba(255, 255, 255, .6)">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <img src="https://the-bruvs.wmktech.net/images/webp/logo.webp" alt="the-bruvs">
                        </div>
                        <h5 class="card-title mb-sm-3 text-center">Log in to the system</h5>
                        <form action="{{ route('login.attempt') }}" method="POST" role="form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-muted small text-center fw-bold">The Bruvs © {{ date('Y') }}</div>
            </div>
        </div>
    </div>
@endsection
