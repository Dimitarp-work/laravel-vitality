@extends('layouts.auth')

@section('title', 'Login | Vitality Platform')

@section('content')
    <div class="w-full max-w-md space-y-6">
        <div class="flex justify-center">
            <div class="bg-pink-100 p-4 rounded-full">✨</div>
        </div>
        <h2 class="text-center text-2xl font-bold text-gray-900">Welcome to Syntess Vitality</h2>
        <p class="text-center text-sm text-gray-500">Your daily wellness companion</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-500 shadow-sm focus:ring-pink-400" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end mt-4 gap-4">
                @if (Route::has('password.request'))
                    <a class="text-pink-500 hover:underline text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md font-semibold transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 mt-3">
            Don't have an account? <a href="{{ route('register') }}" class="text-pink-500 hover:underline">Register</a>
        </p>
    </div>
@endsection
