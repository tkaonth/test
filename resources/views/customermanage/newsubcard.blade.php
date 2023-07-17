@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
    $calender = include base_path('lang\\' . session()->get('locale') . '\calender.php');
    $options = include base_path('lang\\' . session()->get('locale') . '\branchdivision.php');
    //dd($calender);
@endphp
<style>

</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['changecontact'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-full p-5 border-2 rounded-lg">
                    <div class="w-fit">
                        <a class="flex pl-0 p-2 mb-5" href="{{ url()->previous() }}">
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
                        <form method="POST" action="{{ route('addsubcuscard') }}">
                            @csrf
                            <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">{{ $content_lang['cus-detail'].'' }}</h1>
                            <div class="pt-1 p-3 flex w-full justify-between">
                                <div class="w-1/4 flex mr-5">

                                    <div class="w-full ">
                                        <input type="hidden" name="maincard" value="{{ $cusdata->id  }}">
                                        <input type="hidden" name="car_id" value="{{ $cusdata->car_id  }}">
                                        <input type="hidden" name="ins_LJT" value="{{ $cusdata->ins_LJT  }}">
                                        <input type="hidden" name="ins_money" value="{{ $cusdata->ins_money  }}">
                                        <input type="hidden" name="deli_date" value="{{ $cusdata->deli_date  }}">
                                        <input type="hidden" name="stock" value="{{ $cusdata->stock  }}">
                                        <x-label for="cus_code" value="{{ $content_lang['new-code'] }}" />
                                        <x-input id="cus_code" class="block h-8 mt-1 w-full" type="text"
                                            name="cus_code" required autofocus
                                            oninvalid="!this.value || this.setCustomValidity('{{ $content_lang['req-code'] }}')"
                                            value="{{ $cusdata->cus_code  }}" />
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
                                        <option value="" selected disabled>{{ $content_lang['req-district'] }}
                                        </option>


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
                                        <option value="{{ $branch->keyword }}" @if($branch->keyword == $cusdata->cus_branch) @endif>
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
                                        <option value="normal" {{ $cusdata->cus_type == 'normal' ? 'selected' : '' }}>{{ $content_lang['cus-normal'] }}</option>
                                        <option value="kasikam" {{ $cusdata->cus_type == 'kasikam' ? 'selected' : '' }}>{{ $content_lang['cus-kasikam'] }}</option>
                                    </select>

                                    @error('cus_type')
                                        <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="w-1/4">
                                    <x-label for="cus_st" value="{{ $content_lang['table-status'] }}" />
                                    <select
                                        class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1"
                                        name="cus_st" value="{{ old('cus_st') }}">
                                        @foreach ($cus_sts as $cus_st)
                                            <option value="{{ $cus_st->keyword }}" @if($branch->keyword == $cusdata->cus_st) @endif>
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
                            
                            <div>
                                <h1 class="p-2 my-1 text-xl bg-blue-200 rounded-lg">
                                    {{ $content_lang['content-header-ins-detail'] }}
                                </h1>
                                
                                <div class="flex">
                                    <div class="w-1/2 p-3">
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="total_price" class="mx-1 w-fit"
                                                    value="{{ $content_lang['total-price'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="total_price" class="block mt-1 h-8 w-full"
                                                    type="number" name="total_price" autofocus required
                                                    value="{{ old('total_price') }}" />
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
                                                <x-label for="interest_rate" class="mx-1 w-fit"
                                                    value="{{ $content_lang['interest-rate'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="interest_rate" class="block mt-1 h-8 w-full"
                                                    type="text" name="interest_rate" autofocus required
                                                    value="{{ old('interest_rate') }}" />
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
                                                    name="ins_style" autofocus value="{{ old('ins_style') }}" required />
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
                                                    <option value="เดือน" selected>{{ $content_lang['month'] }}</option>
                                                    <option value="ปี">{{ $content_lang['year'] }}</option>
                                                </select>
                                            </div>
                                            <div class="w-3/12 flex items-center">
                                                <x-label class="mx-1 w-fit" value="{{ $content_lang['long'] }}" />
                                                <x-input id="ins_long" class="block mt-1 h-8 w-full" type="number"
                                                    name="ins_long" required autofocus
                                                    value="{{ old('ins_long') }}" required />
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
                                                    <option value="เดือน" selected>{{ $content_lang['month'] }}</option>
                                                    <option value="ปี">{{ $content_lang['year'] }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="w-full flex items-center">
                                            <div class="w-fit mr-1">
                                                <x-label for="total_ins" class="ml-1 w-fit"
                                                    value="{{ $content_lang['total-ins'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <x-input id="total_ins" class="block mt-1 h-8 w-full" type="number"
                                                    name="total_ins" autofocus onchange="calinsper(this)" required
                                                    value="{{ old('total_ins') }}" />
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
                                                    onchange="change_ins_pay()"
                                                    value="{{ old('divid_ins_small') }}" />
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
                                                    onchange="change_ins_pay()"
                                                    value="{{ old('divid_ins_large') }}" />
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
                                                class="block mt-1 h-8 w-full" onchange="change_ins_pay()" value="{{ old('principleperins') }}" />
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
                                                    class="block mt-1 h-8 w-full" onchange="change_ins_pay()" value="{{ old('interestperins') }}" />
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
                                                    name="note" autofocus value="{{ old('note') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-1/2 p-3">
                                        
                                        <div class="w-full flex items-center">
                                            <div class="w-3/12">
                                                <x-label for="start_ins" class="ml-5 w-fit"
                                                    value="{{ $content_lang['start-ins'] }}" />
                                            </div>
                                            <div class="w-4/12">
                                                <input id="start_ins" name="start_ins" type="text" required
                                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                                    value="{{ old('start_ins') }}">
                                                @error('start_ins')
                                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100"
                                                        role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div id="display_ins">

                                        </div>
                                    </div>
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
    var count_guarantor = 0;
    var count_adddown = 0;
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

    function create_ins() {
        let display_ins = document.getElementById('display_ins');
        let divid_ins_small = document.getElementById('divid_ins_small');
        let ins_num = document.getElementById('total_ins');
        while (display_ins.firstChild) {
            display_ins.removeChild(display_ins.firstChild);
        }

        // Create datepicker instance
        if (ins_num.value > 0) {

            for (let i = 0; i < ins_num.value; i++) {

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
        change_ins_pay(ins_num);
    }

    $('.datepicker').on('oninput', function() {
        var startDate = this.value;
        var parts = startDate.split('/'); // Split the value into day, month, and year
        var newDate = this.value;
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
                    console.log('en');
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
        this.value = newDate;
    });
    function convertinsdate(e) {
        var startDate = e.value;
        var parts = startDate.split('/'); // Split the value into day, month, and year
        var newDate = e.value;
        if (parts.length === 3) {
            var day = parseInt(parts[0]);
            var month = parseInt(parts[1]);
            var year = parseInt(parts[2]);
            if(year.toString().length < 4 || year < 50){
                year = '25'+year;
                var date = new Date(year -543, month - 1, day);
                var newDay = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2 });
                var newMonth = (date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
                var newYear = date.getFullYear();
                newDate = newDay + '/' + newMonth + '/' + newYear;
                console.log(newDate);
            }
        }
        e.value = newDate;
        changinsdate(e);
    };

    function changinsdate(e) {
        // Get all the input elements with name="ins_date[]"
        if (e.id == 'ins_appoint_date0') {
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
                
                if(ins_style_type.value == 'เดือน'){
                    date.setMonth(date.getMonth() + parseInt(ins_style.value));
                }else if(ins_style_type.value == 'เดือน'){
                    date.setMonth(date.getMonth() + parseInt(ins_style.value));
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
        for (let k = 0; k < selectdistrict.length; k++) {
            for (var i = 0; i < options.length; i++) {
                const optionElement = document.createElement('option');
                optionElement.value = options[i];
                optionElement.text = optiontext[i];
                if(options[i] == '{!! $cusdata->cus_district  !!}'){
                    optionElement.selected = true;
                }
                selectdistrict[k].add(optionElement);
            }
        }

    }

    function clearinsper() {
        let divid_ins_small = document.getElementById('divid_ins_small');
        let divid_ins_large = document.getElementById('divid_ins_large');
        let principleperins = document.getElementById('principleperins');
        let interestperins = document.getElementById('interestperins');
        divid_ins_small.value = 0;
        divid_ins_large.value = 0;
        principleperins.value = 0;
        interestperins.value = 0;
        create_ins();
    }

    function change_ins_pay(e) {

        let inspayInputs = document.querySelectorAll('input[name="ins_appoint_pay[]"]');
        let principle = document.querySelectorAll('input[name="principle[]"]');
        let interest = document.querySelectorAll('input[name="interest[]"]');
        let total_ins = document.getElementById('total_ins');
        let divid_ins_small = document.getElementById('divid_ins_small');
        let divid_ins_large = document.getElementById('divid_ins_large');
        let principleperins = document.getElementById('principleperins');
        let interestperins = document.getElementById('interestperins');
        let remaining = document.getElementById('remaining');
        if(e.id == 'divid_ins_small' || e.id == 'divid_ins_large'){
            console.log(divid_ins_small.value);
            console.log(divid_ins_large.value);
            if(parseInt(divid_ins_small.value) > 0 || parseInt(divid_ins_large.value) > 0){
                if(parseInt(divid_ins_large.value) > 0){
                    numins = parseInt(total_ins.value / 6);
                    principleperins.value = parseInt(remaining.value / numins);
                    interestperins.value = parseInt(divid_ins_large.value - principleperins.value);
                    divid_ins_small.value = parseInt(interestperins.value);
                }else{
                    principleperins.value = parseInt(remaining.value / total_ins.value);
                    interestperins.value = parseInt(divid_ins_small.value - principleperins.value);
                }
            }
        }


        let count = 1;
        for (let i = 0; i < inspayInputs.length; i++) {
            if (parseInt(divid_ins_large.value) > 0) {
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
</script>
