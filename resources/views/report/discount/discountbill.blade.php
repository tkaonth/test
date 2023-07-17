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
                <div id="printbill" class="relative">
                    @if($billdata->approve_st == 'reject')
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-red-500 text-9xl border-8 border-red-500 p-8 transform opacity-50 -rotate-45">{{ $content_lang['reject'] }}</span>
                        </div>
                    @elseif($billdata->approve_st == 'approved')
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-green-500 text-9xl border-8 border-green-500 p-8 transform opacity-50 -rotate-45">{{ $content_lang['aprove'] }}</span>
                        </div>
                    @endif
                    <div class="flex w-full">
                        <table class="w-full table mb-2 table-auto text-center">
                            <tbody>
                                <tr>
                                    <td class="text-lg">
                                        <div class="flex flex-col">
                                            <div class="ml-auto text-md">
                                                {{ $billdata->bill_number }}
                                            </div>
                                            <div class="ml-auto text-md">
                                                {{ $content_lang['bill-date'] }}
                                                {{$billdata->bill_date}}
                                            </div>
                                            <div class="ml-auto text-md">
                                                {{ $content_lang['create_by'].' : ' }}
                                                {{$billdata->create_by}}
                                            </div>
                                        </div>
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
                                    @if($billdata->bill_type == 'normal_bill')
                                        {{ $content_lang['bill'] }}
                                    @elseif($billdata->bill_type == 'discount_bill')
                                        {{ $content_lang['bill-discount'] }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start pl-10 ">
                                    <div class="flex items-center justify-between pr-5" >
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-branch'] }}
                                            {{$billdata->payment_branch}}
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['approve-by'] }}
                                            {{$billdata->approve_by}}
                                        </div>
                                        <div class="flex items-center">
                                            {{ $content_lang['bill-date'] }}
                                            {{$billdata->bill_date}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
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
                                $sumpayment = 0;
                                $totalpay = 0;
                                $counter = 0;
                            @endphp
                            @if($billdetails)
                                <tr>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500 bg-blue-300">{{$content_lang['ins-down']}}</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                </tr>
                                @foreach ($billdetails as $billdetail)
                                    
                                    @if ($billdetail->list_type == 'ins_down' || $billdetail->list_type == 'ins_insdown')
                                    @php
                                        $counter++;
                                        $totalpay = 0;
                                        $totalpay = $billdetail->list_payments + $billdetail->list_fine + $billdetail->list_tracking;
                                        $sumpayment += $totalpay;
                                    @endphp
                                        <tr>
                                            <td class="border-2 border-blue-500">{{$counter}}</td>
                                            <td class="border-2 border-blue-500">{{$billdetail->list_name}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_payments)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_fine)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_tracking)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($totalpay)}}</td>
                                            <td class="border-2 border-blue-500">-</td>
                                        </tr>
                                    @endif               
                                @endforeach
                                <tr>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500 bg-blue-300">{{$content_lang['ins']}}</td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                    <td class="border-2 border-blue-500"></td>
                                </tr>
                                @foreach ($billdetails as $billdetail)
                                    
                                    @if ($billdetail->list_type == 'ins' || $billdetail->list_type == 'ins_ins')
                                    @php
                                        $counter++;
                                        $totalpay = 0;
                                        $totalpay = $billdetail->list_payments + $billdetail->list_fine + $billdetail->list_tracking;
                                        $sumpayment += $totalpay;
                                    @endphp
                                        <tr>
                                            <td class="border-2 border-blue-500">{{$counter}}</td>
                                            <td class="border-2 border-blue-500">{{$billdetail->list_name}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_payments)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_fine)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($billdetail->list_tracking)}}</td>
                                            <td class="border-2 border-blue-500">{{number_format($totalpay)}}</td>
                                            <td class="border-2 border-blue-500">-</td>
                                        </tr>
                                    @endif               
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
                    @if($billdata->note)
                        @if($billdata->approve_st == 'approved')
                            <div class="text-green-500 w-full justify-center text-center">
                                {{ $content_lang['approvebillnote'].' : '.$billdata->note }}
                            </div>
                        @elseif($billdata->approve_st == 'reject')
                            <div class="text-red-500 w-full justify-center text-center">
                                {{ $content_lang['rejectbillnote'].' : '.$billdata->note }}
                            </div>
                        @elseif($billdata->bill_status == 'cancel')
                            <div class="text-red-500 w-full justify-center text-center">
                                {{ $content_lang['cancelbillnote'].' : '.$billdata->note }}
                            </div>
                        @endif
                    @endif
                </div>
                <div class='flex justify-end space-x-2'>
                    @if($billdata->approve_st == 'waiting')
                        <div class="flex justify-end">
                            <form id="approveform" method="POST" action="{{ route('updatediscountbill') }}">
                                @csrf
                                <input type="hidden" name="cus_id" value="{{$billdata->cus_id}}">
                                <input type="hidden" name="bill_id" value="{{$billdata->id}}">
                                <input type="hidden" name="bill_number" value="{{$billdata->bill_number}}">
                                <input type="hidden" name="note">
                                <input type="hidden" name="approve_st" value="approved">
                                <button type="submit"
                                class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{$content_lang['aprove']}}</button>
                            </form>
                        </div>

                        <div class="flex justify-end">
                            <form id="rejectform" method="POST" action="{{ route('updatediscountbill') }}">
                                @csrf
                                <input type="hidden" name="cus_id" value="{{$billdata->cus_id}}">
                                <input type="hidden" name="bill_id" value="{{$billdata->id}}">
                                <input type="hidden" name="bill_number" value="{{$billdata->bill_number}}">
                                <input type="hidden" name="note">
                                <input type="hidden" name="approve_st" value="reject">
                                <button type="submit"
                                class="p-2 px-3 bg-red-500 shadow-lg text-white rounded-lg hover:bg-red-300">{{$content_lang['reject']}}</button>
                            </form>
                            
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="button" onclick="printbill()"
                        class="p-2 px-3 bg-blue-500 shadow-lg text-white rounded-lg hover:bg-blue-300">{{$content_lang['print-button']}}</button>
                    </div>
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

function cancelnote(e) {
    let cancelnote = $('input[name="note"]');
    cancelnote.val(e.value);
}

$('#approveform').submit(function(e) {
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
        title: '{!! $content_lang['aprove'] !!}<br>'+submitData[3]['value'],
        html: '<input type="text" onkeyup="cancelnote(this)" class="block mt-1 w-full pl-2 rounded-md" placeholder="{!! $content_lang['note'] !!}">',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: '{!! $content_lang['cancel'] !!}',
        confirmButtonText: '{!! $content_lang['aprove'] !!}',
            
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, submit the form
                $(this).off('submit').submit(); // Remove the submit event listener and submit the form
            }
        });
});

$('#rejectform').submit(function(e) {
    e.preventDefault(); // Prevent the form from submitting by default
    let formData = $(this).serialize(); // Using serialize() method
    let submitData = [];
    $(this).find('input').each(function() {
        submitData.push({ 
        field : $(this).attr('name'),
        value : $(this).val()
        });
    });
    console.log(submitData);
    Swal.fire({
        title: '{!! $content_lang['reject'] !!}<br>'+submitData[3]['value'],
        html: '<input type="text" onkeyup="cancelnote(this)" class="block mt-1 w-full pl-2 rounded-md" placeholder="{!! $content_lang['note'] !!}">',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: '{!! $content_lang['cancel'] !!}',
        confirmButtonText: '{!! $content_lang['aprove'] !!}',
            
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, submit the form
                $(this).off('submit').submit(); // Remove the submit event listener and submit the form
            }
        });
});

</script>
