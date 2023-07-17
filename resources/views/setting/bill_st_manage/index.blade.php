@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $content_lang = include base_path('lang\\' . session()->get('locale') . '\bill_st.php');
    
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
                        <form class="flex" action="{{ route('searchbill-st') }}" method="post">
                            @csrf
                            <x-input id="searchTerm" class="block mr-2" type="text" name="searchTerm" autofocus />
                            <button type="submit"
                                class="bg-blue-500 text-white drop-shadow-lg P-2 w-20 rounded-lg hover:bg-blue-300">
                                {{ $content_lang['find-button'] }}
                            </button>
                        </form>
                    </div>
                    <div>
                        @if (Route::has('newbill-st'))
                            <a href="{{ route('newbill-st') }}"
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
                            <th class="px-4 py-2">{{ $content_lang['table-name'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-edit'] }}</th>
                            <th class="px-4 py-2">{{ $content_lang['table-delete'] }}</th>
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
                            @foreach ($bill_sts as $bill_st)
                                @php
                                    $counter++;
                                @endphp
                                <tr class="border-2 hover:bg-gray-300">
                                    <td>{{ $counter }}</td>
                                    @if (session()->get('locale') == 'th')
                                        <td>{{ $bill_st->thai }}</td>
                                    @elseif(session()->get('locale') == 'lo')
                                        <td>{{ $bill_st->lao }}</td>
                                    @elseif(session()->get('locale') == 'en')
                                        <td>{{ $bill_st->eng }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('editbill-st', ['id' => $bill_st->id]) }}">
                                            <div
                                                class="p-2  bg-yellow-500 rounded-lg hover:bg-yellow-300 hover:cursor-pointer">
                                                {{ $content_lang['table-edit'] }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <form id="delete-bill-st{{ $bill_st->id }}" class="w-full"
                                            action="{{ route('deletebill-st', ['id' => $bill_st->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="confirmSubmit('delete-bill-st{{ $bill_st->id }}')"
                                                type="button"
                                                class="p-2 w-full bg-red-500 rounded-lg hover:bg-red-300 hover:cursor-pointer">
                                                {{ $content_lang['table-delete'] }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {!! $bill_sts->links() !!}
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
