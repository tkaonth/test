<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="flex">
    <div class="w-1/6 bg-gray-800 text-gray-100 h-screen flex flex-col justify-between">
        <div class="mt-6 flex-1">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-700 hover:text-white">Link 1</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-700 hover:text-white">Link 2</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-700 hover:text-white">Link 3</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="mb-6">
            <button class="bg-red-500 text-gray-100 py-2 px-4 hover:bg-red-700" id="collapseButton">Collapse</button>
        </div>
    </div>
    <div class="w-5/6 bg-gray-100 p-6">
        @yield('content')
    </div>
    <script>
        const collapseButton = document.getElementById('collapseButton');
        const sidebar = document.querySelector('.bg-gray-800');
        collapseButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
