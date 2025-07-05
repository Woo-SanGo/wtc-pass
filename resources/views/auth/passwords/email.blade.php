<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Load Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for the Inter font */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for error messages (example for demonstration) */
        .is-invalid {
            border-color: #ef4444; /* red-500 */
        }
        .invalid-feedback {
            display: block; /* Ensure error message is visible */
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-xl border border-gray-200">
        <!-- Card Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-800">Reset Password</h1>
        </div>

        <!-- Card Body - Password Reset Form -->
        <form method="POST" action="/password/update">
            <!-- CSRF Token (placeholder for Laravel's @csrf) -->
            <!-- In a real Laravel app, this would be @csrf -->
            <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_HERE">

            <!-- Hidden input for the password reset token -->
            <input type="hidden" name="token" value="YOUR_RESET_TOKEN_HERE">

            <!-- Email Address Input Field -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                    Email Address
                </label>
                <input id="email" type="email"
                    class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                    <!-- Example of error class, replace with Laravel's @error('email') is-invalid @enderror -->
                    <!-- @error('email') is-invalid @enderror -->"
                    name="email"
                    value="user@example.com" <!-- Replace with {{ $email ?? old('email') }} -->
                    required autocomplete="email" autofocus>

                <!-- Error message for email (example for demonstration) -->
                <!-- In a real Laravel app, this would be @error('email') ... @enderror -->
                <!--
                <span class="invalid-feedback text-red-500 text-xs mt-1" role="alert">
                    <strong>The email field is required.</strong>
                </span>
                -->
            </div>

            <!-- New link added here: Use Phone Number Instead -->
            <div class="mb-6 text-center">
                <a href="{{ route('auth.phone.form') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-300 ease-in-out">
                    Use Phone Number Instead
                </a>
            </div>

            <!-- Password Input Field -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                    Password
                </label>
                <input id="password" type="password"
                    class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                    <!-- Example of error class, replace with Laravel's @error('password') is-invalid @enderror -->
                    <!-- @error('password') is-invalid @enderror -->"
                    name="password" required autocomplete="new-password">

                <!-- Error message for password (example for demonstration) -->
                <!--
                <span class="invalid-feedback text-red-500 text-xs mt-1" role="alert">
                    <strong>The password must be at least 8 characters.</strong>
                </span>
                -->
            </div>

            <!-- Confirm Password Input Field -->
            <div class="mb-8">
                <label for="password-confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                    Confirm Password
                </label>
                <input id="password-confirm" type="password"
                    class="shadow-sm appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    name="password_confirmation" required autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:shadow-outline w-full transition duration-300 ease-in-out transform hover:scale-105">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</body>
</html>
