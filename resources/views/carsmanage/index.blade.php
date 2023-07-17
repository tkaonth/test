@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\carsmanage.php');
    
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
                        <form class="flex" action="{{ route('searchcar') }}" method="post">
                            @csrf
                            <x-input id="searchTerm" class="block mr-2" type="text" name="searchTerm" autofocus />
                            <button type="submit"
                                class="bg-blue-500 text-white drop-shadow-lg P-2 w-20 rounded-lg hover:bg-blue-300">
                                {{ $content_lang['find-button'] }}
                            </button>
                        </form>
                    </div>
                    <div>
                        @if (Route::has('newcar'))
                            <a href="{{ route('newcar') }}"
                                class="bg-blue-500 text-white drop-shadow-lg p-2 w-full rounded-lg hover:bg-blue-300">{{ $content_lang['add-user'] }}</a>
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
                            <th class="px-4 py-2">{{ $content_lang['table-owner'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-carmodel'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-carnumber'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-enginemodel'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-car-st'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-detail'] }}</th>
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
                            @foreach ($cars as $car)
                                @php
                                    $counter++;
                                @endphp
                                <tr class="border-2 hover:bg-gray-300">
                                    <td>{{ $counter }}</td>
                                    @php
                                        $cusdata = null;
                                        foreach ($cuss as $cus) {
                                            if ($cus->id == $car->cus_id) {
                                                $cusdata = $cus;
                                            }
                                        }
                                    @endphp
                                    @if ($cusdata)
                                        <td>
                                            <a target="_blank" href="{{ route('cuscard', ['id' => $cusdata->id]) }}">
                                                <div
                                                    class="p-2 drop-shadow-lg text-white bg-blue-500 rounded-lg hover:bg-blue-300 hover:cursor-pointer my-1">
                                                    {{ $cusdata->cus_code }}
                                                </div>
                                            </a>
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td>{{ $car->car_model }}</td>
                                    <td>{{ $car->car_number }}</td>
                                    <td>{{ $car->engine_number }}</td>
                                    @foreach ($car_sts as $car_st)
                                        @if ($car_st->keyword == $car->car_st)
                                        @if (session()->get('locale') == 'th')
                                            <td>{{ $car_st->thai }}</td>
                                        @elseif(session()->get('locale') == 'lo')
                                            <td>{{ $car_st->lao }}</td>
                                        @elseif(session()->get('locale') == 'en')
                                            <td>{{ $car_st->eng }}</td>
                                        @endif
                                            @break
                                        @endif
                                    @endforeach
                                    <td>
                                        <a href="{{ route('detailcar', ['id' => $car->id]) }}">
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
                {!! $cars->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmSubmit(formId) {
        Swal.fire({
            text: "{{ $content_lang['del-alert-text'] }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ $content_lang['del-alert-confirm'] }}",
            cancelButtonText: "{{ $content_lang['del-alert-cancel'] }}",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#' + formId).submit();
            }
        });
    }
</script>
