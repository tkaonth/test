@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\doc_st.php');
    
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ $content_lang['content-header-edit'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-2/3 p-5 border-2 rounded-lg">
                    <div class="w-full">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('docstatus') }}">
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
                        <form method="POST" action="{{ route('updatedoc-st', ['id' => $doc_st->id]) }}">
                            @csrf
                            @method('PUT')
                            <div>
                                <div>
                                    <x-label for="keyword" value="Keyword" />
                                    <x-input id="keyword" class="block mt-1 w-full" readonly type="text" name="keyword"
                                        value="{{$doc_st->keyword}}" required autofocus />
                                </div>
                                <div class="flex justify-between space-x-2 mt-1">
                                    <div>
                                        <x-label for="thai" value="{{ $content_lang['new-name'] }} (TH)" />
                                        <x-input id="thai" class="block mt-1 w-full" type="text" name="thai"
                                        value="{{$doc_st->thai}}" required autofocus />
                                    </div>
                                    <div>
                                        <x-label for="lao" value="{{ $content_lang['new-name'] }} (LAO)" />
                                        <x-input id="lao" class="block mt-1 w-full" type="text" name="lao"
                                        value="{{$doc_st->lao}}" required autofocus />
                                    </div>
                                    <div>
                                        <x-label for="eng" value="{{ $content_lang['new-name'] }} (ENG)" />
                                        <x-input id="eng" class="block mt-1 w-full" type="text" name="eng"
                                        value="{{$doc_st->eng}}" required autofocus />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button
                                    class="ml-4 p-2 bg-blue-500 drop-shadow-lg hover:bg-blue-300 rounded-lg text-white">
                                    {{ $content_lang['edit-editbutton'] }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
