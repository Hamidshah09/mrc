<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postal Service') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="w-full flex justify-end">
            <a href="{{route('postalservice.create')}}" class="mb-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New</a>
            <form method="GET" action="{{ route('postalservice.export.pdf') }}" class="ml-2 inline">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="search_type" value="{{ request('search_type') }}">
                <input type="hidden" name="from" value="{{ request('from') }}">
                <input type="hidden" name="to" value="{{ request('to') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button type="submit" class="mb-2 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Export Report</button>
            </form>
            <form method="GET" action="{{ route('postalservice.export.pdf_receiving') }}" class="ml-2 inline">
                            <button type="button" onclick="openEnvelopeLabelModal()" class="mb-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">Envelope Labels PDF</button>
                    
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="search_type" value="{{ request('search_type') }}">
                <input type="hidden" name="from" value="{{ request('from') }}">
                <input type="hidden" name="to" value="{{ request('to') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button type="submit" class="mb-2 px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">Export Receiving</button>
            </form>
        </div>
        <!-- Envelope Label Modal -->
        <div id="envelopeLabelModal" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Generate Envelope Labels PDF</h2>
                <form id="envelopeLabelForm" method="POST" action="{{ route('postalservice.export.envelope_labels') }}" target="_blank">
                    @csrf
                    <div class="mb-4">
                        <label for="report_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Report Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" id="report_date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                        <div class="mb-6">
                            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Service <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="service_id" 
                                id="service_id" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_id') border-red-500 @enderror" 
                                required>
                                <option value="">Choose a Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ ucfirst($service->service) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEnvelopeLabelModal()" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">Generate PDF</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-full">
            <form action="" class="flex flex-col space-y-2 md:flex-row md:items-center md:space-x-2 md:space-y-0 mb-4 w-full">
                <input type="text" name="search" placeholder="Search by Article Number or Receiver Name" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3 lg:w-1/2" value="{{ request('search') }}">
                <select name="search_type" id="" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    
                    <option value="article_number">Article Number</option>
                    <option selected value="receiver_name">Receiver Name</option>
                    <option value="receiver_address">Receiver Address</option>
                    <option value="phone_number">Phone Number</option>
                </select>

                <label for="from">From</label>
                <input type="date" name="From" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3" value="{{ request('from') }}">
                <label for="from">to</label>
                <input type="date" name="To" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3" value="{{ request('to') }}">
                <label for="status">Status</label>
                <select name="status" id="" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option selected>Choose an option</option>
                    <option value="pending">Pending</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="returned">Returned</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">Search</button>
            </form>


        </div>


        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Table View (hidden on small screens) -->
        <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Article Number</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Receiver Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Weight</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Rate</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($records as $record)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->article_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->receiver_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->phone_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->receiver_address }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->weight }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record->rate }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $record->status->status === 'Delivered' ? 'bg-green-100 text-green-800' :
                                        ($record->status->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                        ($record->status->status === 'In Transit' ? 'bg-blue-100 text-blue-800' :
                                        'bg-red-100 text-red-800'))
                                    }}">
                                    {{ ucfirst($record->status->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    
                                    <a href="{{ route('postalservice.edit', $record->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <x-icons.pencil-square />
                                    </a>
                                        
                                    <a href="{{ route('postalservice.show', $record->id) }}" class="text-green-600 hover:text-green-800">
                                        <x-icons.exclamation-triangle />
                                    </a>
                                    <button onclick="openStatusModal({{ $record->id }})" class="text-purple-600 hover:text-purple-800" title="Update Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
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

        <!-- Card View (visible only on small screens) -->
        <div class="md:hidden space-y-4">
            @foreach ($records as $record)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">ID:</td>
                            <td class="p-3 text-gray-900">{{ $record->id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Article Number:</td>
                            <td class="p-3 text-gray-900">{{ $record->article_number }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Receiver:</td>
                            <td class="p-3 text-gray-900">{{ $record->receiver_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Phone:</td>
                            <td class="p-3 text-gray-900">{{ $record->phone_number ?? 'N/A' }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Address:</td>
                            <td class="p-3 text-gray-900">{{ $record->receiver_address }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Weight:</td>
                            <td class="p-3 text-gray-900">{{ $record->weight }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Rate:</td>
                            <td class="p-3 text-gray-900">{{ $record->rate }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $record->status->status === 'Delivered' ? 'bg-green-100 text-green-800' :
                                        ($record->status->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                        ($record->status->status === 'In Transit' ? 'bg-blue-100 text-blue-800' :
                                        'bg-red-100 text-red-800'))
                                    }}">
                                    {{ ucfirst($record->status->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    @if ($user->id === $record->user_id)
                                        <a href="{{ route('postalservice.edit', $record->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icons.pencil-square />
                                        </a>
                                    @endif
                                    <a href="{{ route('postalservice.show', $record->id) }}" class="text-green-600 hover:text-green-800">
                                        <x-icons.exclamation-triangle />
                                    </a>
                                    <button onclick="openStatusModal({{ $record->id }})" class="text-purple-600 hover:text-purple-800" title="Update Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            @endforeach
            <div>
                {{ $records->links() }}
            </div>
        </div>

    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select New Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status_id" id="status_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Choose a status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ ucfirst($status->status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-purple-600 text-white rounded hover:bg-purple-700">Update Status</button>
                </div>
            </form>
        </div>
    </div>

    <script>
                function openEnvelopeLabelModal() {
                    document.getElementById('envelopeLabelModal').classList.remove('hidden');
                }
                function closeEnvelopeLabelModal() {
                    document.getElementById('envelopeLabelModal').classList.add('hidden');
                    document.getElementById('envelopeLabelForm').reset();
                }
        function openStatusModal(recordId) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');

            // Construct dynamic route URL
            form.action = `/postalservice/update-status/${recordId}`;

            // Show the modal
            modal.classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('statusForm').reset();
        }
    </script>


</x-app-layout>
