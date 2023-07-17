@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    //$login_ui = include base_path('lang\\' . session()->get('locale') . '\auth.php');
    $login_ui = include base_path('lang\\' . session()->get('locale') . '\auth.php');
    //dd(session()->get('locale'));
@endphp
<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $login_ui['content-header'] }}
        </h2>
    </x-slot>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $login_ui[session('status')] }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="username" value="{{ $login_ui['form-username'] }}" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ $login_ui['form-password'] }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ $login_ui['form-remember'] }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ $login_ui['form-login'] }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
