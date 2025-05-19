@extends('layouts.auth')

@section('title', 'Reset Password | Vitality Platform')

@section('content')
    <div class="w-full max-w-md space-y-6">
        <div class="flex justify-center">
            <div class="bg-pink-100 p-4 rounded-full">📧</div>
        </div>
        <h2 class="text-center text-2xl font-bold text-gray-900">Verify Your Email</h2>
        <p class="text-center text-sm text-gray-600">
            Thanks for signing up! Please verify your email address by clicking the link we just sent you. If you didn’t receive it, we can send another.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="text-green-600 text-sm text-center font-medium">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="mt-6 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded transition">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-pink-600 hover:underline">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
@endsection
