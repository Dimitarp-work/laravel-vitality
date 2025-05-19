@extends('layouts.auth')

@section('title', 'Confirm Password | Vitality Platform')

@section('content')
    <div class="w-full max-w-md space-y-6">
        <div class="flex justify-center">
            <div class="bg-pink-100 p-4 rounded-full">🔐</div>
        </div>
        <h2 class="text-center text-2xl font-bold text-gray-900">Confirm Your Password</h2>
        <p class="text-center text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded transition">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
