@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\billsystem.php');
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-manage'] }}
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
                        <div class="flex w-full items-center p-2">
                            <div class="w-full p-2 rounded-md mr-5">
                                <div class="p-2">
                                    <div class="flex justify-between text-xl my-1">
                                        <div>
                                            {{ $content_lang['cus-name'] }}&nbsp;{{ $cusdata->cus_name }}
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
                                            {{ $content_lang['car-num'] }}&nbsp;{{ $cardata->car_number }}
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
                                            {{ $content_lang['engine-num'] }}&nbsp;{{ $cardata->engine_number }}
                                        </div>
                                        <div>
                                            {{ $content_lang['cus-st'] }}&nbsp;
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
                                            {{ $content_lang['tel'] }}&nbsp;{{ $cusdata->cus_tel }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" id="insdata" action="{{ route('createbill') }}">
                        @csrf
                        <input type="hidden" name="cus_id" value="{{ $cusdata->id }}">
                        <div class="my-1">
                            <table class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
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
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['balance'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['status'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['sel-pay'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['payment'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['fine'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['tracking'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['total-pay'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['balance'] }}</th>
                                    </tr>
                                </thead>
                                <tbody class="border-2">
                                    @php
                                        $down_count = 0;
                                        $down_sum_payment = $cusdata->deposit + $cusdata->down_pay_deli;
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
                                    @endphp
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
                                            
                                            $down_totalpayment = 0;
                                            $down_balance = 0;
                                            $ins_down_id = $ins_down->id;
                                        @endphp
                                        <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">{{ $content_lang['payable-down'] }}
                                                {{ $down_count }}</td>
                                                
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
                                                            $ins_down_id = $ins_insdown->ins_id;
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
                                                @if ($count_insdown > 0)
                                                    <br>
                                                @endif
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ number_format($ins_down->appoint_pay) }}<br>
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $ins_down->id) && ($discount->sub_ins_id == null))
                                                        {{ $content_lang['discount'] }}<br>
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        {{ number_format($ins_insdown->appoint_pay) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id) && ($discount->sub_ins_id == $ins_insdown->id))
                                                                {{ $content_lang['discount'] }}<br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                            
                                                @if ($count_insdown > 0)
                                                    {{ $content_lang['balance'] . ' :' }}<br>
                                                @endif
                                            </td>
                                            <td
                                                class="border @if ($ins_down->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ number_format($ins_down->balance) }}<br>
                                                @php
                                                    $down_balance = $ins_down->balance;
                                                @endphp
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $ins_down->id) && ($discount->sub_ins_id == null))
                                                        {{ number_format($discount->balance) }}<br>
                                                        @php
                                                            $down_balance = $discount->balance;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_insdowns as $ins_insdown)
                                                    @if ($ins_insdown->ins_id == $ins_down->id)
                                                        {{ number_format($ins_insdown->balance) }}<br>
                                                        @php
                                                            $insdown_balance = $ins_insdown->balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $ins_down->id) && ($discount->sub_ins_id == $ins_insdown->id))
                                                                {{ number_format($discount->balance) }}<br>
                                                                @php
                                                                    $insdown_balance = $discount->balance;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @php
                                                    if ($count_insdown > 0) {
                                                        $all_down_insdown_balance[] = $insdown_balance;
                                                        $down_balance = $insdown_balance;
                                                    } else {
                                                        $all_down_insdown_balance[] = $down_balance;
                                                    }
                                                    $down_totalpayment = $ins_down->payment + $ins_down->fine + $ins_down->tracking_fee;
                                                    
                                                @endphp
                                                @if ($count_insdown > 0)
                                                    {{ number_format($down_balance) }}<br>
                                                @endif
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ $ins_down->status }}
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                @if ($ins_down->status != 'close' && $ins_down->status != 'waiting approve')
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="ins_down_id[]"
                                                            id="{{ $down_balance }}"
                                                            value="{{ $ins_down->id }}"
                                                           
                                                            class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                                        <span class="ml-2">{{ $content_lang['pay-ins'] }}</span>
                                                    </label>
                                                @endif
                                            </td>
                                            <td 
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsdownpay[]" id="{{$ins_down->id}}">
                                                </div>  
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsdownfine[]" id="{{$ins_down->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsdowntracking[]" id="{{$ins_down->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsdowntotal[]" id="{{$ins_down->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($down_balance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsdownbalance[]" id="{{$ins_down->id}}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @php
                                        for ($i = 0; $i < count($all_down_insdown_count); $i++) {
                                            $down_sum_payment += $all_down_insdown_payment[$i];
                                            $down_sum_fine += $all_down_insdown_fine[$i];
                                            $down_sum_tracking_fee += $all_down_insdown_trackingfee[$i];
                                            $down_sum_total_payment += $all_down_insdown_totalpayment[$i];
                                            $down_sum_down_balance += $all_down_insdown_balance[$i];
                                        }
                                        $down_sum_total_payment = $down_sum_total_payment + $cusdata->deposit + $cusdata->down_pay_deli;
                                    @endphp
                                    <tr class="border-0 font-bold">
                                        <td class="border-0 px-4 py-2"></td>
                                        <td class="border-0 px-4 py-2"></td>
                                        <td class="border-0 px-4 py-2">{{ $content_lang['balance'] }}</td>
                                        <td
                                            class="@if ($down_sum_down_balance > 0) text-red-500 @else text-green-500 @endif border-0  px-4 py-2">
                                            {{ number_format($down_sum_down_balance) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="my-1">
                            <table class="w-full table mb-2 table-auto border-2 text-center rounded-lg">
                                <thead class="bg-gray-400 drop-shadow-lg text-lg">
                                    <tr>
                                        <th colspan="11" class="px-4 py-2">
                                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                                {{ $content_lang['ins-down'] }}
                                            </h2>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['table-list'] }}</th>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['appoint-date'] }}</th>
                                        <th class="bg-orange-300 px-4 py-2">{{ $content_lang['ins'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['payable-balance'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['status'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['sel-pay'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['payment'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['fine'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['tracking'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['total-pay'] }}</th>
                                        <th class="bg-green-400 px-4 py-2">{{ $content_lang['balance'] }}</th>
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
                                            $insinscount = 0;
                                            $insinstotalpay = 0;
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
                                            
                                        @endphp
                                        <tr class="border-2 hover:bg-gray-300 even:bg-gray-100">
                                            <td class="border px-4 py-2">
                                                {{ $content_lang['ins-num'] . ' ' . $inscount }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $insdata->appoint_date }}<br>
                                                @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        @php
                                                            $insinscount++;
                                                            $insinstotalpay = $ins_ins->payment + $ins_ins->fine + $ins_ins->tracking_fee;
                                                            $sumins += intval($ins_ins->appoint_pay);
                                                            $sumpayment += intval($ins_ins->payment);
                                                            $sumfine += intval($ins_ins->fine);
                                                            $sumtracking_fee += intval($ins_ins->tracking_fee);
                                                            $sumtotalpayment += $insinstotalpay;
                                                            $insinsbalance = $ins_ins->balance;
                                                        @endphp
                                                        <br>
                                                    @endif
                                                @endforeach
                                                @if ($insinscount > 0)
                                                    <br>
                                                @endif

                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ number_format($insdata->appoint_pay) }}<br>
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $insdata->id) && ($discount->sub_ins_id == null))
                                                        {{ $content_lang['discount'] }}<br>
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        {{ number_format($ins_ins->appoint_pay) }}<br>
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id) && ($discount->sub_ins_id == $ins_ins->id))
                                                                {{ $content_lang['discount'] }}<br>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @if ($insinscount > 0)
                                                    {{ $content_lang['balance'] . ' :' }}<br>
                                                @endif
                                            </td>
                                            <td
                                                class="border @if ($insdata->balance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ number_format($insdata->balance) }}<br>
                                                @php
                                                    $payablebalance = $insdata->balance;
                                                @endphp
                                                @foreach ($discounts as $discount)
                                                    @if (($discount->ins_id == $insdata->id) && ($discount->sub_ins_id == null))
                                                        {{ number_format($discount->balance) }}<br>
                                                    @php
                                                        $payablebalance = $discount->balance;
                                                    @endphp
                                                    @endif
                                                @endforeach
                                                @foreach ($ins_inss as $ins_ins)
                                                    @if ($ins_ins->ins_id == $insdata->id)
                                                        {{ number_format($ins_ins->balance) }}<br>
                                                        @php
                                                            $insinsbalance = $ins_ins->balance;
                                                        @endphp
                                                        @foreach ($discounts as $discount)
                                                            @if (($discount->ins_id == $insdata->id) && ($discount->sub_ins_id == $ins_ins->id))
                                                                {{ number_format($discount->balance) }}<br>
                                                            @php
                                                                $insinsbalance = $discount->balance;
                                                            @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @php
                                                    if ($insinscount > 0) {
                                                        $allinsinsbalance[] = $insinsbalance;
                                                        $payablebalance = $insinsbalance;
                                                    } else {
                                                        $allinsinsbalance[] = $payablebalance;
                                                    }
                                                @endphp
                                                @if ($insinscount > 0)
                                                    {{ number_format($insinsbalance) }}<br>
                                                @endif
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                {{ $insdata->status }}
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                                @if ($insdata->status != 'close'  && $insdata->status != 'waiting approve')
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="ins_id[]" id="{{ $payablebalance }}"
                                                            value="{{ $insdata->id }}"
                                                            class="form-checkbox rounded-md h-5 w-5 text-gray-600 border-gray-300 checked:hover:bg-blue-500 focus:bg-blue-500 checked:bg-blue-500 hover:bg-blue-500">
                                                        <span class="ml-2">{{ $content_lang['pay-ins'] }}</span>
                                                    </label>
                                                @endif
                                            </td>
                                            <td 
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinspay[]" id="{{$insdata->id}}">
                                                </div>  
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsfine[]" id="{{$insdata->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinstracking[]" id="{{$insdata->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinstotal[]" id="{{$insdata->id}}">
                                                </div>
                                            </td>
                                            <td
                                                class="border @if ($payablebalance > 0) text-red-500 @else text-green-500 @endif w-32 px-4 py-2">
                                                <div name="displayinsbalance[]" id="{{$insdata->id}}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @php
                                        for ($i = 0; $i < count($allinsinsbalance); $i++) {
                                            $sumallablebalance += $allinsinsbalance[$i];
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-300 even:bg-gray-100 font-bold">
                                        <td class="px-4 py-2"></td>
                                        <td class="px-4 py-2"></td>
                                        <td class="font-bold px-4 py-2">{{ $content_lang['total-pay'] }}</td>
                                        <td
                                            class="@if ($sumallablebalance > 0) text-red-500 @else text-green-500 @endif px-4 py-2">
                                            {{ number_format($sumallablebalance) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex mt-2 justify-end pr-4 pb-4">
                            <button type="submit"
                                class="p-2 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['edit-editbutton'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
$('input[type="checkbox"][name="ins_down_id[]"]').on('change', function() {
    let displayinsdownpay = document.querySelectorAll('div[name="displayinsdownpay[]"]');
    let displayinsdownfine = document.querySelectorAll('div[name="displayinsdownfine[]"]');
    let displayinsdowntracking = document.querySelectorAll('div[name="displayinsdowntracking[]"]');
    let displayinsdowntotal = document.querySelectorAll('div[name="displayinsdowntotal[]"]');
    let displayinsdownbalance = document.querySelectorAll('div[name="displayinsdownbalance[]"]');
    let insdownpayId = parseInt($(this).attr('id'));
    let insdownpayVal = $(this).val();
    if ($(this).is(':checked')) {
        // Checkbox is checked, perform desired actions
        for (let i = 0; i < displayinsdownpay.length; i++) {
            if(insdownpayVal == displayinsdownpay[i].id){
                const insdownpaydiv = displayinsdownpay[i];
                const insdowninput = document.createElement('input');
                insdowninput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insdowninput.name = "ins_down_payment[]";
                insdowninput.id = insdownpayVal;
                insdowninput.setAttribute('type', "number");
                insdowninput.setAttribute('max', insdownpayId);
                insdowninput.setAttribute('value', insdownpayId);
                insdowninput.setAttribute('onchange', "calinsdownbalance(this)");

                const insdownfinediv = displayinsdownfine[i];
                const insdownfineinput = document.createElement('input');
                insdownfineinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insdownfineinput.name = "ins_down_fine[]";
                insdownfineinput.id = insdownpayVal;
                insdownfineinput.setAttribute('type', "number");
                insdownfineinput.setAttribute('value', "0");
                insdownfineinput.setAttribute('onchange', "calinsdownbalance(this)");

                const insdowntrackingdiv = displayinsdowntracking[i];
                const insdowntrackinginput = document.createElement('input');
                insdowntrackinginput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insdowntrackinginput.name = "ins_down_tracking[]";
                insdowntrackinginput.id = insdownpayVal;
                insdowntrackinginput.setAttribute('type', "number");
                insdowntrackinginput.setAttribute('value', "0");
                insdowntrackinginput.setAttribute('onchange', "calinsdownbalance(this)");

                const insdowntotaldiv = displayinsdowntotal[i];
                const insdowntotalinput = document.createElement('input');
                insdowntotalinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insdowntotalinput.name = "ins_down_total[]";
                insdowntotalinput.id = insdownpayVal;
                insdowntotalinput.setAttribute('type', "text");
                insdowntotalinput.setAttribute('readonly',true);
                insdowntotalinput.setAttribute('value', insdownpayId.toLocaleString());

                const insdownbalancediv = displayinsdownbalance[i];
                const insdownbalanceinput = document.createElement('input');
                insdownbalanceinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insdownbalanceinput.name = "ins_down_balance[]";
                insdownbalanceinput.id = insdownpayVal;
                insdownbalanceinput.setAttribute('type', "text");
                insdownbalanceinput.setAttribute('readonly',true);
                insdownbalanceinput.setAttribute('value', "0");

                insdownpaydiv.appendChild(insdowninput);
                insdownfinediv.appendChild(insdownfineinput);
                insdowntrackingdiv.appendChild(insdowntrackinginput);
                insdowntotaldiv.appendChild(insdowntotalinput);
                insdownbalancediv.appendChild(insdownbalanceinput);
                break;
            }
        }
        
    } else {
        // Checkbox is unchecked
        for (let i = 0; i < displayinsdownpay.length; i++) {
            if(insdownpayVal == displayinsdownpay[i].id){
                const insdownpaydiv = displayinsdownpay[i];
                const insdownfinediv = displayinsdownfine[i];
                const insdowntrackingdiv = displayinsdowntracking[i];
                const insdowntotaldiv = displayinsdowntotal[i];
                const insdownbalancediv = displayinsdownbalance[i];
                
                while (insdownpaydiv.firstChild) {
                    insdownpaydiv.removeChild(insdownpaydiv.firstChild);
                }
                while (insdownfinediv.firstChild) {
                    insdownfinediv.removeChild(insdownfinediv.firstChild);
                }
                while (insdowntrackingdiv.firstChild) {
                    insdowntrackingdiv.removeChild(insdowntrackingdiv.firstChild);
                }
                while (insdowntrackingdiv.firstChild) {
                    insdowntrackingdiv.removeChild(insdowntrackingdiv.firstChild);
                }
                while (insdowntotaldiv.firstChild) {
                    insdowntotaldiv.removeChild(insdowntotaldiv.firstChild);
                }
                while (insdownbalancediv.firstChild) {
                    insdownbalancediv.removeChild(insdownbalancediv.firstChild);
                }
            }
        }
    }
});

$('input[type="checkbox"][name="ins_id[]"]').on('change', function() {
    let displayinspay = document.querySelectorAll('div[name="displayinspay[]"]');
    let displayinsfine = document.querySelectorAll('div[name="displayinsfine[]"]');
    let displayinstracking = document.querySelectorAll('div[name="displayinstracking[]"]');
    let displayinstotal = document.querySelectorAll('div[name="displayinstotal[]"]');
    let displayinsbalance = document.querySelectorAll('div[name="displayinsbalance[]"]');
    let inspayId = parseInt($(this).attr('id'));
    let inspayVal = $(this).val();
    if ($(this).is(':checked')) {
        // Checkbox is checked, perform desired actions
        for (let i = 0; i < displayinspay.length; i++) {
            if(inspayVal == displayinspay[i].id){
                const inspaydiv = displayinspay[i];
                const insinput = document.createElement('input');
                insinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insinput.name = "ins_payment[]";
                insinput.id = inspayVal;
                insinput.setAttribute('type', "number");
                insinput.setAttribute('value', inspayId);
                insinput.setAttribute('onchange', "calinsbalance(this)");

                const insfinediv = displayinsfine[i];
                const insfineinput = document.createElement('input');
                insfineinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insfineinput.name = "ins_fine[]";
                insfineinput.id = inspayVal;
                insfineinput.setAttribute('type', "number");
                insfineinput.setAttribute('value', "0");
                insfineinput.setAttribute('onchange', "calinsbalance(this)");

                const instrackingdiv = displayinstracking[i];
                const instrackinginput = document.createElement('input');
                instrackinginput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                instrackinginput.name = "ins_tracking[]";
                instrackinginput.id = inspayVal;
                instrackinginput.setAttribute('type', "number");
                instrackinginput.setAttribute('value', "0");
                instrackinginput.setAttribute('onchange', "calinsbalance(this)");

                const instotaldiv = displayinstotal[i];
                const instotalinput = document.createElement('input');
                instotalinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                instotalinput.name = "ins_total[]";
                instotalinput.id = inspayVal;
                instotalinput.setAttribute('type', "text");
                instotalinput.setAttribute('readonly',true);
                instotalinput.setAttribute('value', inspayId.toLocaleString());

                const insbalancediv = displayinsbalance[i];
                const insbalanceinput = document.createElement('input');
                insbalanceinput.className = "block h-8 mt-1 w-full pl-1 border-gray-300 rounded-md text-center";
                insbalanceinput.name = "ins_balance[]";
                insbalanceinput.id = inspayVal;
                insbalanceinput.setAttribute('type', "text");
                insbalanceinput.setAttribute('readonly',true);
                insbalanceinput.setAttribute('value', "0");

                inspaydiv.appendChild(insinput);
                insfinediv.appendChild(insfineinput);
                instrackingdiv.appendChild(instrackinginput);
                instotaldiv.appendChild(instotalinput);
                insbalancediv.appendChild(insbalanceinput);
                break;
            }
        }
        
    } else {
        // Checkbox is unchecked
        for (let i = 0; i < displayinspay.length; i++) {
            if(inspayVal == displayinspay[i].id){
                const inspaydiv = displayinspay[i];
                const insfinediv = displayinsfine[i];
                const instrackingdiv = displayinstracking[i];
                const instotaldiv = displayinstotal[i];
                const insbalancediv = displayinsbalance[i];
                
                while (inspaydiv.firstChild) {
                    inspaydiv.removeChild(inspaydiv.firstChild);
                }
                while (insfinediv.firstChild) {
                    insfinediv.removeChild(insfinediv.firstChild);
                }
                while (instrackingdiv.firstChild) {
                    instrackingdiv.removeChild(instrackingdiv.firstChild);
                }
                while (instrackingdiv.firstChild) {
                    instrackingdiv.removeChild(instrackingdiv.firstChild);
                }
                while (instotaldiv.firstChild) {
                    instotaldiv.removeChild(instotaldiv.firstChild);
                }
                while (insbalancediv.firstChild) {
                    insbalancediv.removeChild(insbalancediv.firstChild);
                }
            }
        }
    }
});

function calinsdownbalance(e) {
    let ins_down_payment = document.querySelectorAll('input[type="number"][name="ins_down_payment[]"]');
    let ins_down_fine = document.querySelectorAll('input[type="number"][name="ins_down_fine[]"]');
    let ins_down_tracking = document.querySelectorAll('input[type="number"][name="ins_down_tracking[]"]');
    let ins_down_total = document.querySelectorAll('input[type="text"][name="ins_down_total[]"]');
    let insdownbalance = document.querySelectorAll('input[type="text"][name="ins_down_balance[]"]');
    let ins_down_id = document.querySelectorAll('input[type="checkbox"][name="ins_down_id[]"]');
    let appoint_pay = 0;
    for (let j = 0; j < ins_down_id.length; j++) {
        if(ins_down_id[j].value == e.id){
            appoint_pay = ins_down_id[j].id;
            break;
        }
    }
    for (let i = 0; i < ins_down_payment.length; i++) {
        if(ins_down_payment[i].id == e.id){
            console.log(ins_down_payment[i].value);
            let balance = appoint_pay - ins_down_payment[i].value;
            let total = parseInt(ins_down_payment[i].value) + parseInt(ins_down_fine[i].value) + parseInt(ins_down_tracking[i].value);
            ins_down_total[i].value = total;
            insdownbalance[i].value = balance;
            break;
        }
    }
}
function calinsbalance(e) {
    let ins_payment = document.querySelectorAll('input[type="number"][name="ins_payment[]"]');
    let ins_fine = document.querySelectorAll('input[type="number"][name="ins_fine[]"]');
    let ins_tracking = document.querySelectorAll('input[type="number"][name="ins_tracking[]"]');
    let ins_total = document.querySelectorAll('input[type="text"][name="ins_total[]"]');
    let insbalance = document.querySelectorAll('input[type="text"][name="ins_balance[]"]');
    let ins_id = document.querySelectorAll('input[type="checkbox"][name="ins_id[]"]');
    let appoint_pay = 0;
    for (let j = 0; j < ins_id.length; j++) {
        if(ins_id[j].value == e.id){
            appoint_pay = ins_id[j].id;
            break;
        }
    }
    for (let i = 0; i < ins_id.length; i++) {
        if(ins_payment[i].id == e.id){
            let balance = appoint_pay - ins_payment[i].value;
            let total = parseInt(ins_payment[i].value) + parseInt(ins_fine[i].value) + parseInt(ins_tracking[i].value);
            ins_total[i].value = total;
            insbalance[i].value = balance;
            break;
        }
    }
}
</script>
