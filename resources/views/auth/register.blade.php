@extends('layouts.app')

@section('content')
<div class="max-w-md bg-gray-700 mx-auto rounded-lg px-4 py-6">
    <h3 class="text-center">Registration Form</h3>
    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        <div class="space-y-2">
            <label for="name" class="">{{ __('Name') }}</label>
            <input
                id="name"
                type="text"
                class="bg-gray-800 text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                    @error('name') is-invalid @enderror"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                autofocus
            >
        </div>
        @error('name')
            <div class="text-sm text-red-500">{{ $message }}</div>
        @enderror

        <div class="space-y-2">
            <label for="email" class="">{{ __('e-mail') }}</label>
            <input
                id="email"
                type="text"
                class="bg-gray-800 text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                        @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                autofocus
            >
        </div>
        @error('email')
            <div class="text-sm text-red-500">{{ $message }}</div>
        @enderror

        <div class="space-y-2">
            <label for="password" class="">{{ __('Password') }}</label>
            <input
                id="password"
                type="password"
                class="bg-gray-800 text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                        @error('password') is-invalid @enderror"
                name="password"
                value="{{ old('password') }}"
                required
                autocomplete="password"
                autofocus
            >
        </div>
        @error('password')
            <div class="text-sm text-red-500">{{ $message }}</div>
        @enderror

        <div class="space-y-2">
            <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
            <input
                id="password-confirm"
                type="password"
                class="bg-gray-800 text-sm rounded-full w-full px-2 py-2 focus:outline-none focus:shadow-outline
                        @error('password-confirm') is-invalid @enderror"
                name="password_confirmation"
                value="{{ old('password-confirm') }}"
                required
                autocomplete="new-password"
                autofocus
            >
        </div>
        @error('email')
            <div class="text-sm text-red-500">{{ $message }}</div>
        @enderror


        <div class="text-center">
            <button
                type="submit"
                class="bg-gray-600 rounded-full px-10 py-2 hover:scale-125"
            >Register</button>
        </div>
    </form>
</div>
@endsection
