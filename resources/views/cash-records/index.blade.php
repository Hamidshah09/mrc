<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cash Records') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <div class="flex items-center justify-end mb-4">
            <div class="flex items-center space-x-2">
                <div x-data="{ openPdf: false }" class="relative">
                    <button @click="openPdf = !openPdf" class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm flex items-center space-x-2">
                        <span>PDF Reports</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="openPdf" @click.away="openPdf = false" x-cloak class="absolute right-0 mt-2 w-44 bg-white border rounded shadow z-50">
                        <a :href="'{{ route('cash-records.note_sheet') }}' + (window.location.search ? window.location.search : '')" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Note Sheet</a>
                        <a :href="'{{ route('cash-records.challan') }}' + (window.location.search ? window.location.search : '')" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Challan</a>
                        <a :href="'{{ route('cash-records.challan_sheet') }}' + (window.location.search ? window.location.search : '')" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Challan Sheet</a>
                        <a :href="'{{ route('cash-records.monthly_report') }}' + (window.location.search ? window.location.search : '')" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Monthly Report</a>
                    </div>
                </div>

                <form action="{{ route('cash-records.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                    @csrf
                    <label for="file" class="px-3 py-2 bg-green-600 text-white rounded cursor-pointer hover:bg-green-700 text-sm">Upload File</label>
                    <input id="file" name="file" type="file" class="hidden" onchange="this.form.submit()">
                </form>

                <a href="{{ route('cash-records.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">New Record</a>
            </div>
        </div>

        <div class="bg-white border rounded shadow-sm p-4 mb-6">
            @if(session('success'))
                <div class="mb-4 text-green-700 p-2 bg-green-100 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 text-red-700 p-2 bg-red-100 rounded">{{ session('error') }}</div>
            @endif
            <form method="GET" action="{{ route('cash-records.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
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
                    <label class="text-sm text-gray-600">Payment Type</label>
                    <select name="payment_type" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">All</option>
                        <option value="Cash" {{ request('payment_type') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Esahulat" {{ request('payment_type') == 'Esahulat' ? 'selected' : '' }}>Esahulat</option>
                        <option value="1 Link" {{ request('payment_type') == '1 Link' ? 'selected' : '' }}>1 Link</option>

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
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Service Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Request Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Domicile #</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Operator</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cashRecords as $record)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->date }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->cnic }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->service_type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->request_type }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->domicile_number }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->status }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $record->operator_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                            <a href="{{ route('cash-records.edit', $record->id) }}" class="rounded text-indigo-700 hover:bg-indigo-400"><x-ionicon-pencil-sharp class="w-6 h-6"/></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-sm text-gray-500">No records found.</td>
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
        <!-- Modal -->
        {{-- <div x-cloak x-show="open" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-semibold mb-3">Generate PDF Report</h3>
                <form method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="block text-sm text-gray-700 mb-1">Select Report Type</label>
                        <select name="report_type" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Report</option>
                            <option value="notesheet">Note Sheet</option>
                            <option value="challanseet">Challan Sheet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm text-gray-700 mb-1">Date</label>
                        <input type="date" name="releasing_date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" />
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>
</x-app-layout>
