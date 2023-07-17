@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\carsmanage.php');
    
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
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('cuscard', ['id' => $cus_id]) }}">
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
                            <form class="mt-8 space-y-3" action="{{ route('uploadfile') }}"
                                method="POST" id="file-form" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 space-y-2">
                                    <input type="hidden" name="cus_id" value="{{$cus_id}}">
                                    <input type="hidden" name="ins_type" value="{{$ins_type}}">
                                    <input type="hidden" id="bill_id" name="bill_id" value="{{$bill_id}}">
                                    <input type="hidden" id="bill_name" name="bill_name" value="{{$bill_number}}">
                                    <label
                                        class="text-sm font-bold text-gray-500 tracking-wide">{{ $content_lang['upload-name'] }}</label>
                                    <input type="text" class="block mt-1 w-full pl-1 border-gray-300 rounded-md" readonly value="{{$bill_number}}">
                                    @error('doc_name')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 space-y-2">
                                    <label
                                        class="text-sm font-bold text-gray-500 tracking-wide">{{ $content_lang['upload-doc'] }}</label>
                                    <div class="flex items-center justify-center w-full drag-drop">
                                        <label
                                            class="flex flex-col rounded-lg border-4 border-dashed w-full h-60 p-10 group text-center">
                                            <div
                                                class="h-full w-full text-center flex flex-col items-center justify-center">

                                                <div id="preview-container"
                                                    class="flex flex-auto max-h-48 w-full mx-auto -mt-10">
                                                </div>
                                                <p id="upload_hint" class="pointer-none text-gray-500">
                                                    <a href="" id=""
                                                        class="text-blue-600 hover:underline">{{ $content_lang['upload-hint'] }}</a>
                                                </p>
                                            </div>
                                            <input type="file" name="file-input[]" id="file-input" multiple
                                                class="hidden">
                                        </label>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400">
                                    <span>{{ $content_lang['upload-type'] }}</span>
                                </p>
                                <div>
                                    <button type="submit"
                                        class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-lg tracking-wide
                                                font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                                        {{ $content_lang['upload-button'] }}
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const fileInput = document.getElementById("file-input");
    const previewContainer = document.getElementById("preview-container");

    fileInput.addEventListener("change", function() {
        previewContainer.innerHTML = "";
        const upload_hint = document.getElementById("upload_hint");
        const files = this.files;
        if (files) {
            upload_hint.classList.add("invisible");
        } else {
            pload_hint.classList.remove("invisible");
        }
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = function(e) {
                const preview = document.createElement("div");
                preview.classList.add("file-preview");
                const img = document.createElement("img");
                if (file.type == 'image/jpeg' || file.type == 'image/png') {
                    img.setAttribute("src", e.target.result);
                } else {
                    img.setAttribute("src", '{{ asset('getuploadicon/document_icon.png') }}');
                }
                const name = document.createElement("span");
                preview.appendChild(img);
                previewContainer.appendChild(preview);
            }
        }
    });

</script>
