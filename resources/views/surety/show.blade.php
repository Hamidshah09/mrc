<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surety Record') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">Record: {{ $record->register_id }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-600">Guarantor</p>
                <p class="text-lg font-medium">{{ $record->guarantaor_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Mobile</p>
                <p class="text-lg font-medium">{{ $record->mobile_no }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Receipt No</p>
                <p class="text-lg font-medium">{{ $record->receipt_no }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Receipt Date</p>
                <p class="text-lg font-medium">{{ optional($record->receipt_date)->format('Y-m-d') ?? $record->receipt_date }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Police Station</p>
                <p class="text-lg font-medium">{{ optional($record->policeStation)->name ?? $record->police_station_id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Amount</p>
                <p class="text-lg font-medium">{{ number_format($record->amount, 0) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Type</p>
                <p class="text-lg font-medium">{{ optional($record->suretyType)->name ?? $record->surety_type_id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Status</p>
                <p class="text-lg font-medium">{{ optional($record->suretyStatus)->status_name ?? optional($record->suretyStatus)->name ?? $record->surety_status_id }}</p>
            </div>
        </div>

        <div class="flex justify-end mb-6">
            <a href="{{ route('surety.edit', $record->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
            <a href="{{ route('surety.index') }}" class="ml-3 px-4 py-2 bg-gray-300 rounded">Back</a>
        </div>

        <h3 class="text-xl font-semibold mb-3">Change History</h3>
        @if($history->isEmpty())
            <p class="text-sm text-gray-600">No history available.</p>
        @else
            <div class="overflow-x-auto bg-white rounded shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">When</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Updated By</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($history as $h)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ optional($h->created_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ optional($h->status)->status_name ?? $statuses[$h->status_id] ?? $h->status_id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ optional($h->updatedBy)->name ?? optional($h->updatedBy)->email ?? $h->updated_by }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
