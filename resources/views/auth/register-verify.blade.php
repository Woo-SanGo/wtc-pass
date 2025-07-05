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
            Verify Phone Number
        </div>

        <div class="p-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('test_otp'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-md mb-6" role="alert">
                    <strong>Test Mode:</strong> Your OTP is: <strong>{{ session('test_otp') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-6" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="text-center mb-6">
                <p class="text-gray-600 mb-2">
                    <strong>Phone:</strong> {{ session('phone') }}
                </p>
                <p class="text-gray-600 mb-2">
                    <strong>Name:</strong> {{ session('name') }}
                </p>
                <p class="text-gray-500 text-sm">
                    Enter the 6-digit code sent to your phone number
                </p>
            </div>

            <form method="POST" action="{{ route('auth.register.verify') }}">
                @csrf
                
                <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                
                <!-- OTP Input -->
                <div class="mb-6">
                    <label for="otp_code" class="block text-gray-700 text-sm font-semibold mb-2">
                        OTP Code
                    </label>
                    <input id="otp_code" type="text" name="otp_code"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('otp_code') border-red-500 @enderror"
                        placeholder="Enter 6-digit OTP" maxlength="6" required autofocus>
                    @error('otp_code')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-[#28A745] text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:ring-2 focus:ring-[#28A745] transition">
                        Complete Registration
                    </button>
                </div>

                <!-- Back to register -->
                <div class="text-center text-sm text-gray-600">
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">
                        Back to Registration
                    </a>
                </div>
            </form>
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