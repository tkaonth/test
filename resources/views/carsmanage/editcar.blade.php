@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\carsmanage.php');
    
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
                        <form method="POST" action="{{ route('addnewcar') }}">
                            @csrf
                            <div class="flex w-full justify-between mb-2">
                                <div class="w-1/3 mr-5">
                                    <x-label for="car_model" value="{{ $content_lang['new-carmodel'] }}" />
                                    <x-input id="car_model" class="block mt-1 w-full" type="text" name="car_model"
                                        required autofocus autocomplete="car_model"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-carnumber'] }}')" />
                                    @error('car_model')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3 mr-5">
                                    <x-label for="car_number" value="{{ $content_lang['new-carnumber'] }}" />
                                    <x-input id="car_number" class="block mt-1 w-full" type="text" name="car_number"
                                        required autofocus autocomplete="car_number"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-carnumber'] }}')" />
                                    @error('car_number')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3">
                                    <x-label for="engine_number" value="{{ $content_lang['new-enginenumber'] }}" />
                                    <x-input id="engine_number" class="block mt-1 w-full" type="text"
                                        name="engine_number" required autofocus autocomplete="engine_number"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-enginenumber'] }}')" />
                                    @error('engine_number')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex w-full justify-between mb-2">

                                <div class="w-1/3 mr-5">
                                    <x-label class="mb-1" for="car_st" value="{{ $content_lang['new-car-st'] }}" />
                                    <select
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        name="car_st">
                                        @foreach ($car_sts as $car_st)
                                            <option value="{{ $car_st->name }}">{{ $car_st->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('car_st')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3 mr-5">
                                    <x-label for="car_price" value="{{ $content_lang['new-car-price'] }}" />
                                    <x-input id="car_price" class="block mt-1 w-full" type="number" name="car_price"
                                        required autofocus autocomplete="car_price" onchange="sumprice()"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-car-price'] }}')" />
                                    @error('car_price')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3">
                                    <x-label for="sum_price" value="{{ $content_lang['new-sum-price'] }}" />
                                    <x-input id="sum_price" class="block mt-1 w-full" type="number" name="sum_price"
                                        required autofocus autocomplete="sum_price"
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-sum-price'] }}')" />
                                    @error('sum_price')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>



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
    function addnewaccform() {
        var div = document.createElement('div');
        div.innerHTML = `<div class="border-2 drop-shadow-sm relative rounded-lg p-3 mb-3">
                                        <div onclick="this.parentElement.remove()" name="removeacc[]" class="removeacc absolute right-5 rounded-lg text-red-500 cursor-pointer hover:bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    <div class="flex w-full justify-between mb-2">
                                        <div class="w-1/2 mr-5">
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
        var acc_price = document.getElementsByName("price[]");
        var sum = 0;
        sum = parseInt(car_price.value);
        var acc_price = Array.from(acc_price).map(el => el.value);
        for (let i = 0; i < acc_price.length; i++) {
            if (acc_price[i] > 0) {
                sum += parseInt(acc_price[i]);
            }
        }
        sum_price.value = sum;
    }
</script>
