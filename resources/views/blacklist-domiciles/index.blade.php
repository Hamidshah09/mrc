<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Black List CNICs for Domicile Applications') }}
        </h2>
    </x-slot>

    <div class="w-[95%] mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('domicile.blacklist.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Entry</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700 p-2 bg-green-100 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-700 p-2 bg-red-100 rounded">{{ session('error') }}</div>
        @endif
        <div class="flex justify-end items-center space-x-4 m-2 mb-4">
            <form action="{{ route('domicile.blacklist.index') }}"
                method="GET"
                class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-4 items-end">

                {{-- Search --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="CNIC / Reason / ID"

                        class="w-full rounded-xl border-gray-300
                            shadow-sm
                            focus:ring-2
                            focus:ring-indigo-500
                            focus:border-indigo-500">

                </div>


                {{-- Status --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>

                    <select
                        name="status"

                        class="w-full rounded-xl border-gray-300
                            shadow-sm
                            focus:ring-2
                            focus:ring-indigo-500
                            focus:border-indigo-500">

                        <option value="">
                            All
                        </option>

                        <option value="blocked"
                            {{ request('status')=='blocked' ? 'selected':'' }}>

                            Blocked

                        </option>

                        <option value="unblocked"
                            {{ request('status')=='unblocked' ? 'selected':'' }}>

                            Unblocked

                        </option>

                    </select>

                </div>


                {{-- From Date --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        From
                    </label>

                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"

                        class="w-full rounded-xl border-gray-300
                            shadow-sm
                            focus:ring-2
                            focus:ring-indigo-500
                            focus:border-indigo-500">

                </div>


                {{-- To Date --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        To
                    </label>

                    <input
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"

                        class="w-full rounded-xl border-gray-300
                            shadow-sm
                            focus:ring-2
                            focus:ring-indigo-500
                            focus:border-indigo-500">

                </div>


                {{-- Search Button --}}
                <div>

                    <button
                        type="submit"

                        class="w-full h-[42px]
                            bg-indigo-600
                            hover:bg-indigo-700
                            text-white rounded-xl
                            shadow">

                        <div class="flex items-center justify-center gap-2">

                            <x-heroicon-s-magnifying-glass
                                class="w-5 h-5"/>

                            Search

                        </div>

                    </button>

                </div>


                {{-- Clear --}}
                <div>

                    <a href="{{ route('domicile.blacklist.index') }}"
                    class="w-full h-[42px]
                            flex items-center justify-center gap-2
                            bg-gray-200
                            hover:bg-gray-300
                            rounded-xl">

                        <x-heroicon-s-x-mark
                            class="w-5 h-5"/>

                        Clear

                    </a>

                </div>

            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated by</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blacklists as $letter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->black_list_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->cnic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($letter->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('domicile.blacklist.edit', $letter->black_list_id) }}"><x-heroicon-s-pencil title="Edit" class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No letters found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $blacklists->links() }}
        </div>
    </div>
</x-app-layout>
