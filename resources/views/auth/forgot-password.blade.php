@extends('layouts.auth')

@section('title', 'Forgot Password | Vitality Platform')

@section('content')
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
@endsection

