<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postal Service Record Details') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">

        {{-- ================= MAIN RECORD DETAILS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
                $fields = [
                    'Article Number'    => $record->article_number,
                    'Receiver Name'     => $record->receiver_name,
                    'Receiver Address'  => $record->receiver_address,
                    'Phone Number'      => $record->phone_number ?? 'N/A',
                    'Weight'            => $record->weight,
                    'Rate'              => $record->rate,
                ];
            @endphp

            @foreach ($fields as $label => $value)
                <div class="border rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        {{ $label }}
                    </label>
                    <p class="text-gray-900 font-semibold break-words">
                        {{ $value }}
                    </p>
                </div>
            @endforeach

            {{-- Status --}}
            <div class="border rounded-lg p-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Current Status
                </label>

                @php
                    $status = $record->status->status ?? 'Unknown';
                    $statusClass = match ($status) {
                        'Delivered'  => 'bg-green-100 text-green-800',
                        'In Transit' => 'bg-blue-100 text-blue-800',
                        'Pending'    => 'bg-yellow-100 text-yellow-800',
                        'Returned'   => 'bg-red-100 text-red-800',
                        default      => 'bg-gray-100 text-gray-800',
                    };
                @endphp

                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                    {{ $status }}
                </span>
            </div>

            {{-- Created At --}}
            <div class="border rounded-lg p-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Created At
                </label>
                <p class="text-gray-900">
                    {{ $record->created_at->format('M d, Y h:i A') }}
                </p>
            </div>

            {{-- Updated At --}}
            <div class="border rounded-lg p-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Last Updated
                </label>
                <p class="text-gray-900">
                    {{ $record->updated_at->format('M d, Y h:i A') }}
                </p>
            </div>

        </div>

        {{-- ================= POSTAL HISTORY ================= --}}
        <div class="mt-12 border-t pt-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">
                Postal History
            </h3>

            @if ($record->history && $record->history->count())

                {{-- ===== Mobile / Small screens ===== --}}
                <div class="space-y-4 lg:hidden">
                    @foreach ($record->history as $history)
                        @php
                            $historyStatus = $history->status->status ?? 'Unknown';
                            $badgeClass = match ($historyStatus) {
                                'Delivered'  => 'bg-green-100 text-green-800',
                                'In Transit' => 'bg-blue-100 text-blue-800',
                                'Pending'    => 'bg-yellow-100 text-yellow-800',
                                'Returned'   => 'bg-red-100 text-red-800',
                                default      => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <div class="border rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                                    {{ $historyStatus }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $history->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600">
                                Updated by:
                                <strong>{{ $history->user->name ?? 'System' }}</strong>
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- ===== Desktop / Large screens ===== --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full border border-gray-300 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                                    Updated By
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">
                                    Updated At
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record->history as $history)
                                @php
                                    $historyStatus = $history->status->status ?? 'Unknown';
                                    $badgeClass = match ($historyStatus) {
                                        'Delivered'  => 'bg-green-100 text-green-800',
                                        'In Transit' => 'bg-blue-100 text-blue-800',
                                        'Pending'    => 'bg-yellow-100 text-yellow-800',
                                        'Returned'   => 'bg-red-100 text-red-800',
                                        default      => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                                            {{ $historyStatus }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $history->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $history->created_at->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <p class="text-gray-500 italic">
                    No postal history available for this record.
                </p>
            @endif
        </div>

        {{-- ================= ACTIONS ================= --}}
        <div class="mt-10 flex justify-end space-x-3">
            <a href="{{ route('postalservice.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                Back
            </a>

            <a href="{{ route('postalservice.edit', $record->id) }}"
               class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Edit
            </a>
        </div>

    </div>
</x-app-layout>
