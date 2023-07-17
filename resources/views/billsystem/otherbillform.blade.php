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
                    <a class="flex pl-0 p-2 mb-5" href="{{ URL::previous() }}">
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
                                        <div class="flex flex-col">
                                            <div class="ml-auto text-md">
                                                {{ $otherbill->bill_number }}
                                            </div>
                                            <div class="ml-auto text-md">
                                                {{ $content_lang['bill-date'] }}
                                                {{$otherbill->bill_date}}
                                            </div>
                                            <div class="ml-auto text-md">
                                                {{ $content_lang['create_by'].' : ' }}
                                                {{$otherbill->create_by}}
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center w-full pr-5">
                                            <div class="ml-auto">
                                                {{ $content_lang['bill-company1'] }}<br>{{ $content_lang['bill-company2'] }}
                                            </div>
                                            <div class="ml-auto">
                                                
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
                                            {{$otherbill->payment_branch}}
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-pay-type'] }}
                                            {{$otherbill->payment_type}}
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill_type'] }}
                                            @if($otherbill->bill_type == 'deposit_bill')
                                                {{ $content_lang['deposit-bill'] }}
                                            @elseif($otherbill->bill_type == 'deli_bill')
                                                {{ $content_lang['downdeli-bill'] }}
                                            @endif
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-date'] }}
                                            {{$otherbill->bill_date}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start pl-10">
                                    <div class="flex items-center space-x-2">
                                        {{ $content_lang['cus-name'] }} {{$otherbill->cus_name}}
                                        {{ $content_lang['tel'] }} {{$otherbill->cus_tel}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-start pl-10">
                                    <div class="flex items-center">
                                        {{ $content_lang['address'] }} {{$otherbill->cus_address}}
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
                                <td colspan="2" class="border-2 border-blue-500">{{ $content_lang['amount'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="border-2 border-blue-500">{{ $content_lang['baht'] }}</td>
                                <td class="border-2 border-blue-500">{{ $content_lang['kip'] }}</td>
                            </tr>
                        </thead>
                        <tbody class="border-2 border-blue-500">

                            <tr>
                                <td class="border-2 border-blue-500">1</td>
                                <td id="paytypeheader" class="border-2 border-blue-500">@if($otherbill->bill_type == 'deposit_bill') {{ $content_lang['deposit-bill'] }} @else {{ $content_lang['downdeli-bill'] }} @endif</td>
                                <td class="border-2 border-blue-500">{{number_format($otherbill->payment)}}</td>
                                <td class="border-2 border-blue-500"></td>
                                <td class="border-2 border-blue-500"></td>
                                <td id="totalpayment" class="border-2 border-blue-500">{{number_format($otherbill->payment)}}</td>
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
                                <td id="sum-payment" class="border-2 border-blue-500">{{number_format($otherbill->payment)}}</td>
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
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="printbill()"
                        class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{ $content_lang['print-button'] }}</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function printbill() {
        var printContents = document.getElementById("printbill");
        var printContents = document.getElementById("printbill").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
