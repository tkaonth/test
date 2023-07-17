@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
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
                        <a class="flex pl-0 p-2 mb-5" href="{{ route('cusmanage') }}">
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
                        @if ($message = Session::get('warning'))
                            <script>
                                Swal.fire({
                                    text: "{{ $message }}",
                                    icon: 'warning',
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
                                        <div>
                                            {{ $content_lang['table-status'] }}&nbsp;
                                            @if (session()->get('locale') == 'th')
                                                <td>{{ $cus_st->thai }}</td>
                                            @elseif(session()->get('locale') == 'lo')
                                                <td>{{ $cus_st->lao }}</td>
                                            @elseif(session()->get('locale') == 'en')
                                                <td>{{ $cus_st->eng }}</td>
                                            @endif
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
                        <div class="flex-row justify-center w-1/4 p-2">
                            <div id="collapsecuscardmenu" class="flex pl-1 w-fit hover:text-gray-300 hover:cursor-pointer">
                                {{ $content_lang['menu'] }}
                                <div id="icon-collapsecuscardmenu" class="menu-name flex items-center ml-2 rotate-180 duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                </div>
                            </div>
                            <div id="cuscardmenu" class="flex-row justify-center w-full">
                                <a target="_blank" href="{{ route('editcusdata', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['approve-licene'] }}
                                    </div>
                                </a>
                                <a target="_blank" href="{{ route('detailcar', ['id' => $cardata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['view_car_detail'] }}
                                    </div>
                                </a>
                                <a target="_blank" href="{{ route('uploadform_cus', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['upload-button'] }}
                                    </div>
                                </a>
                                <a target="_blank" href="{{ route('viewcusdoc', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['view-button'] }}
                                    </div>
                                </a>
                                <a target="_blank" href="{{ route('subcuscardform', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['changecontact'] }}
                                    </div>
                                </a>
                                <a target="_blank" href="{{ route('billsystem', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['bill'] }}
                                    </div>
                                </a>
                                <a href="{{ route('editcuscard', ['id' => $cusdata->id]) }}">
                                    <div
                                        class="p-2 text-center drop-shadow-lg text-white bg-yellow-400 rounded-lg hover:bg-yellow-300 hover:cursor-pointer my-1">
                                        {{ $content_lang['content-header-edit'] }}
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="my-1">    
                        <table class="w-1/2 table mb-2 table-auto border-2 text-center rounded-lg sticky top-0">
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
                                            $splitdivid_ins = explode('/',$cusdata->divid_ins);
                                            $divid_ins = number_format($splitdivid_ins[0]).'/'.number_format($splitdivid_ins[1]);
                                        }else{
                                            $divid_ins = number_format($cusdata->divid_ins);
                                        }
                                    @endphp
                                    <td class="border px-4 py-2">{{ $divid_ins }} บาท</td>
                                </tr>
                            </tbody>
                        </table>                        
                    </div>
                    {{-- <form method="POST" action="{{ route('updatecuscard', ['id' => $cusdata->id]) }}">
                        @csrf
                        @method('PUT') --}}
                        <div class="my-1">
                            <div id="insdown-container">
                                <table id="insdowntable"  class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                    <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                        <tr>
                                            <th colspan="10" class="px-4 py-2">
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
                                        </tr>
                                    </thead>
                                    <tbody class="border-2">
                                        <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">
                                                {{ $content_lang['deposit'] }}
                                            </td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2">{{ $cusdata->deposit_date }}</td>
                                            <td class="border px-4 py-2">
                                                @if ($cusdata->bill_num_deposit)
                                                    <form id="deposit_bill{{$cusdata->id}}">
                                                        <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                        <input type="hidden" name="bill_type" value="deposit">
                                                        <input type="hidden" name="bill_number" value="{{$cusdata->bill_num_deposit}}">
                                                        <input type="hidden" name="bill_status" value="cancel">
                                                        <input type="hidden" name="approve_st" value="waiting">
                                                        <button type="button" class="hover:text-gray-400 deposit-submit @if($cusdata->upload_deposit == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="deposit_bill{{$cusdata->id}}" onclick="showviewbillmodal(this)">{{ $cusdata->bill_num_deposit }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">{{ number_format($cusdata->deposit) }}</td>
                                            <td class="border px-4 py-2">-</td>
                                            <td class="border px-4 py-2">-</td>
                                            <td class="border px-4 py-2">{{ number_format($cusdata->deposit) }}</td>
                                            @if ($cusdata->deposit > 0)
                                                <td class="border text-green-500 px-4 py-2">
                                                    {{ intval($cusdata->deposit) - intval($cusdata->deposit) }}</td>
                                            @else
                                                <td class="border text-red-500 px-4 py-2">
                                                    {{ intval($cusdata->deposit) - intval($cusdata->deposit) }}</td>
                                            @endif
        
                                        </tr>
                                        <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">
                                                {{ $content_lang['down-deli'] }}<br>
                                            </td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2"></td>
                                            <td class="border px-4 py-2">{{ $cusdata->total_pay_deli_date }}</td>
                                            <td class="border px-4 py-2">
                                                @if ($cusdata->bill_num_down_pay_deli)
                                                    <form id="deli_bill{{$cusdata->id}}">
                                                        <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                        <input type="hidden" name="bill_type" value="deli">
                                                        <input type="hidden" name="bill_number" value="{{$cusdata->bill_num_down_pay_deli}}">
                                                        <input type="hidden" name="bill_status" value="cancel">
                                                        <input type="hidden" name="approve_st" value="waiting">
                                                        <button type="button" class="hover:text-gray-400 deli-submit @if($cusdata->upload_deli == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="deli_bill{{$cusdata->id}}" onclick="showviewbillmodal(this)">{{ $cusdata->bill_num_down_pay_deli }}</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">{{ number_format($cusdata->down_pay_deli) }}</td>
                                            <td class="border px-4 py-2">-</td>
                                            <td class="border px-4 py-2">-</td>
                                            <td class="border px-4 py-2">{{ number_format($cusdata->down_pay_deli) }}</td>
                                            <td class="border @if(intval($cusdata->down_pay_deli) - intval($cusdata->down_pay_deli) > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ intval($cusdata->down_pay_deli) - intval($cusdata->down_pay_deli) }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_adddownpay = 0;
                                        @endphp
                                        @if ($adddownpays)
                                            @foreach ($adddownpays as $adddownpay)
                                                @php
                                                    $total_adddownpay += $adddownpay->payment;
                                                @endphp
                                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                    <td class="border px-4 py-2">
                                                        {{ $content_lang['adddown'] }}<br>
                                                    </td>
                                                    <td class="border px-4 py-2"></td>
                                                    <td class="border px-4 py-2"></td>
                                                    <td class="border px-4 py-2">{{ $adddownpay->date }}</td>
                                                    <td class="border px-4 py-2">
                                                        @if ($adddownpay->bill_number)
                                                            <form id="deli_bill{{$adddownpay->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$adddownpay->cus_id}}">
                                                                <input type="hidden" name="bill_type" value="deli">
                                                                <input type="hidden" name="bill_number" value="{{$adddownpay->bill_number}}">
                                                                <input type="hidden" name="bill_status" value="created">
                                                                <input type="hidden" name="approve_st" value="waiting">
                                                                <button type="button" class="hover:text-gray-400 deli-submit @if($adddownpay->uploadfile == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="deli_bill{{$adddownpay->id}}" onclick="showviewbillmodal(this)">{{ $adddownpay->bill_number }}</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td class="border px-4 py-2">{{ number_format($adddownpay->payment) }}</td>
                                                    <td class="border px-4 py-2">-</td>
                                                    <td class="border px-4 py-2">-</td>
                                                    <td class="border px-4 py-2">{{ number_format($adddownpay->payment) }}</td>
                                                    <td class="border @if(intval($adddownpay->payment) - intval($adddownpay->payment) > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                        {{ intval($adddownpay->payment) - intval($adddownpay->payment) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        @php
                                            $down_count = 0;
                                            $down_sum_payment = $cusdata->deposit + $cusdata->down_pay_deli + $total_adddownpay;
                                            $down_sum_fine = 0;
                                            $down_sum_tracking_fee = 0;
                                            $down_sum_total_payment = 0;
                                            $down_sum_down_balance = 0;
    
                                            $all_down_insdown_count = [];
                                            $all_down_insdown_payment = [];
                                            $all_down_insdown_fine = [];
                                            $all_down_insdown_trackingfee = [];
                                            $all_down_insdown_totalpayment = [];
                                            $all_down_insdown_balance = [];
                                            $discountpay = null;
                                        @endphp
                                        @if($insdown)
                                        @foreach ($insdown as $ins_down)
                                        @php
                                            $down_count++;
                                            $down_sum_payment += $ins_down->payment;
                                            $down_sum_fine += $ins_down->fine;
                                            $down_sum_tracking_fee += $ins_down->tracking_fee;
                                            $down_sum_total_payment += $ins_down->payment + $ins_down->fine + $ins_down->tracking_fee;

                                            $count_insdown = 0;
                                            $sum_insdown_payment = 0;
                                            $sum_insdown_fine = 0;
                                            $sum_insdown_tracking_fee = 0;
                                            $sum_insdown_totalpayment = 0;
                                            $insdown_balance = 0;

                                            $cancelpay = null;
                                            $discountpay = null;
                                            $cancelfine = null;
                                            $canceltracking = null;
                                            $canceltotal = null;
                                            $down_totalpayment = 0;
                                            $down_balance = 0;
                                        @endphp
                                        <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">
                                                {{ $content_lang['payable-down'] }} {{$down_count}} <br>
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $ins_down->appoint_date }}<br>
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @php
                                                            $count_insdown++;
                                                            $sum_insdown_payment += $ins_insdown->payment;
                                                            $sum_insdown_fine += $ins_insdown->fine;
                                                            $sum_insdown_tracking_fee += $ins_insdown->tracking_fee;
                                                            $sum_insdown_totalpayment += $ins_insdown->payment + $ins_insdown->fine + $ins_insdown->tracking_fee;
                                                            $insdown_balance = $ins_insdown->balance;
                                                        @endphp
                                                        <br>
                                                    @endif
                                                @endforeach
                                                @php
                                                    $all_down_insdown_count[] = $count_insdown;
                                                    $all_down_insdown_payment[] = $sum_insdown_payment;
                                                    $all_down_insdown_fine[] = $sum_insdown_fine;
                                                    $all_down_insdown_trackingfee[] = $sum_insdown_tracking_fee;
                                                    $all_down_insdown_totalpayment[] = $sum_insdown_totalpayment;
                                                @endphp
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ number_format($ins_down->appoint_pay) }}<br>
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                        {{ $content_lang['discount'] }}<br>
                                                        @break
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        {{ number_format($ins_insdown->appoint_pay) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                {{ $content_lang['discount'] }}<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $ins_down->payment_date }}<br>
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                        {{$discount->date}}<br>
                                                        @break
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        {{ $ins_insdown->payment_date }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                {{$discount->date}}<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            @php
                                                $billnumberflag = null;
                                                $billdiscount = null;
                                                $billdiscountsubins = null;
                                            @endphp
                                            <td class="border px-4 py-2">
                                                    <form id="ins_downbill{{$ins_down->id}}">
                                                        <input type="hidden" name="cus_id" value="{{$ins_down->cus_id}}">
                                                        <input type="hidden" name="bill_type" value="ins_down">
                                                        <input type="hidden" name="bill_number" value="{{$ins_down->bill_number}}">
                                                        @foreach ($billdatas as $billdata)
                                                            @if($billdata->bill_number == $ins_down->bill_number)
                                                                <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                <button type="button" class="hover:text-gray-400 ins_down-submit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{ $ins_down->bill_number }}</button>
                                                                @php
                                                                     $billnumberflag = 'billing';
                                                                     $billname = substr($ins_down->bill_number, 0, 8);
                                                                     if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                        $billdiscount = "DISCOUNT";
                                                                        break;
                                                                     }else{
                                                                        $billdiscount = null;
                                                                     }
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @if (!$billnumberflag)
                                                            <form id="ins_downbill{{$ins_down->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                <input type="hidden" name="bill_type" value="ins_down">
                                                                <input type="hidden" name="bill_number" value="{{$ins_down->bill_number}}">
                                                                <input type="hidden" name="bill_status" value="cancel">
                                                                <input type="hidden" name="approve_st" value="waiting">
                                                                <button type="button" class="hover:text-gray-400 ins_down-submit @if($ins_down->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{ $ins_down->bill_number }}</button><br>
                                                            </form>
                                                        @endif
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                <form id="ins_downbill{{$ins_down->id}}">
                                                                    <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                    <input type="hidden" name="bill_type" value="ins_down">
                                                                    <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                    <input type="hidden" name="bill_status" value="cancel">
                                                                    <input type="hidden" name="approve_st" value="waiting">
                                                                    <button type="button" class="hover:text-gray-400 ins_down-submit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                                </form>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    </form>
                                                
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @php
                                                        $billnumberflag = null;
                                                    @endphp
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @if ($ins_insdown->bill_number)
                                                            <form id="ins_insdownbill{{$ins_insdown->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$ins_insdown->cus_id}}">
                                                                <input type="hidden" name="bill_type" value="ins_insdown">
                                                                <input type="hidden" name="bill_number" value="{{$ins_insdown->bill_number}}">
                                                                @foreach ($billdatas as $billdata)
                                                                    @if($billdata->bill_number == $ins_insdown->bill_number)
                                                                        <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                        <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                        <button type="button" class="hover:text-gray-400 ins_down-submit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{ $ins_insdown->bill_number }}</button>
                                                                        @php
                                                                            $billnumberflag = 'billing';
                                                                            $billname = substr($ins_insdown->bill_number, 0, 8);
                                                                            if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                                $billdiscountsubins = "DISCOUNT";
                                                                                break;
                                                                            }else{
                                                                                $billdiscountsubins = null;
                                                                            }
                                                                        @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                                @if (!$billnumberflag)
                                                                    <form id="ins_insdownbill{{$ins_insdown->id}}">
                                                                        <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                        <input type="hidden" name="bill_type" value="ins_insdown">
                                                                        <input type="hidden" name="bill_number" value="{{ $ins_insdown->bill_number }}">
                                                                        <input type="hidden" name="bill_status" value="cancel">
                                                                        <input type="hidden" name="approve_st" value="waiting">
                                                                        <button type="button" class="hover:text-gray-400 ins_down-submit @if($ins_insdown->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{ $ins_insdown->bill_number }}</button><br>
                                                                    </form>
                                                                @endif
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                        <form id="ins_insdownbill{{$ins_insdown->id}}">
                                                                            <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                            <input type="hidden" name="bill_type" value="discount">
                                                                            <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                            <input type="hidden" name="bill_status" value="cancel">
                                                                            <input type="hidden" name="approve_st" value="waiting">
                                                                            <button type="button" class="hover:text-gray-400 discount-submit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_downbill{{$ins_down->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                                        </form>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                @foreach ($billdetails as $billdetail)
                                                    @if($billdetail->ins_id == $ins_down->id && $billdetail->bill_number == $ins_down->bill_number  && $billdetail->bill_status == 'cancel')
                                                        @php
                                                            $cancelpay = $billdetail->list_payments;
                                                            break;
                                                        @endphp
                                                    @elseif($billdetail->ins_id == $ins_down->id && $billdetail->bill_number == $ins_down->bill_number  && $billdiscount == 'DISCOUNT')
                                                        @php
                                                            $discountpay = $billdetail->list_payments;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if($cancelpay != null)
                                                    <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                        @php
                                                            $cancelpay = null;
                                                        @endphp
                                                        <br>
                                                @elseif($discountpay != null)
                                                    <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                        @php
                                                            $discountpay = null;
                                                        @endphp
                                                        <br>
                                                @else
                                                    {{ number_format($ins_down->payment) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                            <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $ins_insdown->id && $billdetail->bill_number == $ins_insdown->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                @php
                                                                    $cancelpay = $billdetail->list_payments;
                                                                    break;
                                                                @endphp
                                                            @elseif($billdetail->subins_id == $ins_insdown->id && $billdetail->bill_number == $ins_insdown->bill_number && $billdiscountsubins == 'DISCOUNT')
                                                                @php
                                                                    $discountpay = $billdetail->list_payments;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        
                                                        @if($cancelpay != null)
                                                            <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                            @php
                                                                $cancelpay = null;
                                                            @endphp
                                                            <br>
                                                        @elseif($discountpay != null)
                                                            <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                                @php
                                                                    $discountpay = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($ins_insdown->payment) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                    <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                
                                                @foreach ($billdetails as $billdetail)
                                                    @if($billdetail->ins_id == $ins_down->id && $billdetail->bill_number == $ins_down->bill_number && $billdetail->bill_status == 'cancel')
                                                        @php
                                                            $cancelfine = $billdetail->list_fine;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if($cancelfine != null)
                                                    <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                        @php
                                                            $cancelfine = null;
                                                        @endphp
                                                        <br>
                                                @else
                                                    {{ number_format($ins_down->fine) }}<br>
                                                    @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                                0<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $ins_insdown->id && $billdetail->bill_number == $ins_insdown->bill_number && $billdetail->bill_status == 'cancel')
                                                                @php
                                                                    $cancelfine = $billdetail->list_fine;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($cancelfine != null)
                                                            <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                                @php
                                                                    $cancelfine = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($ins_insdown->fine) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            

                                            <td class="border px-4 py-2">
                                                
                                                @foreach ($billdetails as $billdetail)
                                                    @if($billdetail->ins_id == $ins_down->id && $billdetail->bill_number == $ins_down->bill_number && $billdetail->bill_status == 'cancel')
                                                        @php
                                                            $canceltracking = $billdetail->list_fine;
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if($canceltracking != null)
                                                    <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                        @php
                                                            $canceltracking = null;
                                                        @endphp
                                                        <br>
                                                @else
                                                    {{ number_format($ins_down->tracking_fee) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                            0<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $ins_insdown->id && $billdetail->bill_number == $ins_insdown->bill_number && $billdetail->bill_status == 'cancel')
                                                                @php
                                                                    $canceltracking = $billdetail->list_tracking;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($canceltracking != null)
                                                            <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                                @php
                                                                    $canceltracking = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($ins_insdown->tracking_fee) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>

                                            <td class="border px-4 py-2">
                                                @foreach ($billdetails as $billdetail)
                                                    
                                                    @if($billdetail->ins_id == $ins_down->id && $billdetail->bill_number == $ins_down->bill_number && $billdetail->bill_status == 'cancel')
                                                    
                                                        @php
                                                            $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                            break;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                
                                                @if($canceltotal != null)
                                                
                                                    <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                        @php
                                                            $canceltotal = null;
                                                        @endphp
                                                        <br>
                                                @else
                                                    {{ number_format($down_totalpayment) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                            0<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        @php
                                                            $ins_insdown_totalpay = $ins_insdown->payment + $ins_insdown->fine + $ins_insdown->tracking_fee;
                                                        @endphp
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $ins_insdown->id && $billdetail->bill_number == $ins_insdown->bill_number && $billdetail->bill_status == 'cancel')
                                                            
                                                                @php
                                                                    $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($canceltotal != null)
                                                        
                                                            <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                                @php
                                                                    $canceltotal = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($ins_insdown_totalpay) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                       
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    {{ $content_lang['balance'].' :' }}<br>
                                                @endif
                                            </td>

                                            <td class="border @if($ins_down->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                @php
                                                    $down_balance = $ins_down->balance;
                                                @endphp
                                                {{ number_format($down_balance) }}<br>
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == null && $discount->ins_type == "insdown"))
                                                        {{number_format($discount->balance)}}<br>
                                                        @php
                                                            $down_balance = $discount->balance;
                                                        @endphp
                                                        @break
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        {{ number_format($ins_insdown->balance) }}<br>
                                                        @php
                                                            $insdown_balance = $ins_insdown->balance;
                                                            $down_balance = $insdown_balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id && $discount->sub_ins_id == $ins_insdown->id && $discount->ins_type == "insdown"))
                                                                {{number_format($discount->balance)}}<br>
                                                                @php
                                                                    $insdown_balance = $discount->balance;
                                                                    $down_balance = $discount->balance;
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @if($count_insdown > 0)
                                                    {{ number_format($down_balance) }}<br>
                                                @endif
                                                @php
                                                    if($count_insdown > 0){
                                                        $all_down_insdown_balance[] = $insdown_balance;
                                                        $down_balance = $insdown_balance;
                                                    }else{
                                                        $all_down_insdown_balance[] = $down_balance;
                                                    }
                                                    $down_totalpayment = $ins_down->payment + $ins_down->fine + $ins_down->tracking_fee;
                                                    $ins_insdown_totalpay = 0;
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                        @endif
                                        
                                        @php
                                            for ($i=0; $i < count($all_down_insdown_count); $i++) { 
                                                $down_sum_payment += $all_down_insdown_payment[$i];
                                                $down_sum_fine += $all_down_insdown_fine[$i];
                                                $down_sum_tracking_fee += $all_down_insdown_trackingfee[$i];
                                                $down_sum_total_payment += $all_down_insdown_totalpayment[$i];
                                                $down_sum_down_balance += $all_down_insdown_balance[$i];
                                                
                                                
                                            }
                                            $down_sum_total_payment = $down_sum_total_payment + $cusdata->deposit + $cusdata->down_pay_deli + $total_adddownpay;
                                        @endphp
                                        <tr class="border-0 font-bold">
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td class="border-0 px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                            <td class="border-0 px-4 py-2"></td>
                                            <td
                                                class="@if ($down_sum_payment  > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                {{ number_format($down_sum_payment) }}</td>
                                            <td
                                                class="@if ($down_sum_fine > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                {{ number_format($down_sum_fine) }}</td>
                                            <td
                                                class="@if ($down_sum_tracking_fee > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                {{ number_format($down_sum_tracking_fee) }}</td>
                                            <td
                                                class="@if ($down_sum_total_payment > 0) text-green-500 @else text-red-500 @endif border-0 px-4 py-2">
                                                {{ number_format($down_sum_total_payment) }}</td>
                                            <td
                                                class="@if ($down_sum_down_balance > 0) text-red-500 @else text-green-500 @endif border-0  px-4 py-2">
                                                {{ number_format($down_sum_down_balance) }}</td>
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
                                            <th colspan="12" class="px-4 py-2">
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
                                            $sumallablebalance = 0;
    
                                            $allinsinsbalance = [];
                                        @endphp
                                        @foreach ($ins as $insdata)
                                            @php
                                                $insinscount=0;
                                                $insinstotalpay=0;
                                                $insinsbalance = 0;
    
                                                $inscount++;
                                                $totalpayment = 0;
                                                $payablebalance = 0;
                                                $totalpayment = intval($insdata->payment) + intval($insdata->fine) + intval($insdata->tracking_fee);
                                                $sumins += intval($insdata->appoint_pay);
                                                $sumprinciple += intval($insdata->principle);
                                                $suminterest += intval($insdata->interest);
                                                $sumpayment += intval($insdata->payment);
                                                $sumfine += intval($insdata->fine);
                                                $sumtracking_fee += intval($insdata->tracking_fee);
                                                $sumtotalpayment += intval($totalpayment);
                                                
                                                $cancelpay = null;
                                                $cancelfine = null;
                                                $canceltracking = null;
                                                $canceltotal = null;
                                            @endphp
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">
                                                    {{ $content_lang['ins-num'] . ' ' . $inscount }}<br>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ $insdata->appoint_date }}<br>
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if($ins_ins->ins_id == $insdata->id)
                                                            @php
                                                                
                                                                $insinscount++;
                                                                $insinstotalpay = $ins_ins->payment + $ins_ins->fine + $ins_ins->tracking_fee;
                                                                $sumins += intval($ins_ins->appoint_pay);
                                                                $sumpayment += intval($ins_ins->payment);
                                                                $sumfine += intval($ins_ins->fine);
                                                                $sumtracking_fee += intval($ins_ins->tracking_fee);
                                                                $sumtotalpayment += $insinstotalpay;
                                                                
                                                            @endphp
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                    
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ number_format($insdata->appoint_pay) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            {{ $content_lang['discount'] }}<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            {{ number_format($ins_ins->appoint_pay) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    {{ $content_lang['discount'] }}<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @if($insdata->principle > 0) {{ number_format($insdata->principle) }}<br> @else -<br> @endif
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ number_format($insdata->interest) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            <br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ $insdata->payment_date }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            {{$discount->date}}<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            {{ $ins_ins->payment_date }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    {{$discount->date}}<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                @php
                                                    $billnumberflag = null;
                                                    $billdiscount = null;
                                                    $billdiscountsubins = null;
                                                @endphp
                                                <td class="border px-4 py-2">
                                                        <form id="ins_bill{{$insdata->id}}">
                                                            <input type="hidden" name="cus_id" value="{{$insdata->cus_id}}">
                                                            <input type="hidden" name="bill_type" value="ins">
                                                            <input type="hidden" name="bill_number" value="{{$insdata->bill_number}}">
                                                            @foreach ($billdatas as $billdata)
                                                                @if($billdata->bill_number == $insdata->bill_number)
                                                                    <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                    <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                    <button type="button" class="hover:text-gray-400 ins-submit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_bill{{$insdata->id}}" onclick="showviewbillmodal(this)">{{ $insdata->bill_number }}</button>
                                                                    @php
                                                                         $billnumberflag = 'billing';
                                                                         $billname = substr($insdata->bill_number, 0, 8);
                                                                         if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                            $billdiscount = "DISCOUNT";
                                                                            break;
                                                                         }else{
                                                                            $billdiscount = null;
                                                                         }
                                                                    @endphp
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        </form>
                                                        @if (!$billnumberflag)
                                                        <form id="ins_bill{{$insdata->id}}">
                                                            <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                            <input type="hidden" name="bill_type" value="ins">
                                                            <input type="hidden" name="bill_number" value="{{$insdata->bill_number}}">
                                                            <input type="hidden" name="bill_status" value="cancel">
                                                            <input type="hidden" name="approve_st" value="waiting">
                                                            <button type="button" class="hover:text-gray-400 ins-submit @if($insdata->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$insdata->id}}" onclick="showviewbillmodal(this)">{{ $insdata->bill_number }}</button><br>
                                                        </form>
                                                    @endif
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            <form id="ins_bill{{$insdata->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                <input type="hidden" name="bill_type" value="ins">
                                                                <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                <input type="hidden" name="bill_status" value="cancel">
                                                                <input type="hidden" name="approve_st" value="waiting">
                                                                <button type="button" class="hover:text-gray-400 ins-submit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$insdata->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                            </form>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @php
                                                            $billnumberflag = null;
                                                            $billdiscountsubins = null;
                                                        @endphp
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            <form id="ins_insbill{{$ins_ins->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$ins_ins->cus_id}}">
                                                                <input type="hidden" name="bill_type" value="ins_ins">
                                                                <input type="hidden" name="bill_number" value="{{$ins_ins->bill_number}}">
                                                                @foreach ($billdatas as $billdata)
                                                                    @if($billdata->bill_number == $ins_ins->bill_number)
                                                                        <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                        <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                        <button type="button" class="hover:text-gray-400 ins-inssubmit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_insbill{{$ins_ins->id}}" onclick="showviewbillmodal(this)">{{ $ins_ins->bill_number }}</button>
                                                                        @php
                                                                            $billnumberflag = 'billing';
                                                                            $billname = substr($ins_insdown->bill_number, 0, 8);
                                                                            if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                                $billdiscountsubins = "DISCOUNT";
                                                                                break;
                                                                            }else{
                                                                                $billdiscountsubins = null;
                                                                            }
                                                                        @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            </form>
                                                            @if (!$billnumberflag)
                                                                <form id="ins_insbill{{$ins_ins->id}}">
                                                                    <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                    <input type="hidden" name="bill_type" value="ins_ins">
                                                                    <input type="hidden" name="bill_number" value="{{$ins_ins->bill_number}}">
                                                                    <input type="hidden" name="bill_status" value="cancel">
                                                                    <input type="hidden" name="approve_st" value="waiting">
                                                                    <button type="button" class="hover:text-gray-400 ins-inssubmit @if($ins_ins->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$ins_ins->id}}" onclick="showviewbillmodal(this)">{{ $ins_ins->bill_number }}</button><br>
                                                                </form>
                                                            @endif
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    <form id="ins_bill{{$ins_ins->id}}">
                                                                        <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                        <input type="hidden" name="bill_type" value="ins_ins">
                                                                        <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                        <input type="hidden" name="bill_status" value="cancel">
                                                                        <input type="hidden" name="approve_st" value="waiting">
                                                                        <button type="button" class="hover:text-gray-400 ins-inssubmit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$ins_ins->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                                    </form>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $insdata->id && $billdetail->bill_number == $insdata->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $cancelpay = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                break;
                                                            @endphp
                                                        @elseif($billdetail->ins_id == $insdata->id && $billdetail->bill_number == $insdata->bill_number && $billdiscount == 'DISCOUNT')
                                                            @php
                                                                $discountpay = $billdetail->list_payments;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($cancelpay != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                            @php
                                                                $cancelpay = null;
                                                            @endphp
                                                            <br>
                                                    @elseif($discountpay != null)
                                                        <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                        @php
                                                            $discountpay = null;
                                                        @endphp
                                                        <br>
                                                    @else
                                                        {{ number_format($insdata->payment) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            @foreach ($billdetails as $billdetail)
                                                                @if($billdetail->subins_id == $ins_ins->id && $billdetail->bill_number == $ins_ins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                    @php
                                                                        $cancelpay = $billdetail->list_payments;
                                                                        break;
                                                                    @endphp
                                                                @elseif($billdetail->subins_id == $ins_ins->id && $billdetail->bill_number == $ins_ins->bill_number && $billdiscountsubins == 'DISCOUNT')
                                                                    @php
                                                                        $discountpay = $billdetail->list_payments;
                                                                        break;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if($cancelpay != null)
                                                            
                                                                <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                                    @php
                                                                        $cancelpay = null;
                                                                    @endphp
                                                                    <br>
                                                            @elseif($discountpay != null)
                                                                <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                                    @php
                                                                        $discountpay = null;
                                                                    @endphp
                                                                    <br>
                                                            @else
                                                                {{ number_format($ins_ins->payment) }}<br>
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                        <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $insdata->id && $billdetail->bill_number == $insdata->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $cancelfine = $billdetail->list_fine;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($cancelfine != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                            @php
                                                                $cancelfine = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($insdata->fine) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($ins_inss as $ins_ins)
                                                        @if ($ins_ins->ins_id == $insdata->id)
                                                            @foreach ($billdetails as $billdetail)
                                                                @if($billdetail->subins_id == $ins_ins->id && $billdetail->bill_number == $ins_ins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                    @php
                                                                        $cancelfine = $billdetail->list_fine;
                                                                        break;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if($cancelfine != null)
                                                            
                                                                <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                                    @php
                                                                        $cancelfine = null;
                                                                    @endphp
                                                                    <br>
                                                            @else
                                                                {{ number_format($ins_ins->fine) }}<br>
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                        0<br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                        @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $insdata->id && $billdetail->bill_number == $insdata->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $canceltracking = $billdetail->list_tracking;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($canceltracking != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                            @php
                                                                $canceltracking = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($insdata->tracking_fee) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $ins_ins->id && $billdetail->bill_number == $ins_ins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                @php
                                                                    $canceltracking = $billdetail->list_tracking;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($canceltracking != null)
                                                            
                                                            <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                                @php
                                                                    $canceltracking = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($ins_ins->tracking_fee) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
                                                    @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $insdata->id && $billdetail->bill_number == $insdata->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($canceltotal != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                            @php
                                                                $canceltotal = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($totalpayment) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            
                                                            @if($billdetail->subins_id == $ins_ins->id && $billdetail->bill_number == $ins_ins->bill_number && $billdetail->bill_status == 'cancel')
                                                                @php
                                                                    $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                    break;
                                                                @endphp
                                                                
                                                            @endif
                                                        @endforeach
                                                        @if($canceltotal != null)
                                                            <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                                @php
                                                                    $canceltotal = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($insinstotalpay) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        {{ $content_lang['balance'].' :' }}<br>
                                                    @endif
                                                </td>
                                                <td class="border @if ($insdata->balance > 0)) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                    {{ number_format($insdata->balance) }}<br>
                                                    @php
                                                        $payablebalance = $insdata->balance;
                                                    @endphp
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == null && $discount->ins_type == "ins"))
                                                            {{number_format($discount->balance)}}<br>
                                                            @php
                                                                $payablebalance = $discount->balance;
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        {{ number_format($ins_ins->balance) }}<br>
                                                        @php
                                                            $insinsbalance = $ins_ins->balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id && $discount->sub_ins_id == $ins_ins->id && $discount->ins_type == "ins"))
                                                                {{number_format($discount->balance)}}<br>
                                                                @php
                                                                    $insinsbalance = $discount->balance;
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @endforeach
                                                    @if($insinscount > 0)
                                                        {{ number_format($insinsbalance) }}<br>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                if($insinscount > 0){
                                                    $allinsinsbalance[] = $insinsbalance;
                                                }else{
                                                    $allinsinsbalance[] = $payablebalance;
                                                }
                                            @endphp
                                        @endforeach
                                        @php
                                            
                                            for($i=0;$i<count($allinsinsbalance);$i++){
                                                $sumallablebalance += $allinsinsbalance[$i];
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-300 even:bg-gray-100 font-bold">
                                            <td class="px-4 py-2"></td>
                                            <td class="px-4 py-2"></td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($sumins) }}</td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($sumprinciple) }}</td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($suminterest) }}</td>
                                            <td class="px-4 py-2"></td>
                                            <td class="font-bold px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                            <td
                                                class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumpayment) }}</td>
                                            <td
                                                class="@if ($sumfine > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumfine) }}</td>
                                            <td
                                                class="@if ($sumtracking_fee > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumtracking_fee) }}</td>
                                            <td
                                                class="@if ($sumtotalpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumtotalpayment) }}</td>
                                            <td
                                                class="@if ($sumallablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ number_format($sumallablebalance) }}</td>
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
                                    $sumallbalance = $down_sum_down_balance + $sumallablebalance;
                                @endphp
                                <tbody class="border-2">
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-down-pay'] }}</td>
                                        <td
                                            class="@if ($down_sum_payment > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($down_sum_payment) }}</td>
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
                                            class="@if ($sumallablebalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                            {{ number_format($sumallablebalance) }}</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-fine-pay'] }}</td>
                                        <td
                                            class="@if ($sumallfine > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($sumallfine) }}</td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-tracking-fee-pay'] }}</td>
                                        <td
                                            class="@if ($sumalltracking_fee > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                            {{ number_format($sumalltracking_fee) }}</td>
                                        <td class="border text-red-500 px-4 py-2">-</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="border px-4 py-2">{{ $content_lang['total-income'] }}</td>
                                        <td
                                            class="@if ($sumallpaymment > 0) text-green-500 @else text-red-500 @endif border text-green-400 px-4 py-2">
                                            {{ number_format($sumallpaymment) }}</td>
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
                    {{-- </form> --}}
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
                                                    

                                                    $count_ins = count($ins);
                                                    $end_date = $ins[$count_ins-1]['appoint_date'];
                                                    
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
                        <div class="my-1">    
                            <table class="w-1/2 table mb-2 table-auto border-2 text-center rounded-lg sticky top-0">
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
                                        <td class="border px-4 py-2">{{ number_format($subcarddata->total_price) }} บาท</td>
                                        <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['down-pay'] }}</td>
                                        <td class="border px-4 py-2">{{ number_format($subcarddata->down_pay) }} บาท</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['remaining'] }}</td>
                                        <td class="border px-4 py-2">{{ number_format($subcarddata->remaining) }} บาท</td>
                                        <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['interest'] }}</td>
                                        <td class="border px-4 py-2">{{ $subcarddata->interest_rate }} %</td>
                                    </tr>
                                    <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                        <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['table-ins-type'] }}
    
                                        </td>
                                        <td class="border px-4 py-2">{{ $subcarddata->ins_style }} 
                                            @if ($subcarddata->ins_style_type == 'month')
                                                {{ $content_lang['month'] }}
                                            @elseif($subcarddata->ins_style_type == 'year')
                                                {{ $content_lang['year'] }}
                                            @endif
                                        </td>
                                        <td class="bg-orange-300 border px-4 py-2">{{ $content_lang['long'] }}</td>
                                        <td class="border px-4 py-2">{{ $subcarddata->ins_long }}
                                            @if ($subcarddata->ins_long_type == 'month')
                                                {{ $content_lang['month'] }}
                                            @elseif($subcarddata->ins_long_type == 'year')
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
                                            if (strpos($subcarddata->divid_ins, '/') !== false) {
                                                $splitdivid_ins = explode('/',$subcarddata->divid_ins);
                                                $divid_ins = number_format($splitdivid_ins[0]).'/'.number_format($splitdivid_ins[1]);
                                            }else{
                                                $divid_ins = number_format($subcarddata->divid_ins);
                                            }
                                        @endphp
                                        <td class="border px-4 py-2">{{ $divid_ins }} บาท</td>
                                    </tr>
                                </tbody>
                            </table>                        
                        </div>

                    @if(isset($subcardinss))
                        <div class="my-1">
                            <div id="subins-container">
                                <table id="subinstable" class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                    <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                        <tr>
                                            <th colspan="12" class="px-4 py-2">
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
                                        </tr>
                                    </thead>
                                    <tbody class="border-2">
                                        @php
                                            $subinscount = 0;
                                            $sumsubins = 0;
                                            $sumprinciple = 0;
                                            $suminterest = 0;
                                            $sumpayment = 0;
                                            $sumfine = 0;
                                            $sumtracking_fee = 0;
                                            $sumtotalpayment = 0;
                                            $sumpayablebalance = 0;
                                            $sumallablebalance = 0;

                                            $allinsinsbalance = [];
                                        @endphp
                                        @foreach ($subcardinss as $subcardins)
                                            @php
                                                $insinstotalpay=0;
                                                $insinsbalance = 0;
                                                $subdividins_count = 0;
                                                $subinscount++;
                                                $totalpayment = 0;
                                                $payablebalance = 0;
                                                $totalpayment = intval($subcardins->payment) + intval($subcardins->fine) + intval($subcardins->tracking_fee);
                                                $sumsubins += intval($subcardins->appoint_pay);
                                                $sumprinciple += intval($subcardins->principle);
                                                $suminterest += intval($subcardins->interest);
                                                $sumpayment += intval($subcardins->payment);
                                                $sumfine += intval($subcardins->fine);
                                                $sumtracking_fee += intval($subcardins->tracking_fee);
                                                $sumtotalpayment += intval($totalpayment);
                                                
                                                $cancelpay = null;
                                                $cancelfine = null;
                                                $canceltracking = null;
                                                $canceltotal = null;
                                            @endphp
                                            <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                                <td class="border px-4 py-2">
                                                    {{ $content_lang['con-ins'] . ' ' . $subcardins->ins_number }}<br>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ $subcardins->appoint_date }}<br>
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if($subcarddividins->ins_id == $subcardins->id)
                                                            @php
                                                                
                                                                $subdividins_count++;
                                                                $insinstotalpay = $subcarddividins->payment + $subcarddividins->fine + $subcarddividins->tracking_fee;
                                                                $sumsubins += intval($subcarddividins->appoint_pay);
                                                                $sumpayment += intval($subcarddividins->payment);
                                                                $sumfine += intval($subcarddividins->fine);
                                                                $sumtracking_fee += intval($subcarddividins->tracking_fee);
                                                                $sumtotalpayment += $insinstotalpay;
                                                                
                                                            @endphp
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                    
                                                </td>
                                                <td class="border px-4 py-2">
                                                    
                                                    {{ number_format($subcardins->appoint_pay) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                            {{ $content_lang['discount'] }}<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            {{ number_format($subcarddividins->appoint_pay) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                    {{ $content_lang['discount'] }}<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @if($subcardins->principle > 0) {{ number_format($subcardins->principle) }}<br> @else -<br> @endif
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                <br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            <br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                    <br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ number_format($subcardins->interest) }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                            <br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            <br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                    <br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ $subcardins->payment_date }}<br>
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                            {{$discount->date}}<br>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            {{ $subcarddividins->payment_date }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id && $discount->ins_type == "subins"))
                                                                    {{$discount->date}}<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                @php
                                                    $billnumberflag = null;
                                                    $billdiscount = null;
                                                    $billdiscountsubins = null;
                                                @endphp
                                                <td class="border px-4 py-2">
                                                        <form id="ins_bill{{$subcardins->id}}">
                                                            <input type="hidden" name="cus_id" value="{{$subcardins->cus_id}}">
                                                            <input type="hidden" name="bill_type" value="ins">
                                                            <input type="hidden" name="bill_number" value="{{$subcardins->bill_number}}">
                                                            @foreach ($billdatas as $billdata)
                                                                @if($billdata->bill_number == $subcardins->bill_number)
                                                                    <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                    <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                    <button type="button" class="hover:text-gray-400 ins-submit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_bill{{$subcardins->id}}" onclick="showviewbillmodal(this)">{{ $insdata->bill_number }}</button>
                                                                    @php
                                                                        $billnumberflag = 'billing';
                                                                        $billname = substr($subcardins->bill_number, 0, 8);
                                                                        if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                            $billdiscount = "DISCOUNT";
                                                                            break;
                                                                        }else{
                                                                            $billdiscount = null;
                                                                        }
                                                                    @endphp
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        </form>
                                                        @if (!$billnumberflag)
                                                        <form id="ins_bill{{$subcardins->id}}">
                                                            <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                            <input type="hidden" name="bill_type" value="ins">
                                                            <input type="hidden" name="bill_number" value="{{$subcardins->bill_number}}">
                                                            <input type="hidden" name="bill_status" value="cancel">
                                                            <input type="hidden" name="approve_st" value="waiting">
                                                            <button type="button" class="hover:text-gray-400 ins-submit @if($subcardins->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$subcardins->id}}" onclick="showviewbillmodal(this)">{{ $subcardins->bill_number }}</button><br>
                                                        </form>
                                                    @endif
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null))
                                                            <form id="ins_bill{{$subcardins->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                <input type="hidden" name="bill_type" value="ins">
                                                                <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                <input type="hidden" name="bill_status" value="cancel">
                                                                <input type="hidden" name="approve_st" value="waiting">
                                                                <button type="button" class="hover:text-gray-400 ins-submit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$subcardins->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                            </form>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @php
                                                            $billnumberflag = null;
                                                            $billdiscountsubins = null;
                                                        @endphp
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            <form id="ins_insbill{{$subcarddividins->id}}">
                                                                <input type="hidden" name="cus_id" value="{{$subcarddividins->cus_id}}">
                                                                <input type="hidden" name="bill_type" value="ins_ins">
                                                                <input type="hidden" name="bill_number" value="{{$subcarddividins->bill_number}}">
                                                                @foreach ($billdatas as $billdata)
                                                                    @if($billdata->bill_number == $subcarddividins->bill_number)
                                                                        <input type="hidden" name="bill_status" value="{{$billdata->bill_status}}">
                                                                        <input type="hidden" name="approve_st" value="{{$billdata->approve_st}}">
                                                                        <button type="button" class="hover:text-gray-400 ins-inssubmit @if($billdata->bill_status == 'cancel' || $billdata->approve_st == 'reject') text-red-500 @elseif($billdata->bill_upload == 'uploaded') text-green-500 @elseif($billdata->bill_upload == 'waiting') text-yellow-500 @endif" data-form="ins_insbill{{$ins_ins->id}}" onclick="showviewbillmodal(this)">{{ $ins_ins->bill_number }}</button>
                                                                        @php
                                                                            $billnumberflag = 'billing';
                                                                            $billname = substr($subcardins->bill_number, 0, 8);
                                                                            if($billname == "DISCOUNT" && $billdata->approve_st == 'approved'){
                                                                                $billdiscountsubins = "DISCOUNT";
                                                                                break;
                                                                            }else{
                                                                                $billdiscountsubins = null;
                                                                            }
                                                                        @endphp
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            </form>
                                                            @if (!$billnumberflag)
                                                                <form id="ins_insbill{{$subcarddividins->id}}">
                                                                    <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                    <input type="hidden" name="bill_type" value="ins_ins">
                                                                    <input type="hidden" name="bill_number" value="{{$subcarddividins->bill_number}}">
                                                                    <input type="hidden" name="bill_status" value="cancel">
                                                                    <input type="hidden" name="approve_st" value="waiting">
                                                                    <button type="button" class="hover:text-gray-400 ins-inssubmit @if($subcarddividins->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$subcarddividins->id}}" onclick="showviewbillmodal(this)">{{ $subcarddividins->bill_number }}</button><br>
                                                                </form>
                                                            @endif
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                    <form id="ins_bill{{$subcarddividins->id}}">
                                                                        <input type="hidden" name="cus_id" value="{{$cusdata->id}}">
                                                                        <input type="hidden" name="bill_type" value="ins_ins">
                                                                        <input type="hidden" name="bill_number" value="{{$discount->bill_number}}">
                                                                        <input type="hidden" name="bill_status" value="cancel">
                                                                        <input type="hidden" name="approve_st" value="waiting">
                                                                        <button type="button" class="hover:text-gray-400 ins-inssubmit @if($discount->uploadbill == 'uploaded') text-green-500 @else text-yellow-500 @endif" data-form="ins_bill{{$subcarddividins->id}}" onclick="showviewbillmodal(this)">{{$discount->bill_number}}</button><br>
                                                                    </form>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $subcardins->id && $billdetail->bill_number == $subcardins->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $cancelpay = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                break;
                                                            @endphp
                                                        @elseif($billdetail->ins_id == $subcardins->id && $billdetail->bill_number == $subcardins->bill_number && $billdiscount == 'DISCOUNT')
                                                            @php
                                                                $discountpay = $billdetail->list_payments;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($cancelpay != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                            @php
                                                                $cancelpay = null;
                                                            @endphp
                                                            <br>
                                                    @elseif($discountpay != null)
                                                        <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                        @php
                                                            $discountpay = null;
                                                        @endphp
                                                        <br>
                                                    @else
                                                        {{ number_format($subcardins->payment) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null && $discount->ins_type == "subins"))
                                                                <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            @foreach ($billdetails as $billdetail)
                                                                @if($billdetail->subins_id == $subcarddividins->id && $billdetail->bill_number == $subcarddividins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                    @php
                                                                        $cancelpay = $billdetail->list_payments;
                                                                        break;
                                                                    @endphp
                                                                @elseif($billdetail->subins_id == $subcarddividins->id && $billdetail->bill_number == $subcarddividins->bill_number && $billdiscountsubins == 'DISCOUNT')
                                                                    @php
                                                                        $discountpay = $billdetail->list_payments;
                                                                        break;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if($cancelpay != null)
                                                            
                                                                <span class="text-red-500 line-through">{{ number_format($cancelpay) }}</span>
                                                                    @php
                                                                        $cancelpay = null;
                                                                    @endphp
                                                                    <br>
                                                            @elseif($discountpay != null)
                                                                <span class="text-orange-500">{{ number_format($discountpay) }}</span>
                                                                    @php
                                                                        $discountpay = null;
                                                                    @endphp
                                                                    <br>
                                                            @else
                                                                {{ number_format($subcarddividins->payment) }}<br>
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                        <span class="text-orange-500">{{ number_format($discount->discount) }}</span><br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $subcardins->id && $billdetail->bill_number == $subcardins->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $cancelfine = $billdetail->list_fine;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($cancelfine != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                            @php
                                                                $cancelfine = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($subcardins->fine) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                        @if ($subcarddividins->ins_id == $subcardins->id)
                                                            @foreach ($billdetails as $billdetail)
                                                                @if($billdetail->subins_id == $subcarddividins->id && $billdetail->bill_number == $subcarddividins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                    @php
                                                                        $cancelfine = $billdetail->list_fine;
                                                                        break;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if($cancelfine != null)
                                                            
                                                                <span class="text-red-500 line-through">{{ number_format($cancelfine) }}</span>
                                                                    @php
                                                                        $cancelfine = null;
                                                                    @endphp
                                                                    <br>
                                                            @else
                                                                {{ number_format($subcarddividins->fine) }}<br>
                                                                @foreach ($discounts as $discount)
                                                                    @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                        0<br>
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                        @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $subcardins->id && $billdetail->bill_number == $subcardins->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $canceltracking = $billdetail->list_tracking;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($canceltracking != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                            @php
                                                                $canceltracking = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($subcardins->tracking_fee) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                    @if ($subcarddividins->ins_id == $subcardins->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            @if($billdetail->subins_id == $subcarddividins->id && $billdetail->bill_number == $subcarddividins->bill_number && $billdetail->bill_status == 'cancel')
                                                                
                                                                @php
                                                                    $canceltracking = $billdetail->list_tracking;
                                                                    break;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if($canceltracking != null)
                                                            
                                                            <span class="text-red-500 line-through">{{ number_format($canceltracking) }}</span>
                                                                @php
                                                                    $canceltracking = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($subcarddividins->tracking_fee) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
                                                    @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        <br>
                                                    @endif
                                                </td>
                                                <td class="border px-4 py-2">
                                                    @foreach ($billdetails as $billdetail)
                                                        
                                                        @if($billdetail->ins_id == $subcardins->id && $billdetail->bill_number == $subcardins->bill_number && $billdetail->bill_status == 'cancel')
                                                        
                                                            @php
                                                                $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if($canceltotal != null)
                                                    
                                                        <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                            @php
                                                                $canceltotal = null;
                                                            @endphp
                                                            <br>
                                                    @else
                                                        {{ number_format($totalpayment) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null))
                                                                0<br>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                    @if ($subcarddividins->ins_id == $subcardins->id)
                                                        @foreach ($billdetails as $billdetail)
                                                            
                                                            @if($billdetail->subins_id == $subcarddividins->id && $billdetail->bill_number == $subcarddividins->bill_number && $billdetail->bill_status == 'cancel')
                                                                @php
                                                                    $canceltotal = intval($billdetail->list_payments) + intval($billdetail->list_fine) + intval($billdetail->list_tracking);
                                                                    break;
                                                                @endphp
                                                                
                                                            @endif
                                                        @endforeach
                                                        @if($canceltotal != null)
                                                            <span class="text-red-500 line-through">{{ number_format($canceltotal) }}</span>
                                                                @php
                                                                    $canceltotal = null;
                                                                @endphp
                                                                <br>
                                                        @else
                                                            {{ number_format($insinstotalpay) }}<br>
                                                            @foreach ($discounts as $discount)
                                                                @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                    0<br>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        {{ $content_lang['balance'].' :' }}<br>
                                                    @endif
                                                </td>
                                                <td class="border @if ($subcardins->balance > 0)) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                    {{ number_format($subcardins->balance) }}<br>
                                                    @php
                                                        $payablebalance = $subcardins->balance;
                                                    @endphp
                                                    @foreach ($discounts as $discount)
                                                        @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == null))
                                                            {{number_format($discount->balance)}}<br>
                                                            @php
                                                                $payablebalance = $discount->balance;
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @foreach ($subcarddividinss as $subcarddividins)
                                                    @if ($subcarddividins->ins_id == $subcardins->id)
                                                        {{ number_format($subcarddividins->balance) }}<br>
                                                        @php
                                                            $insinsbalance = $subcarddividins->balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $subcardins->id && $discount->sub_ins_id == $subcarddividins->id))
                                                                {{number_format($discount->balance)}}<br>
                                                                @php
                                                                    $insinsbalance = $discount->balance;
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @endforeach
                                                    @if($subdividins_count > 0)
                                                        {{ number_format($insinsbalance) }}<br>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                if($subdividins_count > 0){
                                                    $allinsinsbalance[] = $insinsbalance;
                                                }else{
                                                    $allinsinsbalance[] = $payablebalance;
                                                }
                                            @endphp
                                        @endforeach
                                        @php
                                            
                                            for($i=0;$i<count($allinsinsbalance);$i++){
                                                $sumallablebalance += $allinsinsbalance[$i];
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-300 even:bg-gray-100 font-bold">
                                            <td class="px-4 py-2"></td>
                                            <td class="px-4 py-2"></td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($sumsubins) }}</td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($sumprinciple) }}</td>
                                            <td class="text-gray-500 px-4 py-2">{{ number_format($suminterest) }}</td>
                                            <td class="px-4 py-2"></td>
                                            <td class="font-bold px-4 py-2">{{ $content_lang['total-payment'] }}</td>
                                            <td
                                                class="@if ($sumpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumpayment) }}</td>
                                            <td
                                                class="@if ($sumfine > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumfine) }}</td>
                                            <td
                                                class="@if ($sumtracking_fee > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumtracking_fee) }}</td>
                                            <td
                                                class="@if ($sumtotalpayment > 0) text-green-500 @else text-red-500 @endif px-4 py-2">
                                                {{ number_format($sumtotalpayment) }}</td>
                                            <td
                                                class="@if ($sumallablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ number_format($sumallablebalance) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="subins-endtable"></div>
                            </div>
                            
                        </div>

                    @endif
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
                                $down_sum_payment = 0;
                                $down_sum_down_balance = 0;
                                $down_sum_total_payment = 0;
                                $sumallfine = $down_sum_fine + $sumfine;
                                $sumalltracking_fee = $down_sum_tracking_fee + $sumtracking_fee;
                                $sumallpaymment = $down_sum_total_payment + $sumtotalpayment;
                                $sumallbalance = $down_sum_down_balance + $sumallablebalance;
                                
                            @endphp
                            <tbody class="border-2">
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $content_lang['total-down-pay'] }}</td>
                                    <td
                                        class="@if ($down_sum_payment > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                        {{ number_format($down_sum_payment) }}</td>
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
                                        class="@if ($sumallablebalance > 0) text-red-500 @else text-green-500 @endif border text-red-500 px-4 py-2">
                                        {{ number_format($sumallablebalance) }}</td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $content_lang['total-fine-pay'] }}</td>
                                    <td
                                        class="@if ($sumallfine > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                        {{ number_format($sumallfine) }}</td>
                                    <td class="border text-red-500 px-4 py-2">-</td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $content_lang['total-tracking-fee-pay'] }}</td>
                                    <td
                                        class="@if ($sumalltracking_fee > 0) text-green-500 @else text-red-500 @endif border px-4 py-2">
                                        {{ number_format($sumalltracking_fee) }}</td>
                                    <td class="border text-red-500 px-4 py-2">-</td>
                                </tr>
                                <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $content_lang['total-income'] }}</td>
                                    <td
                                        class="@if ($sumallpaymment > 0) text-green-500 @else text-red-500 @endif border text-green-400 px-4 py-2">
                                        {{ number_format($sumallpaymment) }}</td>
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
                </div>
            </div>
        </div>
    </div>

    <div id="modal-viewbill" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="ml-72 bg-white w-1/4 flex-col rounded-lg shadow-lg">
            <div class="flex bg-gray-300 py-2 rounded-t-lg justify-center items-center shadow-lg mb-4">
                <div class="ml-auto text-center">
                    <h1>รายการบิล</h1>
                </div>
                <div class="ml-auto mr-4">
                    <button class="justify-end font-bold" onclick="closeviewbillModal()">X</button>
                </div>
            </div>
                <div class="flex p-4">
                    <div class="w-full">

                        <div class="w-full flex items-center justify-center mb-1">
                            <form id="uploadform" action="{{route('uploadform')}}" method="POST">
                                @csrf
                                <input type="hidden" id="uploadform" name="cus_id" value="">
                                <input type="hidden" id="uploadform" name="bill_type" value="">
                                <input type="hidden" id="uploadform" name="bill_number" value="">
                                <button type="submit" class="hover:text-gray-400" >{{ $content_lang['upload-button'] }}</button>
                            </form>
                        </div>
                        <div class="w-full flex items-center justify-center mb-1">
                            <form id="getbillfile" action="{{route('getbillfile')}}" method="POST">
                                @csrf
                                <input type="hidden" id="getbillfile" name="cus_id" value="">
                                <input type="hidden" id="getbillfile" name="bill_type" value="">
                                <input type="hidden" id="getbillfile" name="bill_number" value="">
                                <button type="submit" class="hover:text-gray-400" >{{ $content_lang['view-button'] }}</button>
                            </form>
                        </div>

                        <div class="w-full flex items-center justify-center mb-1">
                            <form id="printotherbillform" action="{{ route('getotherbilldetail') }}" method="POST">
                                @csrf
                                <input type="hidden" id="printotherbillform" name="cus_id" value="">
                                <input type="hidden" id="printotherbillform" name="bill_type" value="">
                                <input type="hidden" id="printotherbillform" name="bill_number" value="">
                                <button id="printotherbillbutton" type="submit" class="hover:text-gray-400" data-form="printotherbillform">{{ $content_lang['printbill'] }}</button>
                            </form>
                        </div>

                        <div class="w-full flex items-center justify-center mb-4">
                            <form id="printbillform" action="{{route('printbill')}}" method="POST">
                                @csrf
                                <input type="hidden" id="printbillform" name="cus_id" value="">
                                <input type="hidden" id="printbillform" name="bill_type" value="">
                                <input type="hidden" id="printbillform" name="bill_number" value="">
                                <button id="printbillbutton" type="submit" class="hover:text-gray-400" data-form="printbillform">{{ $content_lang['printbill'] }}</button>
                            </form>
                        </div>
                        <div class="w-full flex items-center justify-center mb-4 text-red-500">
                            <form id="cancelbillform" action="{{route('cancelbill')}}" method="POST">
                                @csrf
                                <input type="hidden" id="cancelbillform" name="cus_id" value="">
                                <input type="hidden" id="cancelbillform" name="bill_type" value="">
                                <input type="hidden" id="cancelbillform" name="bill_number" value="">
                                <input type="hidden" id="cancelbillform" name="note" value="">
                                <button id="cancelbillbutton" type="submit" class="hover:text-gray-400" data-form="cancelbillform">{{ $content_lang['cancelbill'] }}</button>
                            </form>
                        </div>
                    </div>                    
                </div>
        </div>
    </div>
