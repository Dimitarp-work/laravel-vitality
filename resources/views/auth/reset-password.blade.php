@extends('layouts.auth')

@section('title', 'Reset Password | Vitality Platform')

@section('content')
    <div class="w-full max-w-md space-y-6">
        <div class="flex justify-center">
            <div class="bg-pink-100 p-4 rounded-full">🔁</div>
        </div>
        <h2 class="text-center text-2xl font-bold text-gray-900">Reset Your Password</h2>
        <p class="text-center text-sm text-gray-600">
            Choose a new password for your account.
        </p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded transition">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
