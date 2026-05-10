<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verification Letters') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Letters</h3>
            <a href="{{ route('domicile.verification_letter.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Letter</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        <div class="flex justify-between items-center space-x-4 m-2 mb-4">
            <form action="{{route('domicile.verification_letter.index')}}" method="GET" class="w-full mt-3">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex-1 min-w-[220px]">
                        <input type="text" name="filter" value="{{ request('filter') }}" placeholder="Search CNIC, Applicant name, or Sent To" class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200" />
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="from_date" class="text-sm">From</label>
                        <input id="from_date" type="date" name="from_date" value="{{ request('from_date') }}" class="px-3 py-2 border rounded-md" />
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="to_date" class="text-sm">To</label>
                        <input id="to_date" type="date" name="to_date" value="{{ request('to_date') }}" class="px-3 py-2 border rounded-md" />
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Letter Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dispatch No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($letters as $letter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_ID }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_Date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->dispatchDiary->Dispatch_No ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_Sent_by }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->applicants[0]->CNIC ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->applicants[0]->Applicant_Name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('domicile.verification_letter.edit', $letter->Letter_ID) }}" class="bg-indigo-200 text-gray-800 hover:bg-indigo-400 mr-3 p-2 rounded">Edit</a>
                            <a href="{{ route('domicile.verification_letter.letter', $letter->Letter_ID) }}" class="bg-indigo-200 text-gray-800 hover:bg-indigo-400 mr-3 p-2 rounded">Letter</a>
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
