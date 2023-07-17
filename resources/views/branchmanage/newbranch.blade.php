@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\branch.php');
    $options = include base_path('lang\\' . session()->get('locale') . '\branchdivision.php');
    
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
                <div class="w-2/3 p-5 border-2 rounded-lg">
                    <div class="w-full">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('branchmanage') }}">
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
                        <form method="POST" action="{{ route('addnewbranch') }}">
                            @csrf

                            <div>
                                <x-label for="keyword" value="Keyword" />
                                <x-input id="keyword" class="block mt-1 w-full" type="text" name="keyword"
                                    :value="old('keyword')" required autofocus />
                            </div>
                            <div class="flex justify-between space-x-2 mt-1">
                                <div>
                                    <x-label for="thai" value="{{ $content_lang['new-name'] }} (TH)" />
                                    <x-input id="thai" class="block mt-1 w-full" type="text" name="thai"
                                    :value="old('thai')" required autofocus />
                                </div>
                                <div>
                                    <x-label for="lao" value="{{ $content_lang['new-name'] }} (LAO)" />
                                    <x-input id="lao" class="block mt-1 w-full" type="text" name="lao"
                                    :value="old('lao')" required autofocus />
                                </div>
                                <div>
                                    <x-label for="eng" value="{{ $content_lang['new-name'] }} (ENG)" />
                                    <x-input id="eng" class="block mt-1 w-full" type="text" name="eng"
                                    :value="old('eng')" required autofocus />
                                </div>
                            </div>

                            <div class="mt-4 w-full flex space-x-2 justify-between">
                                <div class="w-full">
                                    <x-label class="mb-1" for="zone" value="{{ $content_lang['new-zone'] }}" />
                                    <select
                                        class="w-full p-2 mb-2 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="selectzone" multiple size="11" name="selectzone">
                                    </select>
                                </div>
                                <div class="flex flex-col justify-center items-center">

                                    <div id="addzone"
                                        class="bg-blue-500 p-2 rounded-md drop-shadow-md hover:bg-blue-300 mb-5 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                    <div id="removezone"
                                        class="bg-blue-500 p-2 rounded-md drop-shadow-md hover:bg-blue-300 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <x-label class="mb-1" for="zone"
                                        value="{{ $content_lang['new-zoneselect'] }}" />
                                    <select
                                        class="w-full p-2 mb-2 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        id="selectedzone" name="selectedzone[]" multiple size="11"
                                        name="selectzone">
                                    </select>
                                    @error('selectedzone')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                            </div>

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
<script>
    const selectzone = document.getElementById('selectzone');
    const selectedzone = document.getElementById('selectedzone');
    const textarea = document.getElementById('zone');
    const addzone = document.getElementById('addzone');
    const removezone = document.getElementById('removezone');
    $(document).ready(function() {
        // Define your array of data
        const options = [
            'แขวงอัตปือ',
            'แขวงบ่อแก้ว',
            'แขวงบอลิคำไซ',
            'แขวงจำปาศักดิ์',
            'แขวงหัวพัน',
            'แขวงคำม่วน',
            'แขวงหลวงน้ำทา',
            'แขวงหลวงพระบาง',
            'แขวงอุดมไชย',
            'แขวงพงสาลี',
            'แขวงสาละวัน',
            'แขวงสะหวันนะเขต',
            'นครหลวงเวียงจันทน์',
            'แขวงเวียงจันทน์',
            'แขวงไชยบุรี',
            'แขวงไชยสมบูรณ์',
            'แขวงเซกอง',
            'แขวงเชียงขวาง',
        ];
        let optiontext = {!! json_encode($options) !!}

        for (var i = 0; i < options.length; i++) {
            const optionElement = document.createElement('option');
            optionElement.value = options[i];
            optionElement.text = optiontext[i];
            selectzone.add(optionElement);
        }
    });


    $(document).ready(function() {
        $('#addzone').click(function() {
            $('#selectzone option:selected').each(function() {
                // Add transferred value to select2
                $('#selectedzone').append("<option selected class='bg-white' value='" + $(this)
                    .val() + "'>" + $(this).text() +
                    "</option>");
                // Remove transferred value from select1
                $(this).remove();
            });
            $('#selectedzone').f
        });
    });
    $(document).ready(function() {
        $('#removezone').click(function() {
            $('#selectedzone option:selected').each(function() {
                // Add transferred value to select2
                $('#selectzone').append("<option value='" + $(this).val() + "'>" + $(this)
                    .text() +
                    "</option>");
                // Remove transferred value from select1
                $(this).remove();
            });
        });
    });
</script>
