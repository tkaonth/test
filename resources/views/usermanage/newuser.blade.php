@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\usermanager.php');
    
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ $content_lang['content-header-add'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-1/3 p-5 border-2 rounded-lg">
                    <div class="w-full">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('usermanage') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                            </svg>
                            {{ $content_lang['new-back'] }}
                        </a>
                    </div>
                    <div>
                        @if ($message = Session::get('success'))
                            <script>
                                Swal.fire({
                                    text: "{{ $message }}",
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })
                            </script>
                        @endif
                        <form method="POST" action="{{ route('addnewuser') }}">
                            @csrf

                            <div>
                                <x-label for="name" value="{{ $content_lang['new-name'] }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-name'] }}')" />
                                @error('name')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="username" value="{{ $content_lang['new-username'] }}" />
                                <x-input id="username" class="block mt-1 w-full" type="text" name="username"
                                    :value="old('username')" required autocomplete="username"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-username'] }}')" />
                                @error('username')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="password" value="{{ $content_lang['new-pass'] }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-password'] }}')" />
                                @error('password')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="password_confirmation" value="{{ $content_lang['new-confirmpass'] }}" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-confirmpassword'] }}')" />
                                @error('password_confirmation')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label class="mb-1" for="user_level" value="{{ $content_lang['new-userlevel'] }}" />
                                <select
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    name="user_level">
                                    @foreach ($user_levels as $user_level)
                                        <option value="{{ $user_level->keyword }}">
                                            @if (session()->get('locale') == 'th')
                                                {{ $user_level->thai }}
                                            @elseif(session()->get('locale') == 'lo')
                                                {{ $user_level->lao }}
                                            @elseif(session()->get('locale') == 'en')
                                                {{ $user_level->eng }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_level')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mt-4">
                                    <x-label for="terms">
                                        <div class="flex items-center">
                                            <x-checkbox name="terms" id="terms" required />

                                            <div class="ml-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' =>
                                                        '<a target="_blank" href="' .
                                                        route('terms.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Terms of Service') .
                                                        '</a>',
                                                    'privacy_policy' =>
                                                        '<a target="_blank" href="' .
                                                        route('policy.show') .
                                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                        __('Privacy Policy') .
                                                        '</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </x-label>
                                </div>
                            @endif

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    class="ml-4 p-2 bg-blue-500 drop-shadow-lg hover:bg-blue-300 rounded-lg text-white">
                                    {{ $content_lang['new-addbutton'] }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
