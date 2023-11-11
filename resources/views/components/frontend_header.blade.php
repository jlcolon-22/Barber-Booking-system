{{-- <header class="w-full bg-[#0004] fixed  top-0 shadow z-20 flex justify-between items-center h-[5rem] px-[2rem]">
    <a href="/" class="text-4xl font-semibold whitespace-nowrap flex items-center"> <img
            src="{{ asset('logo.svg') }}" class="h-6 mr-3 sm:h-9" alt="Flowbite Logo" /> Barber Shop</a>
    <nav class="flex items-center justify-end w-full gap-x-20 relative">
        <ul class="flex items-center  gap-x-6">
            <li class="relative">
                <a href="/" class="peer">Home</a>
                <div
                    class="h-[3px] w-0 {{ request()->is('/') ? 'bg-gray-50 w-full' : '' }} peer-hover:bg-gray-5  absolute peer-hover:bg-gray-50 peer-hover:w-full transition-all ease-in-out duration-700">
                </div>
            </li>
            <li class="relative">
                <a href="/services" class="peer">Services</a>
                <div
                    class="h-[3px] w-0  absolute {{ request()->is('services') ? 'bg-gray-50 w-full' : '' }}    peer-hover:bg-gray-50 peer-hover:w-full transition-all ease-in-out duration-700">
                </div>
            </li>

            <li class="relative">
                <a href="/about" class="peer">About</a>
                <div
                    class="h-[3px] w-0 {{ request()->is('about') ? 'bg-gray-50 w-full' : '' }}  absolute peer-hover:bg-gray-50 peer-hover:w-full transition-all ease-in-out duration-700">
                </div>
            </li>
            <li class="relative">
                <a href="/contact" class="peer">Contact Us</a>
                <div
                    class="h-[3px] w-0 {{ request()->is('contact') ? 'bg-gray-50 w-full' : '' }} absolute peer-hover:bg-gray-50 peer-hover:w-full transition-all ease-in-out duration-700">
                </div>
            </li>

        </ul>


        @if (Auth::check())
            <div class="relative">
                <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                    class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 relative"
                    type="button">
                    <span class="sr-only">Open user menu</span>
                    @if (!!Auth::user()->profile)
                        <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->profile) }}" alt="user photo">
                    @else
                        <img class="w-8 h-8 rounded-full"
                            src="{{ 'https://eu.ui-avatars.com/api/?name=' . Auth::user()->firstname . '+' . Auth::user()->lastname }}"
                            alt="user photo">
                    @endif

                    <!-- Dropdown menu -->
                    <div id="dropdownAvatar"
                        class="z-10 hidden bg-white divide-y divide-gray-100 absolute top-10 left-auto right-0 w-44 rounded-lg shadow  dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}</div>

                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownUserAvatarButton">
                            <li>
                                <a href="/account"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Account</a>
                            </li>
                            <li>
                                <a href="/appointment"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Appointment
                                    History</a>
                            </li>

                        </ul>
                        <div class="py-2">
                            <a type="button" onclick="window.location.href = '/auth/logout'"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                out</a>
                        </div>
                    </div>
                </button>


            </div>
        @else
            <div>
                <a href="/auth/login" class="bg-blue-500 px-5 py-2 rounded mr-6">Login</a>

            </div>
        @endif
    </nav>
</header> --}}
<nav class=" w-full border-gray-200 bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="text-3xl font-semibold whitespace-nowrap flex items-center"> <img
                src="{{ asset('logo.svg') }}" class="h-6 mr-3 sm:h-9" alt="Flowbite Logo" /> Barber Shop</a>
        <div class="flex items-center md:order-2">
            @if (Auth::check())
                <button type="button" onclick="showDropdown()"
                    class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    {{-- <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo"> --}}
                    @if (!!Auth::user()->profile)
                        <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->profile) }}" alt="user photo">
                    @else
                        <img class="w-8 h-8 rounded-full"
                            src="{{ 'https://eu.ui-avatars.com/api/?name=' . Auth::user()->firstname . '+' . Auth::user()->lastname }}"
                            alt="user photo">
                    @endif

                </button>
            @else
                <a href="/auth/login"
                    class="flex mr-3 text-sm bg-blue-500 px-5 py-2  rounded-full md:mr-0 focus:ring-4 focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    Login
                </a>
            @endif
            <!-- Dropdown menu -->
            <div class="relative">
                <div class="z-50 hidden absolute top-3 left-auto right-0 w-44 my-4 text-base list-none divide-y rounded-lg shadow bg-gray-700 divide-gray-600 "
                    id="user-dropdown">
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="/account"
                                class="block px-4 py-2 text-sm   hover:bg-gray-600 text-gray-200 hover:text-white">Account</a>
                        </li>
                        <li>
                            <a href="/appointment"
                                class="block px-4 py-2 text-sm   hover:bg-gray-600 text-gray-200 hover:text-white">Appointments</a>
                        </li>

                        <li>
                            <a href="/auth/logout"
                                class="block px-4 py-2 text-sm   hover:bg-gray-600 text-gray-200 hover:text-white">Sign
                                out</a>
                        </li>
                    </ul>
                </div>
            </div>
            <button onclick="showList()" data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm  rounded-lg md:hidden  focus:outline-none focus:ring-2  text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border  rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0  bg-gray-800 md:bg-gray-900 border-gray-700">
                <li>
                    <a href="/"
                        class="{{ request()->is('/') ? ' block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent  md:p-0 md:text-blue-500' : 'block py-2 pl-3 pr-4 text-gray-900 rounded  md:p-0 dark:text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700' }}"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/services"
                        class="{{ request()->is('services') ? ' block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent  md:p-0 md:text-blue-500' : 'block py-2 pl-3 pr-4 text-gray-900 rounded  md:p-0 dark:text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700' }}">Services</a>
                </li>
                <li>
                    <a href="/about"
                        class="{{ request()->is('about') ? ' block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent  md:p-0 md:text-blue-500' : 'block py-2 pl-3 pr-4 text-gray-900 rounded  md:p-0 dark:text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700' }}">About</a>
                </li>
                <li>
                    <a href="/contact"
                        class="{{ request()->is('contact') ? ' block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent  md:p-0 md:text-blue-500' : 'block py-2 pl-3 pr-4 text-gray-900 rounded  md:p-0 dark:text-white md:hover:text-blue-500 hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700' }}">Contact</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
