@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\carsmanage.php');
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ $content_lang['content-header-history'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-1/3 p-5 border-2 rounded-lg">
                    <div class="w-full">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('detailcar', ['id' => $id]) }}">
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
                        <form method="POST" action="{{ route('addcarhistory',['id'=> $id]) }}">
                            @csrf

                            <div>
                                <x-label class="mb-1" for="car_st" value="{{ $content_lang['new-car-st'] }}" />
                                <select
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    name="car_st">
                                    @foreach ($car_sts as $car_st)
                                        <option value="{{ $car_st->keyword }}">
                                            @if (session()->get('locale') == 'th')
                                                {{ $car_st->thai }}
                                            @elseif(session()->get('locale') == 'lo')
                                                {{ $car_st->lao }}
                                            @elseif(session()->get('locale') == 'en')
                                                {{ $car_st->eng }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_st')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="car_expenses" value="{{ $content_lang['history-expenses'] }}" />
                                <x-input id="car_expenses" class="block mt-1 w-full" type="text" name="car_expenses"
                                    :value="old('car_expenses')" required autocomplete="car_expenses"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-car_expenses'] }}')" />
                                @error('car_expenses')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="car_description" value="{{ $content_lang['history-description'] }}" />
                                <textarea id="car_description" 
                                    class="block mt-1 p-3 w-full rounded-lg border-gray-300" name="car_description"
                                    value="" required autocomplete="car_description"
                                    rows="10"
                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-car_description'] }}')" ></textarea>
                                @error('car_description')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    class="ml-4 p-2 bg-blue-500 drop-shadow-lg hover:bg-blue-300 rounded-lg text-white">
                                    {{ $content_lang['new-hisbutton'] }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