</x-app-layout>


<script>

    $(document).ready(function() {
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
            } else if (scroll>ins_top && scroll<ins_endtable){
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
            }else if (scroll>subins_top && scroll<subins_endtable){
                $("#clone").remove();
                if (scroll>subins_top && scroll<subins_endtable) {
                    clone_table = $("#clone");
                    if(clone_table.length == 0){
                        clone_table = $("#subinstable").clone();
                        clone_table.attr('id', 'clone');
                        clone_table.css({position:'fixed',
                                'pointer-events': 'none',
                                top:0});
                        clone_table.width($("#instable").width());
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
        
        $('#collapsecuscardmenu').click(function() {
            $('#cuscardmenu').slideToggle(300); // Toggle the visibility with a sliding animation
            $('#icon-collapsecuscardmenu').toggleClass('rotate-[360deg]');
/*             $(this).text(function(_, text) {
                return text === 'Showmenu' ? 'Hidemenu' : 'Showmenu';
            }); */
        });

        $('.deposit-submit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');
            $('button[id="cancelbillbutton"]').css("display", "block");
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            if(formData[3]['value'] == 'cancel'  || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "block");
            $('button[id="printbillbutton"]').css("display", "none");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
        $('.deli-submit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            console.log(formData);
            if(formData[3]['value'] == 'cancel' || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "block");
            $('button[id="printbillbutton"]').css("display", "none");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
        $('.ins_down-submit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            if(formData[3]['value'] == 'cancel'  || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "none");
            $('button[id="printbillbutton"]').css("display", "block");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
        $('.ins_insdown-submit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            if(formData[3]['value'] == 'cancel'  || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "none");
            $('button[id="printbillbutton"]').css("display", "block");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
        $('.ins-submit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            if(formData[3]['value'] == 'cancel'  || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "none");
            $('button[id="printbillbutton"]').css("display", "block");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
        $('.ins-inssubmit').on('click', function(e) {
            var printbillinput = $('input[id="printbillform"]');
            var printotherbillinput = $('input[id="printotherbillform"]');
            var uploadforminput = $('input[id="uploadform"]');
            var getbillfileinput = $('input[id="getbillfile"]');
            var cancelbillinput = $('input[id="cancelbillform"]');;
            var form = $(this).closest('form'); // Get the parent form of the clicked button
            var formData = form.serializeArray(); // Serialize form data into an array
            if(formData[3]['value'] == 'cancel'  || formData[4]['value'] != 'waiting'){
                $('button[id="cancelbillbutton"]').css("display", "none");
            }else{
                $('button[id="cancelbillbutton"]').css("display", "block");
            }
            $('button[id="printotherbillbutton"]').css("display", "none");
            $('button[id="printbillbutton"]').css("display", "block");
            for (let index = 0; index < printbillinput.length; index++) {
                printbillinput[index].value = formData[index]['value'];
                uploadforminput[index].value = formData[index]['value'];
                getbillfileinput[index].value = formData[index]['value'];
                cancelbillinput[index].value = formData[index]['value'];
                printotherbillinput[index].value = formData[index]['value'];
            }
        });
    });
    function closeviewbillModal() {
        let modalOverlay = document.getElementById('modal-viewbill');
        modalOverlay.classList.add('hidden');
    }
    function showviewbillmodal(e) {
        
        let modalOverlay = document.getElementById('modal-viewbill');
        modalOverlay.classList.remove('hidden');

    }

    function cancelnote(e) {
        let cancelnote = $('input[name="note"]');
        cancelnote.val(e.value);
    }

    $('#cancelbillform').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting by default
        let formData = $(this).serialize(); // Using serialize() method
        let submitData = [];
        $(this).find('input').each(function() {
            submitData.push({ 
            field : $(this).attr('name'),
            value : $(this).val()
            });
        });

        Swal.fire({
            title: '{!! $content_lang['cancelbill'] !!}<br>'+submitData[3]['value'],
            html: '<input type="text" onkeyup="cancelnote(this)" class="block mt-1 w-full pl-2 rounded-md" placeholder="{!! $content_lang['note'] !!}">',
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



</script>
