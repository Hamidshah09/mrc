<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mosques List') }}
            </h2>

            <a href="{{ route('mousques.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
                    font-semibold text-xs text-white uppercase tracking-widest
                    hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                    transition ease-in-out duration-150">
                Add Mosque
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        {{-- ===================== FILTER BAR ===================== --}}
        <form method="GET"
            class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">

            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

                {{-- Mosque Name --}}
                <div class="">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Mosque Name
                    </label>
                    <input type="text"
                        name="name"
                        value="{{ request('name') }}"
                        placeholder="Search mosque name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                {{-- Official Search --}}
                <div class="">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Official (Name / CNIC / Mobile)
                    </label>
                    <input type="text"
                        name="official"
                        value="{{ request('official') }}"
                        placeholder="e.g. Ahmed / 35202 / 0301"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>

                {{-- Sector --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Sector
                    </label>
                    <select name="sector_id"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All</option>
                        @foreach($sectors as $sector)
                            <option value="{{ $sector->id }}"
                                {{ request('sector_id') == $sector->id ? 'selected' : '' }}>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sub Sector --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Sub Sector
                    </label>
                    <input type="text"
                        name="sub_sector"
                        value="{{ request('sub_sector') }}"
                        placeholder="e.g. A, B, 1"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>

                {{-- Has Shops --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Shops
                    </label>
                    <select name="has_shops"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All</option>
                        <option value="1" {{ request('has_shops') === '1' ? 'selected' : '' }}>
                            With Shops
                        </option>
                        <option value="0" {{ request('has_shops') === '0' ? 'selected' : '' }}>
                            No Shops
                        </option>
                    </select>
                </div>

                {{-- Has Madrassa --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        Madrassa
                    </label>
                    <select name="has_maddarsa"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">All</option>
                        <option value="1" {{ request('has_maddarsa') === '1' ? 'selected' : '' }}>
                            Yes
                        </option>
                        <option value="0" {{ request('has_maddarsa') === '0' ? 'selected' : '' }}>
                            No
                        </option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('mousques.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                        Reset
                    </a>
                </div>

            </div>
        </form>
        {{-- ===================== ACTIVE FILTER BADGES ===================== --}}
        @php
            $activeFilters = [
                'name'          => request('name'),
                'sector_id'     => request('sector_id'),
                'sub_sector'    => request('sub_sector'),
                'has_shops'     => request('has_shops'),
                'has_maddarsa'  => request('has_maddarsa'),
                'official'      => request('official'),
            ];
        @endphp

        @if(collect($activeFilters)->filter()->isNotEmpty())
            <div class="mb-4 flex flex-wrap gap-2">

                @foreach($activeFilters as $key => $value)
                    @if($value !== null && $value !== '')

                        <span class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-800 text-xs font-medium px-3 py-2 rounded-lg">

                            {{-- Label --}}
                            <span>
                                @switch($key)
                                    @case('name')
                                        Mosque: {{ $value }}
                                        @break

                                    @case('sector_id')
                                        Sector: {{ optional($sectors->firstWhere('id', $value))->name }}
                                        @break

                                    @case('sub_sector')
                                        Sub-Sector: {{ $value }}
                                        @break

                                    @case('has_shops')
                                        Shops: {{ $value == 1 ? 'Yes' : 'No' }}
                                        @break

                                    @case('has_maddarsa')
                                        Madrassa: {{ $value == 1 ? 'Yes' : 'No' }}
                                        @break

                                    @case('official')
                                        Official: {{ $value }}
                                        @break
                                @endswitch
                            </span>

                            {{-- Remove single filter --}}
                            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                            class="hover:text-red-600 font-bold">
                                ×
                            </a>
                        </span>

                    @endif
                @endforeach

                {{-- Clear all --}}
                <a href="{{ route('mousques.index') }}"
                class="inline-flex items-center bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1 rounded-full hover:bg-gray-300">
                    Clear All
                </a>
            </div>
        @endif



        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 rounded-lg">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Mosque</th>
                        <th class="px-4 py-3">Sector</th>
                        <th class="px-4 py-3 text-center">Shops</th>
                        <th class="px-4 py-3 text-center">Madrassa</th>
                        <th class="px-4 py-3 text-center">Officials</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($mousques as $mousque)
                        {{-- MAIN ROW --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $mousque->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $mousque->sector->name ?? '—' }}
                            </td>

                            {{-- Shops --}}
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                    {{ $mousque->shops->count() }}
                                </span>
                            </td>

                            {{-- Madrassa --}}
                            <td class="px-4 py-3 text-center">
                                @if($mousque->maddarsa)
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Yes
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                        No
                                    </span>
                                @endif
                            </td>

                            {{-- Officials Toggle --}}
                            <td class="px-4 py-3 text-center">
                                @if($mousque->officials->count() > 0)
                                    <button type="button"
                                            onclick="toggleOfficials({{ $mousque->id }}, this)"
                                            class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm px-2 py-1 rounded hover:bg-indigo-50">

                                        {{-- Count --}}
                                        <span class="font-medium">
                                            {{ $mousque->officials->count() }}
                                        </span>

                                        {{-- Down Arrow --}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4 transition-transform duration-200"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            data-arrow>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">0</span>
                                @endif
                            </td>


                            {{-- Actions --}}
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('mousques.show', $mousque->id) }}"
                                   class="text-blue-600 hover:text-blue-800"
                                   title="View">
                                    👁
                                </a>

                                <a href="{{ route('mousques.edit', $mousque->id) }}"
                                   class="text-green-600 hover:text-green-800"
                                   title="Edit">
                                    ✏
                                </a>
                            </td>
                        </tr>

                        {{-- OFFICIALS COLLAPSIBLE ROW --}}
                        <tr id="officials-{{ $mousque->id }}" class="hidden bg-gray-50">
                            <td colspan="6" class="px-6 py-4">

                                @if($mousque->officials->count())
                                    <div class="border rounded">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-300">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Name</th>
                                                    <th class="px-3 py-2 text-left">Father</th>
                                                    <th class="px-3 py-2 text-left">Contact</th>
                                                     <th class="px-3 py-2 text-left">Position</th>
                                                    <th class="px-3 py-2 text-left">Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mousque->officials as $official)
                                                    <tr class="border-t">
                                                        <td class="px-3 py-2">{{ $official->name }}</td>
                                                        <td class="px-3 py-2">{{ $official->father_name }}</td>
                                                        <td class="px-3 py-2">{{ $official->contact_number }}</td>
                                                        <td class="px-3 py-2">{{ $official->position_name }}</td>
                                                        <td class="px-3 py-2">
                                                            <span class="px-2 py-1 text-xs rounded bg-gray-100">
                                                                {{ $official->type }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">
                                        No officials assigned to this mosque.
                                    </p>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-4 mt-4">
        @foreach($mousques as $mousque)
            <div class="border border-gray-200 rounded-lg shadow-sm bg-gray-50 p-4">

                <div class="mb-2">
                    <span class="text-xs text-gray-500">Mosque</span>
                    <p class="font-semibold text-gray-800">
                        {{ $mousque->name }}
                    </p>
                </div>

                <div class="mb-2">
                    <span class="text-xs text-gray-500">Sector</span>
                    <p>{{ $mousque->sector->name ?? '—' }}</p>
                </div>

                <div class="flex justify-between items-center mb-2">
                    <div>
                        <span class="text-xs text-gray-500">Shops</span>
                        <p class="font-medium">{{ $mousque->shops->count() }}</p>
                    </div>

                    <div>
                        <span class="text-xs text-gray-500">Madrassa</span>
                        <p>
                            <span class="px-2 py-1 text-xs rounded
                                {{ $mousque->maddarsa ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $mousque->maddarsa ? 'Yes' : 'No' }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- OFFICIALS COLLAPSE (MOBILE) --}}
                <div class="mt-3">
                    <button type="button"
                            onclick="toggleMobileOfficials({{ $mousque->id }}, this)"
                            class="w-full flex justify-between items-center text-indigo-600 text-sm font-medium">

                        <span>
                            Officials ({{ $mousque->officials->count() }})
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            data-arrow>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="mobile-officials-{{ $mousque->id }}" class="hidden mt-2 border-t pt-2">
                        @forelse($mousque->officials as $official)
                            <div class="text-sm mb-1">
                                <p class="font-medium">{{ $official->name }}</p>
                                <p class="text-gray-600">
                                    {{ $official->position_name }} • {{ $official->contact_number }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No officials</p>
                        @endforelse
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('mousques.show', $mousque->id) }}"
                    class="text-blue-600 text-sm font-medium">
                        View
                    </a>

                    <a href="{{ route('mousques.edit', $mousque->id) }}"
                    class="text-green-600 text-sm font-medium">
                        Edit
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- JS --}}
    <script>
        function toggleOfficials(id, btn) {
            const row = document.getElementById('officials-' + id);
            const arrow = btn.querySelector('[data-arrow]');

            row.classList.toggle('hidden');

            if (arrow) {
                arrow.classList.toggle('rotate-180');
            }
        }
        function toggleMobileOfficials(id, btn) {
            const box = document.getElementById('mobile-officials-' + id);
            const arrow = btn.querySelector('[data-arrow]');

            box.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>

</x-app-layout>
