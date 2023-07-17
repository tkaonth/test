@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\billsystem.php');
    $calender = include base_path('lang\\' . session()->get('locale') . '\calender.php');
    
@endphp




<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content_lang['content-header-manage'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="w-fit">
                    <a class="flex pl-0 p-2 mb-5" href="{{ route('billsystem', ['id' => $cusdata->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                        </svg>
                        {{ $content_lang['new-back'] }}
                    </a>
                </div>
                @if ($message = Session::get('success'))
                    <script>
                        Swal.fire({
                            text: "{{ $message }}",
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                    </script>
                @endif
                @if ($message = Session::get('error'))
                    <script>
                        Swal.fire({
                            text: "{{ $message }}",
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    </script>
                @endif
                <form id="savebill" action="{{ route('savebill') }}" method="post">
                    @csrf
                    <div class="flex w-full">
                        <table class="w-full table mb-2 table-auto text-center">
                            <tbody>
                                <tr>
                                    <td class="text-lg">
                                        <div class="flex items-center justify-center w-full pr-5">
                                            <div class="ml-auto">
                                                {{ $content_lang['bill-company1'] }}<br>{{ $content_lang['bill-company2'] }}
                                            </div>
                                            <div class="ml-auto">
                                                {{-- {{$billnumber}}
                                                <input type="hidden" name="bill_number" value="{{$billnumber}}"> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex pl-10">
                        <table class="w-full table mb-2 table-auto text-start text-sm">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-lg">{{ $content_lang['company-name'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $content_lang['company-address1'] }}<br>
                                        {{ $content_lang['company-address2'] }}<br>
                                    </td>
                                </tr>
                                <tr><td>{{ $content_lang['bill-tel'] }}</td><td>{{ $content_lang['tel-acc'] }}</td></tr>
                                <tr><td></td><td>{{ $content_lang['tel-tech'] }}</td></tr>
                                <tr><td></td><td>{{ $content_lang['tel-part'] }}</td></tr>
                            </tbody>
                        </table>
                        <table class="w-3/12 table mb-2 table-auto text-center">
                            <tbody>
                                <tr>
                                    <td>LOGO</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full table mb-2 table-auto text-start text-sm">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-lg">{{ $content_lang['company-name'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $content_lang['bank-bcel'] }}
                                    </td></tr>
                                <tr><td class="w-fit pl-3">{{ $content_lang['bank-baht'] }}</td><td>{{ $content_lang['bcel-baht-acc'] }}</td></tr>
                                <tr><td class="w-fit pl-3">{{ $content_lang['bank-kip'] }}</td><td>{{ $content_lang['bcel-kip-acc'] }}</td></tr>
                                <tr><td colspan="2">{{ $content_lang['bank-kasikam'] }}</td></tr>
                                <tr><td class="w-fit pl-3">{{ $content_lang['bank-baht'] }}</td><td>{{ $content_lang['kasikam-baht-acc'] }}</td></tr>
                                <tr><td class="w-fit pl-3">{{ $content_lang['bank-kip'] }}</td><td>{{ $content_lang['kasikam-kip-acc'] }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="w-full table mb-2 table-auto text-center text-sm">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-lg text-blue-500">
                                    <div class="flex w-full justify-center items-center">
                                        {{ $content_lang['bill_type'] }}
                                        <select name="bill_type" id="bill_type" required
                                        class=" text-lg text-blue-500 border ml-2 w-40 mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-2">
                                            <option value="" selected disabled>-------</option>
                                            <option value="normal_bill">{{ $content_lang['bill'] }}</option>
                                            <option value="discount_bill">{{ $content_lang['discount'] }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start pl-10">
                                    <div class="flex items-center justify-between pr-5" >
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-branch'] }}
                                            <select name="branch" id="branch" required
                                            class="border ml-2 w-40 h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-2 p-1">
                                                <option value="" selected disabled>-------</option>
                                                <option value="AD">AD</option>
                                                <option value="KM">KM</option>
                                                <option value="BK">BK</option>
                                                <option value="PL">PL</option>
                                                <option value="SHOP">ร้านเหล็ก</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-pay-type'] }}
                                            <select name="payment_type" id="payment_type" required
                                            class="border ml-2 w-40 h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-2 p-1">
                                                <option value="" selected disabled>-------</option>
                                                <option value="BCEL-KTP">BCEL-KTP</option>
                                                <option value="BCEL-LJT">BCEL-LJT</option>
                                                <option value="Cash">{{ $content_lang['cash'] }}</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-date'] }}
                                            <input id="bill_date" name="bill_date" type="text"
                                            class="block h-8 ml-2 mt-1 w-40 border-gray-300 rounded-md datepicker flatpickr-input"
                                            required
                                            value="{{ old('bill_date') }}">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <input type="hidden" name="cus_id" value="{{ $cusdata->id }}">
                                <input type="hidden" name="cus_code" value="{{$cusdata->cus_code}}">
                                <td colspan="2" class="text-start pl-10">{{$content_lang['cus-code'].' '.$cusdata->cus_code.' '.$content_lang['cus-name'].' '.$cusdata->cus_name}}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start pl-10">{{$content_lang['address'].' '.$cusdata->cus_address.' '.$content_lang['group'].' '.$cusdata->cus_group.' '.$content_lang['village'].' '.$cusdata->cus_village.' '.$content_lang['city'].' '.$cusdata->cus_city.' '.$cusdata->cus_district.'  '.$content_lang['tel'].' '.$cusdata->cus_tel}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="w-full table mb-2 table-auto border-2 text-center text-sm">
                        <thead class="border-2 text-center bg-blue-300">
                            <tr class="border-2 text-center">
                                <td rowspan="2" class="border-2 border-blue-500">{{$content_lang['number']}}</td>
                                <td rowspan="2" width="30%" class="border-2 border-blue-500">{{$content_lang['table-list']}}</td>
                                <td rowspan="2" width="10%" class="border-2 border-blue-500">{{$content_lang['ins']}}</td>
                                <td rowspan="2" width="10%" class="border-2 border-blue-500">{{$content_lang['fine']}}</td>
                                <td rowspan="2" width="10%" class="border-2 border-blue-500">{{$content_lang['tracking']}}</td>
                                <td colspan="2" class="border-2 border-blue-500">{{$content_lang['amount']}}</td>
                            </tr>
                            <tr>
                                <td class="border-2 border-blue-500">{{$content_lang['baht']}}</td>
                                <td class="border-2 border-blue-500">{{$content_lang['kip']}}</td>
                            </tr>
                        </thead>
                        <tbody class="border-2 border-blue-500">
                            @php
                                $counter = 0;
                                $sumpayment = 0;
                            @endphp
                            @if($ins_downs)
                            <tr>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500 bg-blue-300">{{$content_lang['ins-down']}}</td>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500"></td>
                            </tr>
                                @foreach ($ins_downs as $ins_down)
                                    @php
                                        $counter++;
                                        $divid_num = 0;
                                        if($ins_down->payment > 0 ){
                                            $flaginspay = true;
                                        }else{
                                            $flaginspay = false;
                                        }
                                        
                                        $ins_down_number = $ins_down->ins_down_number;
                                        $appoint_pay = $ins_down->appoint_pay - $ins_down->payment;
                                    @endphp
                                    @foreach ($ins_insdowns as $ins_insdown)
                                        @php
                                            if($ins_insdown->ins_id == $ins_down->id){
                                                $ins_down_balance = $ins_insdown->balance;
                                                $divid_num = $ins_insdown->ins_number;
                                                $flaginspay = true;
                                                $ins_down_number = $ins_insdown->ins_number;
                                                $appoint_pay = $ins_insdown->balance;
                                            }
                                        @endphp
                                    @endforeach
                                    @for ($i = 0; $i < count($ins_downs_data['id']); $i++)
                                        @if ($ins_downs_data['id'][$i] == $ins_down->id)
                                            @php
                                                $sumpayment += intval($ins_downs_data['total'][$i]);
                                            @endphp
                                            <tr>
                                                <td class="border-2 border-blue-500">{{$counter}}</td>
                                                <td class="border-2 border-blue-500">
                                                    {{'งวดที่ '.$ins_down->ins_down_number}} 
                                                </td>
                                                <td class="border-2 border-blue-500">{{ number_format($ins_downs_data['payment'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">{{ number_format($ins_downs_data['fine'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">{{ number_format($ins_downs_data['tracking'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">
                                                    {{ number_format($ins_downs_data['total'][$i]) }} 
                                                    <input type="hidden" name="ins_down_id[]" value="{{ $ins_down->id }}">
                                                    <input type="hidden" name="ins_down_divid_num[]" @if ($flaginspay)
                                                    value="{{ $divid_num+1 }}"
                                                    @else
                                                    value="0"
                                                    @endif >
                                                    <input type="hidden" name="ins_down_number[]" value="{{$ins_down_number}}">
                                                    <input type="hidden" name="list_type[]" @if($flaginspay) value="ins_insdown" @else value="ins_down" @endif >
                                                    <input type="hidden" name="ins_down_appointpay[]" value="{{$appoint_pay}}">
                                                    <input type="hidden" name="ins_down_name[]" value="{{'งวดที่ '.$ins_down->ins_down_number}}">
                                                    <input type="hidden" name="ins_down_payment[]" value="{{ $ins_downs_data['payment'][$i] }}">
                                                    <input type="hidden" name="ins_down_fine[]" value="{{ $ins_downs_data['fine'][$i] }}">
                                                    <input type="hidden" name="ins_down_tracking[]" value="{{ $ins_downs_data['tracking'][$i] }}">
                                                    <input type="hidden" name="ins_down_balance[]" value="{{ $ins_downs_data['balance'][$i] }}">
                                                </td>
                                                <td class="border-2 border-blue-500">-</td>
                                            </tr>
                                        @endif
                                    @endfor                          
                                @endforeach
                                
                            @endif
                            @if($inss)
                                <tr>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500 bg-blue-300">{{$content_lang['ins']}}</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                </tr>
                                @php
                                    $countinspay = 0;
                                @endphp
                                @foreach ($inss as $ins)
                                    @php
                                        $divid_num = 0;
                                        $counter++;
                                        $countinspay++;
                                        if($ins->payment > 0 ){
                                            $flaginspay = true;
                                        }else{
                                            $flaginspay = false;
                                        }
                                        $ins_number = $ins->ins_number;
                                        $appoint_pay = $ins->appoint_pay - $ins->payment;
                                    @endphp
                                    @foreach ($ins_inss as $ins_ins)
                                        @php
                                            if($ins_ins->ins_id == $ins->id){
                                                $ins_balance = $ins_ins->balance;
                                                $divid_num = $ins_ins->ins_number;
                                                $flaginspay = true;
                                                $ins_number = $ins->ins_number;
                                                $appoint_pay = $ins_ins->balance;
                                            }
                                        @endphp
                                    @endforeach
                                    @for ($i = 0; $i < count($inss_data['id']); $i++)
                                        @if ($inss_data['id'][$i] == $ins->id)
                                            @php
                                                $sumpayment += intval($inss_data['total'][$i]);
                                            @endphp
                                            <tr>
                                                <td class="border-2 border-blue-500">{{$counter}}</td>
                                                <td class="border-2 border-blue-500">
                                                    {{'งวดที่ '.$ins->ins_number}}
                                                </td>
                                                <td class="border-2 border-blue-500">{{ number_format($inss_data['payment'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">{{ number_format($inss_data['fine'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">{{ number_format($inss_data['tracking'][$i]) }}</td>
                                                <td class="border-2 border-blue-500">
                                                    {{ number_format($inss_data['total'][$i]) }} 
                                                    <input type="hidden" name="ins_id[]" value="{{ $ins->id }}">
                                                    <input type="hidden" name="ins_divid_num[]" @if ($flaginspay)
                                                    value="{{ $divid_num+1 }}"
                                                    @else
                                                    value="0"
                                                    @endif >
                                                    <input type="hidden" name="list_type[]" @if($flaginspay) value="ins_ins" @else value="ins" @endif >
                                                    <input type="hidden" name="ins_number[]" value="{{$ins_number}}">
                                                    <input type="hidden" name="ins_name[]" value="{{'งวดที่ '.$ins->ins_number}}">
                                                    <input type="hidden" name="ins_appointpay[]" value="{{$appoint_pay}}">
                                                    <input type="hidden" name="ins_payment[]" value="{{ $inss_data['payment'][$i] }}">
                                                    <input type="hidden" name="ins_fine[]" value="{{ $inss_data['fine'][$i] }}">
                                                    <input type="hidden" name="ins_tracking[]" value="{{ $inss_data['tracking'][$i] }}">
                                                    <input type="hidden" name="ins_balance[]" value="{{ $inss_data['balance'][$i] }}">
                                                </td>
                                                <td class="border-2 border-blue-500">-</td>
                                            </tr>
                                        @endif
                                    @endfor
                                @endforeach
                            @endif
                            
                            <tr>
                                <td colspan="4" class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500">{{$content_lang['sum-cash']}}</td>
                                <td class="border-2 border-blue-500">{{number_format($sumpayment)}}</td>
                                <td class="border-2 border-blue-500">-</td>
                            </tr>
                        </tbody>
                    </table>
    
                    <table class="w-full table mb-2 table-auto text-center text-sm">
                        <tbody>
                            <tr height="30px">
                                <td class="border-r-0 border-2 border-blue-500">
                                    {{$content_lang['payee']}}
                                </td>
                                <td width="80%" class="border-l-0 border-2 border-blue-500">
                                    
                                </td>
                                <td class="border-2 border-blue-500 bg-blue-300">
                                    {{$content_lang['thank1']}}<br>
                                    {{$content_lang['thank2']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="w-full table mb-2 table-auto text-center text-sm">
                        <tbody>
                            <tr>
                                <td>
                                    {{$content_lang['note1']}}<br>
                                    {{$content_lang['note2']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-end">
                        <button type="submit"
                        class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{$content_lang['bill-button']}}</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>

<script>
var calender = JSON.parse('<?php echo $calender; ?>');
$(document).ready(function() {
    const element = document.querySelectorAll('.datepicker-dropdown');
    var datepickerOptions = {
        allowInput: true,
        // Configuration options
        dateFormat: "d/m/Y",
        // Add more options as needed
        locale: calender
    };
    var datepickerInputs = document.getElementsByClassName("datepicker");
    var bill_branch =$("#bill_branch_form");
    var bill_date = $("#bill_date_form");
    console.log(bill_branch);
    console.log(bill_date);
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
    var date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const dateFormat = [day, month, year].join('/');

    $('#bill_date').val(dateFormat);
    $('#bill_date_form').val(dateFormat);
});

$('#savebill').submit(function(e) {
    e.preventDefault(); // Prevent the form from submitting by default

    Swal.fire({
        title: '{!! $content_lang['bill-button'] !!}',
        text: '{!! $content_lang['alert-text'] !!}',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: '{!! $content_lang['alert-cancel'] !!}',
        confirmButtonText: '{!! $content_lang['alert-confirm'] !!}',
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, submit the form
                $(this).off('submit').submit(); // Remove the submit event listener and submit the form
            }
        });
});
</script>
