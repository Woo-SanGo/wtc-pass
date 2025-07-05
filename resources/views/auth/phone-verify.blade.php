@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Verify OTP</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('test_otp'))
                        <div class="alert alert-info">
                            <strong>Test Mode:</strong> Your OTP is: <strong>{{ session('test_otp') }}</strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <p class="mb-2">
                            <strong>Phone:</strong> {{ session('phone') }}
                        </p>
                        <p class="mb-2">
                            <strong>Name:</strong> {{ session('name') }}
                        </p>
                        <p class="text-muted">
                            @if(session('is_registration'))
                                Registration OTP sent to your phone number
                            @else
                                Login OTP sent to your phone number
                            @endif
                        </p>
                    </div>

                    <form method="POST" action="{{ route('auth.phone.verify') }}">
                        @csrf
                        
                        <input type="hidden" name="phone" value="{{ session('phone') }}">
                        <input type="hidden" name="is_registration" value="{{ session('is_registration') ? '1' : '0' }}">
                        
                        <div class="form-group">
                            <label for="otp_code">Enter OTP Code</label>
                            <input type="text" class="form-control @error('otp_code') is-invalid @enderror" 
                                   id="otp_code" name="otp_code" 
                                   placeholder="Enter 6-digit OTP" 
                                   maxlength="6" required autofocus>
                            <small class="form-text text-muted">
                                Enter the 6-digit code sent to your phone
                            </small>
                            @error('otp_code')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                @if(session('is_registration'))
                                    Complete Registration
                                @else
                                    Login
                                @endif
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Didn't receive the OTP? 
                            @if(session('is_registration'))
                                <a href="{{ route('auth.phone.register') }}">Try Again</a>
                            @else
                                <a href="{{ route('auth.phone.login') }}">Try Again</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-focus on OTP input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('otp_code').focus();
});

// Auto-submit when 6 digits are entered
document.getElementById('otp_code').addEventListener('input', function() {
    if (this.value.length === 6) {
        this.form.submit();
    }
});
</script>
@endsection 