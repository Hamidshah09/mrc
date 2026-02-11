<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postal Service Record Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="space-y-6">
            <!-- Article Number -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Article Number</label>
                <p class="text-gray-900 text-lg">{{ $record->article_number }}</p>
            </div>

            <!-- Receiver Name -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Receiver Name</label>
                <p class="text-gray-900 text-lg">{{ $record->receiver_name }}</p>
            </div>

            <!-- Receiver Address -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Receiver Address</label>
                <p class="text-gray-900 text-lg">{{ $record->receiver_address }}</p>
            </div>

            <!-- Phone Number -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <p class="text-gray-900 text-lg">{{ $record->phone_number ?? 'N/A' }}</p>
            </div>

            <!-- Weight -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Weight</label>
                <p class="text-gray-900 text-lg">{{ $record->weight }}</p>
            </div>

            <!-- Rate -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rate</label>
                <p class="text-gray-900 text-lg">{{ $record->rate }}</p>
            </div>

            <!-- Status -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        {{
                            $record->status->status === 'Delivered' ? 'bg-green-100 text-green-800' :
                            ($record->status->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                            ($record->status->status === 'In Transit' ? 'bg-blue-100 text-blue-800' :
                            ($record->status->status === 'Returned' ? 'bg-red-100 text-red-800' :
                            'bg-red-100 text-red-800')))
                        }}">
                        {{ ucfirst($record->status->status) }}
                    </span>
                </p>
            </div>

            <!-- Created At -->
            <div class="border-b pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Created At</label>
                <p class="text-gray-900 text-lg">{{ $record->created_at->format('M d, Y H:i A') }}</p>
            </div>

            <!-- Updated At -->
            <div class="pb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                <p class="text-gray-900 text-lg">{{ $record->updated_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>

        <!-- Postal History Section -->
        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Postal History</h3>
            
            @if($record->history && count($record->history) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Status</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Updated By</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($record->history as $historyRecord)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-300 px-4 py-2 text-gray-900">
                                        {{-- Display status based on status_id --}}
                                        @php
                                            $statusText = '';
                                            switch($historyRecord->status_id) {
                                                case 1: $statusText = 'Pending'; $badgeClass = 'bg-yellow-100 text-yellow-800'; break;
                                                case 2: $statusText = 'In Transit'; $badgeClass = 'bg-blue-100 text-blue-800'; break;
                                                case 3: $statusText = 'Delivered'; $badgeClass = 'bg-green-100 text-green-800'; break;
                                                case 4: $statusText = 'Returned'; $badgeClass = 'bg-red-100 text-red-800'; break;
                                                default: $statusText = 'Unknown'; $badgeClass = 'bg-gray-100 text-gray-800';
                                            }
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                        {{ $historyRecord->user ? $historyRecord->user->name : 'System' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-gray-600">
                                        {{ $historyRecord->created_at->format('M d, Y H:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600 italic">No history records found for this postal service.</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('postalservice.index') }}" 
                class="px-6 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                Back
            </a>
            <a href="{{ route('postalservice.edit', $record->id) }}" 
                class="px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                Edit
            </a>
        </div>
    </div>
</x-app-layout>
