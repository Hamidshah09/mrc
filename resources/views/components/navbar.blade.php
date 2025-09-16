<!-- Navbar -->
    <nav x-data="{ open: false, servicesOpen: false }" class="bg-white/90 backdrop-blur-md shadow fixed top-0 left-0 w-full z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo + Title -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <x-application-logo class="h-9 w-9 fill-current text-gray-800" />
                        <span class="hidden sm:block text-xl font-extrabold text-gray-900">
                            Citizen Facilitation Center
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:space-x-8 sm:items-center">
                    <!-- Services Dropdown -->
                    <div class="relative" x-data="{ dropdown: false }">
                        <button @click="dropdown = !dropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                            Services
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="dropdown" @click.outside="dropdown = false"
                            x-transition
                            class="absolute mt-2 w-56 bg-white shadow-lg rounded-lg z-50">
                            <a href="{{route('arms.info')}}" class="block px-4 py-2 hover:bg-gray-100">Arms License</a>
                            <a href="{{route('domicile.info')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile</a>
                            <a href="{{route('idp.info')}}" class="block px-4 py-2 hover:bg-gray-100">International Driving Permit</a>
                            <a href="{{route('birth.info')}}" class="block px-4 py-2 hover:bg-gray-100">Birth Certificate</a>
                            <a href="{{route('mrc.info')}}" class="block px-4 py-2 hover:bg-gray-100">Marriage Certificate</a>
                            <a href="{{route('drc.info')}}" class="block px-4 py-2 hover:bg-gray-100">Divorce Certificate</a>
                        </div>
                    </div>

                    <!-- About -->
                    <a href="#about" class="text-gray-700 hover:text-blue-600">About</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    @endguest
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                                hover:text-gray-500 hover:bg-gray-100 focus:outline-none
                                focus:bg-gray-100 focus:text-gray-500 transition">
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

        <!-- Mobile Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <!-- Services Dropdown (Mobile) -->
                <div x-data="{ dropdown: false }" class="border-t border-gray-200">
                    <button @click="dropdown = !dropdown" class="w-full flex justify-between px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Services
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="dropdown" x-transition class="pl-6 space-y-1">
                        <a href="{{route('arms.info')}}" class="block px-4 py-2 hover:bg-gray-100">Arms License</a>
                        <a href="{{route('domicile.info')}}" class="block px-4 py-2 hover:bg-gray-100">Domicile</a>
                        <a href="{{route('idp.info')}}" class="block px-4 py-2 hover:bg-gray-100">International Driving Permit</a>
                        <a href="{{route('birth.info')}}" class="block px-4 py-2 hover:bg-gray-100">Birth Certificate</a>
                        <a href="{{route('mrc.info')}}" class="block px-4 py-2 hover:bg-gray-100">Marriage Certificate</a>
                        <a href="{{route('drc.info')}}" class="block px-4 py-2 hover:bg-gray-100"> Divorce Certificate</a>
                    </div>
                </div>

                <!-- About -->
                <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About</a>

                <!-- Login -->
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
                @endguest
            </div>
        </div>
    </nav>