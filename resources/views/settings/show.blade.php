@extends('layouts.app')
@section('title', 'Settings')

@section('content')

    <div class="card w-100 mb-3">
        <div class="card-body">
            <div class="card-title h4 mb-1">Security</div>
            <div class="small text-muted mb-3">Configure the general security password.</div>
            <form action="{{ route('settings.password.update') }}" method="POST" role="form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current security password</label>
                    <input type="password" name="current_password"
                        class="form-control @error('current_password') is-invalid @enderror" id="current_password">
                    @error('current_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New security password</label>
                    <input type="password" name="new_password"
                        class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                    @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm security password</label>
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
                    <button type="submit" class="btn btn-primary">Change Security Password</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card w-100">
        <div class="card-body">
            <div class="card-title h4 mb-1">Settings</div>
            <div class="small text-muted mb-3">Configure the general settings of the application.</div>
            <form action="{{ route('settings.update') }}" method="POST" role="form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tax_rate" class="form-label">TVA % (Value-Added Tax)</label>
                    <input type="number" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror"
                        id="tax_rate" value="{{ old('tax_rate', $taxRate) }}">
                    @error('tax_rate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="delivery_charge" class="form-label">Default Dilvery Charge Value (LL)</label>
                    <input type="number" name="delivery_charge"
                        class="form-control @error('delivery_charge') is-invalid @enderror" id="delivery_charge"
                        value="{{ old('delivery_charge', $deliveryCharge) }}">
                    @error('delivery_charge')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="discount" class="form-label">Default Discount Value (LL)</label>
                    <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror"
                        id="discount" value="{{ old('discount', $discount) }}">
                    @error('discount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                {{-- <div class="mb-3">
                    <label for="send_email" class="form-label">Send customers an email receipt after checkout</label>
                    <select class="form-select @error('send_email') is-invalid @enderror" id="send_email" name="send_email">
                        <option value="1" @if ($sendEmail) selected @endif>Yes</option>
                        <option value="0" @if (!$sendEmail) selected @endif>No</option>
                    </select>
                    @error('send_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

@endsection
