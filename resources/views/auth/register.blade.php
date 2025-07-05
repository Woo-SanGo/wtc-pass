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
            {{ __('Register') }}
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Name') }}
                    </label>
                    <input id="name" type="text" name="name"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Email Address') }}
                    </label>
                    <input id="email" type="email" name="email"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Phone Number') }}
                    </label>
                    <input id="phone" type="text" name="phone"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('phone') border-red-500 @enderror"
                        value="{{ old('phone') }}" required autocomplete="tel" placeholder="e.g., +85512345678">
                    @error('phone')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Register As') }}
                    </label>
                    <select name="role" id="role"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#28A745] @error('role') border-red-500 @enderror" required>
                        <option value="">-- Select Role --</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="shelter" {{ old('role') == 'shelter' ? 'selected' : '' }}>Shelter</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Password') }}
                    </label>
                    <input id="password" type="password" name="password"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745] @error('password') border-red-500 @enderror"
                        required autocomplete="new-password">
                    @error('password')
                        <span class="text-red-500 text-xs italic mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password-confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                        {{ __('Confirm Password') }}
                    </label>
                    <input id="password-confirm" type="password" name="password_confirmation"
                        class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-[#28A745]"
                        required autocomplete="new-password">
                </div>

                <!-- Submit -->
                <div class="mb-4">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-[#28A745] text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:ring-2 focus:ring-[#28A745] transition">
                        {{ __('Register') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative flex items-center justify-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Google button -->
                <div class="text-center">
                    <a href="{{ route('google.login') }}"
                        class="inline-flex items-center justify-center w-full px-6 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-gray-700 font-medium text-lg hover:bg-gray-100 focus:ring-2 focus:ring-gray-300 transition">
                        <img src="{{ asset('images/google_logo.webp') }}" alt="Google logo" class="w-6 h-6 mr-3">
                        Sign up with Google
                    </a>
                </div>

                <!-- Login link -->
                <div class="mt-6 text-center text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">
                        {{ __('Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
