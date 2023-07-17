@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\carsmanage.php');
@endphp



<style>
    /* The grid: Four equal columns that floats next to each other */
    .column {
        float: left;
        width: 25%;
        padding: 10px;
    }

    /* Style the images inside the grid */
    .column img {
        opacity: 0.8;
        cursor: pointer;
    }

    .column img:hover {
        opacity: 1;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* The expanding image container (positioning is needed to position the close button and the text) */
    .container {
        position: relative;
        display: none;
    }

    /* Expanding image text */
    #imgtext {
        position: absolute;
        bottom: 15px;
        left: 15px;
        color: white;
        font-size: 20px;
    }

    /* Closable button inside the image */
    .closebtn {
        position: absolute;
        top: 10px;
        right: 15px;
        color: white;
        font-size: 35px;
        cursor: pointer;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-detail'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-full p-5 border-2 rounded-lg">
                    <div class="w-fit">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('carsmanage') }}">
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

                        <div class="flex my-3">
                            <!-- The expanding image container -->
                            <div class="container">
                                <!-- Close the image -->
                                <span onclick="closeimage(this)" class="closebtn">&times;</span>

                                <!-- Expanded image -->
                                <img id="expandedImg" style="width:100%">

                                <!-- Image text -->
                                <div id="imgtext"></div>
                            </div>
                        </div>

                        <!-- The grid: four columns -->
                        <div class="w-full flex justify-center">
                            <div class="w-full md:w-3/4 lg:w-2/3 xl:w-1/2">
                                <div class="relative">
                                    <div class="flex overflow-x-scroll">
                                        @foreach ($car_file as $item)
                                            <div class="w-1/5 flex-shrink-0 mr-4">
                                                @php
                                                    $fileext = pathinfo($item->file_name, PATHINFO_EXTENSION);
                                                @endphp
                                                @if ($fileext == 'pdf')
                                                    <div class="relative">
                                                        <img src="{{ asset('/getuploadicon/document_icon.png') }}"
                                                            alt="{{ $item->file_name }}" class="w-full">
                                                        <div
                                                            class="absolute inset-0 flex-row justify-center text-center opacity-0 hover:opacity-100 transition duration-300">
                                                            <a href="{{ asset($item->file_path . '/' . $item->file_name) }}"
                                                                target="_blank">
                                                                <div
                                                                    class="bg-blue-500 text-white py-2 px-4 rounded mt-2 mb-1 hover:bg-blue-300">
                                                                    {{ $content_lang['view-button'] }}
                                                                </div>
                                                            </a>
                                                            <button onclick="confirmremovepdf({{ $item->id }})"
                                                                class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-300">{{ $content_lang['remove-button'] }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ asset($item->file_path . '/' . $item->file_name) }}"
                                                        style="width:auto;height:100px;" id="{{ $item->id }}"
                                                        name="{{ $fileext }}" alt="{{ $item->file_name }}"
                                                        class="cursor-pointer" onclick="swicthimage(this);">
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="flex-row justify-items-center items-center">
                                <a id="upload_file" href="{{ route('uploadform_car', ['id' => $car_data->id]) }}">
                                    <div
                                        class="ml-3 mb-2 text-center p-2 bg-blue-500 hover:bg-blue-300 rounded-lg drop-shadow-lg cursor-pointer text-white">
                                        {{ $content_lang['upload-button'] }}
                                    </div>
                                </a>
                                <a id="remove_file" class="hidden">
                                    <div onclick="confirmremovefile(this)"
                                        class="ml-3 mb-2 text-center p-2 bg-red-500 hover:bg-red-300 rounded-lg drop-shadow-lg cursor-pointer text-white">
                                        {{ $content_lang['remove-button'] }}
                                    </div>
                                </a>
                            </div>

                        </div>
                        @if ($cusdata)
                            <h1 class="p-2 my-2 text-xl bg-blue-200 rounded-lg">{{ $content_lang['owner-detail'] }}</h1>
                            @if ($cusdata->id == $car_data->cus_id)
                                <div class="pl-4 flex w-full justify-between mb-2">
                                    <div class="w-1/3 mr-5">
                                        <x-label for="owner_code" value="{{ $content_lang['owner-code'] }}" />
                                        {{ $cusdata->cus_code }}
                                    </div>

                                    <div class="w-1/3 mr-5">
                                        <x-label for="owner_name" value="{{ $content_lang['owner-name'] }}" />
                                        {{ $cusdata->cus_name }}
                                    </div>

                                    <div class="w-1/3 flex mr-5 items-center">
                                        <div class="w-1/2">
                                            <x-label for="owner_status" value="{{ $content_lang['owner-status'] }}" />

                                                @if (session()->get('locale') == 'th')
                                                    {{ $cus_st->thai }}
                                                @elseif(session()->get('locale') == 'lo')
                                                    {{ $cus_st->lao }}
                                                @elseif(session()->get('locale') == 'en')
                                                    {{ $cus_st->eng }}
                                                @endif
                                                
                                        </div>
                                        <div class="w-1/2">
                                            <a target="_blank"
                                                href="{{ route('cuscard', ['id' => $cusdata->id]) }}">
                                                <div
                                                    class="ml-3 mb-2 text-center p-2 bg-blue-500 hover:bg-blue-300 rounded-lg drop-shadow-lg cursor-pointer text-white">
                                                    {{ $content_lang['history-description'] }}
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endif
                        

                        <form method="POST" action="{{ route('updatecar', ['id' => $car_data->id]) }}">
                            @csrf
                            @method('PUT')
                            <h1 class="p-2 my-2 text-xl bg-blue-200 rounded-lg">{{ $content_lang['car-detail'] }}</h1>
                            <div class="pl-4 flex w-full justify-between mb-2">
                                <div class="w-1/4 mr-5">
                                    <x-label for="car_model" value="{{ $content_lang['new-carmodel'] }}" />
                                    <x-input id="car_model" class="block mt-1 w-full border-0" type="text"
                                        name="car_model" required autofocus autocomplete="car_model"
                                        value="{{ $car_data->car_model }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-carnumber'] }}')" />
                                    @error('car_model')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4 mr-5">
                                    <x-label for="car_number" value="{{ $content_lang['new-carnumber'] }}" />
                                    <x-input id="car_number" class="block mt-1 w-full border-0" type="text"
                                        name="car_number" required autofocus autocomplete="car_number"
                                        value="{{ $car_data->car_number }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-carnumber'] }}')" />
                                    @error('car_number')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4 mr-5">
                                    <x-label for="engine_number" value="{{ $content_lang['new-enginenumber'] }}" />
                                    <x-input id="engine_number" class="block mt-1 w-full border-0" type="text"
                                        name="engine_number" required autofocus autocomplete="engine_number"
                                        value="{{ $car_data->engine_number }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-enginenumber'] }}')" />
                                    @error('engine_number')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4">
                                    <x-label class="mb-1" for="car_st"
                                        value="{{ $content_lang['new-car-st'] }}" />
                                    <select
                                        class="border-0 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        name="car_st">
                                        @foreach ($car_sts as $car_st)
                                            <option value="{{ $car_st->keyword }}"
                                                @if (session()->get('locale') == 'th')
                                                    {{ $car_data->car_st == $car_st->keyword ? 'selected' : '' }}>
                                                    {{ $car_st->thai }}</option>
                                                @elseif(session()->get('locale') == 'lo')
                                                    {{ $car_data->car_st == $car_st->keyword ? 'selected' : '' }}>
                                                    {{ $car_st->lao }}</option>
                                                @elseif(session()->get('locale') == 'en')
                                                    {{ $car_data->car_st == $car_st->keyword ? 'selected' : '' }}>
                                                    {{ $car_st->eng }}</option>
                                                @endif
                                                
                                        @endforeach
                                    </select>
                                    @error('car_st')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="pl-4 flex w-full justify-between mb-2">
                                <div class="w-1/4 mr-5">
                                    <x-label for="total_acc_price"
                                        value="{{ $content_lang['new-total-acc-price'] }}" />
                                    <x-input id="total_acc_price" class="block border-0 mt-1 w-full" type="number"
                                        name="total_acc_price" required autofocus autocomplete="total_acc_price"
                                        onchange="sumprice()" value="{{ $car_data->total_acc_price }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-total-acc-price'] }}')" />
                                    @error('total_acc_price')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="w-1/4 mr-5">
                                    <x-label for="car_price" value="{{ $content_lang['new-car-price'] }}" />
                                    <x-input id="car_price" class="block mt-1 w-full border-0" type="number"
                                        name="car_price" required autofocus autocomplete="car_price"
                                        onchange="sumprice()" value="{{ $car_data->car_price }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-car-price'] }}')" />
                                    @error('car_price')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4 mr-5">
                                    <x-label for="car_expenses" value="{{ $content_lang['car-expenses'] }}" />
                                    <x-input id="car_expenses" class="block mt-1 w-full border-0" type="number"
                                        name="car_expenses" required autofocus autocomplete="car_expenses"
                                        onchange="sumprice()" value="{{ $car_data->car_expenses }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-car-price'] }}')" />
                                    @error('car_expenses')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4">
                                    <x-label for="sum_price" value="{{ $content_lang['new-sum-price'] }}" />
                                    <x-input id="sum_price" class="block mt-1 w-full border-0" type="number"
                                        name="sum_price" required autofocus autocomplete="sum_price"
                                        value="{{ $car_data->sum_price }}"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-sum-price'] }}')" />
                                    @error('sum_price')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <input type="hidden" name="acc_remove_list" id="acc_remove_list"
                                        value="">
                                </div>
                            </div>
                            <h1 class="p-2 my-2 text-xl bg-blue-200 rounded-lg">
                                {{ $content_lang['accessory-detail'] }}</h1>

                            @foreach ($car_acc_data as $car_acc)
                                <div class="border-2 drop-shadow-sm relative rounded-lg p-3 mb-3">
                                    <div onclick="confirmSubmit(this,{{ $car_acc->id }})" name="removeacc[]"
                                        class="removeacc absolute right-5 rounded-lg text-red-500 cursor-pointer hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-7 h-7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <input type="hidden" name="acc_id[]" value="{{ $car_acc->id }}">
                                            <x-label class="mb-1" for="car_acc_type[]"
                                                value="{{ $content_lang['new-acc-type'] }}" />
                                            <select onchange="getValue()"
                                                class="border-gray-300 border-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                name="car_acc_type[]">
                                                <option value="ใบมีด"
                                                    {{ $car_acc->car_acc_type == 'ใบมีด' ? 'selected' : '' }}>
                                                    {{ $content_lang['new-acc-subtype1'] }}</option>
                                                <option value="หางไถ"
                                                    {{ $car_acc->car_acc_type == 'หางไถ' ? 'selected' : '' }}>
                                                    {{ $content_lang['new-acc-subtype2'] }}</option>
                                                <option value="อื่นๆ"
                                                    {{ $car_acc->car_acc_type == 'อื่นๆ' ? 'selected' : '' }}>
                                                    {{ $content_lang['new-acc-subtype3'] }}</option>
                                            </select>
                                            @error('car_acc_type[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div name="div_acc_type[]" class="w-1/2 invisible">
                                            <x-label for="acc_type[]" value="{{ $content_lang['new-acc-type'] }}" />
                                            <x-input id="acc_type[]" class="block mt-1 w-full border-0"
                                                type="text" name="acc_type[]" autofocus autocomplete="acc_type[]"
                                                value="{{ $car_acc->car_acc_type }}" />
                                            @error('acc_type[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <x-label for="acc_brand[]"
                                                value="{{ $content_lang['new-acc-brand'] }}" />
                                            <x-input id="acc_brand[]" class="block mt-1 w-full border-0"
                                                type="text" name="acc_brand[]" required autofocus
                                                autocomplete="acc_brand[]" value="{{ $car_acc->acc_brand }}"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-brand'] }}')" />
                                            @error('acc_brand[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="w-1/2">
                                            <x-label for="acc_model[]"
                                                value="{{ $content_lang['new-acc-model'] }}" />
                                            <x-input id="acc_model[]" class="block mt-1 w-full border-0"
                                                type="text" name="acc_model[]" required autofocus
                                                autocomplete="acc_model[]" value="{{ $car_acc->acc_model }}"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-model'] }}')" />
                                            @error('acc_model[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <x-label for="acc_code[]" value="{{ $content_lang['new-acc-code'] }}" />
                                            <x-input id="acc_code[]" class="block mt-1 w-full border-0"
                                                type="text" name="acc_code[]" required autofocus
                                                autocomplete="acc_code[]" value="{{ $car_acc->acc_code }}"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-code'] }}')" />
                                            @error('acc_code[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="w-1/2">
                                            <x-label for="price[]" value="{{ $content_lang['new-acc-price'] }}" />
                                            <x-input id="price[]" class="block mt-1 w-full border-0" type="number"
                                                name="price[]" required autofocus onchange="sumprice()"
                                                autocomplete="price[]" value="{{ $car_acc->acc_price }}"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-price'] }}')" />
                                            @error('price[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                            <button class="w-fit mt-5 mb-2 p-2 bg-blue-500 drop-shadow-lg rounded-lg text-white"
                                type="button" onclick="addnewaccform()">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>{{ $content_lang['new-addacc'] }}
                                </div>
                            </button>

                            <div id="add-accessory">

                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <button
                                    class="ml-4 p-2 bg-blue-500 drop-shadow-lg hover:bg-blue-300 rounded-lg text-white">
                                    {{ $content_lang['edit-editbutton'] }}
                                </button>
                            </div>
                        </form>

                        <h1 class="p-2 my-2 text-xl bg-blue-200 rounded-lg">
                            {{ $content_lang['history-header'] }}</h1>
                        <div class="flex justify-end mt-3 my-2">
                            <div>
                                <a href="{{ route('newcarhistory', ['id' => $car_data->id]) }}"
                                    class="bg-blue-500 text-white drop-shadow-lg p-2 w-full rounded-lg hover:bg-blue-300">
                                    {{ $content_lang['content-header-history'] }}
                                </a>
                            </div>
                        </div>
                        <table class="w-full table mb-2 table-auto border-2 text-center">
                            <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                <tr>
                                    <th>{{ $content_lang['history-date'] }}</th>
                                    <th>{{ $content_lang['history-status'] }}</th>
                                    <th>{{ $content_lang['history-expenses'] }}</th>
                                    <th>{{ $content_lang['history-description'] }}</th>
                                </tr>
                            </thead>
                            <tbody class="border-2">
                                @foreach ($car_logs as $car_log)
                                    <tr class="border-2 hover:bg-gray-300">
                                        <td>{{ $car_log->update_at }}</td>
                                        @foreach ($car_sts as $car_st)
                                            @if($car_log->status == $car_st->keyword)
                                                @if (session()->get('locale') == 'th')
                                                    <td>{{ $car_st->thai }}</td>
                                                @elseif(session()->get('locale') == 'lo')
                                                    <td>{{ $car_st->lao }}</td>
                                                @elseif(session()->get('locale') == 'en')
                                                    <td>{{ $car_st->eng }}</td>
                                                @endif
                                                @break
                                            @endif
                                        @endforeach
                                        <td>{{ $car_log->expenses }}</td>
                                        <td>
                                            @if ($car_log->description != '')
                                                <a href="{{ route('detailcarhistory', ['id' => $car_log->id]) }}">
                                                    <div
                                                        class="p-2 drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer">
                                                        {{ $content_lang['table-detail'] }}
                                                    </div>
                                                </a>
                                            @else
                                                {{ $car_log->description }}
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script>
    var selectedimg = 0;

    function addnewaccform() {
        var div = document.createElement('div');
        div.innerHTML = `<div class="border-2 drop-shadow-sm relative rounded-lg p-3 mb-3">
                                        <div onclick="removeacc(this)" name="removeacc[]" class="mb-2 absolute right-5 rounded-lg text-red-500 cursor-pointer hover:bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <input type="hidden" name="acc_id[]" value="">
                                            <x-label class="mb-1" for="car_acc_type[]"
                                                value="{{ $content_lang['new-acc-type'] }}" />
                                            <select onchange="getValue()"
                                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                name="car_acc_type[]">
                                                <option value="ใบมีด">{{ $content_lang['new-acc-subtype1'] }}</option>
                                                <option value="หางไถ">{{ $content_lang['new-acc-subtype2'] }}</option>
                                                <option value="อื่นๆ">{{ $content_lang['new-acc-subtype3'] }}</option>
                                            </select>
                                            @error('car_acc_type[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div name="div_acc_type[]" class="w-1/2 invisible">
                                            <x-label for="acc_type[]" value="{{ $content_lang['new-acc-type'] }}" />
                                            <x-input id="acc_type[]" class="block mt-1 w-full" type="text"
                                                name="acc_type[]" autofocus autocomplete="acc_type[]" />
                                            @error('acc_type[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <x-label for="acc_brand[]"
                                                value="{{ $content_lang['new-acc-brand'] }}" />
                                            <x-input id="acc_brand[]" class="block mt-1 w-full" type="text"
                                                name="acc_brand[]" required autofocus
                                                autocomplete="acc_brand[]"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-brand'] }}')" />
                                            @error('acc_brand[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="w-1/2">
                                            <x-label for="acc_model[]"
                                                value="{{ $content_lang['new-acc-model'] }}" />
                                            <x-input id="acc_model[]" class="block mt-1 w-full" type="text"
                                                name="acc_model[]" required autofocus
                                                autocomplete="acc_model[]"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-model'] }}')" />
                                            @error('acc_model[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
                                            <x-label for="acc_code[]" value="{{ $content_lang['new-acc-code'] }}" />
                                            <x-input id="acc_code[]" class="block mt-1 w-full" type="text"
                                                name="acc_code[]" required autofocus
                                                autocomplete="acc_code[]"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-code'] }}')" />
                                            @error('acc_code[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="w-1/2">
                                            <x-label for="price[]" value="{{ $content_lang['new-acc-price'] }}" />
                                            <x-input id="price[]" class="block mt-1 w-full" type="number"
                                                name="price[]" required autofocus
                                                onchange="sumprice()" autocomplete="price[]"
                                                oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-acc-price'] }}')" />
                                            @error('price[]')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>`;
        document.getElementById('add-accessory').appendChild(div);
    }

    function getValue() {
        var car_acc_type = document.getElementsByName("car_acc_type[]");
        var acc_type = document.getElementsByName("div_acc_type[]");
        var values = Array.from(car_acc_type).map(el => el.value);
        console.log(values);
        for (let i = 0; i < values.length; i++) {
            if (values[i] == "อื่นๆ") {
                acc_type[i].classList.remove('invisible');
            } else {
                acc_type[i].classList.add('invisible');
            }
        }
    }

    function sumprice() {
        var car_price = document.getElementById("car_price");
        var sum_price = document.getElementById("sum_price");
        var total_acc_price = document.getElementById("total_acc_price");
        var expenses = document.getElementById("car_expenses");
        var acc_price = document.getElementsByName("price[]");
        var sum = 0;
        var total_acc = 0;
        sum = parseInt(car_price.value) + parseInt(expenses.value);
        var acc_price = Array.from(acc_price).map(el => el.value);
        for (let i = 0; i < acc_price.length; i++) {
            if (acc_price[i] > 0) {
                sum += parseInt(acc_price[i]);
                total_acc += parseInt(acc_price[i]);
            }
        }
        sum_price.value = sum;
        total_acc_price.value = total_acc;
    }

    function swicthimage(imgs) {
        // Get the expanded image
        var expandImg = document.getElementById("expandedImg");
        // Get the image text
        var imgText = document.getElementById("imgtext");
        var remove_file = document.getElementById("remove_file");
        // Use the same src in the expanded image as the image being clicked on from the grid
        if (imgs.name.toLowerCase() != 'pdf') {
            expandImg.src = imgs.src;
        }

        selectedimg = imgs.id;
        remove_file.classList.remove("hidden");

        // Use the value of the alt attribute of the clickable image as text inside the expanded image
        imgText.innerHTML = imgs.alt;
        // Show the container element (hidden with CSS)
        expandImg.parentElement.style.display = "block";
    }

    function closeimage(e) {

        var remove_file = document.getElementById("remove_file");
        e.parentElement.style.display = 'none';
        remove_file.classList.add("hidden");
        selectedimg = 0;
    }

    function removeacc(e) {
        e.parentElement.remove();
        sumprice();
    }

    var remove_list = [];

    function confirmSubmit(e, id) {
        Swal.fire({
            text: "{{ $content_lang['del-alert-text'] }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ $content_lang['del-alert-confirm'] }}",
            cancelButtonText: "{{ $content_lang['del-alert-cancel'] }}",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                e.parentElement.remove();
                sumprice();
                remove_list.push(id);
                $('#acc_remove_list').val(remove_list);
            }
        });
    }

    function confirmremovefile(e) {
        var url = "{{ route('removefile_car', ':id') }}".replace(':id', selectedimg);
        Swal.fire({
            text: "{{ $content_lang['del-alert-text-file'] }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ $content_lang['del-alert-confirm'] }}",
            cancelButtonText: "{{ $content_lang['del-alert-cancel'] }}",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed && selectedimg != 0) {
                window.location.href = url;
            }
        });
    }

    function confirmremovepdf(id) {
        console.log(id);
        var url = "{{ route('removefile_car', ':id') }}".replace(':id', id);
        console.log(url);
        Swal.fire({
            text: "{{ $content_lang['del-alert-text-file'] }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ $content_lang['del-alert-confirm'] }}",
            cancelButtonText: "{{ $content_lang['del-alert-cancel'] }}",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed && id) {
                window.location.href = url;
            }
        });
    }
</script>
