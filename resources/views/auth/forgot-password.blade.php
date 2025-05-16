<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vitality Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white text-gray-900">

<!-- Gradient Top Border -->
<div class="h-2 bg-gradient-to-r from-pink-400 to-purple-400"></div>

<div class="flex flex-col md:flex-row min-h-screen">

    <!-- Welcome Section -->
    <section class="w-full md:w-1/2 bg-gradient-to-br from-pink-200 to-pink-100 flex flex-col justify-center p-12 relative overflow-hidden">
        <h1 class="text-4xl font-bold text-pink-900 mb-6">Syntess Vitality</h1>
        <p class="text-lg text-pink-800 mb-8 max-w-2xl">
            Your journey to wellness begins here. Track your progress, find inspiration, and connect with a community that cares about your wellbeing.
        </p>

        <div class="space-y-6">
            <div class="flex items-start space-x-4">
                <div class="text-pink-500 bg-white p-2 rounded-full shadow">❤️</div>
                <div>
                    <h3 class="font-semibold text-pink-900">Track Your Wellness Journey</h3>
                    <p class="text-pink-800 text-sm">Set goals, monitor progress, and celebrate your achievements along the way.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="text-pink-500 bg-white p-2 rounded-full shadow">📈</div>
                <div>
                    <h3 class="font-semibold text-pink-900">Personalized Recommendations</h3>
                    <p class="text-pink-800 text-sm">Receive customized wellness tips based on your activities and preferences.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="text-pink-500 bg-white p-2 rounded-full shadow">😊</div>
                <div>
                    <h3 class="font-semibold text-pink-900">Build Healthy Habits</h3>
                    <p class="text-pink-800 text-sm">Create and maintain daily routines that contribute to your overall wellbeing.</p>
                </div>
            </div>
        </div>

        <!-- Decorative Circles -->
        <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full bg-pink-300 opacity-20"></div>
        <div class="absolute top-1/4 -left-8 w-32 h-32 rounded-full bg-pink-300 opacity-20"></div>
        <div class="absolute bottom-1/3 right-1/4 w-24 h-24 rounded-full bg-pink-400 opacity-20"></div>
    </section>

    <!-- Forgot Password Section -->
    <section class="w-full md:w-1/2 flex justify-center items-center p-8 bg-white">
        <div class="w-full max-w-md space-y-6">
            <div class="flex justify-center">
                <div class="bg-pink-100 p-4 rounded-full">🔒</div>
            </div>
            <h2 class="text-center text-2xl font-bold text-gray-900">Reset Your Password</h2>
            <p class="text-center text-sm text-gray-600">
                Forgot your password? No problem. Enter your email address and we'll send you a reset link.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded transition">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </section>

</div>
</body>
</html>

