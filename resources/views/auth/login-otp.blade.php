@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 400px; margin-top: 50px;">
    <h3>Login with Phone + OTP</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Step 1: Phone input form --}}
    @if(!session('otp'))
        <form method="POST" action="{{ route('login.otp.send') }}">
            @csrf
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required autofocus>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>
    @endif

    {{-- Step 2: OTP verification form --}}
    @if(session('otp') && session('phone'))
        <form method="POST" action="{{ route('login.otp.verify') }}">
            @csrf
            <input type="hidden" name="phone" value="{{ session('phone') }}">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required autofocus>
                @error('otp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Verify & Login</button>
        </form>
    @endif
</div>
@endsection
