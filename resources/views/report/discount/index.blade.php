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
                <div class="flex justify-between items-center my-2 w-full">

                    <div class="flex grow">
                        <form class="flex" action="{{ route('searchdiscount') }}" method="post">
                            @csrf
                            <x-input id="searchTerm" class="block mr-2" type="text" name="searchTerm" autofocus />
                            <button type="submit"
                                class="bg-blue-500 text-white drop-shadow-lg P-2 w-20 rounded-lg hover:bg-blue-300">
                                {{ $content_lang['find-button'] }}
                            </button>
                        </form>
                    </div>
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
                <table class="w-full table mb-2 table-auto border-2 text-center">
                    <thead class="bg-gray-400 drop-shadow-lg text-lg">
                        <tr>
                            <th class="px-4 py-2">{{ $content_lang['number'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['bill-number'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['cus-name'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['discount'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['request-by'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['status'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['detail'] }}</th>
                        </tr>
                    </thead>
                    <tbody class="border-2">
                        @php
                            $counter = 0;
                        @endphp

                        @if ($message = Session::get('notfound'))
                            <tr class="border-2 hover:bg-gray-300">
                                <td colspan="6" class="text-center text-2xl">{{ $message }}
                                </td>
                            </tr>
                        @else
                            @foreach ($bill_datas as $bill_data)
                                @php
                                    $counter++;
                                @endphp
                                <tr class="border-2 hover:bg-gray-300">
                                    <td>{{ $counter }}</td>
                                    <td>{{ $bill_data->bill_number }}</td>
                                    <td>
                                        @foreach ($cusdatas as $cusdata)
                                            @if($cusdata->id == $bill_data->cus_id)
                                                {{ $cusdata->cus_name }}
                                            @endif
                                        @endforeach
                                        
                                    </td>
                                    <td>
                                        @php
                                            $totalpayment = 0;
                                        @endphp
                                        @foreach ($billdetails as $billdetail)
                                            @if($billdetail->bill_id == $bill_data->id)
                                                @php
                                                    $totalpayment += $billdetail->list_payments;
                                                @endphp
                                            @endif
                                        @endforeach
                                        {{number_format($totalpayment)}}
                                    </td>
                                    <td>{{ $bill_data->create_by }}</td>
                                    @if ($bill_data->approve_st == 'waiting')
                                        <td>{{ $content_lang['waiting_approve'] }}</td>
                                    @elseif($bill_data->approve_st == 'approved')
                                        <td>{{ $content_lang['aprove'] }}</td>
                                    @elseif($bill_data->approve_st == 'reject')
                                        <td>{{ $content_lang['reject'] }}</td>
                                    @endif
                                    

                                    <td>
                                        <a href="{{ route('discountbilldetail', ['id' => $bill_data->id]) }}">
                                            <div
                                                class="p-2  bg-blue-500 text-white rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                                {{ $content_lang['detail'] }}
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {!! $bill_datas->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    
</script>
