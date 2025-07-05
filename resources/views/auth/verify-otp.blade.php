@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .form-input-focus:focus {
        outline: none;
        border-color: #28A745;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
    }
</style>

<div class="min-h-screen bg-cover bg-center flex items-center justify-end p-6" style="background-image: url('{{ asset('images/dog_pic.jpg') }}');">
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl mr-20">
        <div class="bg-[#28A745] text-white text-center text-2xl font-bold py-4 rounded-t-lg">
            {{ __('Verify OTP') }}
        </div>

        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.otp.verify') }}">
                @csrf

                <!-- Hidden input to carry phone number -->
                <input 
                    type="hidden" 
                    name="phone" 
                    value="{{ session('phone') ?? old('phone', '+855') }}" />

                <!-- OTP Code -->
                <div class="mb-6">
                    <label for="otp_code" class="block text-gray-700 text-sm font-semibold mb-2">
                        Enter the OTP Code
                    </label>
                    <input id="otp_code" type="text" name="otp_code"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('otp_code') border-red-500 @enderror"
                        placeholder="6-digit OTP" required>
                    @error('otp_code')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-[#28A745] text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:ring-2 focus:ring-[#28A745] transition">
                        Verify OTP
                    </button>
                </div>

                <!-- Back to login -->
                <div class="mt-6 text-center text-sm text-gray-600">
                    {{ __('Entered wrong number?') }}
                    <a href="{{ route('auth.phone.form') }}" class="text-blue-600 hover:underline font-semibold">
                        {{ __('Go Back') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
