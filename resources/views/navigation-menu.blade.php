@php
    if (!session()->get('locale')) {
        session()->put('locale', 'th');
    }
    $menuItems = include base_path('lang\\' . session()->get('locale') . '\menu.php');
    
@endphp

<div id="sidebar" class="w-80">
    <div id="sidebar" class=" fixed min-h-screen w-80 text-center border-r-2 drop-shadow-lg">
        <div class="">
            <div class="flex p-5 border-b-2 justify-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center ">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="menu-name ml-2 text-center">
                    <a class="text-2xl" href="{{ route('dashboard') }}" :active="request() - > routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </a>
                </div>
            </div>
            <div class="flex-col mt-10">
                @foreach ($menuItems as $menuItem)
                    @if (empty($menuItem['subMenuItems']))
                        <a class="" href="{{route($menuItem['url']) }}">
                    @endif
                    <div id="toggle-{{ $menuItem['menu-name'] }}"
                        class="{{ $menuItem['menu-name'] }} flex text-lg p-3 pl-5 hover:bg-gray-300 mx-5 rounded-lg relative hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menuItem['icon'] }}" />
                        </svg>
                        <span class="menu-name grow text-left ml-2">{{ $menuItem['label'] }}</span>
                        @if (!empty($menuItem['subMenuItems']))
                            <div id="icon-{{ $menuItem['menu-name'] }}"
                                class="menu-name flex items-center duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    @if (empty($menuItem['subMenuItems']))
                        </a>
                    @endif
                    @if (!empty($menuItem['subMenuItems']))
                        @foreach ($menuItem['subMenuItems'] as $subMenuItem)
                            <div
                                class="{{ $subMenuItem['menu-name'] }} hidden text-left ml-10 p-3 pl-10 truncate hover:bg-gray-300 mx-5 rounded-lg duration-300">
                                <a href="{{route($subMenuItem['url']) }}">
                                    <span>{{ $subMenuItem['label'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div class="flex p-3 rounded-lg absolute bottom-3 border-t-2 w-full">
                <div class="flex justify-center w-full rounded-lg">
                    <a class="flex cursor-pointer text-lg p-3 menu-name rounded-l-lg justify-center items-center grow hover:bg-gray-300"
                        href="{{ route('profile.show') }}">
                        {{ Auth::user()->name }}
                    </a>
                    <div>
                        <form
                            class="cursor-pointer flex p-3 w-10 rounded-r-lg justify-center  h-full items-center hover:bg-gray-300"
                            method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <button onclick="{{ route('logout') }}" @click.prevent="$root.submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute -right-5 top-[50%]">
            <button class="bg-gray-500 text-white rounded-full p-2"id="toggle-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    var menuopen = true;
    var reportmenuopen = false;
    var settingmenuopen = false;
    const sidebar = document.querySelectorAll('#sidebar');
    const menuname = document.querySelectorAll('.menu-name');
    const toggleButton = document.getElementById('toggle-button');
    const toggleReportSub = document.getElementById('toggle-report-menu');
    const reportSub = document.querySelectorAll('.report-sub');
    const toggleSettingSub = document.getElementById('toggle-setting-menu');
    const settingSub = document.querySelectorAll('.setting-sub');
    const iconreport = document.getElementById('icon-report-menu');
    const iconsetting = document.getElementById('icon-setting-menu');

    toggleButton.addEventListener('click', () => {
        if (menuopen) {
            if(reportmenuopen)
            $('#toggle-report-menu').trigger('click');
            if(settingmenuopen)
            $('#toggle-setting-menu').trigger('click');
            for (i = 0; i < sidebar.length; i++) {
                sidebar[i].classList.remove('w-80');
                sidebar[i].classList.add('w-24');
            }

            setTimeout(() => {
                for (i = 0; i < menuname.length; i++) {
                    menuname[i].classList.add('hidden');
                }
            }, 200);

        } else {

            for (i = 0; i < sidebar.length; i++) {
                sidebar[i].classList.remove('w-24');
                sidebar[i].classList.add('w-80');
            }
            setTimeout(() => {
                for (i = 0; i < menuname.length; i++) {
                    menuname[i].classList.remove('hidden');
                }
            }, 200);
        }
        toggleButton.classList.toggle('rotate-180');
        menuopen = !menuopen;
    });
    toggleReportSub.addEventListener('click', () => {
        if (reportmenuopen) {
            for (i = 0; i < reportSub.length; i++) {
                reportSub[i].classList.add('hidden');
            }
        } else {
            for (i = 0; i < reportSub.length; i++) {
                reportSub[i].classList.remove('hidden');
            }
            for (i = 0; i < settingSub.length; i++) {
                settingSub[i].classList.add('hidden');
            }
            settingmenuopen = false;
            iconsetting.classList.remove('rotate-180');
        }
        iconreport.classList.toggle('rotate-180');
        reportmenuopen = !reportmenuopen;
    });
    toggleSettingSub.addEventListener('click', () => {
        if (settingmenuopen) {
            for (i = 0; i < settingSub.length; i++) {
                settingSub[i].classList.add('hidden');
            }

        } else {
            for (i = 0; i < settingSub.length; i++) {
                settingSub[i].classList.remove('hidden');
            }
            for (i = 0; i < reportSub.length; i++) {
                reportSub[i].classList.add('hidden');
            }
            reportmenuopen = false;
            iconreport.classList.remove('rotate-180');
        }
        iconsetting.classList.toggle('rotate-180');
        settingmenuopen = !settingmenuopen;
    });
</script>
