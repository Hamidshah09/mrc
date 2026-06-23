<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{route('dashboard')}}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                </div> --}}
                @if (
                        auth()->user()->role->role == 'Operator' ||
                        auth()->user()->role->role == 'AC' ||
                        auth()->user()->role->role == 'Magistrate' ||
                        auth()->user()->role->role == 'ADCG'
                    )

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                            <div class="relative" x-data="{ dropdown: false }">

                                <button @click="dropdown = !dropdown"
                                        class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">

                                    Cleanliness Portal

                                    <svg class="ml-1 h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7" />

                                    </svg>

                                </button>

                                <div x-show="dropdown"
                                    @click.outside="dropdown = false"
                                    x-transition
                                    class="absolute mt-2 w-64 bg-white shadow-lg rounded-lg z-50">

                                    {{-- Operator --}}
                                    @if(auth()->user()->role->role == 'Operator')

                                        <a href="{{ route('operator.complaints.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            My Complaints

                                        </a>

                                        <a href="{{ route('operator.complaints.create') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            Create Complaint

                                        </a>

                                    @endif

                                    {{-- AC --}}
                                    @if(auth()->user()->role->role == 'AC')

                                        <a href="{{ route('ac.dashboard') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            AC Dashboard

                                        </a>

                                        <a href="{{ route('ac.complaints.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            Complaints

                                        </a>

                                    @endif

                                    {{-- Magistrate --}}
                                    @if(auth()->user()->role->role == 'Magistrate')

                                        <a href="{{ route('magistrate.dashboard') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            Magistrate Dashboard

                                        </a>

                                        <a href="{{ route('magistrate.complaints.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            Pending Complaints

                                        </a>

                                    @endif

                                    {{-- ADCG --}}
                                    @if(auth()->user()->role->role == 'ADCG')

                                        <a href="{{ route('adcg.dashboard') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            ADCG Dashboard

                                        </a>

                                        <a href="{{ route('adcg.complaints') }}"
                                        class="block px-4 py-2 hover:bg-gray-100">

                                            All Complaints

                                        </a>

                                    @endif

                                    {{-- Notifications --}}
                                    <a href="{{ route('notifications.index') }}"
                                    class="block px-4 py-2 hover:bg-gray-100">

                                        Notifications

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endif
                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'domicile' or auth()->user()->role->role== 'idp' or auth()->user()->role->role== 'arms')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{route('statistics.index')}}" class="block px-4 py-2 hover:bg-gray-100">Statistics</a>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'arms')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Admin
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('users.index')}}" class="block px-4 py-2 hover:bg-gray-100">Users</a>
                                <a href="{{route('arms.index')}}" class="block px-4 py-2 hover:bg-gray-100">Arms</a>
                                <a href="{{route('arms.statistics')}}" class="block px-4 py-2 hover:bg-gray-100">Arms Statistics</a>
                                {{-- <a href="{{route('finance.index')}}" class="block px-4 py-2 hover:bg-gray-100">Finance</a> --}}
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'registrar' or auth()->user()->role->role== 'mrc' or auth()->user()->role->role== 'verifier' or auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'drc')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Mrc
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('mrc.index')}}" class="block px-4 py-2 hover:bg-gray-100">Marriage Records</a>
                                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc')
                                    <a href="{{route('mrc_status.index')}}" class="block px-4 py-2 hover:bg-gray-100">Marriage Status</a>
                                    <a href="{{route('mrc.upload')}}" class="block px-4 py-2 hover:bg-gray-100">Upload</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'drc' or auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                DRC
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('drc.index')}}" class="block px-4 py-2 hover:bg-gray-100">Divorce Cases</a>
                                <a href="{{route('drc.live.create')}}" class="block px-4 py-2 hover:bg-gray-100">New Live Case</a>
                                <a href="{{route('drc.old.create')}}" class="block px-4 py-2 hover:bg-gray-100">Old Completed Case</a>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc' or auth()->user()->role->role== 'domicile')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Postal Service
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('postalservice.index')}}" class="block px-4 py-2 hover:bg-gray-100">Postal Services</a>
            
                            </div>
                        </div>
                    </div>
                @endif --}}
                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'surety')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Surety Service
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('surety.index')}}" class="block px-4 py-2 hover:bg-gray-100">Surety Records</a>
                                {{-- <a href="{{route('postal-status.index')}}" class="block px-4 py-2 hover:bg-gray-100">Postal Status</a> --}}
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'domicile' or auth()->user()->role->role== 'idp')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Domicile
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('daily.limit.index')}}" class="block px-4 py-2 hover:bg-gray-100">Daily Limit</a>
                                <a href="{{route('domicile.index')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile Applications</a>
                                <a href="{{route('cash-records.index')}}" class="block px-4 py-2 hover:bg-gray-100">Cash Reports</a>
                                <a href="{{route('downloads.index')}}" class="block px-4 py-2 hover:bg-gray-100">Downloads</a>
                                <a href="{{route('noc-ict.index')}}" class="block px-4 py-2 hover:bg-gray-100">Noc for ICT</a>
                                <a href="{{route('noc-other-district.index')}}" class="block px-4 py-2 hover:bg-gray-100">Noc Other District</a>
                                <a href="{{route('domicile.cancellation.index')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile Cancellation</a>
                                <a href="{{route('domicile.blacklist.index')}}" class="block px-4 py-2 hover:bg-gray-100">Blacklisted CNICs</a>
                                <a href="{{route('domicile.verification_letter.index')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile Verification</a>
                                <a href="{{route('public.index')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile Public</a>
                                <a href="{{route('domicile.office_letters.index')}}" class="block px-4 py-2 hover:bg-gray-100">Office Letters</a>
                            </div>
                        </div>
                    </div>
                    
                @elseif (auth()->user()->role->role== 'idp')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Idp
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('downloads')}}" class="block px-4 py-2 hover:bg-gray-100">Downloads</a>    
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'auqaf')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                Auqaf
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('mousques.index')}}" class="block px-4 py-2 hover:bg-gray-100">Mousques</a>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role->role== 'ea' or auth()->user()->role->role== 'admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                EA
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdown" @click.outside="dropdown = false"
                                x-transition
                                class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                                <a href="{{route('Employee.index')}}" class="block px-4 py-2 hover:bg-gray-100">Employees</a>
                                <a href="{{route('departments.index')}}" class="block px-4 py-2 hover:bg-gray-100">Departments</a>
                                <a href="{{route('designations.index')}}" class="block px-4 py-2 hover:bg-gray-100">Designations</a>    
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative mr-4">

                    @php

                        $unreadCount = auth()->user()
                            ->unreadNotifications()
                            ->count();

                    @endphp

                    <a href="{{ route('notifications.index') }}"
                    class="relative inline-flex items-center text-gray-600 hover:text-gray-900">

                        {{-- Bell Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032
                                    2.032 0 0118 14.158V11a6.002
                                    6.002 0 00-4-5.659V5a2
                                    2 0 10-4 0v.341C7.67
                                    6.165 6 8.388 6 11v3.159c0
                                    .538-.214 1.055-.595
                                    1.436L4 17h5m6 0v1a3 3 0
                                    11-6 0v-1m6 0H9" />

                        </svg>

                        {{-- Counter --}}
                        @if($unreadCount > 0)

                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2 py-0.5">

                                {{ $unreadCount }}

                            </span>

                        @endif

                    </a>

                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) ?? asset('images/default-avatar.png') }}"
                                alt=""
                                class="h-8 w-8 rounded-full object-cover" />

                            <svg class="ms-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414
                                         1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                               hover:text-gray-500 hover:bg-gray-100 focus:outline-none
                               focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> --}}
        @if (
                auth()->user()->role->role == 'Operator' ||
                auth()->user()->role->role == 'AC' ||
                auth()->user()->role->role == 'Magistrate' ||
                auth()->user()->role->role == 'ADCG'
            )

                <div class="border-t border-gray-200 pt-2 pb-3">

                    <div class="px-4 py-2 text-xs font-bold text-gray-500 uppercase">

                        Cleanliness Portal

                    </div>

                    {{-- Operator --}}
                    @if(auth()->user()->role->role == 'Operator')

                        <x-responsive-nav-link
                            :href="route('operator.complaints.index')">

                            {{ __('My Complaints') }}

                        </x-responsive-nav-link>

                        <x-responsive-nav-link
                            :href="route('operator.complaints.create')">

                            {{ __('Create Complaint') }}

                        </x-responsive-nav-link>

                    @endif

                    {{-- AC --}}
                    @if(auth()->user()->role->role == 'AC')

                        <x-responsive-nav-link
                            :href="route('ac.dashboard')">

                            {{ __('AC Dashboard') }}

                        </x-responsive-nav-link>

                        <x-responsive-nav-link
                            :href="route('ac.complaints.index')">

                            {{ __('Complaints') }}

                        </x-responsive-nav-link>

                    @endif

                    {{-- Magistrate --}}
                    @if(auth()->user()->role->role == 'Magistrate')

                        <x-responsive-nav-link
                            :href="route('magistrate.dashboard')">

                            {{ __('Magistrate Dashboard') }}

                        </x-responsive-nav-link>

                        <x-responsive-nav-link
                            :href="route('magistrate.complaints.index')">

                            {{ __('Pending Complaints') }}

                        </x-responsive-nav-link>

                    @endif

                    {{-- ADCG --}}
                    @if(auth()->user()->role->role == 'ADCG')

                        <x-responsive-nav-link
                            :href="route('adcg.dashboard')">

                            {{ __('ADCG Dashboard') }}

                        </x-responsive-nav-link>

                        <x-responsive-nav-link
                            :href="route('adcg.complaints')">

                            {{ __('All Complaints') }}

                        </x-responsive-nav-link>

                    @endif

                    {{-- Notifications --}}
                    <x-responsive-nav-link
                        :href="route('notifications.index')">

                        {{ __('Notifications') }}

                    </x-responsive-nav-link>

                </div>

            @endif
        @if (auth()->user()->role->role== 'admin' or  auth()->user()->role->role== 'domicile' or auth()->user()->role->role== 'idp')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('statistics.index')" :active="request()->routeIs('statistics.index')">
                    {{ __('CFC Statistics') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role->role== 'surety' or auth()->user()->role->role== 'admin')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('surety.index')" :active="request()->routeIs('surety.index')">
                    {{ __('Surety Records') }}
                </x-responsive-nav-link>
            </div>       
        @endif
        @if (auth()->user()->role->role== 'registrar' or auth()->user()->role->role== 'mrc' or auth()->user()->role->role== 'verifier' or auth()->user()->role->role== 'admin')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('mrc.index')" :active="request()->routeIs('mrc_status.index')">
                    {{ __('Marriage Records') }}
                </x-responsive-nav-link>
            </div>
            @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc' or auth()->user()->role->role== 'drc')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('mrc_status.index')" :active="request()->routeIs('mrc_status.index')">
                        {{ __('MRC Status') }}
                    </x-responsive-nav-link>
                </div>
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('mrc.upload')" :active="request()->routeIs('mrc.upload')">
                        {{ __('Upload') }}
                    </x-responsive-nav-link>
                </div>
            @endif        
        @endif
        @if (auth()->user()->role->role== 'drc' or auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('drc.index')" :active="request()->routeIs('drc.*')">
                    {{ __('Divorce Cases') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role->role== 'admin' or  auth()->user()->role->role== 'auqaf')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('mousques.index')" :active="request()->routeIs('mousques.index')">
                    {{ __('Mousques') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role->role== 'admin')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('arms.index')" :active="request()->routeIs('arms.index')">
                    {{ __('Arms') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('arms.statistics')" :active="request()->routeIs('arms.statistics')">
                    {{ __('Arms Statistics') }}
                </x-responsive-nav-link>
            </div>
        @endif
        {{-- @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'mrc' or auth()->user()->role->role== 'domicile')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('postalservice.index')" :active="request()->routeIs('postalservice.index')">
                    {{ __('Postal Services') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('postal-status.index')" :active="request()->routeIs('postal-status.index')">
                    {{ __('Postal Status') }}
                </x-responsive-nav-link>
            </div>
        @endif --}}
        @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'domicile')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('domicile.index')" :active="request()->routeIs('domicile.index')">
                    {{ __('Domicile Applications') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('cash-records.index')" :active="request()->routeIs('cash-records.index')">
                    {{ __('Cash Reports') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('noc-ict.index')" :active="request()->routeIs('noc-ict.index')">
                    {{ __('Noc for ICT') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('noc-other-district.index')" :active="request()->routeIs('noc-other-district.index')">
                    {{ __('Noc Other District') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('domicile.cancellation.index')" :active="request()->routeIs('domicile.cancellation.index')">
                    {{ __('Cancellation of Domicile Certificate') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('domicile.blacklist.index')" :active="request()->routeIs('domicile.blacklist.index')">
                    {{ __('Blacklisted CNICs') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('domicile.verification_letter.index')" :active="request()->routeIs('domicile.verification_letter.index')">
                    {{ __('Domicile Verification') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('daily.limit.index')" :active="request()->routeIs('daily.limit.index')">
                    {{ __('Daily Limit') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('domicile.office_letters.index')" :active="request()->routeIs('domicile.office_letters.index')">
                    {{ __('Office Letters') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('downloads.index')" :active="request()->routeIs('downloads.index')">
                    {{ __('Downloads') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role->role== 'admin' or auth()->user()->role->role== 'ea')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('Employee.index')" :active="request()->routeIs('Employee.index')">
                    {{ __('Employees') }}
                </x-responsive-nav-link>
            </div>
        @endif
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4 space-x-3">
                <img src="{{ asset('storage/' . Auth::user()->profile_image) ?? asset('images/default-avatar.png') }}"
                    alt=""
                    class="h-8 w-8 rounded-full object-cover" />

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
