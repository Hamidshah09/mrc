{{-- resources/views/components/sidebar.blade.php --}}
<div x-data="{ open: false }" class="flex">

    {{-- Sidebar (visible on desktop, toggleable on mobile) --}}
    <aside
        :class="{ 'translate-x-0': open, '-translate-x-full': !open }"
        class="fixed z-40 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out sm:translate-x-0 sm:static sm:inset-auto sm:transform-none">
        
        <div class="p-4 border-b flex items-center justify-center">
            <a href="{{ route('home') }}">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <nav class="mt-6 space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" class="block px-6 py-2 text-gray-700 hover:bg-gray-100">
                Dashboard
            </a>

            {{-- Statistics --}}
            @if (auth()->user()->role->role == 'admin' || auth()->user()->role->role == 'domicile' || auth()->user()->role->role == 'idp')
                <a href="{{ route('statistics.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-gray-100">
                    Statistics
                </a>
            @endif

            {{-- Admin --}}
            @if (auth()->user()->role->role == 'admin')
                <a href="{{ route('users.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-gray-100">Users</a>
                <a href="{{ route('arms.index') }}" class="block px-6 py-2 text-gray-700 hover:bg-gray-100">Arms</a>
            @endif

            {{-- Domicile --}}
            @if (auth()->user()->role->role == 'admin' || auth()->user()->role->role == 'domicile')
                <div x-data="{ submenu: false }" class="px-6">
                    <button @click="submenu = !submenu"
                        class="flex justify-between w-full text-gray-700 hover:text-blue-600 py-2">
                        Domicile
                        <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="submenu" x-transition class="ml-3 space-y-1">
                        <a href="{{ route('Passcode.create') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Generate Passcode
                        </a>
                        <a href="{{ route('Passcodes.gen_report') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Passcode Report
                        </a>
                        <a href="{{ route('domicile.admin') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">
                            Form P
                        </a>
                    </div>
                </div>
            @endif
        </nav>
    </aside>

    {{-- Content area --}}
    <div class="flex-1 flex flex-col min-h-screen">
        {{-- Top Bar --}}
        <header class="flex items-center justify-between bg-gray-100 px-4 py-3 border-b">
            <button @click="open = !open" class="sm:hidden inline-flex items-center text-gray-700 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="font-semibold text-lg">Dashboard</h1>
        </header>

        {{-- Page Content Slot --}}
        <main class="p-6 flex-1">
            {{ $slot ?? '' }}
        </main>
    </div>
</div>
