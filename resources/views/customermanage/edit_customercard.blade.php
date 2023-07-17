@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
    $calender = include base_path('lang\\' . session()->get('locale') . '\calender.php');
    
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-cuscard'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="customercard" class="max-w-10/12 mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white overflow-hidden justify-center shadow-xl sm:rounded-lg p-5">
                <div class="w-full p-5 border-2 rounded-lg">
                    <div class="w-fit">
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('cuscard', ['id' => $cusdata->id]) }}">
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
                    </div>
                    <div class="flex rounded-md drop-shadow-lg">
                        <div class="flex w-3/4 items-center p-2">
                            <div class="w-full p-2 rounded-md mr-5">
                                <div class="p-2">
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['table-name'] }}&nbsp;{{ $cusdata->cus_name }}
                                        </div>
                                        <div>
                                            {{ $content_lang['cus-code'] }}&nbsp;{{ $cusdata->cus_code }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['car-model'] }}&nbsp;{{ $cardata->car_model }}
                                        </div>
                                        <div>
                                            {{ $content_lang['deli-date'] }}&nbsp;{{ $cusdata->deli_date }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['car-number'] }}&nbsp;{{ $cardata->car_number }}
                                        </div>
                                        <div>
                                            @php
                                               if(count($ins)>0){
                                                  $count_ins = count($ins);
                                                  $end_date = $ins[$count_ins-1]['appoint_date'];
                                               }else{
                                                  $end_date = $cusdata->deli_date;
                                               }
                                            @endphp
                                            {{ $content_lang['end-date'] }} {{ $end_date }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['car-enginenumber'] }}&nbsp;{{ $cardata->engine_number }}
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <div>
                                                {{ $content_lang['table-status'] }}
                                            </div>
                                            <div>
                                                <select
                                                    class="border h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-1 pr-8"
                                                    id="cus_st" onchange="change_cus_st(this)">
                                                    @foreach ($cus_sts as $cus_st)
                                                        <option @if ($cusdata->cus_st == $cus_st->keyword) selected @endif
                                                            value="{{ $cus_st->keyword }}">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['address'] }}&nbsp;{{ $cusdata->cus_address . ' ' . $cusdata->cus_group . ' ' . $cusdata->cus_village . ' ' . $cusdata->cus_city . ' ' . $cusdata->cus_district }}
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['new-tel'] }}&nbsp;{{ $cusdata->cus_tel }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="flex-row justify-center w-1/4 p-2">
                            <div
                                class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                {{ $content_lang['approve-licene'] }}
                            </div>
                            <a target="_blank" href="{{ route('detailcar', ['id' => $cardata->id]) }}">
                                <div
                                    class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                    {{ $content_lang['view_car_detail'] }}
                                </div>
                            </a>
                            <a href="{{ route('uploadform_cus', ['id' => $cusdata->id]) }}">
                                <div
                                    class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                    {{ $content_lang['upload-button'] }}
                                </div>
                            </a>
                            <a href="{{ route('viewcusdoc', ['id' => $cusdata->id]) }}">
                                <div
                                    class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                    {{ $content_lang['view-button'] }}
                                </div>
                            </a>
                            <a target="_blank" href="{{ route('printcuscard', ['id' => $cusdata->id]) }}">
                                <div
                                    class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                    {{ $content_lang['dowloadpdf'] }}
                                </div>
                            </a>
                        </div> --}}
                    </div>
                    <div class="my-1">
                        <table class="w-1/2 table mb-2 table-auto border-2 text-center rounded-lg">
                            <thead class="bg-gray-400 text-lg">
                                <tr>
                                    <th colspan="4" class="px-4 py-2">
                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                            {{ $content_lang['header-car-detail'] }}
                                        </h2>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-2">
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['car_price'] }}</td>
                                    <td class="border px-4 py-2">{{ number_format($cusdata->total_price) }} บาท</td>
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['down-pay'] }}</td>
                                    <td class="border px-4 py-2">{{ number_format($cusdata->down_pay) }} บาท</td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['remaining'] }}</td>
                                    <td class="border px-4 py-2">{{ number_format($cusdata->remaining) }} บาท</td>
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['interest'] }}</td>
                                    <td class="border px-4 py-2">{{ $cusdata->interest_rate }} %</td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['table-ins-type'] }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $cusdata->ins_style }}
                                        @if ($cusdata->ins_style_type == 'month')
                                            {{ $content_lang['month'] }}
                                        @elseif($cusdata->ins_style_type == 'year')
                                            {{ $content_lang['year'] }}
                                        @endif
                                    </td>
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['long'] }}</td>
                                    <td class="border px-4 py-2">{{ $cusdata->ins_long }}
                                        @if ($cusdata->ins_long_type == 'month')
                                            {{ $content_lang['month'] }}
                                        @elseif($cusdata->ins_long_type == 'year')
                                            {{ $content_lang['year'] }}
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['total-ins-pay'] }}
                                    </td>
                                    <td class="border px-4 py-2">{{ count($ins) }} งวด</td>
                                    <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['ins'] }}</td>
                                    @php
                                        if (strpos($cusdata->divid_ins, '/') !== false) {
                                            $splitdivid_ins = explode('/', $cusdata->divid_ins);
                                            $divid_ins = number_format($splitdivid_ins[0]) . '/' . number_format($splitdivid_ins[1]);
                                        } else {
                                            $divid_ins = number_format($cusdata->divid_ins);
                                        }
                                    @endphp
                                    <td class="border px-4 py-2">{{ $divid_ins }} บาท</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form method="POST" id="dataform" action="{{ route('updatecuscard', ['id' => $cusdata->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="my-1">
                            <div id="insdown-container">
                                <table id="insdowntable" class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                    <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                        <tr>
                                            <th colspan="11" class="px-4 py-2">
                                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                    {{ $content_lang['payable-down'] }}
                                                </h2>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['appoint-date'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-down'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['date'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['bill-number'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['payment'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['fine'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['tracking-fee'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['total-payment'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['balance'] }}</th>
                                            <th class="bg-green-400 px-4 py-2"> </th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-2">
                                        <tr id="deposit-parent" class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">{{ $content_lang['deposit'] }}</td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2">
                                                <input type="hidden" id="ins_insdown_number" class="ins_insdown_number" value="0">
                                                <input type="hidden" class="ins_down_id" name="cus_st" value="{{ $cusdata->cus_st }}">
                                                <input id="deposit_date" name="deposit_date" type="text"
                                                    class="block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                    value="{{ $cusdata->deposit_date }}">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input id="bill_num_deposit" class="text-center h-8 w-full p-0 border-0"
                                                    type="text" name="bill_num_deposit" autofocus
                                                    value="{{ $cusdata->bill_num_deposit }}" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input id="deposit"
                                                    class="text-center h-8 w-full p-0 border-0 deposit-payment down-payment"
                                                    type="number" name="deposit" autofocus
                                                    value="{{ $cusdata->deposit }}" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0 down-fine"
                                                    type="number" readonly value="0" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0 down-trackingfee"
                                                    type="number" readonly value="0" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input
                                                    class="text-center h-8 w-full p-0 border-0 deposit-totalpayment down-totalpayment" readonly
                                                    type="number" autofocus value="{{ $cusdata->deposit }}" />
                                            </td>
                                            @if ($cusdata->deposit > 0)
                                                <td class="border text-green-500 px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-balance" readonly
                                                        type="number"
                                                        value="{{ intval($cusdata->deposit) - intval($cusdata->deposit) }}" />
                                                </td>
                                            @else
                                                <td class="border text-red-500 px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-balance" readonly
                                                        type="number"
                                                        value="{{ intval($cusdata->deposit) - intval($cusdata->deposit) }}" />
                                                </td>
                                            @endif

                                        </tr>
                                        <tr id="down-deli-parent" class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">{{ $content_lang['down-deli'] }}</td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2">
                                                <input type="hidden" id="ins_insdown_number" class="ins_insdown_number" value="0">
                                                <input type="hidden" class="ins_down_id">
                                                <input id="total_pay_deli_date" name="total_pay_deli_date" type="text"
                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                    value="{{ $cusdata->total_pay_deli_date }}">
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="bill_num_down_pay_deli" type="text"
                                                    name="bill_num_down_pay_deli"
                                                    value="{{ $cusdata->bill_num_down_pay_deli }}" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input
                                                    class="text-center h-8 w-full p-0 border-0 downdeli-payment  down-payment"
                                                    id="down_pay_deli" type="number" name="down_pay_deli"
                                                    value="{{ $cusdata->down_pay_deli }}" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0 down-fine"
                                                    type="number" readonly value="0" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0 down-trackingfee"
                                                    type="number" readonly value="0" />
                                            </td>
                                            <td class="border px-4 py-2">
                                                <x-input
                                                    class="text-center h-8 w-full p-0 border-0 downdeli-totalpayment down-totalpayment" readonly
                                                    type="number" value="{{ $cusdata->down_pay_deli }}" />
                                            </td>
                                            <td
                                                class="border @if ($cusdata->down_pay_deli > 1) text-red-500 @else text-green-500 @endif  px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0 down-balance"
                                                    type="number" readonly
                                                    value="{{ intval($cusdata->down_pay_deli) - intval($cusdata->down_pay_deli) }}" />
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @php
                                            $total_adddown = 0;
                                        @endphp
                                        @if ($adddownpays)
                                            @foreach ($adddownpays as $adddownpay)
                                            @php
                                                $total_adddown += $adddownpay->payment;
                                            @endphp
                                                <tr id="adddown-deli-parent" class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                    <td class="border px-4 py-2">{{ $content_lang['adddown'] }}</td>
                                                    <td class="border px-4 py-2"></td>
                                                    <td class="border px-4 py-2"></td>
                                                    <td class="border px-4 py-2">
                                                        <input type="hidden" id="ins_insdown_number" class="ins_insdown_number" value="0">
                                                        <input type="hidden" class="ins_down_id" name="adddown_id[]" value="{{$adddownpay->id}}">
                                                        <input id="{{$adddownpay->id}}" name="adddown_date[]" type="text"
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                            value="{{ $adddownpay->date }}">
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0"
                                                            id="{{$adddownpay->id}}" type="text"
                                                            name="adddown_billnumber[]"
                                                            value="{{ $adddownpay->bill_number }}" />
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <x-input
                                                            class="text-center h-8 w-full p-0 border-0 adddown-payment  down-payment"
                                                            id="{{$adddownpay->id}}" type="number" name="adddown_pay[]"
                                                            value="{{ $adddownpay->payment }}" />
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0 down-fine"
                                                            type="number" readonly value="0" />
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0 down-trackingfee"
                                                            type="number" readonly value="0" />
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <x-input
                                                            id="{{$adddownpay->id}}"
                                                            class="text-center h-8 w-full p-0 border-0 adddown-totalpayment down-totalpayment" readonly
                                                            type="number" value="{{ $adddownpay->payment }}" />
                                                    </td>
                                                    <td
                                                        class="border @if ($adddownpay->payment > 1) text-red-500 @else text-green-500 @endif  px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0 adddown-balance"
                                                            type="number" readonly id="{{$adddownpay->id}}"
                                                            value="{{ intval($adddownpay->payment) - intval($adddownpay->payment) }}" />
                                                    </td>
                                                    <td>
        
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        @endif
                                        @php
                                            $down_sum_payment = 0;
                                            $down_sum_fine = 0;
                                            $down_sum_tracking_fee = 0;
                                            $down_sum_total_payment = $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown;
                                            $down_sum_down_balance = 0;
                                            $count = 0;
                                            
                                        @endphp
                                        @foreach ($insdown as $ins_down)
                                        @php
                                            $count_ins_insdown = 0;
                                            $ins_insdown_balance = 0;
                                            $sum_ins_insdown_payment = 0;
                                            $sum_ins_insdown_fine = 0;
                                            $sum_ins_insdown_tracking_fee = 0;
                                            $sum_ins_insdown_totalpayment = 0;

                                            $havediscount = null;
                                        @endphp
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['payable-down'] }}
                                                    {{ $count + 1 }}</td>
                                                <td class="border px-4 py-2">
                                                    <input type="hidden" class="ins_down_id" id="ins_down_id[]"
                                                        name="ins_down_id[]" value="{{ $ins_down->id }}" />
                                                    <input id="down_appoint_date{{ $ins_down->id }}"
                                                        name="down_appoint_date[]" type="text"
                                                        class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                        value="{{ $ins_down->appoint_date }}">
                                                        @if ($ins_down->id)
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                    <button type="button" class="h-8 mt-1 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                    <button type="button" class="h-8 mt-1 hover:text-white deletedividinsdown" id="{{ $ins_insdown->id }}">{{$content_lang['del-divid'] }}</button><br>
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <button type="button" class="h-8 mt-1 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" class="ins_insdown_id" id="ins_insdown_id[]"
                                                                    name="ins_insdown_id[]" value="{{ $ins_insdown->id }}" />
                                                                <input type="hidden" class="ins_insdown_insid" id="ins_insdown_insid[]"
                                                                    name="ins_insdown_insid[]" value="{{ $ins_insdown->ins_id }}" />
                                                                @php
                                                                    $count_ins_insdown = $ins_insdown->ins_number;
                                                                    $ins_insdown_balance = $ins_insdown->balance;
                                                                    $sum_ins_insdown_payment += $ins_insdown->payment;
                                                                    $sum_ins_insdown_fine += $ins_insdown->fine;
                                                                    $sum_ins_insdown_tracking_fee += $ins_insdown->tracking_fee;
                                                                    $sum_ins_insdown_totalpayment += $ins_insdown->payment + $ins_insdown->fine + $ins_insdown->tracking_fee;
                                                                @endphp                                                     
                                                            @endif
                                                            @endforeach
                                                            
                                                            @if ($count_ins_insdown > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        <input type="hidden" id="{{ $ins_down->id }}" name="ins_insdown_number[]" class="ins_insdown_number" value="{{ $count_ins_insdown }}">
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0"
                                                        id="down_appoint_pay{{ $ins_down->id }}" type="number"
                                                        name="down_appoint_pay[]" value="{{ $ins_down->appoint_pay }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                    id="discount_text{{ $discount->id }}" type="text"
                                                                    name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                    @php
                                                                        $havediscount = $discount->id;
                                                                    @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input type="number" class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                id="{{$ins_down->id}}" name="ins_insdown_appoint_pay[]" 
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                value="{{ $ins_insdown->appoint_pay }}">
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                            <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                                id="discount_text{{ $discount->id }}" type="text"
                                                                                name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                                @php
                                                                                    $havediscount = $discount->id;
                                                                                @endphp
                                                                            @break
                                                                        @endif
                                                                    @endforeach        
                                                                @endif
                                                                                                             
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input id="{{ $ins_down->id }}" name="down_payment_date[]"
                                                        type="text"
                                                        class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input down-date"
                                                        value="{{ $ins_down->payment_date }}">
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="text"
                                                                    name="discount_date[]" value="{{ $discount->date }}" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_payment_date[]"
                                                                    type="text"
                                                                    class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center datepicker flatpickr-input down-date"
                                                                    value="{{ $ins_insdown->payment_date }}">   
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="text"
                                                                                name="discount_date[]" value="{{ $discount->date }}" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach    
                                                                @endif
                                                                                                                
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-billnumber"
                                                        id="{{ $ins_down->id }}" type="text" name="down_bill_number[]"
                                                        value="{{ $ins_down->bill_number }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="text"
                                                                    name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_bill_number[]"
                                                                type="text"
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center down-billnumber"
                                                                value="{{ $ins_insdown->bill_number }}">    
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="text"
                                                                                name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach  
                                                                @endif 
                                                                                                               
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-payment"
                                                        id="{{ $ins_down->id }}" type="number" name="down_payment[]"
                                                        value="{{ $ins_down->payment }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="number"
                                                                    name="discount[]" value="{{ $discount->discount }}" />
                                                                @break
                                                            @endif
                                                        @endforeach  
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_payment[]"
                                                                type="number" 
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center down-payment"
                                                                value="{{ $ins_insdown->payment }}">  
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="number"
                                                                                name="discount[]" value="{{ $discount->discount }}" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach  
                                                                @endif   
                                                                                                                
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-fine"
                                                        id="{{ $ins_down->id }}" type="number" name="down_fine[]"
                                                        value="{{ $ins_down->fine }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="number" readonly
                                                                    name="discount_fine[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach 
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_fine[]"
                                                                type="number"
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center down-fine"
                                                                value="{{ $ins_insdown->fine }}"> 
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="number" readonly
                                                                                name="discount_fine[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach 
                                                                @endif
                                                                                                                  
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-trackingfee"
                                                        id="{{ $ins_down->id }}" type="number"
                                                        name="down_tracking_fee[]"
                                                        value="{{ $ins_down->tracking_fee }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="number" readonly
                                                                    name="discount_tracking_fee[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach 
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_tracking_fee[]"
                                                                type="number"
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center down-trackingfee"
                                                                value="{{ $ins_insdown->tracking_fee }}">   
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="number" readonly
                                                                                name="discount_tracking_fee[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach  
                                                                @endif
                                                                                                                  
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                        @endif
                                                </td>
                                                @php
                                                    $down_total_payment = $ins_down->payment + $ins_down->fine + $ins_down->tracking_fee;
                                                    $down_balance = $ins_down->balance;
                                                    $down_sum_payment += $ins_down->payment + $sum_ins_insdown_payment;
                                                    $down_sum_fine += $ins_down->fine + $sum_ins_insdown_fine;
                                                    $down_sum_tracking_fee += $ins_down->tracking_fee + $sum_ins_insdown_tracking_fee;
                                                    $down_sum_total_payment += $down_total_payment + $sum_ins_insdown_totalpayment;
                                                    
                                                    
                                                @endphp
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-totalpayment"
                                                        id="{{ $ins_down->id }}" type="number"
                                                        name="down_total_payment[]" value="{{ $down_total_payment }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                    id="{{$ins_down->id}}" type="number" readonly
                                                                    name="discount_total[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                @php
                                                                    $ins_insdown_total = $ins_insdown->payment + $ins_insdown->fine + $ins_insdown->tracking_fee;
                                                                @endphp
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_total_payment[]"
                                                                type="number"
                                                                class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center down-totalpayment"
                                                                value="{{ $ins_insdown_total }}">   
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$ins_down->id}}" type="number" readonly
                                                                                name="discount_total[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach   
                                                                @endif
                                                                                                                
                                                            @endif
                                                        @endforeach
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center" value="{{ $content_lang['balance'].' :' }}">
                                                        @endif
                                                        
                                                </td>
                                                <td
                                                    class="border @if ($ins_down->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 down-balance"
                                                        id="{{ $ins_down->id }}" type="number" name="down_balance[]" readonly
                                                        value="{{ $ins_down->balance }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 down-balance @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                    id="{{$ins_down->id}}" type="number"
                                                                    name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                    @php
                                                                        $down_balance = $discount->balance;
                                                                    @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($ins_insdowns as $ins_insdown)
                                                            @if ($ins_insdown->ins_id == $ins_down->id)
                                                                <input id="{{$ins_down->id}}" name="ins_insdown_balance[]"
                                                                type="number"
                                                                class="block @if ($ins_insdown->balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                value="{{ $ins_insdown->balance }}">
                                                                @php
                                                                    
                                                                    $ins_insdown_balance = $ins_insdown->balance;
                                                                @endphp
                                                                @if ($ins_insdown->id)
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 down-balance @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                                id="{{$ins_down->id}}" type="number"
                                                                                name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                                @php
                                                                                    $ins_insdown_balance = $discount->balance;
                                                                                @endphp
                                                                            @break
                                                                        @endif
                                                                    @endforeach  
                                                                @endif                                        
                                                            @endif
                                                        @endforeach
                                                        @php
                                                            if($count_ins_insdown > 0){
                                                                $down_sum_down_balance += $ins_insdown_balance;
                                                            }else{
                                                                $down_sum_down_balance += $down_balance;
                                                            }
                                                        @endphp
                                                        @if ($count_ins_insdown > 0 )
                                                            <input readonly type="number" id="{{ $ins_down->id }}" 
                                                            class="block @if ($ins_insdown_balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md insdown-lastbalance text-center" 
                                                            value="{{ $ins_insdown_balance }}">
                                                            
                                                        @endif
                                                </td>
                                                <td>
                                                    @if (($down_balance > 0 && $count_ins_insdown == 0) || ($count_ins_insdown > 0 && $ins_insdown_balance > 0))
                                                        <button type="button" class="hover:text-white discount_insdown" id="{{ $ins_down->id }}">{{$content_lang['discount'] }}</button>
                                                    @endif
                                                    
                                                    @if (($count_ins_insdown > 0 && $ins_insdown_balance > 0) || ($count_ins_insdown == 0 && $down_balance > 0) && ($ins_down->payment || $ins_down->fine || $ins_down->tracking_fee || $havediscount)  )
                                                        <button type="button" class="hover:text-white divid_insdown" id="{{ $ins_down->id }}">{{ $content_lang['divid_ins'] }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $count++;
                                            @endphp
                                        @endforeach

                                        <tr class="border-0 font-bold">
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td
                                                class="@if ($down_sum_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="down_sum_payment"
                                                    type="text" name="down_sum_payment"
                                                    value="{{ number_format($down_sum_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown) }}" />
                                            </td>
                                            <td
                                                class="@if ($down_sum_fine > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="down_sum_fine"
                                                    type="text" name="down_sum_fine" value="{{ number_format($down_sum_fine) }}" />
                                            </td>
                                            <td
                                                class="@if ($down_sum_tracking_fee > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="down_sum_tracking_fee" type="text"
                                                    name="down_sum_tracking_fee"
                                                    value="{{ number_format($down_sum_tracking_fee) }}" />
                                            </td>
                                            <td
                                                class="@if ($down_sum_total_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="down_sum_total_payment" type="text"
                                                    name="down_sum_total_payment"
                                                    value="{{ number_format($down_sum_total_payment) }}" />
                                            </td>
                                            <td
                                                class="@if ($down_sum_down_balance > 0) text-red-500 @else text-green-500 @endif border-0  px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="down_sum_down_balance" type="text"
                                                    name="down_sum_down_balance"
                                                    value="{{ number_format($down_sum_down_balance) }}" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="insdown-endtable"></div>
                            </div>
                        </div>
                        <div class="my-1">
                            <div id="ins-container">
                                <table id="instable" class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                    <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                        <tr>
                                            <th colspan="13" class="px-4 py-2">
                                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                    {{ $content_lang['ins-down'] }}
                                                </h2>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['appoint-date'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['ins'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['principle'] }}</th>
                                            <th class="bg-orange-300 px-4 py-2">{{ $content_lang['interest'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['payment-date'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['bill-number'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['ins'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['fine'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['tracking-fee'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['total-payment'] }}</th>
                                            <th class="bg-green-400 px-4 py-2">{{ $content_lang['payable-balance'] }}</th>
                                            <th class="bg-green-400 px-4 py-2"> </th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-2">
                                        @php
                                            $inscount = 0;
                                            $sumins = 0;
                                            $sumprinciple = 0;
                                            $suminterest = 0;
                                            $sumpayment = 0;
                                            $sumfine = 0;
                                            $sumtracking_fee = 0;
                                            $sumtotalpayment = 0;
                                            $sumpayablebalance = 0;
                                            $all_count_ins_ins = [];
                                            $sumall_ins_ins_payment = [];
                                            $sumall_ins_ins_fine = [];
                                            $sumall_ins_ins_tracking_fee = [];
                                            $sumall_ins_ins_totalpayment = [];
                                            $sumall_ins_ins_balance = [];
                                            $payablebalance = [];
                                        @endphp
                                        @foreach ($ins as $insdata)
                                            @php
                                                $inscount++;
                                                $totalpayment = 0;
                                                
                                                $count_ins_ins = 0;
                                                $totalpayment = intval($insdata->payment) + intval($insdata->fine) + intval($insdata->tracking_fee);
                                                $sumins += intval($insdata->appoint_pay);
                                                $sumprinciple += intval($insdata->principle);
                                                $suminterest += intval($insdata->interest);
                                                $sumpayment += intval($insdata->payment);
                                                $sumfine += intval($insdata->fine);
                                                $sumtracking_fee += intval($insdata->tracking_fee);
                                                $sumtotalpayment += intval($totalpayment);
                                                $ins_ins_balance = 0;
                                                $sum_ins_ins_payment = 0;
                                                $sum_ins_ins_fine = 0;
                                                $sum_ins_ins_tracking_fee = 0;
                                                $sum_ins_ins_totalpayment = 0;

                                                $havediscount = null;
                                            @endphp
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">
                                                    {{ $content_lang['ins-num'] . ' ' . $inscount }}
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="hidden" id="{{ $insdata->id }}" class="ins_id" name="ins_id[]"
                                                        value="{{ $insdata->id }}" />
                                                    <input id="{{ $insdata->id }}" name="ins_appoint_date[]"
                                                        type="text"
                                                        class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                        value="{{ $insdata->appoint_date }}">
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            <button type="button" class="h-8 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <button type="button" class="h-8 hover:text-white deletedividins" id="{{ $ins_ins->id }}">{{$content_lang['del-divid'] }}</button><br>
                                                            <input type="hidden" class="ins_ins_id" id="{{ $insdata->id }}"
                                                                name="ins_ins_id[]" value="{{ $ins_ins->id }}" />
                                                            <input type="hidden" class="ins_ins_insid" id="{{ $insdata->id }}"
                                                                name="ins_ins_insid[]" value="{{ $ins_ins->ins_id }}" />
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                <button type="button" class="h-8 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                            @php
                                                                $count_ins_ins = $ins_ins->ins_number;
                                                                $ins_ins_balance = $ins_ins->balance;
                                                                $sum_ins_ins_payment += $ins_ins->payment;
                                                                $sum_ins_ins_fine += $ins_ins->fine;
                                                                $sum_ins_ins_tracking_fee += $ins_ins->tracking_fee;
                                                                $sum_ins_ins_totalpayment += $ins_ins->payment + $ins_ins->fine + $ins_ins->tracking_fee;
                                                            @endphp                                                        
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                    <input type="hidden" id="{{ $insdata->id }}" name="ins_ins_number[]" class="ins_ins_number" value="{{ $count_ins_ins }}">
                                                    @php
                                                        $all_count_ins_ins[] = $count_ins_ins;
                                                        $sumall_ins_ins_payment[] = $sum_ins_ins_payment;
                                                        $sumall_ins_ins_fine[] = $sum_ins_ins_fine;
                                                        $sumall_ins_ins_tracking_fee[] = $sum_ins_ins_tracking_fee;
                                                        $sumall_ins_ins_totalpayment[] = $sum_ins_ins_totalpayment;
                                                        
                                                    @endphp
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-app-pay"
                                                        id="{{ $insdata->id }}" type="number"
                                                        name="ins_appoint_pay[]" value="{{ $insdata->appoint_pay }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            
                                                            <input type="number" class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                            id="{{$insdata->id}}" name="ins_ins_appoint_pay[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                            value="{{ $ins_ins->appoint_pay }}">
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                    @break
                                                                @endif
                                                            @endforeach                                                     
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input
                                                        class="text-center h-8 w-full p-0 border-0 border-gray-300 rounded-md ins-principle"
                                                        id="{{ $insdata->id }}" type="number" name="ins_principle[]"
                                                        @if ($insdata->principle != '-') value="{{ $insdata->principle }}" @else value="0" @endif />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                @break
                                                            @endif
                                                        @endforeach 
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <input id="{{$insdata->id}}" name="ins_ins_principle[]"
                                                            type="text"
                                                            class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                            @if ($ins_ins->principle != '-') value="{{ $ins_ins->principle }}" @else value="0" @endif >   
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                    @break
                                                                @endif
                                                            @endforeach                                                    
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input
                                                        class="text-center h-8 w-full p-0 border-0 border-gray-300 rounded-md ins-interest"
                                                        id="{{ $insdata->id }}" type="number" name="ins_interest[]"
                                                        @if ($insdata->interest != '-') value="{{ $insdata->interest }}" @else value="0" @endif />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                    id="discount_text{{ $discount->id }}" type="text"
                                                                    name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                    @php
                                                                        $havediscount = $discount->id;
                                                                    @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <input id="{{$insdata->id}}" name="ins_ins_interest[]"
                                                            type="text"
                                                            class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                            @if ($ins_ins->interest != '-') value="{{ $ins_ins->interest }}" @else value="0" @endif >
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                    <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                        id="discount_text{{ $discount->id }}" type="text"
                                                                        name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                        @php
                                                                            $havediscount = $discount->id;
                                                                        @endphp
                                                                    @break
                                                                @endif
                                                            @endforeach                                                      
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input id="{{ $insdata->id }}" name="ins_payment_date[]"
                                                        type="text"
                                                        class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input ins-date"
                                                        value="{{ $insdata->payment_date }}">
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-date"
                                                                    id="{{ $insdata->id }}" type="text"
                                                                    name="discount_date[]" value="{{ $discount->date }}" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            
                                                            <input type="text"
                                                            id="{{$insdata->id}}" name="ins_ins_payment_date[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input ins-date"
                                                            value="{{ $ins_ins->payment_date }}"> 
                                                            @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-date"
                                                                    id="{{ $insdata->id }}" type="text"
                                                                    name="discount_date[]" value="{{ $discount->date }}" />
                                                                @break
                                                            @endif
                                                        @endforeach                                                    
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-billnumber"
                                                        id="{{ $insdata->id }}" type="text"
                                                        name="ins_bill_number[]" value="{{ $insdata->bill_number }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 discountins-billnumber"
                                                                    id="{{ $insdata->id }}" type="text"
                                                                    name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            
                                                            <input type="text"
                                                            id="{{$insdata->id}}" name="ins_ins_bill_number[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center ins-billnumber"
                                                            value="{{ $ins_ins->bill_number }}">   
                                                            @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-billnumber"
                                                                    id="{{ $insdata->id }}" type="text"
                                                                    name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                @break
                                                            @endif
                                                        @endforeach                                                  
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-payment"
                                                        id="{{ $insdata->id }}" type="number" name="ins_payment[]"
                                                        value="{{ $insdata->payment }}"  />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-payment"
                                                                    id="{{$insdata->id}}" type="number"
                                                                    name="discount[]" value="{{ $discount->discount }}" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            
                                                            <input type="number" 
                                                            id="{{$insdata->id}}" name="ins_ins_payment[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center ins-payment"
                                                            value="{{ $ins_ins->payment }}">  
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-payment"
                                                                        id="{{$insdata->id}}" type="number"
                                                                        name="discount[]" value="{{ $discount->discount }}" />
                                                                    @break
                                                                @endif
                                                            @endforeach                                                   
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-fine"
                                                        id="{{ $insdata->id }}" type="number" name="ins_fine[]"
                                                        value="{{ $insdata->fine }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-fine"
                                                                    id="{{$insdata->id}}" type="number" readonly
                                                                    name="discount_fine[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <input type="number"
                                                            id="{{$insdata->id}}" name="ins_ins_fine[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center"
                                                            value="{{ $ins_ins->fine }}"> 
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-fine"
                                                                        id="{{$insdata->id}}" type="number" readonly
                                                                        name="discount_fine[]" value="0" />
                                                                    @break
                                                                @endif
                                                            @endforeach                                                    
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-trackingfee"
                                                        id="{{ $insdata->id }}" type="number"
                                                        name="ins_tracking_fee[]"
                                                        value="{{ $insdata->tracking_fee }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-trackingfee"
                                                                    id="{{$insdata->id}}" type="number" readonly
                                                                    name="discount_tracking_fee[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach 
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <input type="number"
                                                            id="{{$insdata->id}}" name="ins_ins_tracking_fee[]" 
                                                            class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center"
                                                            value="{{ $ins_ins->tracking_fee }}">  
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-trackingfee"
                                                                        id="{{$insdata->id}}" type="number" readonly
                                                                        name="discount_tracking_fee[]" value="0" />
                                                                    @break
                                                                @endif
                                                            @endforeach                                                    
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                    @endif
                                                </td>
                                                @php
                                                    
                                                    
                                                @endphp
                                                <td class="border px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-totalpayment"
                                                        id="{{ $insdata->id }}" type="number" name="totalpayment[]"
                                                        value="{{ $totalpayment }}" />
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-totalpayment"
                                                                    id="{{$insdata->id}}" type="number" readonly
                                                                    name="discount_total[]" value="0" />
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            @php
                                                                $ins_ins_total = $ins_ins->payment + $ins_ins->fine + $ins_ins->tracking_fee;
                                                            @endphp
                                                            <input id="{{$insdata->id}}" name="ins_ins_total_payment[]"
                                                            type="number" 
                                                            class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center ins-totalpayment"
                                                            value="{{ $ins_ins_total }}"> 
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-totalpayment"
                                                                        id="{{$insdata->id}}" type="number" readonly
                                                                        name="discount_total[]" value="0" />
                                                                    @break
                                                                @endif
                                                            @endforeach                                                     
                                                        @endif
                                                    @endforeach
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center" value="{{ $content_lang['balance'].' :' }}">
                                                    @endif
                                                
                                                </td>
                                                @php
                                                    $insbalance = 0;
                                                @endphp
                                                <td
                                                    class="border @if ($insdata->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                    <x-input class="text-center h-8 w-full p-0 border-0 ins-payablebalance"
                                                        id="{{$insdata->id}}" type="number"
                                                        name="ins_payablebalance[]" value="{{ $insdata->balance }}" />
                                                        @php
                                                            $insbalance = $insdata->balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-payablebalance @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                    id="{{$insdata->id}}" type="number"
                                                                    name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                    @php
                                                                        $insbalance = $discount->balance;
                                                                    @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <input id="{{$insdata->id}}" name="ins_ins_balance[]"
                                                            type="number"
                                                            class="block @if ($ins_ins->balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                            value="{{ $ins_ins->balance }}">     
                                                            @php
                                                                $ins_ins_balance = $ins_ins->balance;
                                                            @endphp
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 ins-payablebalance @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                        id="{{$insdata->id}}" type="number"
                                                                        name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                        @php
                                                                            $ins_ins_balance = $discount->balance;
                                                                        @endphp
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                                                                             
                                                        @endif
                                                    @endforeach
                                                    @php
                                                        $payablebalance[] = $insbalance;
                                                        $sumall_ins_ins_balance[] = $ins_ins_balance;
                                                    @endphp
                                                    @if ($count_ins_ins > 0 )
                                                        <input readonly type="number" id="{{ $insdata->id }}" 
                                                        class="block @if ($ins_ins_balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md ins-lastbalance text-center" 
                                                        value="{{ $ins_ins_balance }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (($ins_ins_balance > 0 && $count_ins_ins > 0) || ($count_ins_ins == 0 && $payablebalance[$inscount-1] > 0))
                                                        <button type="button" class="hover:text-white discount_ins" id="{{ $insdata->id }}">{{$content_lang['discount'] }}</button>
                                                    @endif
                                                    @if (($count_ins_ins > 0 && $ins_ins_balance > 0) || ($count_ins_ins == 0 && $payablebalance[$inscount-1] > 0) && ($insdata->payment || $insdata->fine || $insdata->tracking_fee || $havediscount))
                                                        <button type="button" class="hover:text-white divid_ins" id="{{ $insdata->id }}">{{ $content_lang['divid_ins'] }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @php
                                            /* echo count($all_count_ins_ins);
                                            print_r($all_count_ins_ins);
                                            print_r($sumall_ins_ins_balance);
                                            print_r($sumall_ins_ins_payment);
                                            print_r($sumall_ins_ins_fine);
                                            print_r($sumall_ins_ins_tracking_fee);
                                            print_r($sumall_ins_ins_totalpayment); */
                                            for ($i=0; $i < count($all_count_ins_ins); $i++) { 
                                                if($all_count_ins_ins[$i] > 0){
                                                    $sumpayablebalance += $sumall_ins_ins_balance[$i];
                                                }else{
                                                    $sumpayablebalance += $payablebalance[$i];
                                                }
                                                $sumpayment += $sumall_ins_ins_payment[$i];
                                                $sumfine += $sumall_ins_ins_fine[$i];
                                                $sumtracking_fee += $sumall_ins_ins_tracking_fee[$i];
                                                $sumtotalpayment += $sumall_ins_ins_totalpayment[$i];
                                                //echo 'number : '.$i.' : '.$sumtotalpayment.'<br>';
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-300 even:bg-gray-100 font-bold">
                                            <td class="px-4 py-2"></td>
                                            <td class="px-4 py-2"></td>
                                            <td class="text-gray-500 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="ins_sumins"
                                                    type="text" name="ins_sumins"
                                                    value="{{ number_format($sumins) }}" />
                                            </td>
                                            <td class="text-gray-500 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="ins_sumprinciple"
                                                    type="text" name="ins_sumprinciple"
                                                    value="{{ number_format($sumprinciple) }}" />
                                            </td>
                                            <td class="text-gray-500 px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="ins_suminterest"
                                                    type="text" name="ins_suminterest"
                                                    value="{{ number_format($suminterest) }}" />
                                            </td>
                                            <td class="px-4 py-2"></td>
                                            <td class="font-bold px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                            <td
                                                class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="ins_sumpayment"
                                                    type="text" name="ins_sumpayment"
                                                    value="{{ number_format($sumpayment) }}" />
                                            </td>
                                            <td
                                                class="@if ($sumfine > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0" id="ins_sumfine"
                                                    type="text" name="ins_sumfine"
                                                    value="{{ number_format($sumfine) }}" />
                                            </td>
                                            <td
                                                class="@if ($sumtracking_fee > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="ins_sumtracking_fee" type="text" name="ins_sumtracking_fee"
                                                    value="{{ number_format($sumtracking_fee) }}" />
                                            </td>
                                            <td
                                                class="@if ($sumtotalpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="ins_sumtotalpayment" type="text" name="ins_sumtotalpayment"
                                                    value="{{ number_format($sumtotalpayment) }}" />
                                            </td>
                                            <td
                                                class="@if ($sumpayablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                <x-input class="text-center h-8 w-full p-0 border-0"
                                                    id="ins_sumpayablebalance" type="text"
                                                    name="ins_sumpayablebalance"
                                                    value="{{ number_format($sumpayablebalance) }}" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="ins-endtable"></div>
                            </div>
                        </div>
                       <div class="my-1">
                            <table class="w-1/2 table mb-2 table-auto border-2 text-center rounded-lg">
                                <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                    <tr>
                                        <th colspan="11" class="px-4 py-2">
                                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                {{ $content_lang['summarize'] }}
                                            </h2>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['payment'] }}</th>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['balance'] }}</th>
                                    </tr>
                                </thead>
                                @php
                                    $sumallfine = $down_sum_fine + $sumfine;
                                    $sumalltracking_fee = $down_sum_tracking_fee + $sumtracking_fee;
                                    $sumallpaymment = $down_sum_total_payment + $sumtotalpayment;
                                    $sumallbalance = $down_sum_down_balance + $sumpayablebalance;
                                @endphp
                                <tbody class="border-2">
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-down-pay'] }}</td>
                                        <td
                                            class="@if ($down_sum_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($down_sum_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddown) }}
                                        </td>
                                        <td
                                            class="@if ($down_sum_down_balance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                            {{ number_format($down_sum_down_balance) }}</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-ins-pay'] }}</td>
                                        <td
                                            class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($sumpayment) }}</td>
                                        <td
                                            class="@if ($sumpayablebalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                            {{ number_format($sumpayablebalance) }}</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-fine-pay'] }}</td>
                                        <td
                                            class="@if ($sumallfine > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($sumallfine) }}</td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-tracking-fee-pay'] }}
                                        </td>
                                        <td
                                            class="@if ($sumalltracking_fee > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($sumalltracking_fee) }}</td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-income'] }}</td>
                                        <td
                                            class="@if ($sumallpaymment > 0) text-green-500 @else text-red-500 @endif border text-green-400 px-4 py-2">
                                            {{ number_format($sumallpaymment) }}
                                        </td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-balance'] }}</td>
                                        <td
                                            class="@if ($sumallbalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                            {{ number_format($sumallbalance) }}</td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                </tbody>


                            </table>
                        </div>
                        @if(isset($subcarddata))
                            <div class="flex rounded-md drop-shadow-lg">
                                <div class="flex w-3/4 items-center p-2">
                                    <div class="w-full p-2 rounded-md mr-5">
                                        <div class="p-2">
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['table-name'] }}&nbsp;{{ $subcarddata->cus_name }}
                                                </div>
                                                <div>
                                                    {{ $content_lang['cus-code'] }}&nbsp;{{ $subcarddata->cus_code }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['car-model'] }}&nbsp;{{ $cardata->car_model }}
                                                </div>
                                                <div>
                                                    {{ $content_lang['deli-date'] }}&nbsp;{{ $subcarddata->deli_date }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['car-number'] }}&nbsp;{{ $cardata->car_number }}
                                                </div>
                                                <div>
                                                    @php
                                                    if(count($subcardinss)>0){
                                                        $count_ins = count($subcardinss);
                                                        $end_date = $subcardinss[count($subcardinss)-1]['appoint_date'];
                                                    }else{
                                                        $end_date = $subcarddata->deli_date;
                                                    }
                                                    @endphp
                                                    {{ $content_lang['end-date'] }} {{ $end_date }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['car-enginenumber'] }}&nbsp;{{ $cardata->engine_number }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['address'] }}&nbsp;{{ $subcarddata->cus_address . ' ' . $subcarddata->cus_group . ' ' . $subcarddata->cus_village . ' ' . $subcarddata->cus_city . ' ' . $subcarddata->cus_district }}
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xl my-1">
                                                <div>
                                                    {{ $content_lang['new-tel'] }}&nbsp;{{ $subcarddata->cus_tel }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(isset($subcardinss))
                                <div class="my-1">
                                    <div id="subins-container">
                                        <table id="subinstable" class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                            <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                                <tr>
                                                    <th colspan="13" class="px-4 py-2">
                                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                            {{ $content_lang['ins-down'] }}
                                                        </h2>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                                    <th class="bg-orange-300 px-4 py-2">{{ $content_lang['appoint-date'] }}</th>
                                                    <th class="bg-orange-300 px-4 py-2">{{ $content_lang['ins'] }}</th>
                                                    <th class="bg-orange-300 px-4 py-2">{{ $content_lang['principle'] }}</th>
                                                    <th class="bg-orange-300 px-4 py-2">{{ $content_lang['interest'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['payment-date'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['bill-number'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['ins'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['fine'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['tracking-fee'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['total-payment'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2">{{ $content_lang['payable-balance'] }}</th>
                                                    <th class="bg-green-400 px-4 py-2"> </th>
                                                </tr>
                                            </thead>
                                            <tbody class="border-2">
                                                @php
                                                    $inscount = 0;
                                                    $sumins = 0;
                                                    $sumprinciple = 0;
                                                    $suminterest = 0;
                                                    $sumpayment = 0;
                                                    $sumfine = 0;
                                                    $sumtracking_fee = 0;
                                                    $sumtotalpayment = 0;
                                                    $sumpayablebalance = 0;
                                                    $all_count_ins_ins = [];
                                                    $sumall_ins_ins_payment = [];
                                                    $sumall_ins_ins_fine = [];
                                                    $sumall_ins_ins_tracking_fee = [];
                                                    $sumall_ins_ins_totalpayment = [];
                                                    $sumall_ins_ins_balance = [];
                                                    $payablebalance = [];
                                                @endphp
                                                @foreach ($subcardinss as $subcardins)
                                                    @php
                                                        $inscount++;
                                                        $totalpayment = 0;
                                                        
                                                        $count_ins_ins = 0;
                                                        $totalpayment = intval($subcardins->payment) + intval($subcardins->fine) + intval($subcardins->tracking_fee);
                                                        $sumins += intval($subcardins->appoint_pay);
                                                        $sumprinciple += intval($subcardins->principle);
                                                        $suminterest += intval($subcardins->interest);
                                                        $sumpayment += intval($subcardins->payment);
                                                        $sumfine += intval($subcardins->fine);
                                                        $sumtracking_fee += intval($subcardins->tracking_fee);
                                                        $sumtotalpayment += intval($totalpayment);
                                                        $ins_ins_balance = 0;
                                                        $sum_ins_ins_payment = 0;
                                                        $sum_ins_ins_fine = 0;
                                                        $sum_ins_ins_tracking_fee = 0;
                                                        $sum_ins_ins_totalpayment = 0;

                                                        $havediscount = null;
                                                    @endphp
                                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                        <td class="border px-4 py-2">
                                                            {{ $content_lang['con-ins'] . ' ' . $subcardins->ins_number }}
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <input type="hidden" id="{{ $subcardins->id }}" class="subins_id" name="subins_id[]"
                                                                value="{{ $subcardins->id }}" />
                                                            <input id="{{ $subcardins->id }}" name="subins_appoint_date[]"
                                                                type="text"
                                                                class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input"
                                                                value="{{ $subcardins->appoint_date }}">
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                    <button type="button" class="h-8 mt-1 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <button type="button" class="h-8 mt-1 hover:text-white deletesubdividins" id="{{ $subcarddividins->id }}">{{$content_lang['del-divid'] }}</button><br>
                                                                
                                                                    <input type="hidden" class="subdividins_id" id="{{ $subcardins->id }}"
                                                                        name="subdividins_id[]" value="{{ $subcarddividins->id }}" />
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                        <button type="button" class="h-8 mt-1 hover:text-white deletediscount" id="{{ $discount->id }}">{{$content_lang['del-discount'] }}</button><br>
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                    @php
                                                                        $count_ins_ins = $subcarddividins->ins_number;
                                                                        $ins_ins_balance = $subcarddividins->balance;
                                                                        $sum_ins_ins_payment += $subcarddividins->payment;
                                                                        $sum_ins_ins_fine += $subcarddividins->fine;
                                                                        $sum_ins_ins_tracking_fee += $subcarddividins->tracking_fee;
                                                                        $sum_ins_ins_totalpayment += $subcarddividins->payment + $subcarddividins->fine + $subcarddividins->tracking_fee;
                                                                    @endphp                                                        
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                            <input type="hidden" id="{{ $subcardins->id }}" name="subdividins_number[]" class="subdividins_number" value="{{ $count_ins_ins }}">
                                                            @php
                                                                $all_count_ins_ins[] = $count_ins_ins;
                                                                $sumall_ins_ins_payment[] = $sum_ins_ins_payment;
                                                                $sumall_ins_ins_fine[] = $sum_ins_ins_fine;
                                                                $sumall_ins_ins_tracking_fee[] = $sum_ins_ins_tracking_fee;
                                                                $sumall_ins_ins_totalpayment[] = $sum_ins_ins_totalpayment;
                                                                
                                                            @endphp
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-app-pay"
                                                                id="{{ $subcardins->id }}" type="number"
                                                                name="subins_appoint_pay[]" value="{{ $subcardins->appoint_pay }}" />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    
                                                                    <input type="number" class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                    id="{{$subcardins->id}}" name="subdividins_appoint_pay[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                    value="{{ $subcarddividins->appoint_pay }}">
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                     
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <input
                                                                class="text-center h-8 w-full p-0 border-0 border-gray-300 rounded-md subins-principle"
                                                                id="{{ $subcardins->id }}" type="number" name="subins_principle[]"
                                                                @if ($subcardins->principle != '-') value="{{ $subcardins->principle }}" @else value="0" @endif />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                        @break
                                                                    @endif
                                                                @endforeach 
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <input id="{{$subcardins->id}}" name="subdividins_principle[]"
                                                                    type="text"
                                                                    class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                    @if ($subcarddividins->principle != '-') value="{{ $subcarddividins->principle }}" @else value="0" @endif >   
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                    
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <input
                                                                class="text-center h-8 w-full p-0 border-0 border-gray-300 rounded-md subins-interest"
                                                                id="{{ $subcardins->id }}" type="number" name="subins_interest[]"
                                                                @if ($subcardins->interest != '-') value="{{ $subcardins->interest }}" @else value="0" @endif />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                    <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                    <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                            id="discoun_text{{ $discount->id }}" type="text"
                                                                            name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                            @php
                                                                                $havediscount = $discount->id;
                                                                            @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <input id="{{$subcardins->id}}" name="subdivdins_interest[]"
                                                                    type="text"
                                                                    class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center"
                                                                    @if ($subcarddividins->interest != '-') value="{{ $subcarddividins->interest }}" @else value="0" @endif >
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id  && $discount->ins_type == "subins"))
                                                                            <input type="hidden" name="discount_id[]" value="{{$discount->id}}">
                                                                            <input type="hidden" name="discount_type[]" value="{{$discount->ins_type}}">
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300" readonly
                                                                                id="discount_text{{ $discount->id }}" type="text"
                                                                                name="discount_text[]" value="{{ $content_lang['discount'] }}" />
                                                                                @php
                                                                                    $havediscount = $discount->id;
                                                                                @endphp
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                      
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <input id="{{ $subcardins->id }}" name="subins_payment_date[]"
                                                                type="text"
                                                                class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input subins-date"
                                                                value="{{ $subcardins->payment_date }}">
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 subins-date"
                                                                            id="{{ $subcardins->id }}" type="text"
                                                                            name="discount_date[]" value="{{ $discount->date }}" />
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    
                                                                    <input type="text"
                                                                    id="{{$subcardins->id}}" name="subdividins_payment_date[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center datepicker flatpickr-input subins-date"
                                                                    value="{{ $subcarddividins->payment_date }}"> 
                                                                    @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 subins-date"
                                                                            id="{{ $subcardins->id }}" type="text"
                                                                            name="discount_date[]" value="{{ $discount->date }}" />
                                                                        @break
                                                                    @endif
                                                                @endforeach                                                    
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-billnumber"
                                                                id="{{ $subcardins->id }}" type="text"
                                                                name="subins_bill_number[]" value="{{ $subcardins->bill_number }}" />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 discountins-billnumber"
                                                                            id="{{ $subcardins->id }}" type="text"
                                                                            name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    
                                                                    <input type="text"
                                                                    id="{{$subcardins->id}}" name="subdividins_bill_number[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center subins-billnumber"
                                                                    value="{{ $subcarddividins->bill_number }}">   
                                                                    @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 discountins-billnumber"
                                                                            id="{{ $subcardins->id }}" type="text"
                                                                            name="discount_bill_number[]" value="{{ $discount->bill_number }}" />
                                                                        @break
                                                                    @endif
                                                                @endforeach                                                  
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-payment"
                                                                id="{{ $subcardins->id }}" type="number" name="subins_payment[]"
                                                                value="{{ $subcardins->payment }}"  />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                            id="{{$subcardins->id}}" type="number"
                                                                            name="discount[]" value="{{ $discount->discount }}" />
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    
                                                                    <input type="number" 
                                                                    id="{{$subcardins->id}}" name="subdividins_payment[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center subins-payment"
                                                                    value="{{ $subcarddividins->payment }}">  
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$subcardins->id}}" type="number"
                                                                                name="discount[]" value="{{ $discount->discount }}" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                   
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-fine"
                                                                id="{{ $subcardins->id }}" type="number" name="subins_fine[]"
                                                                value="{{ $subcardins->fine }}" />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                            id="{{$subcardins->id}}" type="number" readonly
                                                                            name="discount_fine[]" value="0" />
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <input type="number"
                                                                    id="{{$subcardins->id}}" name="subdividins_fine[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center subins-fine"
                                                                    value="{{ $subcarddividins->fine }}">
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$subcardins->id}}" type="number" readonly
                                                                                name="discount_fine[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                    
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-trackingfee"
                                                                id="{{ $subcardins->id }}" type="number"
                                                                name="subins_tracking_fee[]"
                                                                value="{{ $subcardins->tracking_fee }}" />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                            id="{{$subcardins->id}}" type="number" readonly
                                                                            name="discount_tracking_fee[]" value="0" />
                                                                        @break
                                                                    @endif
                                                                @endforeach 
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <input type="number"
                                                                    id="{{$subcardins->id}}" name="subdividins_tracking_fee[]" 
                                                                    class="block h-8 mt-1 w-full p-0 border-gray-300 rounded-md text-center subins-trackingfee"
                                                                    value="{{ $subcarddividins->tracking_fee }}">  
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$subcardins->id}}" type="number" readonly
                                                                                name="discount_tracking_fee[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                    
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center">
                                                            @endif
                                                        </td>
                                                        @php
                                                            
                                                            
                                                        @endphp
                                                        <td class="border px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-totalpayment"
                                                                id="{{ $subcardins->id }}" type="number" name="subtotalpayment[]"
                                                                value="{{ $totalpayment }}" />
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                            id="{{$subcardins->id}}" type="number" readonly
                                                                            name="discount_total[]" value="0" />
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    @php
                                                                        $ins_ins_total = $subcarddividins->payment + $subcarddividins->fine + $subcarddividins->tracking_fee;
                                                                    @endphp
                                                                    <input id="{{$subcardins->id}}" name="subdividins_total_payment[]"
                                                                    type="number" 
                                                                    class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center subins-totalpayment"
                                                                    value="{{ $ins_ins_total }}"> 
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300"
                                                                                id="{{$subcardins->id}}" type="number" readonly
                                                                                name="discount_total[]" value="0" />
                                                                            @break
                                                                        @endif
                                                                    @endforeach                                                     
                                                                @endif
                                                            @endforeach
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly class="block h-8 mt-1 w-full p-0 border-0 rounded-md text-center" value="{{ $content_lang['balance'].' :' }}">
                                                            @endif
                                                        
                                                        </td>
                                                        @php
                                                            $insbalance = 0;
                                                        @endphp
                                                        <td
                                                            class="border @if ($subcardins->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                            <x-input class="text-center h-8 w-full p-0 border-0 subins-payablebalance"
                                                                id="{{$subcardins->id}}" type="number"
                                                                name="subins_payablebalance[]" value="{{ $subcardins->balance }}" />
                                                                @php
                                                                    $insbalance = $subcardins->balance;
                                                                @endphp
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                        <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                            id="{{$subcardins->id}}" type="number"
                                                                            name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                            @php
                                                                                $insbalance = $discount->balance;
                                                                            @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @foreach ($subcarddividinss as $subcarddividins)
                                                                @if ($subcarddividins->ins_id == $subcardins->id)
                                                                    <input id="{{$subcardins->id}}" name="subdividins_balance[]"
                                                                    type="number"
                                                                    class="block @if ($subcarddividins->balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md text-center subins-payablebalance"
                                                                    value="{{ $subcarddividins->balance }}">     
                                                                    @php
                                                                        $ins_ins_balance = $subcarddividins->balance;
                                                                    @endphp
                                                                    @foreach ($discounts as $discount)
                                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                            <x-input class="text-center mt-1 h-8 w-full p-0 border-1 border-orange-300 @if ($discount->balance > 0) text-red-500 @else text-green-500 @endif"
                                                                                id="{{$subcardins->id}}" type="number"
                                                                                name="discount_balance[]" value="{{ $discount->balance }}" />
                                                                                @php
                                                                                    $ins_ins_balance = $discount->balance;
                                                                                @endphp
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                                                                    
                                                                @endif
                                                            @endforeach
                                                            @php
                                                                $payablebalance[] = $insbalance;
                                                                $sumall_ins_ins_balance[] = $ins_ins_balance;
                                                            @endphp
                                                            @if ($count_ins_ins > 0 )
                                                                <input readonly type="number" id="{{ $subcardins->id }}" 
                                                                class="block @if ($ins_ins_balance > 0) text-red-500 @else text-green-500 @endif h-8 mt-1 w-full p-0 border-0 rounded-md subins-lastbalance text-center" 
                                                                value="{{ $ins_ins_balance }}">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (($ins_ins_balance > 0 && $count_ins_ins > 0) || ($count_ins_ins == 0 && $payablebalance[$inscount-1] > 0))
                                                                <button type="button" class="hover:text-white discount_subins" id="{{ $subcardins->id }}">{{$content_lang['discount'] }}</button>
                                                            @endif
                                                            @if (($count_ins_ins > 0 && $ins_ins_balance > 0) || ($count_ins_ins == 0 && $payablebalance[$inscount-1] > 0) && ($subcardins->payment || $subcardins->fine || $subcardins->tracking_fee || $havediscount))
                                                                <button type="button" class="hover:text-white divid_subins" id="{{ $subcardins->id }}">{{ $content_lang['divid_ins'] }}</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @php
                                                    /* echo count($all_count_ins_ins);
                                                    print_r($all_count_ins_ins);
                                                    print_r($sumall_ins_ins_balance);
                                                    print_r($sumall_ins_ins_payment);
                                                    print_r($sumall_ins_ins_fine);
                                                    print_r($sumall_ins_ins_tracking_fee);
                                                    print_r($sumall_ins_ins_totalpayment); */
                                                    for ($i=0; $i < count($all_count_ins_ins); $i++) { 
                                                        if($all_count_ins_ins[$i] > 0){
                                                            $sumpayablebalance += $sumall_ins_ins_balance[$i];
                                                        }else{
                                                            $sumpayablebalance += $payablebalance[$i];
                                                        }
                                                        $sumpayment += $sumall_ins_ins_payment[$i];
                                                        $sumfine += $sumall_ins_ins_fine[$i];
                                                        $sumtracking_fee += $sumall_ins_ins_tracking_fee[$i];
                                                        $sumtotalpayment += $sumall_ins_ins_totalpayment[$i];
                                                        //echo 'number : '.$i.' : '.$sumtotalpayment.'<br>';
                                                    }
                                                @endphp
                                                <tr class="hover:bg-gray-300 even:bg-gray-100 font-bold">
                                                    <td class="px-4 py-2"></td>
                                                    <td class="px-4 py-2"></td>
                                                    <td class="text-gray-500 px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0" id="subins_sumins"
                                                            type="text" name="subins_sumins"
                                                            value="{{ number_format($sumins) }}" />
                                                    </td>
                                                    <td class="text-gray-500 px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0" id="subins_sumprinciple"
                                                            type="text" name="subins_sumprinciple"
                                                            value="{{ number_format($sumprinciple) }}" />
                                                    </td>
                                                    <td class="text-gray-500 px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0" id="subins_suminterest"
                                                            type="text" name="subins_suminterest"
                                                            value="{{ number_format($suminterest) }}" />
                                                    </td>
                                                    <td class="px-4 py-2"></td>
                                                    <td class="font-bold px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                                    <td
                                                        class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0" id="subins_sumpayment"
                                                            type="text" name="subins_sumpayment"
                                                            value="{{ number_format($sumpayment) }}" />
                                                    </td>
                                                    <td
                                                        class="@if ($sumfine > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0" id="subins_sumfine"
                                                            type="text" name="subins_sumfine"
                                                            value="{{ number_format($sumfine) }}" />
                                                    </td>
                                                    <td
                                                        class="@if ($sumtracking_fee > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0"
                                                            id="subins_sumtracking_fee" type="text" name="subins_sumtracking_fee"
                                                            value="{{ number_format($sumtracking_fee) }}" />
                                                    </td>
                                                    <td
                                                        class="@if ($sumtotalpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0"
                                                            id="subins_sumtotalpayment" type="text" name="subins_sumtotalpayment"
                                                            value="{{ number_format($sumtotalpayment) }}" />
                                                    </td>
                                                    <td
                                                        class="@if ($sumpayablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                        <x-input class="text-center h-8 w-full p-0 border-0"
                                                            id="subins_sumpayablebalance" type="text"
                                                            name="subins_sumpayablebalance"
                                                            value="{{ number_format($sumpayablebalance) }}" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div id="subins-endtable"></div>
                                    </div>
                                </div>
                                <div class="my-1">
                                    <table class="w-1/2 table mb-2 table-auto border-2 text-center rounded-lg">
                                        <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                            <tr>
                                                <th colspan="11" class="px-4 py-2">
                                                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                        {{ $content_lang['summarize'] }}
                                                    </h2>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                                <th class="bg-orange-300 px-4 py-2">{{ $content_lang['payment'] }}</th>
                                                <th class="bg-orange-300 px-4 py-2">{{ $content_lang['balance'] }}</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $sumallfine = $sumfine;
                                            $sumalltracking_fee = $sumtracking_fee;
                                            $sumallpaymment = $sumtotalpayment;
                                            $sumallbalance = $sumpayablebalance;
                                        @endphp
                                        <tbody class="border-2">
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-down-pay'] }}</td>
                                                <td
                                                    class="text-green-500 text-red-500 border px-4 py-2">
                                                    {{ number_format(0) }}
                                                </td>
                                                <td
                                                    class="text-green-500 border text-red-500 px-4 py-2">
                                                    {{ number_format(0) }}</td>
                                            </tr>
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-ins-pay'] }}</td>
                                                <td
                                                    class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                                    {{ number_format($sumpayment) }}</td>
                                                <td
                                                    class="@if ($sumpayablebalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                                    {{ number_format($sumpayablebalance) }}</td>
                                            </tr>
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-fine-pay'] }}</td>
                                                <td
                                                    class="@if ($sumallfine > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                                    {{ number_format($sumallfine) }}</td>
                                                <td class="border text-red-500 px-4 py-2">-</td>
                                            </tr>
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-tracking-fee-pay'] }}
                                                </td>
                                                <td
                                                    class="@if ($sumalltracking_fee > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                                    {{ number_format($sumalltracking_fee) }}</td>
                                                <td class="border text-red-500 px-4 py-2">-</td>
                                            </tr>
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-income'] }}</td>
                                                <td
                                                    class="@if ($sumallpaymment > 0) text-green-500 @else text-red-500 @endif border text-green-400 px-4 py-2">
                                                    {{ number_format($sumallpaymment) }}
                                                </td>
                                                <td class="border text-red-500 px-4 py-2">-</td>
                                            </tr>
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">{{ $content_lang['total-balance'] }}</td>
                                                <td
                                                    class="@if ($sumallbalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                                    {{ number_format($sumallbalance) }}</td>
                                                <td class="border text-red-500 px-4 py-2">-</td>
                                            </tr>
                                        </tbody>


                                    </table>
                                </div>
                            @endif
                        @endif
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
    
    <div id="modal-insinsdown" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['divid_ins_down'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closeinsdownModal()">X</button>
                </div>
            </div>
            <form method="POST" id="divid_insdown" action="{{ route('addinsinsdown') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="date_ins_insdown" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="ins_down_id_modal" type="hidden" name="ins_down_id_modal" />
                                <input id="ins_insdown_number_modal" type="hidden" name="ins_insdown_number_modal" />
                                <input id="ins_insdown_appoint_pay" type="hidden" name="ins_insdown_appoint_pay" />
                                <input id="date_ins_insdown" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="date_ins_insdown" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('date_ins_insdown') }}" />
                                @error('date_ins_insdown')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_payment" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_payment" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['payment'] }}"
                                    name="ins_insdown_payment" autofocus value="{{ old('ins_insdown_payment') }}" />
                                @error('ins_insdown_payment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_tracking" class="ml-1 w-fit"
                                    value="{{ $content_lang['tracking-fee'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_tracking" placeholder="{{ $content_lang['tracking-fee'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_insdown_tracking" autofocus
                                    value="{{ old('ins_insdown_tracking') }}" />
                                @error('ins_insdown_tracking')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_billnum" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_billnum" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="ins_insdown_billnum" autofocus value="{{ old('ins_insdown_billnum') }}" />
                                @error('ins_insdown_billnum')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_fine" class="ml-1 w-fit"
                                    value="{{ $content_lang['fine'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_fine" class="block h-8 mt-1 w-full border-gray-300 rounded-md"
                                    type="number" name="ins_insdown_fine" autofocus placeholder="{{ $content_lang['fine'] }}"
                                    value="{{ old('ins_insdown_fine') }}" />
                                @error('ins_insdown_fine')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_totalpayment" class="ml-1 w-fit"
                                    value="{{ $content_lang['total-payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_totalpayment" placeholder="{{ $content_lang['total-payment'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_insdown_totalpayment" autofocus
                                    value="{{ old('ins_insdown_totalpayment') }}" />
                                @error('ins_insdown_totalpayment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_insdown_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_insdown_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_insdown_balance" autofocus value="{{ old('ins_insdown_balance') }}" />
                                @error('ins_insdown_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-insins" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['divid_ins_ins'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closeinsModal()">X</button>
                </div>
            </div>
            <form method="POST" id="divid_ins" action="{{ route('addinsins') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="date_ins_ins" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="ins_ins_id_modal" type="hidden" name="ins_ins_id_modal" />
                                <input id="ins_ins_number_modal" type="hidden" name="ins_ins_number_modal" />
                                <input id="ins_ins_appoint_pay" type="hidden" name="ins_ins_appoint_pay" />
                                <input id="date_ins_ins" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="date_ins_ins" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('date_ins_ins') }}" />
                                @error('date_ins_ins')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_payment" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_payment" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['payment'] }}"
                                    name="ins_ins_payment" autofocus value="{{ old('ins_ins_payment') }}" />
                                @error('ins_ins_payment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_tracking" class="ml-1 w-fit"
                                    value="{{ $content_lang['tracking-fee'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_tracking" placeholder="{{ $content_lang['tracking-fee'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_ins_tracking" autofocus
                                    value="{{ old('ins_ins_tracking') }}" />
                                @error('ins_ins_tracking')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_billnum" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_billnum" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="ins_ins_billnum" autofocus value="{{ old('ins_ins_billnum') }}" />
                                @error('ins_ins_billnum')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_fine" class="ml-1 w-fit"
                                    value="{{ $content_lang['fine'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_fine" class="block h-8 mt-1 w-full border-gray-300 rounded-md"
                                    type="number" name="ins_ins_fine" autofocus placeholder="{{ $content_lang['fine'] }}"
                                    value="{{ old('ins_ins_fine') }}" />
                                @error('ins_ins_fine')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_totalpayment" class="ml-1 w-fit"
                                    value="{{ $content_lang['total-payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_totalpayment" placeholder="{{ $content_lang['total-payment'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_ins_totalpayment" autofocus
                                    value="{{ old('ins_ins_totalpayment') }}" />
                                @error('ins_ins_totalpayment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="ins_ins_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="ins_ins_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="ins_ins_balance" autofocus value="{{ old('ins_ins_balance') }}" />
                                @error('ins_ins_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-subins" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['divid_ins_ins'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closesubinsModal()">X</button>
                </div>
            </div>
            <form method="POST" id="divid_subins" action="{{ route('addsubins') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="date_subdividins" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="subdividins_id_modal" type="hidden" name="subdividins_id_modal" />
                                <input id="subdividins_number_modal" type="hidden" name="subdividins_number_modal" />
                                <input id="subdividins_appoint_pay" type="hidden" name="subdividins_appoint_pay" />
                                <input id="date_subdividins" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="date_subdividins" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('date_subdividins') }}" />
                                @error('date_ins_ins')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_payment" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_payment" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['payment'] }}"
                                    name="subdividins_payment" autofocus value="{{ old('subdividins_payment') }}" />
                                @error('subdividins_payment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_tracking" class="ml-1 w-fit"
                                    value="{{ $content_lang['tracking-fee'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_tracking" placeholder="{{ $content_lang['tracking-fee'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="subdividins_tracking" autofocus
                                    value="{{ old('subdividins_tracking') }}" />
                                @error('subdividins_tracking')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_billnum" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_billnum" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="subdividins_billnum" autofocus value="{{ old('subdividins_billnum') }}" />
                                @error('subdividins_billnum')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_fine" class="ml-1 w-fit"
                                    value="{{ $content_lang['fine'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_fine" class="block h-8 mt-1 w-full border-gray-300 rounded-md"
                                    type="number" name="subdividins_fine" autofocus placeholder="{{ $content_lang['fine'] }}"
                                    value="{{ old('ins_ins_fine') }}" />
                                @error('subdividins_fine')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_totalpayment" class="ml-1 w-fit"
                                    value="{{ $content_lang['total-payment'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_totalpayment" placeholder="{{ $content_lang['total-payment'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="subdividins_totalpayment" autofocus
                                    value="{{ old('subdividins_totalpayment') }}" />
                                @error('subdividins_totalpayment')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="subdividins_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="subdividins_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="subdividins_balance" autofocus value="{{ old('subdividins_balance') }}" />
                                @error('subdividins_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-discountdown" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['discount'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closediscountdownModal()">X</button>
                </div>
            </div>
            <form method="POST" id="discountdown" action="{{ route('discountdown') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountdown_date" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="ins_down_id_discountmodal" type="hidden" name="ins_down_id_discountmodal" />
                                <input id="ins_insdown_number_discountmodal" type="hidden" name="ins_insdown_number_discountmodal" />
                                <input id="ins_insdown_appoint_pay_discountmodal" type="hidden" name="ins_insdown_appoint_pay_discountmodal" />
                                <input id="discountdown_date" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="discountdown_date" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('discountdown_date') }}" />
                                @error('discountdown_date')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="dispcountdown_pay" class="ml-1 w-fit"
                                    value="{{ $content_lang['discount'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="dispcountdown_pay" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['discount'] }}"
                                    name="dispcountdown_pay" autofocus value="{{ old('dispcountdown_pay') }}" />
                                @error('dispcountdown_pay')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discount_bill" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discount_bill" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="discount_bill" autofocus value="{{ old('discount_bill') }}" />
                                @error('discount_bill')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountdown_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discountdown_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="discountdown_balance" autofocus value="{{ old('discountdown_balance') }}" />
                                @error('discountdown_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-discountins" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['discount'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closediscountinsModal()">X</button>
                </div>
            </div>
            <form method="POST" id="discountins" action="{{ route('discountins') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discount_date" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="ins_id_discountmodal" type="hidden" name="ins_id_discountmodal" />
                                <input id="ins_ins_number_discountmodal" type="hidden" name="ins_ins_number_discountmodal" />
                                <input id="ins_ins_appoint_pay_discountmodal" type="hidden" name="ins_ins_appoint_pay_discountmodal" />
                                <input id="discountins_date_modal" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="discountins_date_modal" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('discountins_date_modal') }}" />
                                @error('discountins_date_modal')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="dispcountins_pay" class="ml-1 w-fit"
                                    value="{{ $content_lang['discount'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="dispcountins_pay" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['discount'] }}"
                                    name="dispcountins_pay" autofocus value="{{ old('dispcountins_pay') }}" />
                                @error('dispcountins_pay')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountins_bill" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discountins_bill" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="discountins_bill" autofocus value="{{ old('discountins_bill') }}" />
                                @error('discountins_bill')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountins_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discountins_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="discountins_balance" autofocus value="{{ old('discountins_balance') }}" />
                                @error('discountins_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-discountsubins" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/2 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>{{ $content_lang['discount'] }}</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closediscountsubinsModal()">X</button>
                </div>
            </div>
            <form method="POST" id="discountsubins" action="{{ route('discountsubins') }}">
                @csrf
                <div class="flex p-4">
                    <div class="w-1/2">

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountsubins_date_modal" class="ml-1 w-fit"
                                    value="{{ $content_lang['payment-date'] }}" />
                            </div>
                            <div class="w-6/12">
                                <input id="cus_id" type="hidden" name="cus_id"
                                    value="{{ $cusdata->id }}" />
                                <input id="subins_id_discountmodal" type="hidden" name="subins_id_discountmodal" />
                                <input id="subdividins_number_discountmodal" type="hidden" name="subdividins_number_discountmodal" />
                                <input id="subdividins_appoint_pay_discountmodal" type="hidden" name="subdividins_appoint_pay_discountmodal" />
                                <input id="discountsubins_date_modal" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md datepicker flatpickr-input"
                                    type="text" name="discountsubins_date_modal" autofocus placeholder="{{ $content_lang['payment-date'] }}"
                                    value="{{ old('discountsubins_date_modal') }}" />
                                @error('discountsubins_date_modal')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="dispcountsubins_pay" class="ml-1 w-fit"
                                    value="{{ $content_lang['discount'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="dispcountsubins_pay" required
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number" placeholder="{{ $content_lang['discount'] }}"
                                    name="dispcountsubins_pay" autofocus value="{{ old('dispcountsubins_pay') }}" />
                                @error('dispcountsubins_pay')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>

                    </div>

                    <div class="w-1/2">
                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountsubins_bill" class="ml-1 w-fit"
                                    value="{{ $content_lang['bill-number'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discountsubins_bill" placeholder="{{ $content_lang['bill-number'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="text" required
                                    name="discountsubins_bill" autofocus value="{{ old('discountsubins_bill') }}" />
                                @error('discountsubins_bill')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full flex items-center mb-1">
                            <div class="w-3/12 mr-2">
                                <x-label for="discountsubins_balance" class="ml-1 w-fit"
                                    value="{{ $content_lang['balance'] }}" />
                            </div>
                            <div class="w-6/12 flex items-center">
                                <input id="discountsubins_balance" placeholder="{{ $content_lang['balance'] }}"
                                    class="block h-8 mt-1 w-full border-gray-300 rounded-md" type="number"
                                    name="discountsubins_balance" autofocus value="{{ old('discountsubins_balance') }}" />
                                @error('discountsubins_balance')
                                    <div class="p-2 mt-1 text-sm text-red-500 rounded-lg bg-red-100" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="w-fit text-right">
                                <x-label class="ml-2 w-fit" value="{{ $content_lang['unit'] }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pr-4 pb-4">
                    <button type="submit"
                        class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>

<script>
    var calender = JSON.parse('<?php echo $calender; ?>');
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
        $('input[name="ins_insdown_payment"]').on('input', function() {
            calinsdownmodal();
        });
        $('input[name="appoint_pay_ins_insdown"]').on('input', function() {
            calinsdownmodal();
        });
        $('input[name="ins_insdown_fine"]').on('input', function() {
            calinsdownmodal();
        });
        $('input[name="ins_insdown_tracking"]').on('input', function() {
            calinsdownmodal();
        });
        $('input[name="ins_insdown_totalpayment"]').on('input', function() {
            calinsdownmodal();
        });
        $('input[name="ins_insdown_balance"]').on('input', function() {
            calinsdownmodal();
        });

        $('input[name="ins_ins_payment"]').on('input', function() {
            calinsmodal();
        });
        $('input[name="appoint_pay_ins_ins"]').on('input', function() {
            calinsmodal();
        });
        $('input[name="ins_ins_fine"]').on('input', function() {
            calinsmodal();
        });
        $('input[name="ins_ins_tracking"]').on('input', function() {
            calinsmodal();
        });
        $('input[name="ins_ins_totalpayment"]').on('input', function() {
            calinsmodal();
        });
        $('input[name="ins_ins_balance"]').on('input', function() {
            calinsmodal();
        });

        $('input[name="subdividins_payment"]').on('input', function() {
            calsubinsmodal();
        });
        $('input[name="subdividins_fine"]').on('input', function() {
            calsubinsmodal();
        });
        $('input[name="subdividins_tracking"]').on('input', function() {
            calsubinsmodal();
        });
        $('input[name="subdividins_totalpayment"]').on('input', function() {
            calsubinsmodal();
        });
        $('input[name="subdividins_balance"]').on('input', function() {
            calsubinsmodal();
        });

        $('input[name="dispcountdown_pay"]').on('input', function() {
            caldiscountdownmodal();
        });

        $('input[name="dispcountins_pay"]').on('input', function() {
            caldiscountinsmodal();
        });

        $('input[name="dispcountsubins_pay"]').on('input', function() {
            caldiscountsubinsmodal();
        });

        function moveScroll(){
            var scroll = $(window).scrollTop();
            var insdown_top = $("#insdowntable").offset().top;
            var insdown_endtable = $("#insdown-endtable").offset().top;
            var ins_top = $("#instable").offset().top;
            var ins_endtable = $("#ins-endtable").offset().top;
            var subins_top = $("#subinstable").offset().top;
            var subins_endtable = $("#subins-endtable").offset().top;
            if (scroll>ins_endtable || scroll<insdown_top){
                 $("#clone").remove();
            }
            if (scroll>insdown_top && scroll<insdown_endtable) {
                $("#clone").remove();
                clone_table = $("#clone");
                if(clone_table.length == 0){
                    clone_table = $("#insdowntable").clone();
                    clone_table.attr('id', 'clone');
                    clone_table.css({position:'fixed',
                            'pointer-events': 'none',
                            top:0});
                    clone_table.width($("#insdowntable").width());
                    $("#insdown-container").append(clone_table);
                    $("#clone").css({visibility:'hidden'});
                    $("#clone thead").css({visibility:'visible'});
                }
            } else if (scroll>ins_top && scroll<insdown_endtable){
                $("#clone").remove();
                if (scroll>ins_top && scroll<ins_endtable) {
                    clone_table = $("#clone");
                    if(clone_table.length == 0){
                        clone_table = $("#instable").clone();
                        clone_table.attr('id', 'clone');
                        clone_table.css({position:'fixed',
                                'pointer-events': 'none',
                                top:0});
                        clone_table.width($("#instable").width());
                        $("#ins-container").append(clone_table);
                        $("#clone").css({visibility:'hidden'});
                        $("#clone thead").css({visibility:'visible'});
                    }
                } else {
                    $("#clone").remove();
                }
            }else if (scroll>ins_endtable && scroll>subins_top && scroll<subins_endtable){
                $("#clone").remove();
                if (scroll>subins_top && scroll<subins_endtable) {
                    clone_table = $("#clone");
                    if(clone_table.length == 0){
                        clone_table = $("#subinstable").clone();
                        clone_table.attr('id', 'clone');
                        clone_table.css({position:'fixed',
                                'pointer-events': 'none',
                                top:0});
                        clone_table.width($("#subinstable").width());
                        $("#subins-container").append(clone_table);
                        $("#clone").css({visibility:'hidden'});
                        $("#clone thead").css({visibility:'visible'});
                    }
                } else {
                    $("#clone").remove();
                }
            }
            
        }
        $(window).scroll(moveScroll);

        $('.deposit-payment').on('input', function() {
            let newValue = $(this).val();
            let deposit_input = $('.deposit-totalpayment');
            deposit_input.val(newValue);

            calnewalldown(this.id);
        });

        $('.downdeli-payment').on('input', function() {
            let newValue = $(this).val();
            let deli_input = $('.downdeli-totalpayment');
            deli_input.val(newValue);
            calnewalldown(this.id);
        });

        $('.adddown-payment').on('input', function() {
            let newValue = $(this).val();
            let adddown_total = $('.adddown-totalpayment');
            console.log(this.id);
            console.log(adddown_total.length);
            for (let i = 0; i < adddown_total.length; i++) {
                console.log(adddown_total[i].id);
                if(adddown_total[i].id == this.id){
                    adddown_total[i].value = newValue;
                    break;
                }
            }
            calnewalldown(this.id);
        });

        $('.divid_insdown').on('click', function() {
            let ins_down_id = $('.ins_down_id');
            let down_payment = $('.down-payment');
            let down_fine = $('.down-fine');
            let down_trackingfee = $('.down-trackingfee');
            let down_totalpayment = $('.down-totalpayment');
            let down_balance_input = $('.down-balance');
            let ins_insdown_number = $('.ins_insdown_number');
            let ins_insdown_lastbalance = $('.insdown-lastbalance');
            let down_balance = 0;
            let numberIndex = null;
            for (let i = 0; i < down_payment.length; i++) {
                if (down_payment[i].id == this.id && down_payment[i].value) {
                    //console.log(ins_insdown_lastbalance.length);
                    for (let k = 0; k < ins_insdown_lastbalance.length; k++) {
                        if(ins_insdown_lastbalance[k].id == this.id){
                            console.log(ins_insdown_lastbalance[k].id);
                            down_balance = ins_insdown_lastbalance[k].value;
                            break;
                        }
                    }
                    console.log(down_balance_input);
                    if(down_balance == 0){
                        for (let l = 0; l < down_balance_input.length; l++) {
                            if(down_balance_input[l].id == this.id){
                                down_balance = down_balance_input[l].value;
                            }
                        }
                    }
                    
                    for (let j = 0; j < ins_insdown_number.length; j++) {
                        if(ins_insdown_number[j].id == this.id){
                            numberIndex = ins_insdown_number[j].value;
                            break;
                        }
                        
                    }
                }
            }
            console.log(down_balance);
            createinsinsdown(this.id,down_balance ,numberIndex);
        });

        $('.discount_insdown').on('click', function() {
            let ins_down_id = $('.ins_down_id');
            let down_date_input = $('.down-date');
            let down_payment = $('.down-payment');
            let down_billnumber_input = $('.down-billnumber');
            let down_balance_input = $('.down-balance');
            let ins_insdown_number = $('.ins_insdown_number');
            let ins_insdown_lastbalance = $('.insdown-lastbalance');
            let down_date = '';
            let down_billnumber = '';
            let down_balance = 0;
            let numberIndex = null;
            for (let i = 0; i < down_payment.length; i++) {
                if (down_payment[i].id == this.id && down_payment[i].value) {
                    //console.log(ins_insdown_lastbalance.length);
                    for (let k = 0; k < ins_insdown_lastbalance.length; k++) {
                        if(ins_insdown_lastbalance[k].id == this.id){
                            console.log(ins_insdown_lastbalance[k].id);
                            down_balance = ins_insdown_lastbalance[k].value;
                            break;
                        }
                    }
                    if(down_balance == 0){
                        for (let l = 0; l < down_balance_input.length; l++) {
                            if(down_balance_input[l].id == this.id){
                                down_balance = down_balance_input[l].value;
                            }
                        }
                    }
                    
                    for (let j = 0; j < ins_insdown_number.length; j++) {
                        if(ins_insdown_number[j].id == this.id){
                            numberIndex = ins_insdown_number[j].value;
                            break;
                        }
                        
                    }

                    for (let j = 0; j < down_date_input.length; j++) {
                        if(down_date_input[j].id == this.id){
                            down_date = down_date_input[j].value;
                            break;
                        }
                        
                    }
                    for (let j = 0; j < down_billnumber_input.length; j++) {
                        if(down_billnumber_input[j].id == this.id){
                            down_billnumber = down_billnumber_input[j].value;
                            break;
                        }
                        
                    }
                    
                }
            }
            creatediscountdown(this.id,down_balance ,numberIndex,down_date,down_billnumber);
        });

        $('.divid_ins').on('click', function() {
            let ins_id = $('.ins_id');
            let ins_payment = $('.ins-payment');
            let ins_fine = $('.ins-fine');
            let ins_trackingfee = $('.ins-trackingfee');
            let ins_totalpayment = $('.ins-totalpayment');
            let ins_balance_input = $('.ins-payablebalance');
            let ins_ins_number = $('.ins_ins_number');
            let ins_ins_lastbalance = $('.ins-lastbalance');
            let ins_balance = 0;
            let numberIndex = null;

            for (let i = 0; i < ins_payment.length; i++) {
                if (ins_payment[i].id == this.id && ins_payment[i].value) {
                    for (let k = 0; k < ins_ins_lastbalance.length; k++) {
                        if(ins_ins_lastbalance[k].id == this.id){
                            ins_balance = ins_ins_lastbalance[k].value;
                            break;
                        }
                    }
                    if(ins_balance == 0){
                        for (let l = 0; l < ins_balance_input.length; l++) {
                            if(ins_balance_input[l].id == this.id){
                                ins_balance = ins_balance_input[l].value;
                            }
                        }
                    }
                    for (let j = 0; j < ins_ins_number.length; j++) {
                        //console.log(ins_ins_number[j].id);
                        if(ins_ins_number[j].id == this.id){
                            numberIndex = ins_ins_number[j].value;
                            break;
                        }
                        
                    }
                }
            }
            createinsins(this.id,ins_balance ,numberIndex);
        });

        $('.divid_subins').on('click', function() {
            let subdividins_id = $('.subins_id');
            let subdividins_payment = $('.subins-payment');
            let subdividins_fine = $('.subins-fine');
            let subdividins_trackingfee = $('.subins-trackingfee');
            let subdividins_totalpayment = $('.subins-totalpayment');
            let subdividins_balance_input = $('.subins-payablebalance');
            let subdividins_number = $('.subdividins_number');
            let subdividins_lastbalance = $('.subins-lastbalance');
            let subdividins_balance = 0;
            let numberIndex = null;

            for (let i = 0; i < subdividins_payment.length; i++) {
                if (subdividins_payment[i].id == this.id && subdividins_payment[i].value) {
                    for (let k = 0; k < subdividins_lastbalance.length; k++) {
                        if(subdividins_lastbalance[k].id == this.id){
                            subdividins_balance = subdividins_lastbalance[k].value;
                            break;
                        }
                    }
                    if(subdividins_balance == 0){
                        for (let l = 0; l < subdividins_balance_input.length; l++) {
                            if(subdividins_balance_input[l].id == this.id){
                                subdividins_balance = subdividins_balance_input[l].value;
                            }
                        }
                    }
                    for (let j = 0; j < subdividins_number.length; j++) {
                        //console.log(subdividins_number[j].id);
                        if(subdividins_number[j].id == this.id){
                            numberIndex = subdividins_number[j].value;
                            break;
                        }
                        
                    }
                }
            }
            createsubdividins(this.id,subdividins_balance ,numberIndex);
        });

        $('.discount_ins').on('click', function() {
            let ins_id = $('.ins_id');
            let subins_id =$('.ins_ins_id');
            let ins_date_input = $('.ins-date');
            let down_payment = $('.ins-payment');
            let ins_billnumber_input = $('.ins-billnumber');
            let ins_balance_input = $('.ins-payablebalance ');
            let ins_ins_number = $('.ins_ins_number');
            let ins_ins_lastbalance = $('.ins-lastbalance');
            let ins_date = '';
            let ins_billnumber = '';
            let ins_balance = 0;
            let numberIndex = null;
            for (let i = 0; i < down_payment.length; i++) {
                
                if (down_payment[i].id == this.id && down_payment[i].value) {
                    for (let k = 0; k < ins_ins_lastbalance.length; k++) {
                        if(ins_ins_lastbalance[k].id == this.id){
                            ins_balance = ins_ins_lastbalance[k].value;
                            break;
                        }
                    }
                    if(ins_balance == 0){
                        for (let l = 0; l < ins_balance_input.length; l++) {
                            if(ins_balance_input[l].id == this.id){
                                ins_balance = ins_balance_input[l].value;
                            }
                        }
                    }
                    
                    for (let j = 0; j < ins_ins_number.length; j++) {
                        if(ins_ins_number[j].id == this.id){
                            numberIndex = ins_ins_number[j].value;
                            break;
                        }
                        
                    }

                    for (let j = 0; j < ins_date_input.length; j++) {
                        if(ins_date_input[j].id == this.id){
                            ins_date = ins_date_input[j].value;
                            break;
                        }
                        
                    }
                    for (let j = 0; j < ins_billnumber_input.length; j++) {
                        if(ins_billnumber_input[j].id == this.id){
                            ins_billnumber = ins_billnumber_input[j].value;
                            break;
                        }
                        
                    }
                    
                }
            }
            creatediscountins(this.id,ins_balance ,numberIndex,ins_date,ins_billnumber);
        });

        $('.discount_subins').on('click', function() {
            let subins_id = $('.subins_id');
            let subdividins_id =$('.subdividins_id');
            let subins_date_input = $('.subins-date');
            let subins_payment = $('.subins-payment');
            let subins_billnumber_input = $('.subins-billnumber');
            let subins_balance_input = $('.subins-payablebalance ');
            let subdividins_number = $('.subdividins_number');
            let subdividins_lastbalance = $('.subins-lastbalance');
            let subins_date = '';
            let subins_billnumber = '';
            let subins_balance = 0;
            let numberIndex = null;
            for (let i = 0; i < subins_payment.length; i++) {
                
                if (subins_payment[i].id == this.id && subins_payment[i].value) {
                    for (let k = 0; k < subdividins_lastbalance.length; k++) {
                        if(subdividins_lastbalance[k].id == this.id){
                            subins_balance = subdividins_lastbalance[k].value;
                            break;
                        }
                    }
                    if(subins_balance == 0){
                        for (let l = 0; l < subins_balance_input.length; l++) {
                            if(subins_balance_input[l].id == this.id){
                                subins_balance = subins_balance_input[l].value;
                            }
                        }
                    }
                    
                    for (let j = 0; j < subdividins_number.length; j++) {
                        if(subdividins_number[j].id == this.id){
                            numberIndex = subdividins_number[j].value;
                            break;
                        }
                        
                    }

                    for (let j = 0; j < subins_date_input.length; j++) {
                        if(subins_date_input[j].id == this.id){
                            subins_date = subins_date_input[j].value;
                            break;
                        }
                        
                    }
                    for (let j = 0; j < subins_billnumber_input.length; j++) {
                        if(subins_billnumber_input[j].id == this.id){
                            subins_billnumber = subins_billnumber_input[j].value;
                            break;
                        }
                        
                    }
                    
                }
            }
            creatediscountsubins(this.id,subins_balance ,numberIndex,subins_date,subins_billnumber);
        });

        $('input[name="down_payment[]"]').on('input', function() {
            let newValue = $(this).val();
            let down_appoint_pay = $('input[name="down_appoint_pay[]"]');
            let down_payment_input = $('input[name="down_payment[]"]');
            let down_fine_input = $('input[name="down_fine[]"]');
            let down_tracking_fee_input = $('input[name="down_tracking_fee[]"]');
            let down_total_payment_input = $('input[name="down_total_payment[]"]');
            let down_balance_input = $('input[name="down_balance[]"]');

            let ins_insdown_appoint_pay = $('input[name="ins_insdown_appoint_pay[]"]');
            let ins_insdown_payment = $('input[name="ins_insdown_payment[]"]');
            let ins_insdown_fine = $('input[name="ins_insdown_fine[]"]');
            let ins_insdown_tracking_fee = $('input[name="ins_insdown_tracking_fee[]"]');
            let ins_insdown_total_payment = $('input[name="ins_insdown_total_payment[]"]');
            let ins_insdown_balance = $('input[name="ins_insdown_balance[]"]');
            let ins_insdown_lastbalance = $('.insdown-lastbalance');
            
            for (let i = 0; i < down_payment_input.length; i++) {
                if (down_balance_input[i].id == this.id) {
                    let totalpay = parseInt(newValue) + parseInt(down_fine_input[i].value) + parseInt(
                        down_tracking_fee_input[i].value);
                    down_total_payment_input[i].value = totalpay;
                    down_balance_input[i].value = parseInt(down_appoint_pay[i].value) - parseInt(
                        down_payment_input[i].value);

                    /* for (let k = 0; k < ins_insdown_appoint_pay.length; k++) {
                        if(ins_insdown_appoint_pay[k].id == down_payment_input[i].id){
                            console.log(ins_insdown_appoint_pay[k]);
                            console.log(ins_insdown_payment[k]);
                            console.log(ins_insdown_fine[k]);
                            console.log(ins_insdown_tracking_fee[k]);
                            console.log(ins_insdown_total_payment[k]);
                            console.log(ins_insdown_balance[k]);
                        }
                    }
                    for (let j = 0; j < ins_insdown_lastbalance.length; j++) {
                        if(ins_insdown_lastbalance[j].id == down_payment_input[i].id){
                            console.log(ins_insdown_lastbalance[j]);
                        }
                    } */
                    break;
                }
            }
            calnewalldown(this.id);
        });

        $('input[name="down_fine[]"]').on('input', function() {
            let newValue = $(this).val();
            let down_appoint_pay = $('input[name="down_appoint_pay[]"]');
            let down_payment_input = $('input[name="down_payment[]"]');
            let down_fine_input = $('input[name="down_fine[]"]');
            let down_tracking_fee_input = $('input[name="down_tracking_fee[]"]');
            let down_total_payment_input = $('input[name="down_total_payment[]"]');
            let down_balance_input = $('input[name="down_balance[]"]');
            for (let i = 0; i < down_payment_input.length; i++) {
                if (down_total_payment_input[i].id == this.id) {
                    let totalpay = parseInt(down_payment_input[i].value) + parseInt(newValue) +
                        parseInt(down_tracking_fee_input[i].value);
                    down_total_payment_input[i].value = totalpay;
                    down_balance_input[i].value = parseInt(down_appoint_pay[i].value) - parseInt(
                        down_payment_input[i].value);
                    break;
                }
            }
            calnewalldown(this.id);
        });

        $('input[name="down_tracking_fee[]"]').on('input', function() {
            let newValue = $(this).val();
            let down_appoint_pay = $('input[name="down_appoint_pay[]"]');
            let down_payment_input = $('input[name="down_payment[]"]');
            let down_fine_input = $('input[name="down_fine[]"]');
            let down_tracking_fee_input = $('input[name="down_tracking_fee[]"]');
            let down_total_payment_input = $('input[name="down_total_payment[]"]');
            let down_balance_input = $('input[name="down_balance[]"]');
            for (let i = 0; i < down_payment_input.length; i++) {
                if (down_total_payment_input[i].id == this.id) {
                    let totalpay = parseInt(down_payment_input[i].value) + parseInt(down_fine_input[i]
                        .value) + parseInt(newValue);
                    down_total_payment_input[i].value = totalpay;
                    down_balance_input[i].value = parseInt(down_appoint_pay[i].value) - parseInt(
                        down_payment_input[i].value);
                    break;
                }
            }
            calnewalldown(this.id);
        });

        $('input[name="ins_payment[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="ins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="ins_payment[]"]');
            let ins_fine_input = $('input[name="ins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="ins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="totalpayment[]"]');
            let ins_balance_input = $('input[name="ins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(newValue) + parseInt(ins_fine_input[i].value) + parseInt(
                        ins_tracking_fee_input[i].value);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallins();
        });

        

        $('input[name="ins_fine[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="ins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="ins_payment[]"]');
            let ins_fine_input = $('input[name="ins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="ins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="totalpayment[]"]');
            let ins_balance_input = $('input[name="ins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(ins_payment_input[i].value) + parseInt(newValue) + parseInt(
                        ins_tracking_fee_input[i].value);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallins();
        });

        $('input[name="ins_tracking_fee[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="ins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="ins_payment[]"]');
            let ins_fine_input = $('input[name="ins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="ins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="totalpayment[]"]');
            let ins_balance_input = $('input[name="ins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(ins_payment_input[i].value) + parseInt(ins_fine_input[i]
                        .value) + parseInt(newValue);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallins();
        });
        
        $('input[name="subins_payment[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="subins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="subins_payment[]"]');
            let ins_fine_input = $('input[name="subins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="subins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="subtotalpayment[]"]');
            let ins_balance_input = $('input[name="subins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(newValue) + parseInt(ins_fine_input[i].value) + parseInt(
                        ins_tracking_fee_input[i].value);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallsubins();
        });

        $('input[name="subins_fine[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="subins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="subins_payment[]"]');
            let ins_fine_input = $('input[name="subins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="subins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="subtotalpayment[]"]');
            let ins_balance_input = $('input[name="subins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(newValue) + parseInt(ins_fine_input[i].value) + parseInt(
                        ins_tracking_fee_input[i].value);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallsubins();
        });

        $('input[name="subins_tracking_fee[]"]').on('input', function() {
            let newValue = $(this).val();
            let ins_appoint_pay = $('input[name="subins_appoint_pay[]"]');
            let ins_payment_input = $('input[name="subins_payment[]"]');
            let ins_fine_input = $('input[name="subins_fine[]"]');
            let ins_tracking_fee_input = $('input[name="subins_tracking_fee[]"]');
            let ins_total_payment_input = $('input[name="subtotalpayment[]"]');
            let ins_balance_input = $('input[name="subins_payablebalance[]"]');
            for (let i = 0; i < ins_payment_input.length; i++) {
                if (ins_fine_input[i].id == this.id) {
                    let totalpay = parseInt(newValue) + parseInt(ins_fine_input[i].value) + parseInt(
                        ins_tracking_fee_input[i].value);
                    ins_total_payment_input[i].value = totalpay;
                    ins_balance_input[i].value = parseInt(ins_appoint_pay[i].value) - parseInt(
                        ins_payment_input[i].value);
                    break;
                }
            }
            calnewallsubins();
        });

        $('input[name="ins_appoint_pay[]"]').on('input', function() {
            calnewallbaseins();
        });

        $('input[name="ins_principle[]"]').on('input', function() {
            calnewallbaseins();
        });

        $('input[name="ins_interest[]"]').on('input', function() {
            calnewallbaseins();
        });

        $('input[name="subins_appoint_pay[]"]').on('input', function() {
            calnewallbasesubins();
        });
        $('input[name="subins_principle[]"]').on('input', function() {
            calnewallbasesubins();
        });
        $('input[name="subins_interest[]"]').on('input', function() {
            calnewallbasesubins();
        });

        function calnewalldown(id) {
            let ins_down_id = $('.ins_down_id');
            let down_payment = $('.down-payment');
            let down_fine = $('.down-fine');
            let down_trackingfee = $('.down-trackingfee');
            let down_totalpayment = $('.down-totalpayment');
            let down_balance = $('.down-balance');
            let ins_insdown_number = $('.ins_insdown_number');
            let ins_insdown_lastbalance = $('.insdown-lastbalance');
            let sum_down_payment = 0;
            let sum_down_fine = 0;
            let sum_down_trackingfee = 0;
            let sum_down_totalpayment = 0;
            let sum_down_balance = 0;
            
            for (let i = 0; i < down_payment.length; i++) {
                
                sum_down_payment += parseInt(down_payment[i].value);
                sum_down_fine += parseInt(down_fine[i].value);
                sum_down_trackingfee += parseInt(down_trackingfee[i].value);
                sum_down_totalpayment += parseInt(down_totalpayment[i].value);                
            }

            for (let i = 0; i < down_balance.length; i++) {
                let divid_ins_down = null;
                for (let k = 0; k < ins_insdown_lastbalance.length; k++) {
                     if (ins_insdown_lastbalance[k].id == down_balance[i].id) {
                        divid_ins_down = parseInt(ins_insdown_lastbalance[k].value);
                        break;
                    }
                }
                if(divid_ins_down != null){
                    sum_down_balance += parseInt(divid_ins_down);
                }else{
                    sum_down_balance += parseInt(down_balance[i].value);
                }
            }
            $('#down_sum_payment').val(sum_down_payment.toLocaleString());
            $('#down_sum_fine').val(sum_down_fine.toLocaleString());
            $('#down_sum_tracking_fee').val(sum_down_trackingfee.toLocaleString());
            $('#down_sum_total_payment').val(sum_down_totalpayment.toLocaleString());
            $('#down_sum_down_balance').val(sum_down_balance.toLocaleString());

        }

        function calnewallins() {
            let ins_payment = $('.ins-payment');
            let ins_fine = $('.ins-fine');
            let ins_trackingfee = $('.ins-trackingfee');
            let ins_totalpayment = $('.ins-totalpayment');
            let ins_balance = $('.ins-payablebalance');
            let ins_ins_number = $('.ins_ins_number');
            let ins_ins_lastbalance = $('.ins-lastbalance');
            let sum_ins_payment = 0;
            let sum_ins_fine = 0;
            let sum_ins_trackingfee = 0;
            let sum_ins_totalpayment = 0;
            let sum_ins_balance = 0;
            for (let i = 0; i < ins_balance.length; i++) {
                sum_ins_payment += parseInt(ins_payment[i].value);
                sum_ins_fine += parseInt(ins_fine[i].value);
                sum_ins_trackingfee += parseInt(ins_trackingfee[i].value);
                sum_ins_totalpayment += parseInt(ins_totalpayment[i].value);
            }

            for (let i = 0; i < ins_balance.length; i++) {
                let divid_ins = null;
                for (let k = 0; k < ins_ins_lastbalance.length; k++) {
                     if (ins_ins_lastbalance[k].id == ins_balance[k].id) {
                        divid_ins = parseInt(ins_ins_lastbalance[k].value);
                        break;
                    }
                }
                if(divid_ins != null){
                    sum_ins_balance += parseInt(divid_ins);
                }else{
                    sum_ins_balance += parseInt(ins_balance[i].value);
                }
            }

            $('#ins_sumpayment').val(sum_ins_payment);
            $('#ins_sumfine').val(sum_ins_fine);
            $('#ins_sumtracking_fee').val(sum_ins_trackingfee);
            $('#ins_sumtotalpayment').val(sum_ins_totalpayment);
            $('#ins_sumpayablebalance').val(sum_ins_balance);
        }

        function calnewallsubins() {
            let ins_payment = $('.subins-payment');
            let ins_fine = $('.subins-fine');
            let ins_trackingfee = $('.subins-trackingfee');
            let ins_totalpayment = $('.subins-totalpayment');
            let ins_balance = $('.subins-payablebalance');
            let ins_ins_number = $('.subdividins_number');
            let ins_ins_lastbalance = $('.subins-lastbalance');
            let sum_ins_payment = 0;
            let sum_ins_fine = 0;
            let sum_ins_trackingfee = 0;
            let sum_ins_totalpayment = 0;
            let sum_ins_balance = 0;
            for (let i = 0; i < ins_balance.length; i++) {
                sum_ins_payment += parseInt(ins_payment[i].value);
                sum_ins_fine += parseInt(ins_fine[i].value);
                sum_ins_trackingfee += parseInt(ins_trackingfee[i].value);
                sum_ins_totalpayment += parseInt(ins_totalpayment[i].value);
            }

            for (let i = 0; i < ins_balance.length; i++) {
                let divid_ins = null;
                for (let k = 0; k < ins_ins_lastbalance.length; k++) {
                     if (ins_ins_lastbalance[k].id == ins_balance[k].id) {
                        divid_ins = parseInt(ins_ins_lastbalance[k].value);
                        break;
                    }
                }
                if(divid_ins != null){
                    sum_ins_balance += parseInt(divid_ins);
                }else{
                    sum_ins_balance += parseInt(ins_balance[i].value);
                }
            }

            $('#subins_sumpayment').val(sum_ins_payment);
            $('#subins_sumfine').val(sum_ins_fine);
            $('#subins_sumtracking_fee').val(sum_ins_trackingfee);
            $('#subins_sumtotalpayment').val(sum_ins_totalpayment);
            $('#subins_sumpayablebalance').val(sum_ins_balance);
        }

        function calnewallbaseins() {
            let ins_app_pay = $('.ins-app-pay');
            let ins_principle = $('.ins-principle');
            let ins_interest = $('.ins-interest');
            let sum_ins_app_pay = 0;
            let sum_ins_principle = 0;
            let sum_ins_interest = 0;
            for (let i = 0; i < ins_app_pay.length; i++) {
                sum_ins_app_pay += parseInt(ins_app_pay[i].value);
                sum_ins_principle += parseInt(ins_principle[i].value);
                sum_ins_interest += parseInt(ins_interest[i].value);
            }
            $('#ins_sumins').val(sum_ins_app_pay);
            $('#ins_sumprinciple').val(sum_ins_principle);
            $('#ins_suminterest').val(sum_ins_interest);
        }

        function calnewallbasesubins() {
            let subins_app_pay = $('.subins-app-pay');
            let subins_principle = $('.subins-principle');
            let subins_interest = $('.subins-interest');
            let sum_subins_app_pay = 0;
            let sum_subins_principle = 0;
            let sum_aubins_interest = 0;
            for (let i = 0; i < subins_app_pay.length; i++) {
                sum_subins_app_pay += parseInt(subins_app_pay[i].value);
                sum_subins_principle += parseInt(subins_principle[i].value);
                sum_subins_interest += parseInt(subins_interest[i].value);
            }
            $('#subins_sumins').val(sum_subins_app_pay);
            $('#subins_sumprinciple').val(sum_subins_principle);
            $('#subins_suminterest').val(sum_subins_interest);
        }

        $('#dataform').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                if(oldValue != newValue){
                    changedData.push({ field : $(this).attr('placeholder'),
                    old : oldValue,
                    new : newValue});
                }
            });
            //onsole.log(changedData);
            //console.log(changedData);
            // Display the SweetAlert confirmation dialog
            Swal.fire({
            title: '{!! $content_lang['confirm_save'] !!}',
            text: 'You are about to submit the form. Confirm?',
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
        });

        $('#divid_insdown').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "date_ins_insdown" || name == "ins_insdown_billnum"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['fine'] !!}', 
                                '{!! $content_lang['tracking-fee'] !!}', 
                                '{!! $content_lang['total-payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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
            
        });

        $('#discountdown').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "discountdown_date" || name == "discount_bill"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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
        });

        $('#divid_ins').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "date_ins_ins" || name == "ins_ins_billnum"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['fine'] !!}', 
                                '{!! $content_lang['tracking-fee'] !!}', 
                                '{!! $content_lang['total-payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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
            
        });

        $('#divid_subins').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "date_subdividins" || name == "subdividins_billnum"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['fine'] !!}', 
                                '{!! $content_lang['tracking-fee'] !!}', 
                                '{!! $content_lang['total-payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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
            
        });

        $('#discountins').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "discountins_date_modal" || name == "discountins_bill"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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

        $('#discountsubins').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting by default
            let formData = $(this).serialize(); // Using serialize() method
            let changedData = [];
            let htmltext = '';
            $(this).find('input, textarea, select').each(function() {
                let newValue = $(this).val();
                let oldValue = $(this).prop('defaultValue');
                let field = $(this).attr('placeholder');
                let name = $(this).attr('name');
                
                if(oldValue != newValue ){
                    if(name == "discountsubins_date_modal" || name == "discountsubins_bill"){
                        changedData.push({ field : field,
                        old : oldValue,
                        new : newValue});
                    }else{
                        changedData.push({ field : field,
                        old : parseInt(oldValue),
                        new : parseInt(newValue)});
                    }
                    
                }
            });
            const sortOrder = ['{!! $content_lang['payment-date'] !!}', 
                                '{!! $content_lang['bill-number'] !!}', 
                                '{!! $content_lang['payment'] !!}', 
                                '{!! $content_lang['balance'] !!}', 
            ];
            // Custom sorting function
            const customSort = (a, b) => {
            const indexA = sortOrder.indexOf(a.field);
            const indexB = sortOrder.indexOf(b.field);
                return indexA - indexB;
            };
            const sortedArray = changedData.sort(customSort);
            for (let i = 0; i < changedData.length; i++) {
                const item = changedData[i];
                
                htmltext += item.field+' : '+item.new.toLocaleString()+'<br>';
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
        
    });

    function change_cus_st(e) {
        let cus_st_input = $('input[name="cus_st"]');
        cus_st_input.val(e.value);
    }

    function createinsinsdown(id, balance,ins_insdown_number) {
        let modalOverlay = document.getElementById('modal-insinsdown');
        let ins_insdown_appoint_pay = document.getElementById('ins_insdown_appoint_pay');
        let date_ins_insdown = document.getElementById('date_ins_insdown');
        let ins_down_id_modal = document.getElementById('ins_down_id_modal');
        let ins_insdown_payment = document.getElementById('ins_insdown_payment');
        let ins_insdown_fine = document.getElementById('ins_insdown_fine');
        let ins_insdown_tracking = document.getElementById('ins_insdown_tracking');
        let ins_insdown_totalpayment = document.getElementById('ins_insdown_totalpayment');
        let ins_insdown_balance = document.getElementById('ins_insdown_balance');
        let ins_insdown_number_modal = document.getElementById('ins_insdown_number_modal');
        modalOverlay.classList.remove('hidden');
        date_ins_insdown.value = "";
        ins_insdown_appoint_pay.value = balance;
        ins_down_id_modal.value = id;
        ins_insdown_payment.value = 0;
        ins_insdown_fine.value = 0;
        ins_insdown_tracking.value = 0;
        ins_insdown_totalpayment.value = 0;
        ins_insdown_balance.value = balance;
        ins_insdown_number_modal.value = parseInt(ins_insdown_number)+1;
        calinsdownmodal();
    }

    function creatediscountdown(id, down_balance ,numberIndex,down_date,down_billnumber) {
        let modalOverlay = document.getElementById('modal-discountdown');
        let ins_insdown_appoint_pay = document.getElementById('ins_insdown_appoint_pay_discountmodal');
        let discountdown_date = document.getElementById('discountdown_date');
        let ins_down_id_modal = document.getElementById('ins_down_id_discountmodal');
        let ins_down_bill_modal = document.getElementById('discount_bill');
        let ins_insdown_payment = document.getElementById('ins_insdown_payment');
        let ins_insdown_balance = document.getElementById('discountdown_balance');
        let ins_insdown_number_modal = document.getElementById('ins_insdown_number_discountmodal');
        modalOverlay.classList.remove('hidden');
        discountdown_date.value = down_date;
        ins_down_bill_modal.value = down_billnumber;
        ins_insdown_appoint_pay.value = down_balance;
        ins_down_id_modal.value = id;
        ins_insdown_payment.value = 0;
        ins_insdown_balance.value = down_balance;
        ins_insdown_number_modal.value = parseInt(numberIndex)+1;
        caldiscountdownmodal();
    }

    function creatediscountins(id,ins_balance ,numberIndex,ins_date,ins_billnumber) {
        let modalOverlay = document.getElementById('modal-discountins');
        let ins_ins_appoint_pay = document.getElementById('ins_ins_appoint_pay_discountmodal');
        let discountins_date = document.getElementById('discountins_date_modal');
        let ins_id_modal = document.getElementById('ins_id_discountmodal');
        let ins_bill_modal = document.getElementById('discountins_bill');
        let ins_payment = document.getElementById('dispcountins_pay');
        let ins_balance_modal = document.getElementById('discountins_balance');
        let ins_ins_number_modal = document.getElementById('ins_ins_number_discountmodal');
        modalOverlay.classList.remove('hidden');
        discountins_date.value = ins_date;
        ins_bill_modal.value = ins_billnumber;
        ins_ins_appoint_pay.value = ins_balance;
        ins_id_modal.value = id;
        ins_payment.value = 0;
        ins_balance_modal.value = ins_balance;
        ins_ins_number_modal.value = parseInt(numberIndex)+1;
        caldiscountinsmodal();
    }

    function creatediscountsubins(id, subins_balance ,numberIndex,subins_date,subins_billnumber) {
        console.log(subins_balance);
        let modalOverlay = document.getElementById('modal-discountsubins');
        let subdividins_appoint_pay = document.getElementById('subdividins_appoint_pay_discountmodal');
        let discountins_date = document.getElementById('discountsubins_date_modal');
        let subins_id_modal = document.getElementById('subins_id_discountmodal');
        let subins_bill_modal = document.getElementById('discountsubins_bill');
        let subins_payment = document.getElementById('dispcountsubins_pay');
        let subins_balance_modal = document.getElementById('discountsubins_balance');
        let subdividins_number_modal = document.getElementById('subdividins_number_discountmodal');
        modalOverlay.classList.remove('hidden');
        discountins_date.value = subins_date;
        subins_bill_modal.value = subins_billnumber;
        subdividins_appoint_pay.value = subins_balance;
        subins_id_modal.value = id;
        subins_payment.value = 0;
        subins_balance_modal.value = subins_balance;
        subdividins_number_modal.value = parseInt(numberIndex)+1;
        caldiscountsubinsmodal();
    }

    function createinsins(id, balance,ins_ins_number) {
        let modalOverlay = document.getElementById('modal-insins');
        let ins_ins_appoint_pay = document.getElementById('ins_ins_appoint_pay');
        let date_ins_ins = document.getElementById('date_ins_ins');
        let ins_ins_id_modal = document.getElementById('ins_ins_id_modal');
        let ins_ins_payment = document.getElementById('ins_ins_payment');
        let ins_ins_fine = document.getElementById('ins_ins_fine');
        let ins_ins_tracking = document.getElementById('ins_ins_tracking');
        let ins_ins_totalpayment = document.getElementById('ins_ins_totalpayment');
        let ins_ins_balance = document.getElementById('ins_ins_balance');
        let ins_ins_number_modal = document.getElementById('ins_ins_number_modal');
        modalOverlay.classList.remove('hidden');
        date_ins_ins.value = "";
        ins_ins_appoint_pay.value = balance;
        ins_ins_id_modal.value = id;
        ins_ins_payment.value = 0;
        ins_ins_fine.value = 0;
        ins_ins_tracking.value = 0;
        ins_ins_totalpayment.value = 0;
        ins_ins_balance.value = balance;
        ins_ins_number_modal.value = parseInt(ins_ins_number)+1;
        calinsmodal();
    }

    function createsubdividins(id, balance,subdividins_number) {
        let modalOverlay = document.getElementById('modal-subins');
        let subdividins_appoint_pay = document.getElementById('subdividins_appoint_pay');
        let date_subdividins = document.getElementById('date_subdividins');
        let subdividins_id_modal = document.getElementById('subdividins_id_modal');
        let subdividins_payment = document.getElementById('subdividins_payment');
        let subdividins_fine = document.getElementById('subdividins_fine');
        let subdividins_tracking = document.getElementById('subdividins_tracking');
        let subdividins_totalpayment = document.getElementById('subdividins_totalpayment');
        let subdividins_balance = document.getElementById('subdividins_balance');
        let subdividins_number_modal = document.getElementById('subdividins_number_modal');
        modalOverlay.classList.remove('hidden');
        date_subdividins.value = "";
        subdividins_appoint_pay.value = balance;
        subdividins_id_modal.value = id;
        subdividins_payment.value = 0;
        subdividins_fine.value = 0;
        subdividins_tracking.value = 0;
        subdividins_totalpayment.value = 0;
        subdividins_balance.value = balance;
        subdividins_number_modal.value = parseInt(subdividins_number)+1;
        calsubinsmodal();
    }

    

    function calinsdownmodal() {

        let ins_down_id_modal = document.getElementById('ins_down_id_modal');
        let ins_insdown_payment = document.getElementById('ins_insdown_payment');
        let ins_insdown_fine = document.getElementById('ins_insdown_fine');
        let ins_insdown_tracking = document.getElementById('ins_insdown_tracking');
        let ins_insdown_totalpayment = document.getElementById('ins_insdown_totalpayment');
        let ins_insdown_appoint_pay = document.getElementById('ins_insdown_appoint_pay');
        
        ins_insdown_totalpayment.value = parseInt(ins_insdown_payment.value) + parseInt(ins_insdown_fine.value) +
            parseInt(ins_insdown_tracking.value);
        ins_insdown_balance.value = parseInt(ins_insdown_appoint_pay.value) - parseInt(ins_insdown_payment.value);

    }

    function caldiscountdownmodal() {

        let discountdown_payment = document.getElementById('dispcountdown_pay');
        let ins_insdown_appoint_pay_discountmodal = document.getElementById('ins_insdown_appoint_pay_discountmodal');
        let discountdown_balance = document.getElementById('discountdown_balance');
        if(discountdown_payment.value){
            discountdown_balance.value = parseInt(ins_insdown_appoint_pay_discountmodal.value) - parseInt(discountdown_payment.value);
        }
    }

    function caldiscountinsmodal() {

        let discountins_payment = document.getElementById('dispcountins_pay');
        let ins_appoint_pay_discountmodal = document.getElementById('ins_ins_appoint_pay_discountmodal');
        let discountins_balance = document.getElementById('discountins_balance');
        if(discountins_payment.value){
            discountins_balance.value = parseInt(ins_appoint_pay_discountmodal.value) - parseInt(discountins_payment.value);
        }
    }

    function caldiscountsubinsmodal() {

        let discountsubins_payment = document.getElementById('dispcountsubins_pay');
        let subins_appoint_pay_discountmodal = document.getElementById('subdividins_appoint_pay_discountmodal');
        let discountsubins_balance = document.getElementById('discountsubins_balance');
        if(discountsubins_payment.value){
            discountsubins_balance.value = parseInt(subins_appoint_pay_discountmodal.value) - parseInt(discountsubins_payment.value);
        }
    }

    function calinsmodal() {

        let ins_ins_id_modal = document.getElementById('ins_ins_id_modal');
        let ins_ins_payment = document.getElementById('ins_ins_payment');
        let ins_ins_fine = document.getElementById('ins_ins_fine');
        let ins_ins_tracking = document.getElementById('ins_ins_tracking');
        let ins_ins_totalpayment = document.getElementById('ins_ins_totalpayment');
        let ins_ins_appoint_pay = document.getElementById('ins_ins_appoint_pay');

        ins_ins_totalpayment.value = parseInt(ins_ins_payment.value) + parseInt(ins_ins_fine.value) +
            parseInt(ins_ins_tracking.value);
        ins_ins_balance.value = parseInt(ins_ins_appoint_pay.value) - parseInt(ins_ins_payment.value);

    }

    function calsubinsmodal() {

        let subdividins_id_modal = document.getElementById('subdividins_id_modal');
        let subdividins_payment = document.getElementById('subdividins_payment');
        let subdividins_fine = document.getElementById('subdividins_fine');
        let subdividins_tracking = document.getElementById('subdividins_tracking');
        let subdividins_totalpayment = document.getElementById('subdividins_totalpayment');
        let subdividins_appoint_pay = document.getElementById('subdividins_appoint_pay');

        subdividins_totalpayment.value = parseInt(subdividins_payment.value) + parseInt(subdividins_fine.value) +
            parseInt(subdividins_tracking.value);
        subdividins_balance.value = parseInt(subdividins_appoint_pay.value) - parseInt(subdividins_payment.value);

    }

    function closeinsdownModal() {
        let modalOverlay = document.getElementById('modal-insinsdown');
        modalOverlay.classList.add('hidden');
    }

    function closediscountdownModal() {
        let modalOverlay = document.getElementById('modal-discountdown');
        modalOverlay.classList.add('hidden');
    }

    function closediscountinsModal() {
        let modalOverlay = document.getElementById('modal-discountins');
        modalOverlay.classList.add('hidden');
    }

    function closediscountsubinsModal() {
        let modalOverlay = document.getElementById('modal-discountsubins');
        modalOverlay.classList.add('hidden');
    }

    function closeinsModal() {
        let modalOverlay = document.getElementById('modal-insins');
        modalOverlay.classList.add('hidden');
    }
    
    function closesubinsModal() {
        let modalOverlay = document.getElementById('modal-subins');
        modalOverlay.classList.add('hidden');
    }

    function closesubsubinsModal() {
        let modalOverlay = document.getElementById('modal-discountsubins');
        modalOverlay.classList.add('hidden');
    }

    function confirmsavedata(e) {
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

    $('.datepicker').on('input', function() {
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
    });

    $('.deletediscount').on('click', function() {

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
                    window.location.href = '{{ route("deletediscount", ["id" => ":id"]) }}'.replace(':id', this.id);
                }
            });
    });

    $('.deletedividinsdown').on('click', function() {
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
                    window.location.href = '{{ route("deleteinsinsdown", ["id" => ":id"]) }}'.replace(':id', this.id);
                }
            });
    });

    $('.deletedividins').on('click', function() {
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
                    window.location.href = '{{ route("deleteinsins", ["id" => ":id"]) }}'.replace(':id', this.id);
                }
            });
    });

    $('.deletesubdividins').on('click', function() {
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
                    window.location.href = '{{ route("deletesubdividins", ["id" => ":id"]) }}'.replace(':id', this.id);
                }
            });
    });
</script>
