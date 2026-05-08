<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Cash Records</h2>

            <div class="flex items-center space-x-2">
                <a href="{{ route('cash-records.note_sheet') }}{{ request()->getQueryString() ? ('?' . request()->getQueryString()) : '' }}" target="_blank" class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Note Sheet (PDF)</a>
                <a href="{{ route('cash-records.challan') }}{{ request()->getQueryString() ? ('?' . request()->getQueryString()) : '' }}" target="_blank" class="px-3 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">Challan (PDF)</a>

                <form action="{{ route('cash-records.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                    @csrf
                    <label for="file" class="px-3 py-2 bg-green-600 text-white rounded cursor-pointer hover:bg-green-700 text-sm">Upload File</label>
                    <input id="file" name="file" type="file" class="hidden" onchange="this.form.submit()">
                </form>

                <a href="{{ route('cash-records.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">New Record</a>
            </div>
        </div>

        <div class="bg-white border rounded shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('cash-records.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="text-sm text-gray-600">From</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="text-sm text-gray-600">To</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Service Type</label>
                    <select name="service_type" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">All</option>
                        <option value="online" {{ request('service_type') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ request('service_type') == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Search</label>
                    <div class="flex">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="name, CNIC or mobile" class="mt-1 block w-full border-gray-300 rounded-l-md">
                        <button type="submit" class="px-3 bg-indigo-600 text-white rounded-r-md">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white border rounded shadow-sm overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-300">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">CNIC</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Mobile</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Service Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Request Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Domicile #</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Operator</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cashRecords as $record)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->date }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->cnic }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->mobile }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->service_type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->request_type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->domicile_number }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->status }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->operator_name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-sm text-gray-500">No records found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            @if(method_exists($cashRecords, 'links'))
                {{ $cashRecords->appends(request()->query())->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
