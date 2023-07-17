@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
    $calender = include base_path('lang\\' . session()->get('locale') . '\calender.php');
    $options = include base_path('lang\\' . session()->get('locale') . '\branchdivision.php');
@endphp
<style>

</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-edit'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-full p-5 border-2 rounded-lg">
                    <div class="w-fit">
                        <a class="flex pl-0 p-2 mb-5" href="{{ URL::previous() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                            </svg>
                            {{ $content_lang['new-back'] }}
                        </a>
                    </div>
                    <div id="printapprovedoc">
                        @if ($message = Session::get('success'))
                            <script>
                                Swal.fire({
                                    text: "{{ $message }}",
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })
                            </script>
                        @endif
                        <form method="POST" id="cusdata" action="{{ route('updatecusdata') }}">
                            @csrf
                            <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">{{ $content_lang['cus-detail'] }}</h1>
                            <div class="pt-1 p-3 flex w-full justify-between">
                                <div class="w-1/4 flex mr-5">

                                    <div class="w-full ">
                                        <x-label for="cus_code" value="{{ $content_lang['new-code'] }}" />
                                        <input type="hidden" name="cus_id" value="{{ $cusdata->id }}">
                                        <x-input id="cus_code" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_code" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-code'] }}')"
                                            value="{{ $cusdata->cus_code }}" />
                                        @error('cus_code')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-3/4 flex">
                                    <div class="w-1/2 mr-5">
                                        <x-label for="cus_name" value="{{ $content_lang['new-name'] }}" />
                                        <x-input id="cus_name" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_name" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-name'] }}')"
                                            value="{{ $cusdata->cus_name }}" />
                                        @error('cus_name')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-label for="cus_idcard" value="{{ $content_lang['new-idcard'] }}" />
                                        <x-input id="cus_idcard" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_idcard" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-idcard'] }}')"
                                            value="{{ $cusdata->cus_idcard }}" />
                                        @error('cus_idcard')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1 p-3 flex w-full justify-between">
                                <div class="w-1/4 flex mr-5">
                                    <div class="w-1/3 mr-5">
                                        <x-label for="cus_age" value="{{ $content_lang['new-age'] }}" />
                                        <x-input id="cus_age" class="block h-8 mt-1 w-full" type="number"
                                            name="cus_age" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-age'] }}')"
                                            value="{{ $cusdata->cus_age }}" />
                                        @error('cus_age')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-2/3">
                                        <x-label for="cus_bd" value="{{ $content_lang['new-bd'] }}" />
                                        <input id="cus_bd" name="cus_bd" type="text"
                                            class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-bd'] }}')"
                                            value="{{ $cusdata->cus_bd }}">
                                        @error('cus_bd')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="cus_tel" value="{{ $content_lang['new-tel'] }}" />
                                    <x-input id="cus_tel" class="block h-8 mt-1 w-full" type="text" name="cus_tel"
                                        required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-tel'] }}')"
                                        value="{{ $cusdata->cus_tel }}" />
                                    @error('cus_tel')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4 flex mr-5">
                                    <div class="w-1/2 mr-5">
                                        <x-label for="cus_address" value="{{ $content_lang['new-address'] }}" />
                                        <x-input id="cus_address" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_address" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-address'] }}')"
                                            value="{{ $cusdata->cus_address }}" />
                                        @error('cus_address')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-label for="cus_group" value="{{ $content_lang['new-group'] }}" />
                                        <x-input id="cus_group" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_group" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-group'] }}')"
                                            value="{{ $cusdata->cus_group }}" />
                                        @error('cus_group')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-1/4">
                                    <x-label for="cus_village" value="{{ $content_lang['new-village'] }}" />
                                    <x-input id="cus_village" class="block h-8 mt-1 w-full" type="text"
                                        name="cus_village" required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-village'] }}')"
                                        value="{{ $cusdata->cus_village }}" />
                                    @error('cus_village')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-1 p-3 flex w-full">
                                <div class="w-1/4 mr-5">
                                    <x-label for="cus_city" value="{{ $content_lang['new-city'] }}" />
                                    <x-input id="cus_city" class="block h-8 mt-1 w-full" type="text"
                                        name="cus_city" required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-city'] }}')"
                                        value="{{ $cusdata->cus_city }}" />
                                    @error('cus_city')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="cus_district" value="{{ $content_lang['new-district'] }}" />
                                    <select id="district"
                                        class="district border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="cus_district" required value="{{ old('district') }}">
                                        {{-- <option value="" selected disabled>{{ $content_lang['req-district'] }}
                                        </option> --}}
                                    </select>
                                    @error('cus_district')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="cus_branch" value="{{ $content_lang['new-branch'] }}" />
                                    <select
                                        class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="cus_branch" value="{{ old('cus_branch') }}">
                                        @foreach ($branchs as $branch)
                                            <option value="{{ $branch->keyword }}" @if ($branch->keyword == $cusdata->cus_branch)
                                                selected
                                            @endif>
                                                @if (session()->get('locale') == 'th')
                                                    {{ $branch->thai }}
                                                @elseif(session()->get('locale') == 'lo')
                                                    {{ $branch->lao }}
                                                @elseif(session()->get('locale') == 'en')
                                                    {{ $branch->eng }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('cus_branch')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="cus_type" value="{{ $content_lang['new-cus-type'] }}" />
                                    <select
                                        class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="cus_type" value="{{ old('cus_type') }}">
                                        <option value="normal" @if($cusdata->cus_type == 'normal') selected @endif>{{ $content_lang['cus-normal'] }}</option>
                                        <option value="kasikam" @if($cusdata->cus_type == 'kasikam') selected @endif>{{ $content_lang['cus-kasikam'] }}</option>
                                    </select>

                                    @error('cus_type')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4 ml-5">
                                    <x-label for="cus_st" value="{{ $content_lang['table-status'] }}" />
                                    <select
                                        class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="cus_st" value="{{ old('cus_st') }}">
                                        @foreach ($cus_sts as $cus_st)
                                            <option value="{{ $cus_st->keyword }}" @if($cus_st->keyword == $cusdata->cus_st)
                                                    selected
                                                @endif>
                                            @if (session()->get('locale') == 'th')
                                                {{ $cus_st->thai }}
                                            @elseif(session()->get('locale') == 'lo')
                                                {{ $cus_st->lao }}
                                            @elseif(session()->get('locale') == 'en')
                                                {{ $cus_st->eng }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('cus_st')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <button class="w-fit mt-5 mb-2 p-2 bg-blue-500 drop-shadow-lg rounded-lg text-white"
                                type="button" onclick="addnewguarantorform()">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>{{ $content_lang['new-addguarantor'] }}
                                </div>
                            </button>
                            <div id="add-guarantor">
                                @if(isset($guarantors))
                                    @foreach ($guarantors as $guarantor)
                                        <div class="rounded-md">
                                            <h1 name="guarantornum[]" class="p-2 my-1 text-xl bg-blue-200 rounded-lg flex items-center">
                                                {{ $content_lang['detail-guarantor'] }} 
                                            </h1>
                                            <div onclick="removeguarantor(this)" id='{{$guarantor->id}}' class="ml-auto flex w-fit justify-end text-end pr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="rounded-lg text-red-500 mb-2 cursor-pointer hover:bg-gray-200 w-7 h-7">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <div class="pt-1 p-3 flex w-full justify-between">
                                            <div class="w-full flex">
                                                <div class="w-1/2 mr-5">
                                                    <x-label for="guarantor_name[]" value="{{ $content_lang['new-name'] }}" />
                                                    <input type="hidden" name="guarantor_id[]" value="{{ $guarantor->id }}">
                                                    <x-input id="guarantor_name[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_name[]"
                                                        required autofocus
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-name'] }}')" value="{{ $guarantor->name }}"/>
                                                    @error('guarantor_name[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="w-1/2">
                                                    <x-label for="guarantor_idcard[]" value="{{ $content_lang['new-idcard'] }}" />
                                                    <x-input id="guarantor_idcard[]" class="block h-8 mt-1 w-full" type="text"
                                                        name="guarantor_idcard[]" required autofocus value="{{ $guarantor->idcard }}"
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-idcard'] }}')" />
                                                    @error('guarantor_idcard[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="pt-1 p-3 flex w-full justify-between">
                                            <div class="w-1/4 flex mr-5">
                                                <div class="w-1/3 mr-5">
                                                    <x-label for="guarantor_age[]" value="{{ $content_lang['new-age'] }}" />
                                                    <x-input id="guarantor_age[]" class="block h-8 mt-1 w-full" type="number" name="guarantor_age[]"
                                                        required autofocus value="{{ $guarantor->age }}"
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-age'] }}')" />
                                                    @error('guarantor_age[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="w-2/3">
                                                    <x-label for="guarantor_bd[]" value="{{ $content_lang['new-bd'] }}" />
                                                    <input id="guarantor_bd[]" name="guarantor_bd[]" type="text"
                                                        class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                        value="{{ $guarantor->bd }}" oninput="convertinsdate(this)"
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-bd'] }}')">
                                                    @error('guarantor_bd[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
            
                                            </div>
                                            <div class="w-1/4 mr-5">
                                                <x-label for="guarantor_tel[]" value="{{ $content_lang['new-tel'] }}" />
                                                <x-input id="guarantor_tel[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_tel[]"
                                                    required autofocus value="{{ $guarantor->tel }}"
                                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-tel'] }}')" />
                                                @error('guarantor_tel[]')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
            
                                            <div class="w-1/4 flex mr-5">
                                                <div class="w-1/2 mr-5">
                                                    <x-label for="guarantor_address[]" value="{{ $content_lang['new-address'] }}" />
                                                    <x-input id="guarantor_address[]" class="block h-8 mt-1 w-full" type="text"
                                                        name="guarantor_address[]" required autofocus value="{{ $guarantor->address }}"
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-address'] }}')" />
                                                    @error('guarantor_address[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                            role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="w-1/2">
                                                    <x-label for="guarantor_group[]" value="{{ $content_lang['new-group'] }}" />
                                                    <x-input id="guarantor_group[]" class="block h-8 mt-1 w-full" type="text"
                                                        name="guarantor_group[]" required autofocus value="{{ $guarantor->group }}"
                                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-group'] }}')" />
                                                    @error('guarantor_group[]')
                                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                            role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
            
                                            <div class="w-1/4">
                                                <x-label for="guarantor_village[]" value="{{ $content_lang['new-village'] }}" />
                                                <x-input id="guarantor_village[]" class="block h-8 mt-1 w-full" type="text"
                                                    name="guarantor_village[]" required autofocus value="{{ $guarantor->village }}"
                                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-village'] }}')" />
                                                @error('guarantor_village[]')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
            
                                            </div>
                                        </div>
            
                                        <div class="pt-1 p-3 flex w-full">
                                            <div class="w-1/4 mr-5">
                                                <x-label for="guarantor_city[]" value="{{ $content_lang['new-city'] }}" />
                                                <x-input id="guarantor_city[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_city[]"
                                                    required autofocus value="{{ $guarantor->city }}"
                                                    oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-city'] }}')" />
                                                @error('guarantor_city[]')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/4 mr-5">
                                                <x-label for="guarantor_district[]" value="{{ $content_lang['new-district'] }}" />
                                                <select id="{{ $guarantor->id }}" class="district border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                                    name="guarantor_district[]" required>
                                                   {{--  <option value="" selected disabled>{{ $content_lang['req-district'] }}</option> --}}
                                                </select>
                                                @error('guarantor_district[]')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            </div>

                            <div>
                                <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">
                                    {{ $content_lang['header-car-detail'] }}
                                </h1>
                                <div class="flex my-3">
                                    <!-- The expanding image container -->
                                    <div class="container">
                                        <!-- Close the image -->
                                        <span onclick="closeimage(this)" id="closeimg"
                                            class="closebtn flex justify-end cursor-pointer invisible">&times;</span>

                                        <!-- Expanded image -->
                                        <img id="expandedImg" style="width:100%">
                                    </div>
                                </div>

                                <div class="w-full flex justify-center">
                                    <div class="relative w-10/12">
                                        <div id="displaycarfile" class="flex w-full overflow-x-scroll">

                                        </div>
                                        <div id="cardetailbutton">

                                        </div>
                                    </div>
                                </div>
                                <div class="flex mb-2">
                                    <div class="w-1/4 mr-5">
                                        <x-label for="car_number" value="{{ $content_lang['car-number'] }}" />
                                        <input type="hidden" name="car_id" id="car_id">
                                        <select
                                            class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                            name="car_number" id="car_number" onchange="showcardetail(this)"
                                            value="{{ old('car_number') }}">
                                            @foreach ($cars as $car)
                                                <option value="{{ $car->id }}" @if($car->id == $cusdata->car_id) selected @endif>{{ $car->car_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('car_number')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4 mr-5">
                                        <x-label for="car-model" value="{{ $content_lang['car-model'] }}" />
                                        <x-input id="car-model" class="block h-8 border-0 mt-1 w-full" type="text"
                                            name="car-model" required autofocus readonly />
                                        @error('car-model')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4 mr-5">
                                        <x-label for="car-enginenumber"
                                            value="{{ $content_lang['car-enginenumber'] }}" />
                                        <x-input id="car-enginenumber" class="block h-8 border-0 mt-1 w-full"
                                            type="text" name="car-enginenumber" required autofocus readonly />
                                        @error('car-enginenumber')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4">
                                        <x-label for="car_st" value="{{ $content_lang['car-st'] }}" />
                                        <x-input id="car_st" class="block h-8 border-0 mt-1 w-full" type="text"
                                            name="car_st" autofocus readonly />    
                                        @error('car_st')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="flex">
                                    <div class="w-1/4 mr-5">
                                        <x-label for="car_price" value="{{ $content_lang['car_price'] }}" />
                                        <x-input id="car_price" class="block h-8 border-0 mt-1 w-full" type="text"
                                            name="car_price" required autofocus readonly />
                                        @error('car_price')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4 mr-5">
                                        <x-label for="total_acc_price"
                                            value="{{ $content_lang['total_acc_price'] }}" />
                                        <x-input id="total_acc_price" class="block h-8 border-0 mt-1 w-full"
                                            type="text" name="total_acc_price" required autofocus readonly />
                                        @error('total_acc_price')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4 mr-5">
                                        <x-label for="total_expenses_price"
                                            value="{{ $content_lang['total_expenses_price'] }}" />
                                        <x-input id="total_expenses_price" class="block h-8 border-0 mt-1 w-full"
                                            type="text" name="total_expenses_price" required autofocus readonly />
                                        @error('total_expenses_price')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/4">
                                        <x-label for="total_price" value="{{ $content_lang['total_price'] }}" />
                                        <x-input id="total_price" class="block h-8 border-0 mt-1 w-full"
                                            type="text" autofocus readonly />
                                        @error('total_price')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div id="displayacc" class="drop-shadow-sm relative rounded-lg p-1 mb-3">
                                    
                                </div>


                            </div>
                            <div>
                                <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">{{ $content_lang['gift-header'] }}
                                </h1>
                                <div class="flex-col justify-center my-2">
                                    <div class="w-10/12 justify-between items-center flex">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="gift[]" value="ปั้มลม"
                                                @foreach ($gifts as $gift)
                                                    @if ($gift->name == 'ปั้มลม')
                                                        checked
                                                        @break
                                                    @endif
                                                @endforeach
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['gift-item1'] }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="gift[]" value="กันชน"
                                                @foreach ($gifts as $gift)
                                                    @if ($gift->name == 'กันชน')
                                                        checked
                                                        @break
                                                    @endif
                                                @endforeach
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['gift-item2'] }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="gift[]" value="เสื้อยืด 2 ตัว"
                                                @foreach ($gifts as $gift)
                                                    @if ($gift->name == 'เสื้อยืด 2 ตัว')
                                                        checked
                                                        @break
                                                    @endif
                                                @endforeach
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['gift-item3'] }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="gift[]" value="กระเป๋า 2 ใบ"
                                                @foreach ($gifts as $gift)
                                                    @if ($gift->name == 'กระเป๋า 2 ใบ')
                                                        checked
                                                        @break
                                                    @endif
                                                @endforeach
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['gift-item4'] }}</span>
                                        </label>
                                        @php
                                            $othergift_name = null;
                                        @endphp
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="gift[]" value="other"
                                                @foreach ($gifts as $gift)
                                                    @if ($gift->name != 'ปั้มลม' && $gift->name != 'กันชน' && $gift->name != 'เสื้อยืด 2 ตัว'  && $gift->name != 'กระเป๋า 2 ใบ')
                                                        checked
                                                        @php
                                                            $othergift_name =  $gift->name;
                                                        @endphp
                                                        @break
                                                    @endif
                                                @endforeach
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500"
                                                onchange="togglegiftother(this)">
                                            <span class="ml-2">{{ $content_lang['gift-other'] }}</span>
                                        </label>
                                        <div id="other-input" class="flex items-center @if(!$othergift_name) invisible @endif">
                                            <label for="other_item"
                                                class="mr-2 ">{{ $content_lang['gift-input'] }}</label>
                                            <x-input id="other_item" class="block p-2 w-full h-full" type="text"
                                                name="other_item" value="{{$othergift_name}}" autofocus />
                                        </div>
                                    </div>
                                    <div class="w-full flex items-center">
                                        <select name="deposit_select" id="deposit_select" onchange="showbilldetail(this)"
                                            class="border h-8 mr-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-2 p-1">
											<option value="0" selected>------------------------------</option>
                                            @foreach ($otherbills as $otherbill)
                                                @if($otherbill->bill_type == 'deposit_bill')
                                                    <option value="{{$otherbill->id}}" @if ($otherbill->cus_id == $cusdata->id) selected @endif>
                                                        {{$otherbill->cus_name.' ['.$otherbill->bill_number.']'}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="w-4/12 flex items-center">
                                            <x-label for="deposit" class="whitespace-nowrap"
                                                value="{{ $content_lang['deposit'] }} {{ $content_lang['number'] }}" />
                                            <x-input id="deposit" class="block ml-1 mr-1 mt-1 h-8 w-full" type="number"
                                                name="deposit" oninput="caltotalpaydeli()" autofocus
                                                value="{{$cusdata->deposit}}" />
                                                <x-label for="deposit" class="whitespace-nowrap"
                                                value="{{ $content_lang['unit'] }}" />
                                            @error('deposit')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-5/12 flex items-center">
                                            <x-label for="deposit_bill_number" class="mx-1 whitespace-nowrap"
                                                value="{{ $content_lang['bill-number'] }} " />
                                            <x-input id="deposit_bill_number" class="block mt-1 h-8 w-full" type="text"
                                                name="deposit_bill_number" autofocus
                                                value="{{$cusdata->bill_num_deposit}}" />
                                            @error('deposit_bill_number')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-3/12 flex items-center">
                                            <x-label for="deposit_date" class="mx-1 whitespace-nowrap" value="{{ $content_lang['date'] }}" />
                                            <input id="deposit_date" name="deposit_date" type="text"
                                                class="block h-8 mr-1 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                value="{{$cusdata->deposit_date}}">
                                            @error('deposit_date')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full flex items-center">
                                        <select name="deli_select" id="deli_select" onchange="showbilldetail(this)"
                                            class="border h-8 mr-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-2 p-1">
											<option value="0" selected>------------------------------</option>
                                            @foreach ($otherbills as $otherbill)
                                                @if($otherbill->bill_type == 'deli_bill')
                                                    <option value="{{$otherbill->id}}" @if ($otherbill->bill_number == $cusdata->bill_num_down_pay_deli) selected @endif>
                                                        {{$otherbill->cus_name.' ['.$otherbill->bill_number.']'}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="w-4/12 flex items-center">
                                            <x-label for="down_pay_deli" class="whitespace-nowrap"
                                                value="{{ $content_lang['table-down'] }} {{ $content_lang['number'] }}" />
                                            <x-input id="down_pay_deli" class="block ml-1 mr-1 mt-1 h-8 w-full" type="number"
                                                name="down_pay_deli" oninput="caltotalpaydeli()" autofocus
                                                value="{{$cusdata->down_pay_deli}}" />
                                                <x-label for="down_pay_deli" class="whitespace-nowrap"
                                                value="{{ $content_lang['unit'] }}" />
                                            @error('down_pay_deli')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                    
                                        <div class="w-5/12 flex items-center">
                                            <x-label for="down_pay_deli_bill_number" class="mx-1 whitespace-nowrap"
                                                value="{{ $content_lang['bill-number'] }} " />
                                            <x-input id="down_pay_deli_bill_number" class="block mt-1 h-8 w-full" type="text"
                                                name="down_pay_deli_bill_number" autofocus
                                                value="{{$cusdata->bill_num_down_pay_deli}}" />
                                            @error('down_pay_deli_bill_number')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-3/12 flex items-center">
                                            <x-label for="down_paydeli_date" class="mx-1 whitespace-nowrap" value="{{ $content_lang['date'] }}" />
                                            <input id="down_paydeli_date" name="down_paydeli_date" type="text"
                                                class="block h-8 mr-1 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                value="{{$cusdata->deli_date}}" oninput="setdelidate(this)">
                                            @error('down_paydeli_date')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    
                                    <div id="add-dowpay" @if (!isset($adddownpays))
                                        class="invisible"
                                    @endif>
                                        @if (isset($adddownpays))
                                            @foreach ($adddownpays as $adddownpay)
                                                <div name="adddownnumber[]" class="flex-col">
                                                    <div  onclick="removeadddown(this)" id='{{$adddownpay->id}}' class="ml-auto flex w-fit justify-end text-end pr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="rounded-lg text-red-500 cursor-pointer hover:bg-gray-200 w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="w-full flex items-center">
                                                        
                                                        <select name="adddownselect[]" id='{{$adddownpay->id}}' onchange="showbilldetail_add(this)"
                                                            class="border h-8 mr-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-2 p-1">
                                                            <option value="0" selected>------------------------------</option>
                                                            @foreach ($otherbills as $otherbill)
                                                                @if($otherbill->bill_type == 'deli_bill')
                                                                    <option value="{{$otherbill->id}}" @if ($otherbill->id == $adddownpay->bill_id)
                                                                        selected
                                                                    @endif>
                                                                        {{$otherbill->cus_name.' ['.$otherbill->bill_number.']'}}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <div class="w-4/12 flex items-center">
                                                            <x-label for="adddown_pay[]" class="whitespace-nowrap"
                                                                value="{{ $content_lang['table-down'] }} {{ $content_lang['number'] }}" />
                                                            <input type="hidden" name="adddownpay_id[]" value="{{ $adddownpay->id }}">
                                                            <x-input id='{{$adddownpay->id}}' class="block ml-1 mr-1 mt-1 h-8 w-full" type="number"
                                                                name="adddown_pay[]" oninput="caltotalpaydeli()" autofocus
                                                                value="{{ $adddownpay->payment }}" />
                                                                <x-label for="adddown_pay[]" class="whitespace-nowrap"
                                                                value="{{ $content_lang['unit'] }}" />
                                                            @error('adddown_pay[]')
                                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                                    role="alert">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                    
                                                        <div class="w-5/12 flex items-center">
                                                            <x-label for="adddown_billnumber[]" class="mx-1 whitespace-nowrap"
                                                                value="{{ $content_lang['bill-number'] }} " />
                                                            <x-input id='{{$adddownpay->id}}' class="block mt-1 h-8 w-full" type="text"
                                                                name="adddown_billnumber[]" autofocus
                                                                value="{{ $adddownpay->bill_number }}" />
                                                            @error('adddown_billnumber[]')
                                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                                    role="alert">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="w-3/12 flex items-center">
                                                            <x-label for="adddown_date[]" class="mx-1 whitespace-nowrap" value="{{ $content_lang['date'] }}" />
                                                            <input id='{{$adddownpay->id}}' name="adddown_date[]" type="text"
                                                                class="block h-8 mr-1 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                                value="{{ $adddownpay->date }}">
                                                            @error('adddown_date[]')
                                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                                    role="alert">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button class="w-fit mt-5 mb-2 p-2 bg-blue-500 drop-shadow-lg rounded-lg text-white"
                                        type="button" onclick="addnewdownform()">
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>{{ $content_lang['adddown'] }}
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">
                                    {{ $content_lang['content-header-ins-detail'] }}
                                </h1>
                                <div class="flex">
                                    <div class="w-1/2 p-4 text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="ins_type[]" @if ($cusdata->ins_LJT == '1')
                                                checked
                                            @endif value="LJT"
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['ins-pay-byLJT'] }}</span>
                                        </label>
                                    </div>
                                    <div class="w-1/2 p-4 text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="ins_type[]" @if ($cusdata->ins_money == '1')
                                            checked
                                            @endif value="Money"
                                                class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                            <span class="ml-2">{{ $content_lang['ins-by-money'] }}</span>
                                        </label>
                                    </div>
                                    @error('ins_type')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="flex">
                                    <div class="w-1/2 p-3">
                                        <div class="w-full flex items-center">
                                            <div class="w-1/4">
                                                <x-label for="promotion" class="mx-1 w-fit"
                                                    value="{{ $content_lang['promotion'] }}" />
                                            </div>
                                            <div class="w-3/4">
                                                <x-input id="promotion" class="block mt-1 h-8 w-full" type="text"
                                                    name="promotion" autofocus value="{{ $cusdata->promotion }}" />
                                                @error('promotion')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="total_price" class="mx-1 w-fit"
                                                    value="{{ $content_lang['total-price'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="total_price_detail" class="block mt-1 h-8 w-full"
                                                    type="number" name="total_price" autofocus required
                                                    value="{{ $cusdata->total_price }}" />
                                                @error('total_price')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="discount" class="mx-1 w-fit"
                                                    value="{{ $content_lang['discount'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="discount" class="block mt-1 h-8 w-full" type="number"
                                                    name="discount" autofocus oninput="discountcal(this)" required
                                                    value="{{ $cusdata->discount }}" />
                                                @error('discount')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="net_price" class="mx-1 w-fit"
                                                    value="{{ $content_lang['net-price'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="net_price" class="block mt-1 h-8 w-full" type="number"
                                                    name="net_price" autofocus value="{{ $cusdata->net_price }}" required />
                                                @error('net_price')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="down_pay" class="mx-1 w-fit"
                                                    value="{{ $content_lang['down-pay'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="down_pay" class="block mt-1 h-8 w-full" type="number"
                                                    name="down_pay" autofocus oninput="calremaining(this)"
                                                    value="{{ $cusdata->down_pay }}" required />
                                                @error('down_pay')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>


                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="total_pay_deli" class="mx-1 w-fit"
                                                    value="{{ $content_lang['total-pay'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="total_pay_deli" class="block mt-1 h-8 w-full"
                                                    type="number" name="total_pay_deli" autofocus
                                                    value="{{ $cusdata->total_pay_deli }}" required />
                                                @error('total_pay_deli')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                            <div class="w-1/12 text-center">
                                                <x-label for="total_pay_deli_date"
                                                    value="{{ $content_lang['date'] }}" />
                                            </div>
                                            <div class="w-3/12">
                                                <input id="total_pay_deli_date" name="total_pay_deli_date"
                                                    type="text"
                                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                    required value="{{ $cusdata->total_pay_deli_date }}">
                                                @error('total_pay_deli_date')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="ins_down_number" class="mx-1 w-fit"
                                                    value="{{ $content_lang['ins_downnum'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="ins_down_number" class="block mt-1 h-8 w-full"
                                                    oninput="createinsdown(this)" type="number"
                                                    name="ins_down_number" value="{{ count($insdowns) }}" autofocus required />
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['onlyins'] }}" />
                                            </div>
                                        </div>
                                        @php
                                            $countinsdown = 0;
                                        @endphp
                                        <div id="display_ins_down">
                                            @if (isset($insdowns))
                                                @foreach ($insdowns as $insdown)
                                                    @php
                                                        $countinsdown++;
                                                    @endphp
                                                    <div class="w-full flex items-center center">
                                                        <div class="w-3/12">
                                                            <x-label for="ins_down_appoint_pay" class="mx-1 w-fit" value="{{ $content_lang['ins-down-pay'].' '.$countinsdown }}">
                                                            </x-label>
                                                        </div>
                                                        <div class=w-4/12>
                                                            <input type="hidden" name="insdown_id[]" value="{{$insdown->id}}">
                                                            <input class="block h-8 mt-1 w-full border-gray-300 rounded-md"
                                                                type="number" id="ins_down_appoint_pay[]" name="ins_down_appoint_pay[]"
                                                                value="{{ $insdown->appoint_pay }}" required>
                                                        </div>
                                                        <div class="w-1/12">
                                                            <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}">
                                                            </x-label>
                                                        </div>
                                                        <div class="w-1/12 text-center">
                                                            <x-label for="ins_down_appoint_pay" class="mx-1 w-fit" value="{{ $content_lang['date'] }}">
                                                            </x-label>
                                                        </div>
                                                        <div class="w-3/12">
                                                            <input type="text" class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                            id="ins_down_appoint_date[]" name="ins_down_appoint_date[]" value="{{ $insdown->appoint_date }}"
                                                            required oninput="convertinsdate(this)">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="remaining" class="mx-1 w-fit"
                                                    value="{{ $content_lang['remaining'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="remaining" class="block mt-1 h-8 w-full" type="number"
                                                    name="remaining" autofocus value="{{ $cusdata->remaining }}" required />
                                                @error('remaining')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="interest_rate" class="mx-1 w-fit"
                                                    value="{{ $content_lang['interest-rate'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="interest_rate" class="block mt-1 h-8 w-full"
                                                    type="text" name="interest_rate" autofocus required
                                                    value="{{ $cusdata->interest_rate }}" />
                                                @error('interest_rate')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-2/12 text-right">
                                                <x-label class="mx-1 w-fit"
                                                    value="{{ $content_lang['per-month'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="ins_style" class="mx-1 w-fit"
                                                    value="{{ $content_lang['ins-type'] }}" />
                                            </div>
                                            <div class="w-2/12">
                                                <x-input id="ins_style" class="block mt-1 h-8 w-full" type="text"
                                                    name="ins_style" autofocus value="{{ $cusdata->ins_style }}" required />
                                                @error('ins_style')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="ml-1 w-2/12">
                                                <select name="ins_style_type" id="ins_style_type"
                                                    class="border mt-1 border-gray-300 h-8 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                                                    <option value="month" @if ($cusdata->ins_style_type == 'month')
                                                        selected
                                                    @endif>{{ $content_lang['month'] }}</option>
                                                    <option value="year" @if ($cusdata->ins_style_type == 'year')
                                                        selected
                                                    @endif>{{ $content_lang['year'] }}</option>
                                                </select>
                                            </div>
                                            <div class="w-3/12 flex items-center">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['long'] }}" />
                                                <x-input id="ins_long" class="block mt-1 h-8 w-full" type="number"
                                                    name="ins_long" required autofocus
                                                    value="{{ $cusdata->ins_long }}" required />
                                                @error('ins_long')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="ml-1 w-2/12">
                                                <select name="ins_long_type" id="ins_long_type"
                                                    class="border mt-1 border-gray-300 h-8 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1">
                                                    <option value="month" @if ($cusdata->ins_long_type == 'month')
                                                        selected
                                                    @endif>{{ $content_lang['month'] }}</option>
                                                    <option value="year" @if ($cusdata->ins_long_type == 'year')
                                                        selected
                                                    @endif>{{ $content_lang['year'] }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                            $start_ins = $inss[0]['appoint_date'];
                                            $divid_ins_small = $inss[0]['appoint_pay'];
                                            $divid_ins_large = 0;
                                            $principleperins = $inss[0]['principle'];
                                            $interestperins = 0;
                                            for ($i=0; $i < count($inss); $i++) { 
                                                $interestperins = $inss[$i]['interest'];
                                                if($divid_ins_small == $inss[$i]['appoint_pay']){
                                                    $divid_ins_small = $inss[$i]['appoint_pay'];

                                                }else{
                                                    $divid_ins_large = $inss[$i]['appoint_pay'];
                                                    $principleperins = $inss[$i]['principle'];
                                                    break;
                                                }
                                            } 
                                        @endphp
                                        <div class="w-full flex items-center">
                                            <div class="w-fit mr-1">
                                                <x-label for="total_ins" class="ml-1 w-fit"
                                                    value="{{ $content_lang['total-ins'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="total_ins" class="block mt-1 h-8 w-full" type="number"
                                                    name="total_ins" autofocus oninput="calinsper(this)" required
                                                    value="{{ count($inss) }}" />
                                                @error('total_ins')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-2/12 text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['ins'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-fit/12">
                                                <x-label for="divid_ins_small" class="ml-1 w-fit"
                                                    value="{{ $content_lang['divid-ins-small'] }}" />
                                            </div>
                                            <div class="w-4/12 ml-1">
                                                <x-input id="divid_ins_small" class="block mt-1 h-8 w-full"
                                                    type="number" name="divid_ins_small" autofocus required
                                                    oninput="change_ins_pay()"
                                                    value="{{ $divid_ins_small }}" />
                                                @error('divid_ins_small')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-fit text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>

                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-fit">
                                                <x-label for="divid_ins_large" class="ml-1 w-fit"
                                                    value="{{ $content_lang['divid-ins-large'] }}" />
                                            </div>
                                            <div class="w-4/12 ml-1">
                                                <x-input id="divid_ins_large" class="block mt-1 h-8 w-full"
                                                    type="number" name="divid_ins_large" autofocus
                                                    oninput="change_ins_pay()"
                                                    value="{{ $divid_ins_large }}" />
                                                @error('divid_ins_large')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-fit text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-fit">
                                                <x-label for="divid_ins_large" class="ml-1 w-fit"
                                                    value="{{ $content_lang['principle'] }}" />
                                            </div>
                                            <div class="w-3/12 ml-1">
                                                <x-input type="number" id="principleperins" name="principleperins"
                                                class="block mt-1 h-8 w-full" oninput="change_ins_pay()" value="{{ $principleperins }}" />
                                            </div>
                                            <div class="w-fit text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                            <div class="w-fit">
                                                <x-label for="divid_ins_large" class="ml-1 w-fit"
                                                    value="{{ $content_lang['interest'] }}" />
                                            </div>
                                            <div class="w-3/12 ml-1">
                                                <x-input type="number" id="interestperins" name="interestperins"
                                                    class="block mt-1 h-8 w-full" oninput="change_ins_pay()" value="{{ $interestperins }}" />
                                            </div>
                                            <div class="w-fit text-right">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['unit'] }}" />
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="note" class="ml-1 w-fit"
                                                    value="{{ $content_lang['other'] }}" />
                                            </div>
                                            <div class="w-9/12">
                                                <x-input id="note" class="block mt-1 h-8 w-full" type="text"
                                                    name="note" autofocus value="{{ $cusdata->note }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-1/2 p-3">
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="deli_date" class="ml-5 w-fit"
                                                    value="{{ $content_lang['deli-date'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <input id="deli_date" name="deli_date" type="text" required
                                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                    value="{{ $cusdata->deli_date }}">
                                                @error('deli_date')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-2/12">
                                                <x-label class="ml-5 w-fit" value="{{ $content_lang['stock'] }}" />
                                            </div>
                                            <div class="w-3/12">
                                                <select name="stock" id="stock" required
                                                    class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1">
                                                    <option value="" selected disabled>------------------------------</option>
                                                    <option value="AD" @if($cusdata->stock == "AD") selected @endif>AD</option>
                                                    <option value="KM" @if($cusdata->stock == "KM") selected @endif>KM</option>
                                                    <option value="BK" @if($cusdata->stock == "BK") selected @endif>BK</option>
                                                    <option value="PL" @if($cusdata->stock == "PL") selected @endif>PL</option>
                                                    <option value="SHOP" @if($cusdata->stock == "SHOP") selected @endif>ร้านเหล็ก</option>
                                                </select>
                                                @error('stock')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="start_ins" class="ml-5 w-fit"
                                                    value="{{ $content_lang['start-ins'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <input id="start_ins" name="start_ins" type="text" required
                                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                    value="{{ $start_ins }}">
                                                @error('start_ins')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div id="display_ins">
                                            @if(isset($inss))
                                                @php
                                                    $count_ins = 0;
                                                @endphp
                                                @foreach ($inss as $ins)
                                                    @php
                                                        $count_ins++;
                                                    @endphp
                                                    <div class="w-full flex items-center center">
                                                        <div class="flex justify-center w-3/12 mr-1">
                                                            <x-label for="ins_appoint_date[]" class="ml-1 w-fit text-sm" id="ins_num[]" 
                                                            value="{{ $content_lang['ins-num'].' '.$count_ins.' '.$content_lang['date']}}"></x-label>
                                                        </div>
                                                        <div class="w-4/12">
                                                            <input type="hidden" name="ins_id[]" value="{{ $ins->id }}">
                                                            <input type="text" class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker ins_date" required
                                                            name="ins_appoint_date[]" id="{{ 'ins_appoint_date'.($count_ins-1) }}" value="{{ $ins->appoint_date }}">
                                                        </div>
                                                        <div class="w-2/12 flex items-center justify-center mr-1">
                                                            <x-label for="ins_appoint_pay[]" class="ml-1 w-fit text-sm" 
                                                            value="{{ $content_lang['number'] }}"></x-label>
                                                        </div>
                                                        <div class="w-4/12">
                                                            <input type="number" class="block h-8 mt-1 w-full border-gray-300 rounded-md" id="ins_appoint_pay[]"
                                                            name="ins_appoint_pay[]" required value="{{ $ins->appoint_pay }}">
                                                            <input type="hidden" name="principle[]" value="{{ $ins->principle }}">
                                                            <input type="hidden" name="interest[]" value="{{ $ins->interest }}">
                                                        </div>
                                                        <div class="w-1/12 flex justify-end">
                                                            <x-label class="ml-1 w-fit text-sm" 
                                                            value="{{ $content_lang['unit'] }}"></x-label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="flex justify-center my-2">
                                    <div class="w-11/12 items-center flex">
                                        <div class="w-2/12">
                                            <label class="inline-flex items-center">
                                                <input type="radio" @if (!isset($boker)) checked  @endif  name="boker" value="ไม่มีนายหน้า"
                                                    class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500"
                                                    onchange="toggleboker(this)">
                                                <span class="ml-2">{{ $content_lang['no-boker'] }}</span>
                                            </label>
                                        </div>
                                        <div class="w-2/12">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="boker" value="มีนายหน้า" @if (isset($boker)) checked  @endif
                                                    class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500"
                                                    onchange="toggleboker(this)">
                                                <span class="ml-2">{{ $content_lang['boker'] }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="boker-form">
                                    @if (isset($boker))
                                        <div class="w-full flex justify-center items-center mb-1">
                                            <div class="w-2/4 mr-3">
                                                <x-label for="boker_name" value="{{ $content_lang['new-name'] }}" />
                                                <input type="hidden" name="boker_id" value="{{ $boker->id }}">
                                                <x-input id="boker_name" name="boker_name" class="block h-8 mt-1 w-full"
                                                    type="text" autofocus value="{{ $boker->name }}" />
                                                @error('boker_name')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/4 relative mr-3">
                                                <x-label for="boker_money"
                                                    value="{{ $content_lang['number-money'] }}" />
                                                <x-input id="boker_money" name="boker_money"
                                                    class="block h-8 mt-1 w-full" type="text" autofocus value="{{ $boker->boker_money }}"/>
                                                <label
                                                    class="absolute top-1/2 right-2">{{ $content_lang['unit'] }}</label>
                                                @error('boker_money')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/4 mr-3">
                                                <x-label for="boker_tel" value="{{ $content_lang['new-tel'] }}" />
                                                <x-input id="boker_tel" name="boker_tel" value="{{ $boker->tel }}" class="block h-8 mt-1 w-full"
                                                    type="text" autofocus />
                                                @error('boker_tel')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="w-full flex justify-center items-center">
                                            <div class="w-1/12 mr-3">
                                                <x-label for="boker_address"
                                                    value="{{ $content_lang['new-address'] }}" />
                                                <x-input id="boker_address" name="boker_address" value="{{ $boker->address }}"
                                                    class="block h-8 mt-1 w-full" type="text" autofocus />
                                                @error('boker_address')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-1/12 mr-3">
                                                <x-label for="boker_group" value="{{ $content_lang['new-group'] }}" />
                                                <x-input id="boker_group" name="boker_group" value="{{ $boker->group }}"
                                                    class="block h-8 mt-1 w-full" type="text" autofocus />
                                                @error('boker_group')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-2/12 mr-3">
                                                <x-label for="boker_village"
                                                    value="{{ $content_lang['new-village'] }}" />
                                                <x-input id="boker_village" name="boker_village" value="{{ $boker->village }}"
                                                    class="block h-8 mt-1 w-full" type="text" autofocus />
                                                @error('boker_village')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-4/12 mr-3">
                                                <x-label for="boker_city" value="{{ $content_lang['new-city'] }}" />
                                                <x-input id="boker_city" name="boker_city" class="block h-8 mt-1 w-full"
                                                    value="{{ $boker->city }}" type="text" autofocus />
                                                @error('boker_city')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="w-4/12 mr-3">
                                                <x-label for="boker_district"
                                                    value="{{ $content_lang['new-district'] }}" />
                                                <select id="boker_district"
                                                    class="district border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                                    name="boker_district" required>
                                                        {{ $content_lang['req-district'] }}</option>
                                                </select>
                                                @error('boker_district')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    

                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="button" onclick="printdoc()"
                                    class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{$content_lang['print-button']}}</button>
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
<script>
    var count_guarantor = 0;
    var count_adddown = 0;
    var remove_insdown = null;
    var remove_ins = null;
    var calender = JSON.parse('<?php echo $calender; ?>');
    var diffdown = 0;
    $(function() {
        const element = document.querySelectorAll('.datepicker-dropdown');
        var datepickerOptions = {
            allowInput: true,
            // Configuration options
            dateFormat: "d/m/Y",
            // Add more options as needed
            locale: calender
        };
        var datepickerInputs = document.getElementsByClassName("datepicker");
        for (var i = 0; i < datepickerInputs.length; i++) {
            var input = datepickerInputs[i];

            // Create datepicker instance for each input
            flatpickr(input, datepickerOptions);
        }

        for (let i = 0; i < element.length; i++) {
            const childElements = element[i].querySelectorAll('*');
            childElements.forEach(child => {
                child.classList.forEach(className => {
                    child.classList.add('my-datepick');
                    if (className.startsWith('dark')) {
                        child.classList.remove(className);
                    }
                });
            });
        }
    });
    $(document).ready(function() {
        let car_number = document.getElementById('car_number');
        let deposit_select = document.getElementById('deposit_select');
        let deli_select = document.getElementById('deli_select');
        let adddownselect = document.querySelectorAll('select[name="adddownselect[]"]');
        let down_pay = document.getElementById('down_pay');
        showcardetail(car_number);
        if(deposit_select.value > 0){
            showbilldetail(deposit_select);
        }
        if(deli_select.value > 0){
            showbilldetail(deli_select);
        }
        if(down_pay.value > 0){
            calremaining(down_pay);
        }
        for (let i = 0; i < adddownselect.length; i++) {
            if(adddownselect[i].value > 0){
                showbilldetail_add(adddownselect[i]);
            }
        }
        
        $('.my-datepick').click(function() {
            const element = document.querySelectorAll('.datepicker-dropdown');
            for (let i = 0; i < element.length; i++) {
                const childElements = element[i].querySelectorAll('*');
                childElements.forEach(child => {
                    child.classList.forEach(className => {
                        if (className.startsWith('dark')) {
                            child.classList.remove(className);
                        }
                    });
                });
            }
        });
        createoptiondivision();
    });

    function addnewguarantorform() {
        var div_guarantor = document.getElementById('add-guarantor');
        div_guarantor.classList.remove('invisible');
        count_guarantor++;
        var div = document.createElement('div');
        div.innerHTML = `<div class="rounded-md">
                                <h1 name="guarantornum[]" class="p-2 my-1 text-xl bg-blue-200 rounded-lg flex items-center">
                                    {{ $content_lang['detail-guarantor'] }} 
                                </h1>
                                <div onclick="removeguarantor(this)" class="ml-auto flex w-fit justify-end text-end pr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="rounded-lg text-red-500 mb-2 cursor-pointer hover:bg-gray-200 w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="pt-1 p-3 flex w-full justify-between">
                                <div class="w-full flex">
                                    <div class="w-1/2 mr-5">
                                        <x-label for="guarantor_name[]" value="{{ $content_lang['new-name'] }}" />
                                        <input type="hidden" name="guarantor_id[]" value="null">
                                        <x-input id="guarantor_name[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_name[]"
                                            required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-name'] }}')" value="{{ old('start_ins') }}"/>
                                        @error('guarantor_name[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-label for="guarantor_idcard[]" value="{{ $content_lang['new-idcard'] }}" />
                                        <x-input id="guarantor_idcard[]" class="block h-8 mt-1 w-full" type="text"
                                            name="guarantor_idcard[]" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-idcard'] }}')" />
                                        @error('guarantor_idcard[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1 p-3 flex w-full justify-between">
                                <div class="w-1/4 flex mr-5">
                                    <div class="w-1/3 mr-5">
                                        <x-label for="guarantor_age[]" value="{{ $content_lang['new-age'] }}" />
                                        <x-input id="guarantor_age[]" class="block h-8 mt-1 w-full" type="number" name="guarantor_age[]"
                                            required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-age'] }}')" />
                                        @error('guarantor_age[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-2/3">
                                        <x-label for="guarantor_bd[]" value="{{ $content_lang['new-bd'] }}" />
                                        <input id="guarantor_bd[]" name="guarantor_bd[]" type="text"
                                            class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-bd'] }}')">
                                        @error('guarantor_bd[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="guarantor_tel[]" value="{{ $content_lang['new-tel'] }}" />
                                    <x-input id="guarantor_tel[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_tel[]"
                                        required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-tel'] }}')" />
                                    @error('guarantor_tel[]')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/4 flex mr-5">
                                    <div class="w-1/2 mr-5">
                                        <x-label for="guarantor_address[]" value="{{ $content_lang['new-address'] }}" />
                                        <x-input id="guarantor_address[]" class="block h-8 mt-1 w-full" type="text"
                                            name="guarantor_address[]" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-address'] }}')" />
                                        @error('guarantor_address[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="w-1/2">
                                        <x-label for="guarantor_group[]" value="{{ $content_lang['new-group'] }}" />
                                        <x-input id="guarantor_group[]" class="block h-8 mt-1 w-full" type="text"
                                            name="guarantor_group[]" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-group'] }}')" />
                                        @error('guarantor_group[]')
                                            <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-1/4">
                                    <x-label for="guarantor_village[]" value="{{ $content_lang['new-village'] }}" />
                                    <x-input id="guarantor_village[]" class="block h-8 mt-1 w-full" type="text"
                                        name="guarantor_village[]" required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-village'] }}')" />
                                    @error('guarantor_village[]')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="pt-1 p-3 flex w-full">
                                <div class="w-1/4 mr-5">
                                    <x-label for="guarantor_city[]" value="{{ $content_lang['new-city'] }}" />
                                    <x-input id="guarantor_city[]" class="block h-8 mt-1 w-full" type="text" name="guarantor_city[]"
                                        required autofocus
                                        oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-city'] }}')" />
                                    @error('guarantor_city[]')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4 mr-5">
                                    <x-label for="guarantor_district[]" value="{{ $content_lang['new-district'] }}" />
                                    <select id="guarantor_district[]" class="district border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="guarantor_district[]" required>


                                    </select>
                                    @error('guarantor_district[]')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>`;
        div_guarantor.appendChild(div);
        createoptiondivision();
        var datepickerOptions = {
            allowInput: true,
            // Configuration options
            dateFormat: "d/m/Y",
            // Add more options as needed
            locale: calender
        };
        var datepickerInputs = document.getElementsByClassName("datepicker");
        for (var i = 0; i < datepickerInputs.length; i++) {
            var input = datepickerInputs[i];

            // Create datepicker instance for each input
            flatpickr(input, datepickerOptions);
        }
    }

    function addnewdownform() {
        var div_guarantor = document.getElementById('add-dowpay');
        div_guarantor.classList.remove('invisible');
        count_adddown++;
        var div = document.createElement('div');
        div.innerHTML = `<div name="adddownnumber[]" class="flex-col">
                            <div  onclick="removeadddown(this)" class="removeacc flex justify-end text-end pr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="rounded-lg text-red-500 cursor-pointer hover:bg-gray-200 w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="w-full flex items-center">
                                            
                                <select name="adddownselect[]" onchange="showbilldetail_add(this)" id='add_down`+count_adddown+`'
                                        class="border h-8 mr-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-2 p-1">
                                    <option disabled selected value="null">----------------------------</option>
                                    @foreach ($otherbills as $otherbill)
                                        @if($otherbill->bill_type == 'deli_bill')
                                            <option value="{{$otherbill->id}}">{{$otherbill->cus_name.' ['.$otherbill->bill_number.']'}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="w-4/12 flex items-center">
                                    <x-label for="adddown_pay[]" class="whitespace-nowrap"
                                        value="{{ $content_lang['table-down'] }} {{ $content_lang['number'] }}" />
                                    <x-input id='add_down`+count_adddown+`' class="block ml-1 mr-1 mt-1 h-8 w-full" type="number"
                                        name="adddown_pay[]" oninput="caltotalpaydeli()" autofocus value="{{ old('adddown_pay[]') }}" />
                                    <x-label for="adddown_pay[]" class="whitespace-nowrap" value="{{ $content_lang['unit'] }}" />
                                </div>
                        
                                <div class="w-5/12 flex items-center">
                                    <x-label for="adddown_billnumber[]" class="mx-1 whitespace-nowrap" value="{{ $content_lang['bill-number'] }} " />
                                    <x-input id='add_down`+count_adddown+`' class="block mt-1 h-8 w-full" type="text"
                                        name="adddown_billnumber[]" autofocus value="{{ old('adddown_billnumber[]') }}" />
                                </div>
                                <div class="w-3/12 flex items-center">
                                    <x-label for="adddown_date[]" class="mx-1 whitespace-nowrap" value="{{ $content_lang['date'] }}" />
                                        <input id='add_down`+count_adddown+`' name="adddown_date[]" type="text"
                                            class="block h-8 mr-1 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input" value="{{ old('adddown_date[]') }}">
                                </div>
                            </div>
                        </div>`;
        div_guarantor.appendChild(div);
        createoptiondivision();
        var datepickerOptions = {
            allowInput: true,
            // Configuration options
            dateFormat: "d/m/Y",
            // Add more options as needed
            locale: calender
        };
        var datepickerInputs = document.getElementsByClassName("datepicker");
        for (var i = 0; i < datepickerInputs.length; i++) {
            var input = datepickerInputs[i];

            // Create datepicker instance for each input
            flatpickr(input, datepickerOptions);
        }
    }

    function showcardetail(e) {
        var displaycarfile = document.getElementById('displaycarfile');
        var div = document.createElement('div');
        let input_carid = document.getElementById('car_id');
        let input_carmodel = document.getElementById('car-model');
        let input_carengine = document.getElementById('car-enginenumber');
        let input_carst = document.getElementById('car_st');
        let input_carprice = document.getElementById('car_price');
        let input_totalacc = document.getElementById('total_acc_price');
        let input_totalexpenses = document.getElementById('total_expenses_price');
        let input_totalprice = document.querySelectorAll('input[id="total_price"]');
        let total_price_detail = document.getElementById('total_price_detail');
        let input_netprice = document.getElementById('net_price');
        let displayacc = document.getElementById('displayacc');
        let cardetailbutton = document.getElementById('cardetailbutton');
        // Remove all child elements
        while (displaycarfile.firstChild) {
            displaycarfile.removeChild(displaycarfile.firstChild);
        }
        while (displayacc.firstChild) {
            displayacc.removeChild(displayacc.firstChild);
        }
        while (cardetailbutton.firstChild) {
            cardetailbutton.removeChild(cardetailbutton.firstChild);
        }
        $.ajax({
            url: "{{ route('detailcardata', ':id') }}".replace(':id', e.value),
            type: "GET",
            success: function(data) {
                if (data.car_data.id) {
                    input_carid.value = data.car_data.id;
                    const link_cardetail = document.createElement('a');
                    link_cardetail.href = "{{ route('detailcar', ':id') }}".replace(':id', data.car_data
                        .id);
                    link_cardetail.target = "_blank"
                    const link_cardetaildiv = document.createElement('div');
                    link_cardetaildiv.className =
                        'bg-blue-500 rounded-lg drop-shadow-lg text-center text-white p-2 my-2 cursor-pointer hover:bg-blue-300';
                    link_cardetaildiv.innerHTML = '{{ $content_lang['view_car_detail'] }}';

                    cardetailbutton.appendChild(link_cardetail);
                    link_cardetail.appendChild(link_cardetaildiv);
                }
                if (data.car_file.length > 0) {
                    for (let i = 0; i < data.car_file.length; i++) {
                        let file_path = data.car_file[i].file_path;
                        let file_name = data.car_file[i].file_name;
                        const extension = data.car_file[i].file_name.split(".").pop();

                        // Create a div element
                        const divElement = document.createElement('div');
                        divElement.className = 'w-1/5 flex-shrink-0 mr-4';

                        // Create an image element
                        const imgElement = document.createElement('img');
                        imgElement.alt = data.car_file[i].file_name;
                        imgElement.className = 'cursor-pointer';
                        imgElement.style.width = '150px';
                        imgElement.style.height = '100px';

                        if (extension === 'pdf') {
                            // Create a relative div container
                            const relativeDiv = document.createElement('div');
                            relativeDiv.className = 'relative';

                            // Create an image element for PDF icon
                            const pdfIcon = document.createElement('img');
                            pdfIcon.src = "{{ asset('/getuploadicon/document_icon.png') }}";
                            pdfIcon.alt = data.car_file[i].file_name;
                            pdfIcon.style.width = '150px';
                            pdfIcon.style.height = '100px';

                            // Create an absolute div for hover content
                            const absoluteDiv = document.createElement('div');
                            absoluteDiv.className =
                                'absolute inset-0 flex-row justify-center text-center opacity-0 hover:opacity-100 transition duration-300';

                            // Create a link element to open PDF in a new tab
                            const linkElement = document.createElement('a');
                            linkElement.href =
                                "{{ asset('/getcarfile/') }}/" + file_path + "/" + file_name;
                            linkElement.target = '_blank';

                            const viewpdfbutton = document.createElement('div');
                            viewpdfbutton.className =
                                "bg-blue-500 text-white py-2 px-2 rounded mt-2 mb-1 hover:bg-blue-300";
                            viewpdfbutton.innerHTML = '{{ $content_lang['view-button'] }}';

                            // Append the elements to their respective parent elements
                            absoluteDiv.appendChild(linkElement);
                            linkElement.appendChild(viewpdfbutton);
                            relativeDiv.appendChild(pdfIcon);
                            relativeDiv.appendChild(absoluteDiv);
                            divElement.appendChild(relativeDiv);
                        } else {
                            imgElement.src =
                                "{{ asset('/getcarfile/') }}/" + file_path + "/" + file_name;
                            imgElement.onclick = function() {
                                swicthimage(this);
                            };
                            imgElement.name = extension
                            divElement.appendChild(imgElement);
                        }

                        // Append the div element to the container
                        const container = document.getElementById('displaycarfile');
                        container.appendChild(divElement);

                    }
                }
                input_carmodel.value = data.car_data.car_model;
                input_carengine.value = data.car_data.engine_number;
                
                let sessionlang = '{!!session()->get('locale') !!}';
                if(sessionlang == 'th'){
                    input_carst.value = data.car_st.thai;
                }else if(sessionlang == 'la'){
                    input_carst.value = data.car_st.lao;
                }else if(sessionlang == 'en'){
                    input_carst.value = data.car_st.eng;
                }
                input_carprice.value = data.car_data.car_price;
                input_totalacc.value = data.car_data.total_acc_price;
                input_totalexpenses.value = data.car_data.car_expenses;
                input_totalprice.forEach(function(input) {
                    input.value = data.car_data.sum_price;
                    total_price_detail.value = data.car_data.sum_price;
                });
                input_netprice.value = data.car_data.sum_price;
                for (let i = 0; i < data.car_acc_data.length; i++) {
                    if (data.car_acc_data.length > 0) {

                        const main_acc = document.createElement('div');
                        main_acc.className = 'border-2 rounded-lg mb-2 p-3';
                        const maindiv1 = document.createElement('div');
                        maindiv1.className = 'flex w-full justify-between mb-2';
                        const div2_acc_type = document.createElement('div');
                        div2_acc_type.className = 'w-1/2 mr-5';
                        const label_acc_type = document.createElement('label');
                        label_acc_type.className = "block font-medium text-sm text-gray-700 mb-1";
                        label_acc_type.setAttribute('for', 'car_acc_type[]');
                        label_acc_type.textContent = '{{ $content_lang['acc_type'] }}';
                        const input_acc_type = document.createElement('input');
                        input_acc_type.className =
                            "border-gray-300 h-8 border-0 text-gray-900 text-sm rounded-lg focus:border-0 w-full p-2";
                        input_acc_type.name = "car_acc_type[]";
                        input_acc_type.setAttribute('readonly', true);
                        input_acc_type.setAttribute('value', data.car_acc_data[i].car_acc_type);
                        displayacc.appendChild(main_acc);
                        main_acc.appendChild(maindiv1);
                        maindiv1.appendChild(div2_acc_type);
                        div2_acc_type.appendChild(label_acc_type);
                        div2_acc_type.appendChild(input_acc_type);

                        const div_acc_brand = document.createElement('div');
                        div_acc_brand.className = 'w-1/2 mr-5';
                        const label_acc_brand = document.createElement('label');
                        label_acc_brand.className = "block font-medium text-sm text-gray-700 mb-1";
                        label_acc_brand.setAttribute('for', 'acc_brand[]');
                        label_acc_brand.textContent = '{{ $content_lang['acc_brand'] }}';
                        const input_acc_brand = document.createElement('input');
                        input_acc_brand.className =
                            "border-gray-300 h-8 border-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2";
                        input_acc_brand.name = "acc_brand[]";
                        input_acc_brand.setAttribute('readonly', true);
                        input_acc_brand.setAttribute('value', data.car_acc_data[i].acc_brand);
                        main_acc.appendChild(maindiv1);
                        maindiv1.appendChild(div_acc_brand);
                        div_acc_brand.appendChild(label_acc_brand);
                        div_acc_brand.appendChild(input_acc_brand);

                        const maindiv2 = document.createElement('div');
                        maindiv2.className = 'flex w-full justify-between mb-2';
                        const div_acc_model = document.createElement('div');
                        div_acc_model.className = 'w-1/3 mr-5';
                        const label_acc_model = document.createElement('label');
                        label_acc_model.className = "block font-medium text-sm text-gray-700 mb-1";
                        label_acc_model.setAttribute('for', 'acc_model[]');
                        label_acc_model.textContent = '{{ $content_lang['acc_model'] }}';
                        const input_acc_model = document.createElement('input');
                        input_acc_model.className =
                            "border-gray-300 h-8 border-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2";
                        input_acc_model.name = "acc_model[]";
                        input_acc_model.setAttribute('readonly', true);
                        input_acc_model.setAttribute('value', data.car_acc_data[i].acc_model);
                        main_acc.appendChild(maindiv2);
                        maindiv2.appendChild(div_acc_model);
                        div_acc_model.appendChild(label_acc_model);
                        div_acc_model.appendChild(input_acc_model);

                        const div_acc_code = document.createElement('div');
                        div_acc_code.className = 'w-1/3 mr-5';
                        const label_acc_code = document.createElement('label');
                        label_acc_code.className = "block font-medium text-sm text-gray-700 mb-1";
                        label_acc_code.setAttribute('for', 'acc_code[]');
                        label_acc_code.textContent = '{{ $content_lang['acc_code'] }}';
                        const input_acc_code = document.createElement('input');
                        input_acc_code.className =
                            "border-gray-300 h-8 border-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2";
                        input_acc_code.name = "acc_code[]";
                        input_acc_code.setAttribute('readonly', true);
                        input_acc_code.setAttribute('value', data.car_acc_data[i].acc_code);
                        maindiv2.appendChild(div_acc_code);
                        div_acc_code.appendChild(label_acc_code);
                        div_acc_code.appendChild(input_acc_code);

                        const div_acc_price = document.createElement('div');
                        div_acc_price.className = 'w-1/3 mr-5';
                        const label_acc_price = document.createElement('label');
                        label_acc_price.className = "block font-medium text-sm text-gray-700 mb-1";
                        label_acc_price.setAttribute('for', 'acc_price[]');
                        label_acc_price.textContent = '{{ $content_lang['acc_price'] }}';
                        const input_acc_price = document.createElement('input');
                        input_acc_price.className =
                            "border-gray-300 h-8 border-0 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2";
                        input_acc_price.name = "acc_price[]";
                        input_acc_price.setAttribute('readonly', true);
                        input_acc_price.setAttribute('value', data.car_acc_data[i].acc_price);
                        maindiv2.appendChild(div_acc_price);
                        div_acc_price.appendChild(label_acc_price);
                        div_acc_price.appendChild(input_acc_price);


                    }
                }

            }
        });
    }

    function showbilldetail(e) {
        let deposit = document.getElementById('deposit');
        let deposit_bill_number = document.getElementById('deposit_bill_number');
        let deposit_date = document.getElementById('deposit_date');
        let deli = document.getElementById('down_pay_deli');
        let deli_bill_number = document.getElementById('down_pay_deli_bill_number');
        let deli_date = document.getElementById('down_paydeli_date');
        $.ajax({
            url: "{{ route('getbilldata', ':id') }}".replace(':id', e.value),
            type: "GET",
            success: function(data) {
                if(data.billdetail.bill_type == 'deposit_bill'){
                    deposit.value = data.billdetail.payment;
                    deposit_bill_number.value = data.billdetail.bill_number ;
                    deposit_date.value = data.billdetail.bill_date;
                }else if(data.billdetail.bill_type == 'deli_bill'){
                    deli.value = data.billdetail.payment;
                    deli_bill_number.value = data.billdetail.bill_number ;
                    deli_date.value = data.billdetail.bill_date;
                }
                caltotalpaydeli();
            }
        });
    }

    function showbilldetail_add(e) {
        let adddown_pay = document.querySelectorAll('input[name="adddown_pay[]"]');
        let adddown_billnumber = document.querySelectorAll('input[name="adddown_billnumber[]"]');
        let adddown_date = document.querySelectorAll('input[name="adddown_date[]"]');
        $.ajax({
            url: "{{ route('getbilldata', ':id') }}".replace(':id', e.value),
            type: "GET",
            success: function(data) {
                if(data.billdetail.bill_type == 'deli_bill'){
                    for (let i = 0; i < adddown_pay.length; i++) {
                        if(adddown_pay[i].id == e.id){
                            adddown_pay[i].value = data.billdetail.payment;
                            adddown_billnumber[i].value = data.billdetail.bill_number ;
                            adddown_date[i].value = data.billdetail.bill_date;
                        }
                    }
                }
                caltotalpaydeli();
            }
        });
    }

    function removeguarantor(e) {
        var guarantornum = document.getElementsByName("guarantornum[]");
        Swal.fire({
            title: '{!! $content_lang['del-data'] !!}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: '{!! $content_lang['del-alert-cancel'] !!}',
            confirmButtonText: '{!! $content_lang['del-alert-confirm'] !!}',
            }).then((result) => {
            if (result.isConfirmed) {
                if(e.id > 0){
                    $.ajax({
                    url: "{{ route('removeguarantor', ':id') }}".replace(':id', e.id),
                    type: "GET",
                    success: function(data) {
                        
                    }
                    });
                }
                e.parentElement.remove();
                for (let i = 0; i < guarantornum.length; i++) {
                    if (count_guarantor > 0) {
                        guarantornum[i].innerHTML = '{{ $content_lang['detail-guarantor'] }}' + (i + 1);
                    }
                }
            }
        });
        
    }

    function removeadddown(e) {
        var adddownnumber = document.getElementsByName("adddownnumber[]");
        Swal.fire({
            title: '{!! $content_lang['del-data'] !!}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: '{!! $content_lang['del-alert-cancel'] !!}',
            confirmButtonText: '{!! $content_lang['del-alert-confirm'] !!}',
            }).then((result) => {
            if (result.isConfirmed) {
                if(e.id > 0){
                    $.ajax({
                    url: "{{ route('removeadddown', ':id') }}".replace(':id', e.id),
                    type: "GET",
                    success: function(data) {
                        
                    }
                });
                }
                e.parentElement.remove();

                caltotalpaydeli();
            }
        });
        
    }

    function swicthimage(imgs) {
        // Get the expanded image
        var expandImg = document.getElementById("expandedImg");
        var closeimg = document.getElementById("closeimg");
        // Get the image text
        var imgText = document.getElementById("imgtext");
        var remove_file = document.getElementById("remove_file");
        // Use the same src in the expanded image as the image being clicked on from the grid
        if (imgs.name.toLowerCase() != 'pdf') {
            expandImg.src = imgs.src;
        }
        closeimg.classList.remove('invisible');
        // Use the value of the alt attribute of the clickable image as text inside the expanded image
        // Show the container element (hidden with CSS)
        expandImg.parentElement.style.display = "block";
    }

    function create_ins(ins_num) {
        let display_ins = document.getElementById('display_ins');
        let divid_ins_small = document.getElementById('divid_ins_small');
        remove_ins = true;
        while (display_ins.firstChild) {
            display_ins.removeChild(display_ins.firstChild);
        }

        // Create datepicker instance
        if (ins_num > 0) {

            for (let i = 0; i < ins_num; i++) {

                const main_div = document.createElement('div');
                main_div.classList = "w-full flex items-center center";
                const ins_num_div = document.createElement('div');
                ins_num_div.classList = "flex justify-center w-3/12 mr-1";
                const ins_num_label = document.createElement('x-label');
                ins_num_label.classList = "ml-1 w-fit text-sm";
                ins_num_label.setAttribute('id', 'ins_num[]');
                ins_num_label.textContent = '{{ $content_lang['ins-num'] }} ' + (parseInt(i) + parseInt(1)) +
                    ' {{ $content_lang['date'] }}';
                const ins_date_div = document.createElement('div');
                ins_date_div.classList = "w-4/12";
                const ins_date_input = document.createElement('input');
                ins_date_input.setAttribute('id', 'ins_appoint_date' + i);
                ins_date_input.setAttribute('name', 'ins_appoint_date[]');
                ins_date_input.setAttribute('required', true);
                ins_date_input.setAttribute('type', 'text');
                ins_date_input.setAttribute('oninput', 'convertinsdate(this)');
                ins_date_input.classList = "block h-8 mt-1 w-full border-gray-300 rounded-md datepicker ins_date";
                const number_div = document.createElement('div');
                number_div.classList = "w-2/12 flex items-center justify-center mr-1";
                const number_label = document.createElement('x-label');
                number_label.classList = "ml-1 w-fit text-sm";
                number_label.textContent = '{{ $content_lang['number'] }}';
                const ins_div = document.createElement('div');
                ins_div.classList = "w-4/12";
                const ins_input = document.createElement('input');
                ins_input.classList = "block h-8 mt-1 w-full border-gray-300 rounded-md";
                ins_input.setAttribute('id', 'ins_appoint_pay[]');
                ins_input.setAttribute('name', 'ins_appoint_pay[]');
                ins_input.setAttribute('type', 'number');
                ins_input.setAttribute('required', true);
                ins_input.setAttribute('value', divid_ins_small.value);
                const principle_input = document.createElement('input');
                principle_input.setAttribute('id', 'principle[]');
                principle_input.setAttribute('name', 'principle[]');
                principle_input.setAttribute('type', 'hidden');
                const interest_input = document.createElement('input');
                interest_input.setAttribute('id', 'interest[]');
                interest_input.setAttribute('name', 'interest[]');
                interest_input.setAttribute('type', 'hidden');

                const unit_div = document.createElement('div');
                unit_div.classList = "w-1/12 flex justify-end";
                const unit_label = document.createElement('x-label');
                unit_label.classList = "ml-1 w-fit text-sm";
                unit_label.textContent = '{{ $content_lang['unit'] }}';

                display_ins.appendChild(main_div);
                main_div.appendChild(ins_num_div);
                ins_num_div.appendChild(ins_num_label);
                main_div.appendChild(ins_date_div);
                ins_date_div.appendChild(ins_date_input);
                main_div.appendChild(number_div);
                number_div.appendChild(number_label);
                main_div.appendChild(ins_div);
                ins_div.appendChild(ins_input);
                ins_div.appendChild(principle_input);
                ins_div.appendChild(interest_input);
                main_div.appendChild(unit_div);
                unit_div.appendChild(unit_label);
            }
            var datepickerOptions = {
                allowInput: true,
                // Configuration options
                dateFormat: "d/m/Y",
                // Add more options as needed
                locale: calender
            };
            var datepickerInputs = document.getElementsByClassName("datepicker");
            for (var i = 0; i < datepickerInputs.length; i++) {
                var input = datepickerInputs[i];

                // Create datepicker instance for each input
                flatpickr(input, datepickerOptions);
            }
        }
        change_ins_pay();
    }

    function closeimage(e) {
        var closeimg = document.getElementById("closeimg");
        e.parentElement.style.display = 'none';
        closeimg.classList.add("invisible");
    }

    function togglegiftother(checkbox) {
        const input = document.getElementById('other-input');
        const item_other = document.getElementById('other_item');
        item_other.value = "";
        input.classList.toggle('invisible', !checkbox.checked);
    }

    function toggleboker(checkbox) {
        const mainboker = document.getElementById('boker-form');

        if (checkbox.value == 'มีนายหน้า') {
            var bokerform = document.createElement('div');

            bokerform.innerHTML = `<div class="w-full flex justify-center items-center mb-1">
                                        <div class="w-2/4 mr-3">
                                            <x-label for="boker_name" value="{{ $content_lang['new-name'] }}" />
                                            <x-input id="boker_name" name="boker_name" class="block h-8 mt-1 w-full"
                                                type="text" autofocus />
                                            @error('boker_name')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-1/4 relative mr-3">
                                            <x-label for="boker_money"
                                                value="{{ $content_lang['number-money'] }}" />
                                            <x-input id="boker_money" name="boker_money"
                                                class="block h-8 mt-1 w-full" type="text" autofocus />
                                            <label
                                                class="absolute top-1/2 right-2">{{ $content_lang['unit'] }}</label>
                                            @error('boker_money')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-1/4 mr-3">
                                            <x-label for="boker_tel" value="{{ $content_lang['new-tel'] }}" />
                                            <x-input id="boker_tel" name="boker_tel" class="block h-8 mt-1 w-full"
                                                type="text" autofocus />
                                            @error('boker_tel')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-full flex justify-center items-center">
                                        <div class="w-1/12 mr-3">
                                            <x-label for="boker_address"
                                                value="{{ $content_lang['new-address'] }}" />
                                            <x-input id="boker_address" name="boker_address"
                                                class="block h-8 mt-1 w-full" type="text" autofocus />
                                            @error('boker_address')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-1/12 mr-3">
                                            <x-label for="boker_group" value="{{ $content_lang['new-group'] }}" />
                                            <x-input id="boker_group" name="boker_group"
                                                class="block h-8 mt-1 w-full" type="text" autofocus />
                                            @error('boker_group')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-2/12 mr-3">
                                            <x-label for="boker_village"
                                                value="{{ $content_lang['new-village'] }}" />
                                            <x-input id="boker_village" name="boker_village"
                                                class="block h-8 mt-1 w-full" type="text" autofocus />
                                            @error('boker_village')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-4/12 mr-3">
                                            <x-label for="boker_city" value="{{ $content_lang['new-city'] }}" />
                                            <x-input id="boker_city" name="boker_city" class="block h-8 mt-1 w-full"
                                                type="text" autofocus />
                                            @error('boker_city')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="w-4/12 mr-3">
                                            <x-label for="boker_district"
                                                value="{{ $content_lang['new-district'] }}" />
                                            <select id="boker_district"
                                                class="district border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                                name="boker_district" required>
                                                    {{ $content_lang['req-district'] }}</option>


                                            </select>
                                            @error('boker_district')
                                                <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                    role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>`;
            mainboker.appendChild(bokerform);
            createoptiondivision();
        } else {
            while (mainboker.firstChild) {
                mainboker.removeChild(mainboker.firstChild);
            }
        }
    }

    function changinsdate(inputid) {
        // Get all the input elements with name="ins_date[]"
        
        if (inputid == 'ins_appoint_date0') {
            
            let firstinsdate = document.getElementById('ins_appoint_date0');
            var insDateInputs = document.querySelectorAll('input[name="ins_appoint_date[]"]');
            let ins_style = document.getElementById('ins_style');
            let ins_style_type = document.getElementById('ins_style_type');
            
            for (let i = 0; i < insDateInputs.length; i++) {
                var startDate = insDateInputs[i].value;
                var parts = startDate.split('/'); // Split the value into day, month, and year

                if (parts.length === 3) {
                    var day = parseInt(parts[0]);
                    var month = parseInt(parts[1]);
                    var year = parseInt(parts[2]);

                    // Create a JavaScript Date object with the specified day, month, and year
                    var date = new Date(year, month - 1, day);
                    var lastday_flag = false;
                
                    var endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
                    if(day == endDate){
                        lastday_flag = true;
                    }else{
                        lastday_flag = false;
                    }
                // Get the new day, month, and year
                
                    if(ins_style_type.value == 'month'){
                        date.setMonth(date.getMonth() + parseInt(ins_style.value));
                    }else if(ins_style_type.value == 'year'){
                        date.setYear(date.getFullYear() + parseInt(ins_style.value));
                    }
                    var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newYear = date.getFullYear();
                    if(lastday_flag){
                        endDate = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
                        newDay = endDate;
                    }
                

                // Format the new date as 'd/m/y' and display it
                    var newDate = newDay + '/' + newMonth + '/' + newYear;

                    if (i + 1 < insDateInputs.length){
                        insDateInputs[i + 1].value = newDate;
                    }
                    
                }
            }
        }
    }

    function createoptiondivision() {
        var selectdistrict = document.getElementsByClassName('district');
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
        let guarantor = {!! json_encode($guarantors) !!}
        for (let k = 0; k < selectdistrict.length; k++) {
            if(selectdistrict[k].name == "cus_district"){
                for (var i = 0; i < options.length; i++) {
                    const optionElement = document.createElement('option');
                    optionElement.value = options[i];
                    optionElement.text = optiontext[i];
                    if(options[i] == '{!! isset($cusdata->cus_district) ? $cusdata->cus_district : 'null'  !!}'){
                        optionElement.selected = true;
                    }
                    selectdistrict[k].add(optionElement);
                }
            }else if(selectdistrict[k].name == "boker_district"){
                for (var i = 0; i < options.length; i++) {
                    const optionElement = document.createElement('option');
                    optionElement.value = options[i];
                    optionElement.text = optiontext[i];
                    if(options[i] == '{!! isset($boker->district) ? $boker->district : 'null'  !!}'){
                        optionElement.selected = true;
                    }
                    selectdistrict[k].add(optionElement);
                }
            }else if(selectdistrict[k].name == "guarantor_district[]"){
                if(selectdistrict[k].id == "guarantor_district[]"){
                    console.log('gg');
                    for (var i = 0; i < options.length; i++) {
                        const optionElement = document.createElement('option');
                        optionElement.value = options[i];
                        optionElement.text = optiontext[i];
                        selectdistrict[k].add(optionElement);
                    }
                }
                for (let j = 0; j < guarantor.length; j++) {
                    if(selectdistrict[k].id == guarantor[j].id){
                        for (var i = 0; i < options.length; i++) {
                            const optionElement = document.createElement('option');
                            optionElement.value = options[i];
                            optionElement.text = optiontext[i];
                            if(options[i] == guarantor[j].district){
                                optionElement.selected = true;
                            }
                            selectdistrict[k].add(optionElement);
                        }
                    }
                }
            }
            
        }

    }

    function createinsdown(e) {
        let insdown_id = document.querySelectorAll('input[name="insdown_id[]"]');
        let display_ins_down = document.getElementById('display_ins_down');
        let down_pay = document.getElementById('down_pay');
        let total_pay_deli = document.getElementById('total_pay_deli');
        let ins_down_per = (parseInt(down_pay.value) - parseInt(total_pay_deli.value)) / parseInt(e.value);
        remove_insdown = true;
        while (display_ins_down.firstChild) {
            display_ins_down.removeChild(display_ins_down.firstChild);
        }

        // Create datepicker instance
        if (e.value > 0) {
            for (let i = 0; i < e.value; i++) {

                const main_div = document.createElement('div');
                main_div.classList = "w-full flex items-center center";
                const down_label_div = document.createElement('div');
                down_label_div.classList = "w-3/12";
                const ins_num_label = document.createElement('label');
                ins_num_label.classList = "mx-1 text-sm w-fit";
                ins_num_label.textContent = '{{ $content_lang['ins-down-pay'] }} ' + (parseInt(i) + parseInt(1));
                const ins_down_div = document.createElement('div');
                ins_down_div.classList = "w-4/12";
                const ins_down_input = document.createElement('input');
                ins_down_input.setAttribute('id', 'ins_down_appoint_pay[]');
                ins_down_input.setAttribute('name', 'ins_down_appoint_pay[]');
                ins_down_input.setAttribute('type', 'number');
                ins_down_input.setAttribute('min', 0);
                ins_down_input.setAttribute('max', 99999999);
                ins_down_input.setAttribute('value', ins_down_per);
                ins_down_input.setAttribute('required', true);
                ins_down_input.classList = "block h-8 mt-1 w-full border-gray-300 rounded-md";
                const unit_label_div = document.createElement('div');
                unit_label_div.classList = "w-1/12";
                const unit_label = document.createElement('label');
                unit_label.classList = "mx-1 text-sm w-fit";
                unit_label.textContent = '{{ $content_lang['unit'] }}';
                const date_label_div = document.createElement('div');
                date_label_div.classList = "w-1/12 text-center";
                const date_label = document.createElement('label');
                date_label.classList = "mx-1 text-sm w-fit";
                date_label.textContent = '{{ $content_lang['date'] }}';
                const date_input_div = document.createElement('div');
                date_input_div.classList = "w-3/12";
                const date_input = document.createElement('input');
                date_input.classList = "block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input";
                date_input.setAttribute('id', 'ins_down_appoint_date[]');
                date_input.setAttribute('name', 'ins_down_appoint_date[]');
                date_input.setAttribute('type', 'text');
                date_input.setAttribute('oninput', 'convertinsdate(this)');
                date_input.setAttribute('required', true);

                display_ins_down.appendChild(main_div);
                main_div.appendChild(down_label_div);
                down_label_div.appendChild(ins_num_label);
                main_div.appendChild(ins_down_div);
                ins_down_div.appendChild(ins_down_input);
                main_div.appendChild(unit_label_div);
                unit_label_div.appendChild(unit_label);
                main_div.appendChild(date_label_div);
                date_label_div.appendChild(date_label);
                main_div.appendChild(date_input_div);
                date_input_div.appendChild(date_input);
            }
            var datepickerOptions = {
                allowInput: true,
                // Configuration options
                dateFormat: "d/m/Y",
                // Add more options as needed
                locale: calender

                
            };
            var datepickerInputs = document.getElementsByClassName("datepicker");
            for (var i = 0; i < datepickerInputs.length; i++) {
                var input = datepickerInputs[i];

                // Create datepicker instance for each input
                flatpickr(input, datepickerOptions);
            }
        }
    }

    function discountcal(e) {
        let total_price = document.getElementById('total_price_detail');
        let net_price = document.getElementById('net_price');
        net_price.value = parseInt(total_price.value) - parseInt(e.value);
    }

    function caltotalpaydeli() {
        let deposit = document.getElementById('deposit');
        let down_pay_deli = document.getElementById('down_pay_deli');
        let adddown_pay = document.querySelectorAll('input[name="adddown_pay[]"]');
        let total_pay_deli = document.getElementById('total_pay_deli');
        let total_adddown = 0;
        let total_pay = 0;
        
        for (let i = 0; i < adddown_pay.length; i++) {
            if(adddown_pay[i].value){
                total_adddown += parseInt(adddown_pay[i].value);
            }
        }
        total_pay = parseInt(deposit.value) + parseInt(down_pay_deli.value);
        if(total_adddown >0){
            total_pay += parseInt(total_adddown);
        }
        total_pay_deli.value = total_pay;
    }

    function calremaining(e) {
        let down_pay = document.getElementById('down_pay');
        let remaining = document.getElementById('remaining');
        let net_price = document.getElementById('net_price');
        remaining.value = parseInt(net_price.value) - parseInt(down_pay.value);
    }

    function calinsper(e) {
        let divid_ins_small = document.getElementById('divid_ins_small');
        let remaining = document.getElementById('remaining');
        let interest_rate = document.getElementById('interest_rate');
        let interestperins_input = document.getElementById('interestperins');
        let principleperins_input = document.getElementById('principleperins');
        let closeacc = (parseInt(remaining.value) * (parseFloat(interest_rate.value) / 100)) * 36 + parseInt(remaining
            .value);
        let insperins = parseInt(closeacc) / parseInt(e.value);
        let interest = (parseInt(remaining.value) * (parseFloat(interest_rate.value) / 100)) * 36;
        let interestperins = parseInt(interest) / parseInt(e.value);
        let principleperins = parseInt(insperins) - parseInt(interestperins);
        divid_ins_small.value = Math.ceil(insperins);
        interestperins_input.value = Math.ceil(interestperins);
        principleperins_input.value = Math.ceil(principleperins);
        create_ins(parseInt(e.value));
    }

    function change_ins_pay() {
        let inspayInputs = document.querySelectorAll('input[name="ins_appoint_pay[]"]');
        let principle = document.querySelectorAll('input[name="principle[]"]');
        let interest = document.querySelectorAll('input[name="interest[]"]');
        let divid_ins_small = document.getElementById('divid_ins_small');
        let divid_ins_large = document.getElementById('divid_ins_large');
        let principleperins = document.getElementById('principleperins');
        let interestperins = document.getElementById('interestperins');
        let count = 1;
        for (let i = 0; i < inspayInputs.length; i++) {
            if (divid_ins_large.value != "" || divid_ins_large.value == "-" ||divid_ins_large.value == "0") {
                if (count < 6) {
                    inspayInputs[i].value = divid_ins_small.value;
                    principle[i].value = "-";
                } else {
                    inspayInputs[i].value = divid_ins_large.value;
                    principle[i].value = principleperins.value;
                    count = 0;
                }
                interest[i].value = interestperins.value;
                count++;
            } else {
                inspayInputs[i].value = divid_ins_small.value;
                principle[i].value = principleperins.value;
                interest[i].value = interestperins.value;
            }
        }
    }

    function setdelidate(e) {
        let total_pay_deli_date = document.getElementById('total_pay_deli_date');
        let deli_date = document.getElementById('deli_date');
        total_pay_deli_date.value = e.value;
        deli_date.value = e.value;
    }
    $('.datepicker').on('input', function() {
        var startDate = this.value;
        var parts = startDate.split('/'); // Split the value into day, month, and year
        var newDate = startDate;
        if (parts.length === 3) {
            var day = parseInt(parts[0]);
            var month = parseInt(parts[1]);
            var year = parseInt(parts[2]);
            var yearstring = year.toString();
            if(!yearstring.startsWith('20')){
                if((yearstring.startsWith('25') && year > 2500 && year.toString().length == 4) || (!yearstring.startsWith('25') && year.toString().length > 1 && year.toString().length < 4 && year >= 50) ){
                    if(!yearstring.startsWith('25')){
                        year = '25'+year;
                    }
                    console.log('th');
                    var date = new Date(year -543, month - 1, day);
                    var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newYear = date.getFullYear();
                    newDate = newDay + '/' + newMonth + '/' + newYear;
                    this.value = newDate;
                }else if(!yearstring.startsWith('25') && year.toString().length > 1 && year.toString().length < 4 && year < 50){
                    year = '20'+year;
                    var date = new Date(year, month - 1, day);
                    var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newYear = date.getFullYear();
                    newDate = newDay + '/' + newMonth + '/' + newYear;
                    this.value = newDate;
                }
            }
        }
        
    });
    function convertinsdate(e) {
        var startDate = e.value;
        var parts = startDate.split('/'); // Split the value into day, month, and year
        var newDate = e.value;
        if (parts.length === 3) {
            var day = parseInt(parts[0]);
            var month = parseInt(parts[1]);
            var year = parseInt(parts[2]);
            var yearstring = year.toString();
            if(!yearstring.startsWith('20')){
                if((yearstring.startsWith('25') && year > 2500 && year.toString().length == 4) || (!yearstring.startsWith('25') && year.toString().length > 1 && year.toString().length < 4 && year >= 50) ){
                    if(!yearstring.startsWith('25')){
                        year = '25'+year;
                    }
                    
                    var date = new Date(year -543, month - 1, day);
                    var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newYear = date.getFullYear();
                    newDate = newDay + '/' + newMonth + '/' + newYear;
                    e.value = newDate;
                    
                }else if(!yearstring.startsWith('25') && year.toString().length > 1 && year.toString().length < 4 && year < 50){
                    
                    year = '20'+year;
                    var date = new Date(year, month - 1, day);
                    var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                    var newYear = date.getFullYear();
                    newDate = newDay + '/' + newMonth + '/' + newYear;
                    
                    e.value = newDate;
                    
                }
            }
            changinsdate(e.id);
        }
        
        
    };
    function printdoc() {
        var printContents = document.getElementById("printapprovedoc");
        var printContents = document.getElementById("printapprovedoc").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
    $('#cusdata').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting by default
        let formData = $(this).serialize(); // Using serialize() method
        var sweetIcon = 'question';
        let content_lang = {!! json_encode($content_lang) !!};
        var htmltext = '';
        if(remove_insdown == true || remove_ins == true){
            htmltext = '<span style="color: red;">'+content_lang['warnning-edit']+'</span>';
        }

        // Display the SweetAlert confirmation dialog
        Swal.fire({
            title: '{!! $content_lang['confirm_save'] !!}',
            html: htmltext,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: '{!! $content_lang['del-alert-cancel'] !!}',
            confirmButtonText: '{!! $content_lang['del-alert-confirm'] !!}',
            }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, submit the form
                $(this).off('submit').submit(); // Remove the submit event listener and submit the form
            }
        });
    })
</script>
