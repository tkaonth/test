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
                    <a class="flex pl-0 p-2 mb-5" href="{{ route('otherbill') }}">
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
                <div id="printbill">
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
                                <tr>
                                    <td>{{ $content_lang['bill-tel'] }}</td>
                                    <td>{{ $content_lang['tel-acc'] }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $content_lang['tel-tech'] }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $content_lang['tel-part'] }}</td>
                                </tr>
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
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-fit pl-3">{{ $content_lang['bank-baht'] }}</td>
                                    <td>{{ $content_lang['bcel-baht-acc'] }}</td>
                                </tr>
                                <tr>
                                    <td class="w-fit pl-3">{{ $content_lang['bank-kip'] }}</td>
                                    <td>{{ $content_lang['bcel-kip-acc'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{ $content_lang['bank-kasikam'] }}</td>
                                </tr>
                                <tr>
                                    <td class="w-fit pl-3">{{ $content_lang['bank-baht'] }}</td>
                                    <td>{{ $content_lang['kasikam-baht-acc'] }}</td>
                                </tr>
                                <tr>
                                    <td class="w-fit pl-3">{{ $content_lang['bank-kip'] }}</td>
                                    <td>{{ $content_lang['kasikam-kip-acc'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                   
                    <form action="{{ route('storeotherbill') }}" id="savebill" method="post">
                        @csrf
                        <table class="w-full table mb-2 table-auto text-center text-sm">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-lg text-blue-500">{{ $content_lang['bill'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start pl-10 ">
                                        <div class="flex items-center justify-between pr-5">
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
                                                {{ $content_lang['bill_type'] }}
                                                <select name="bill_type" id="bill_type" required onchange="setbilltype(this)"
                                                class="border ml-2 w-40 h-8 mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-2 p-1">
                                                    <option value="" selected disabled>-------</option>
                                                    <option value="deposit_bill">{{ $content_lang['deposit-bill'] }}</option>
                                                    <option value="deli_bill">{{ $content_lang['downdeli-bill'] }}</option>
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
                                    <td colspan="2" class="text-start pl-10">
                                        <div class="flex items-center space-x-2">
                                            {{ $content_lang['cus-name'] }} <input type="text" name="cus_name" class="block h-8 mx-2 mt-1 w-1/3 pl-1 border-gray-300 rounded-md"> {{ $content_lang['tel'] }} <input type="text" name="cus_tel" class="block h-8 ml-2 mt-1 w-1/6 pl-1 border-gray-300 rounded-md">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-start pl-10">
                                        <div class="flex items-center">
                                            {{ $content_lang['address'] }} <input type="text" name="cus_address" class="block h-8 mx-2 mt-1 w-2/3 pl-1 border-gray-300 rounded-md">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full table mb-2 table-auto border-2 text-center text-sm">
                            <thead class="border-2 text-center bg-blue-300">
                                <tr class="border-2 text-center">
                                    <td rowspan="2" class="border-2 border-blue-500">{{ $content_lang['number'] }}</td>
                                    <td rowspan="2" width="30%" class="border-2 border-blue-500">
                                        {{ $content_lang['table-list'] }}</td>
                                    <td rowspan="2" width="10%" class="border-2 border-blue-500">
                                        {{ $content_lang['amount'] }}</td>
                                    <td rowspan="2" width="10%" class="border-2 border-blue-500">
                                        {{ $content_lang['fine'] }}</td>
                                    <td rowspan="2" width="10%" class="border-2 border-blue-500">
                                        {{ $content_lang['tracking'] }}</td>
                                    <td colspan="2" class="border-2 border-blue-500">{{ $content_lang['amount'] }}</td>
                                </tr>
                                <tr>
                                    <td class="border-2 border-blue-500">{{ $content_lang['baht'] }}</td>
                                    <td class="border-2 border-blue-500">{{ $content_lang['kip'] }}</td>
                                </tr>
                            </thead>
                            <tbody class="border-2 border-blue-500">
    
                                <tr>
                                    <td class="border-2 border-blue-500">1</td>
                                    <td id="paytypeheader" class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"><input type="number" required name="payment" onkeyup="setpayment(this)" class="text-center block h-5 w-full pl-1 border-gray-300 rounded-md"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td id="totalpayment" class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
    
                                <tr>
                                    <td class="border-2 border-blue-500">2</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
    
                                <tr>
                                    <td class="border-2 border-blue-500">3</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
    
                                <tr>
                                    <td class="border-2 border-blue-500">4</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
    
                                <tr>
                                    <td class="border-2 border-blue-500">5</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
    
                                <tr>
                                    <td colspan="4" class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">{{ $content_lang['sum-cash'] }}</td>
                                    <td id="sum-payment" class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500">-</td>
                                </tr>
                            </tbody>
                        </table>
    
                        <table class="w-full table mb-2 table-auto text-center text-sm">
                            <tbody>
                                <tr height="30px">
                                    <td class="border-r-0 border-2 border-blue-500">
                                        {{ $content_lang['payee'] }}
                                    </td>
                                    <td width="80%" class="border-l-0 border-2 border-blue-500">
    
                                    </td>
                                    <td class="border-2 border-blue-500 bg-blue-300">
                                        {{ $content_lang['thank1'] }}<br>
                                        {{ $content_lang['thank2'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="w-full table mb-2 table-auto text-center text-sm">
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $content_lang['note1'] }}<br>
                                        {{ $content_lang['note2'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['bill-button'] }}</button>
                        </div>
                    </form>
                </div>
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

function setbilltype(e) {
    var paytypeheader = document.getElementById('paytypeheader');
    var selectElement = document.getElementById("bill_type"); // Replace "yourSelectElement" with the ID of your select element
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    var optionValue = selectedOption.value;
    var optionText = selectedOption.text;
    paytypeheader.textContent = optionText;
    console.log("Option Value: " + optionValue);
    console.log("Option Text: " + optionText);
}

function setpayment(e) {
    var totalpayment = document.getElementById('totalpayment');
    var sumpayment = document.getElementById('sum-payment');

    var value = parseInt(e.value);
    totalpayment.textContent = value.toLocaleString();
    sumpayment.textContent = value.toLocaleString();
}

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
