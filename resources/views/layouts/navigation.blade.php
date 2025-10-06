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
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{route('dashboard')}}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                </div>
                @if (auth()->user()->role!= 'customer' or auth()->user()->role!= 'registrar' or auth()->user()->role!= 'verifier')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{route('statistics.index')}}" class="block px-4 py-2 hover:bg-gray-100">Statistics</a>
                    </div>
                @endif
                @if (auth()->user()->role== 'admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{route('users.index')}}" class="block px-4 py-2 hover:bg-gray-100">Users</a>
                    </div>
                @endif
                @if (auth()->user()->role== 'registrar' or auth()->user()->role== 'mrc' or auth()->user()->role== 'verifier' or auth()->user()->role== 'admin')
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
                                @if (auth()->user()->role== 'admin' or auth()->user()->role== 'mrc')
                                    <a href="{{route('mrc_status.index')}}" class="block px-4 py-2 hover:bg-gray-100">Marriage Status</a>
                                    <a href="{{route('mrc.upload')}}" class="block px-4 py-2 hover:bg-gray-100">Upload</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role== 'admin' or auth()->user()->role== 'domicile')
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
                                <a href="{{route('Passcode.create')}}" class="block px-4 py-2 hover:bg-gray-100">Generate Passcode</a>
                                <a href="{{route('Passcodes.gen_report')}}" class="block px-4 py-2 hover:bg-gray-100">Passcode Report</a>
                                <a href="{{route('domicile.admin')}}" class="block px-4 py-2 hover:bg-gray-100">Form P</a>
                                <a href="{{route('downloads')}}" class="block px-4 py-2 hover:bg-gray-100">Downloads</a>
                                <a href="{{route('chatbot.questions')}}" class="block px-4 py-2 hover:bg-gray-100">Bot Questions</a>
                            </div>
                        </div>
                    </div>
                    
                @elseif (auth()->user()->role== 'idp')
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
                @if (auth()->user()->role== 'ea' or auth()->user()->role== 'admin')
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
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @if (auth()->user()->role!= 'customer' or  auth()->user()->role!= 'registrar' or auth()->user()->role!= 'verifier')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('statistics.index')" :active="request()->routeIs('statistics.index')">
                    {{ __('CFC Statistics') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role== 'registrar' or auth()->user()->role== 'mrc' or auth()->user()->role== 'verifier' or auth()->user()->role== 'admin')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('mrc.index')" :active="request()->routeIs('mrc_status.index')">
                    {{ __('Marriage Records') }}
                </x-responsive-nav-link>
            </div>
            @if (auth()->user()->role== 'admin' or auth()->user()->role== 'mrc')
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
        @if (auth()->user()->role== 'admin')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role== 'admin' or auth()->user()->role== 'domicile')
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('chatbot.questions')" :active="request()->routeIs('chatbot.questions')">
                    {{ __('Pending Questions') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('Passcode.create')" :active="request()->routeIs('Passcode.create')">
                    {{ __('Generate Passcode') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('Passcodes.gen_report')" :active="request()->routeIs('Passcodes.gen_report')">
                    {{ __('Passcode report') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('downloads')" :active="request()->routeIs('downloads')">
                    {{ __('Downloads') }}
                </x-responsive-nav-link>
            </div>
        @endif
        @if (auth()->user()->role== 'admin' or auth()->user()->role== 'ea')
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
