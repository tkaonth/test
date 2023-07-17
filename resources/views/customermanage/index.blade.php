@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\customermanage.php');
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
                        <form class="flex" action="{{ route('searchcus') }}" method="post">
                            @csrf
                            <x-input id="searchTerm" class="block mr-2" type="text" name="searchTerm" autofocus />
                            <button type="submit"
                                class="bg-blue-500 text-white drop-shadow-lg P-2 w-20 rounded-lg hover:bg-blue-300">
                                {{ $content_lang['find-button'] }}
                            </button>
                        </form>
                    </div>
                    <div>
                        @if (Route::has('newcus'))
                            <a href="{{ route('newcus') }}"
                                class="bg-blue-500 text-white drop-shadow-lg p-2 w-full rounded-lg hover:bg-blue-300">{{ $content_lang['add-cus'] }}</a>
                        @endif
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
                            <th class="px-4 py-2">{{ $content_lang['table-num'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-code'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-name'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-cus-branch'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-cus-type'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-car-number'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-status'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['cus-detail'] }}</th>
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
                            @foreach ($cusdata as $cus)
                                @php
                                    $counter++;
                                @endphp
                                <tr class="border-2 hover:bg-gray-300">
                                    <td>{{ $counter }}</td>
                                    <td>{{ $cus->cus_code }}</td>
                                    <td>{{ $cus->cus_name }}</td>
                                    @foreach ($branchs as $branch)
                                        @if ($branch->keyword == $cus->cus_branch)
                                            @if (session()->get('locale') == 'th')
                                                <td>{{ $branch->thai }}</td>
                                            @elseif(session()->get('locale') == 'lo')
                                                <td>{{ $branch->lao }}</td>
                                            @elseif(session()->get('locale') == 'en')
                                                <td>{{ $branch->eng }}</td>
                                            @endif
                                            @break
                                        @endif
                                    @endforeach

                                    @if ($cus->cus_type == 'normal')
                                        <td>{{ $content_lang['cus-normal'] }}</td>
                                    @elseif($cus->cus_type == 'kasikam')
                                        <td>{{ $content_lang['cus-kasikam'] }}</td>
                                    @endif

                                    @foreach ($cardata as $car)
                                        @if ($car->cus_id == $cus->id)
                                            <td>
                                                <a target="_blank" href="{{ route('detailcar', ['id' => $car->id]) }}">
                                                    <div class="p-2 drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                                        {{ $car->car_number }}
                                                    </div>
                                                </a>
                                            </td>
                                        @endif
                                    @endforeach
                                    @foreach ($cus_sts as $cus_st)
                                        @if ($cus->cus_st == $cus_st->keyword)
                                            @if (session()->get('locale') == 'th')
                                                <td>{{ $cus_st->thai }}</td>
                                            @elseif(session()->get('locale') == 'lo')
                                                <td>{{ $cus_st->lao }}</td>
                                            @elseif(session()->get('locale') == 'en')
                                                <td>{{ $cus_st->eng }}</td>
                                            @endif
                                            @break
                                        @endif
                                    @endforeach

                                    <td>
                                        <a href="{{ route('cuscard', ['id' => $cus->id]) }}">
                                            <div
                                                class="p-2 drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                                {{ $content_lang['table-detail'] }}
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {!! $cusdata->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
</script>
