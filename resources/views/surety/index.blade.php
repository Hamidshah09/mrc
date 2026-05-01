<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surety Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        
        <div class="w-full flex justify-end">
            <a href="{{ route('surety.dashboard') }}" class="mb-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                Dashboard
            </a>

            <a href="{{ route('suretydocuments.index') }}"
               class="mb-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                New
            </a>
            
        </div>

        <!-- Filters -->
        <div class="w-full">
            <form action="" class="flex flex-col space-y-2 md:flex-row md:items-center md:space-x-2 md:space-y-0 mb-4 w-full">
                  <input type="text" name="search" placeholder="Search by Register ID or Guarantor Name"
                      class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3 lg:w-1/2"
                      value="{{ request('search') }}">

                <select name="surety_type_id"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">All Types</option>
                    @foreach($suretyTypes as $t)
                        <option value="{{ $t->id }}" {{ request('surety_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>

                <select name="police_station_id"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">All Police Stations</option>
                    @foreach($policeStations as $ps)
                        <option value="{{ $ps->id }}" {{ request('police_station_id') == $ps->id ? 'selected' : '' }}>{{ $ps->name }}</option>
                    @endforeach
                </select>

                <select name="status"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">All Statuses</option>
                    @foreach($surityStatuses as $s)
                        <option value="{{ $s->id }}" {{ request('status') == $s->id ? 'selected' : '' }}>{{ $s->status_name ?? $s->name }}</option>
                    @endforeach
                </select>

                  <label for="from">From</label>
                  <input type="date" name="from"
                      class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3"
                      value="{{ request('from') }}">

                  <label for="to">To</label>
                  <input type="date" name="to"
                      class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3"
                      value="{{ request('to') }}">

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Search
                </button>
            </form>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="text-green-700 bg-green-100 p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table View (Desktop) -->
        <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Register ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Guarantor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Mobile</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Receipt No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Receiving Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Accused</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($records as $record)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->register_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->guarantor_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->mobile_no }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->receipt_no }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ optional($record->receiving_date)->format('Y-m-d') ?? $record->receiving_date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->accused_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 text-right">{{ number_format($record->amount, 0) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ optional($record->suretyType)->name ?? $record->surety_type_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ optional($record->suretyStatus)->status_name ?? optional($record->suretyStatus)->name ?? $record->surety_status_id }}</td>

                            <td class="px-6 py-4 text-sm">
                                <div x-data="{ open: false }" class="relative">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('surety.edit', $record->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icons.pencil-square />
                                        </a>

                                        <button @click="open = true" type="button" class="text-green-600 hover:text-green-800">
                                            <x-icons.check-circle />
                                        </button>

                                        <a href="{{route('surety.show', $record->id)}}" class="text-purple-600 hover:text-purple-800">
                                            <x-icons.document-text />
                                        </a>
                                    </div>

                                    <!-- Modal -->
                                    <div x-cloak x-show="open" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
                                        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                            <h3 class="text-lg font-semibold mb-3">Update Status for {{ $record->register_id }}</h3>
                                            <form method="POST" action="{{ route('surety.updatestatus', $record->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="block text-sm text-gray-700 mb-1">Status</label>
                                                    <select name="surety_status_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                                        <option value="">Select status</option>
                                                        @foreach($surityStatuses as $s)
                                                            <option value="{{ $s->id }}" {{ $record->surety_status_id == $s->id ? 'selected' : '' }}>{{ $s->status_name ?? $s->name }}</option>
                                                        @endforeach
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
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $records->links() }}
            </div>
        </div>

        <!-- Card View (Mobile) -->
        <div class="md:hidden space-y-4">
            @foreach ($records as $record)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Register ID:</td>
                            <td class="p-3 text-gray-900">{{ $record->register_id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Guarantor:</td>
                            <td class="p-3 text-gray-900">{{ $record->guarantaor_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Mobile:</td>
                            <td class="p-3 text-gray-900">{{ $record->mobile_no }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Receipt No:</td>
                            <td class="p-3 text-gray-900">{{ $record->receipt_no }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Date:</td>
                            <td class="p-3 text-gray-900">{{ optional($record->receipt_date)->format('Y-m-d') ?? $record->receipt_date }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Police Station:</td>
                            <td class="p-3 text-gray-900">{{ optional($record->policeStation)->name ?? $record->police_station_id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Amount:</td>
                            <td class="p-3 text-gray-900">{{ number_format($record->amount, 0) }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Type:</td>
                            <td class="p-3 text-gray-900">{{ optional($record->suretyType)->name ?? $record->surety_type_id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3 text-gray-900">{{ optional($record->suretyStatus)->status_name ?? optional($record->suretyStatus)->name ?? $record->surety_status_id }}</td>
                        </tr>

                        <tr>
                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="p-3">
                                <div x-data="{ open: false }" class="relative">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('surety.edit', $record->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icons.pencil-square />
                                        </a>
                                        <button @click="open = true" type="button" class="text-green-600 hover:text-green-800">
                                            <x-icons.check-circle />
                                        </button>
                                        <a href="{{route('surety.show', $record->id)}}" class="text-purple-600 hover:text-purple-800">
                                            <x-icons.document-text />
                                        </a>
                                    </div>

                                    <!-- Mobile Modal -->
                                    <div x-cloak x-show="open" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
                                        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                            <h3 class="text-lg font-semibold mb-3">Update Status for {{ $record->register_id }}</h3>
                                            <form method="POST" action="{{ route('surety.updatestatus', $record->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="block text-sm text-gray-700 mb-1">Status</label>
                                                    <select name="surety_status_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                                        <option value="">Select status</option>
                                                        @foreach($surityStatuses as $s)
                                                            <option value="{{ $s->id }}" {{ $record->surety_status_id == $s->id ? 'selected' : '' }}>{{ $s->status_name ?? $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="block text-sm text-gray-700 mb-1">Date</label>
                                                    <input type="date" name="manual_date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" />
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
    <!-- No bulk status update for surety table -->

</x-app-layout>
