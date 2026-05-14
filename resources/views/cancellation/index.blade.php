<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Domicile Cancellation Letters') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="flex justify-end items-center mb-4">
            <a href="{{ route('domicile.cancellation.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Letter</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        <div class="flex justify-between items-center space-x-4 m-2 mb-4">
            <form action="{{ route('domicile.cancellation.index') }}"
                method="GET"
                class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4 items-end">

                {{-- Search --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="CNIC / Name / Letter ID / Domicile No / Dispatch"

                        class="w-full rounded-xl border-gray-300
                            shadow-sm
                            focus:ring-2
                            focus:ring-indigo-500
                            focus:border-indigo-500">

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
                            shadow transition">

                        <div class="flex items-center justify-center gap-2">

                            <x-heroicon-s-magnifying-glass
                                class="w-5 h-5"/>

                            Search

                        </div>

                    </button>

                </div>


                {{-- Clear Button --}}
                <div>

                    <a href="{{ route('domicile.cancellation.index') }}"
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
            <table class="min-w-full divide-y divide-gray-400">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Letter Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dispatch No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domicile No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domicile Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($letters as $letter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_ID }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_Date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->dispatchDiary->Dispatch_No ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->CNIC ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Applicant_Name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Domicile_No ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Domicile_Date ?? 'N/A' }}</td>
                        <td class="px-6 py-4 flex flex-row space-between">
                            <a href="{{ route('domicile.cancellation.edit', $letter->Letter_ID) }}" ><x-heroicon-s-pencil title="Edit" class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/></a>
                            <a href="{{ route('domicile.cancellation.letter', $letter->Letter_ID) }}" ><x-heroicon-s-document-check title="Issue Letter" class="w-7 h-7 text-green-400 hover:text-green-600 transition"/></a>
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
            {{ $letters->links() }}
        </div>
    </div>
</x-app-layout>
