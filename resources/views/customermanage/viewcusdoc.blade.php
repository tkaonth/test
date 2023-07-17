@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
@endphp



<style>
    .file-preview {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .file-preview img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-upload'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-2/3 p-5 border-2 rounded-lg">
                    <div class="w-fit">
                        
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('cuscard', ['id' => $id]) }}">
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
                        <div class="rounded-lg drop-shadow-lg">
                            <ul class="bg-gray-50 rounded-lg p-4">
                                @foreach ($doc_lists as $doc_list)
                                    @php
                                        $fileext = pathinfo($doc_list->doc_name, PATHINFO_EXTENSION);
                                    @endphp
                                        <li class="flex items-center p-2 rounded-lg hover:bg-gray-200">
                                            <img @if($fileext == 'pdf') src="{{ asset('/getuploadicon/document_icon.png') }}" @else src="{{ asset($doc_list->doc_path . '/' . $doc_list->doc_name) }}" @endif
                                                alt="GG" width="50" height="auto">
                                            <div class="ml-3 flex justify-between items-center w-full">
                                                <div class="text-blue-500">
                                                    {{ $doc_list->doc_name }}
                                                </div>
                                                <div class="flex space-x-2">
                                                    <a target="_blank" href="{{ asset($doc_list->doc_path . '/' . $doc_list->doc_name) }}">
                                                        <div class="p-2 rounded-lg bg-blue-500 hover:bg-blue-300 text-white cursor-pointer">
                                                            {{ $content_lang['view-button'] }}
                                                        </div>
                                                    </a>
                                                    <button onclick="confirmremovefile({{ $doc_list->id }})">
                                                        <div class="p-2 rounded-lg bg-red-500 hover:bg-red-300 text-white cursor-pointer">
                                                            {{ $content_lang['removefile-button'] }}
                                                        </div>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                        </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>

    function confirmremovefile(e) {
        console.log(e);
        var url = "{{ route('removefile_cus', ':id') }}".replace(':id', e);
        Swal.fire({
            text: "{{ $content_lang['del-alert-text-file'] }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ $content_lang['del-alert-confirm'] }}",
            cancelButtonText: "{{ $content_lang['del-alert-cancel'] }}",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
