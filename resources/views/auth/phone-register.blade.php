@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Register with Phone Number</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth.phone.register') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   placeholder="e.g., 0123456789 or +855123456789" required>
                            <small class="form-text text-muted">
                                Enter your Cambodian phone number (e.g., 0123456789, 855123456789, or +855123456789)
                            </small>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Send Registration OTP
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Already have an account? 
                            <a href="{{ route('auth.phone.login') }}">Login with Phone</a>
                        </p>
                        <p>Or 
                            <a href="{{ route('login') }}">Login with Email</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 