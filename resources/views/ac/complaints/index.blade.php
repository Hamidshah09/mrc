<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <h2 class="text-3xl font-bold text-gray-800">

                    Complaints

                </h2>

            </div>

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif
            {{-- Filters --}}
            <form method="GET"
                action="{{ route('ac.complaints.index') }}"
                class="mb-6 bg-gray-50 border rounded-xl p-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Status --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Status

                        </label>

                        <select name="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm">

                            <option value="">
                                All Statuses
                            </option>

                            <option value="pending"
                                {{ request('status') == 'pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="assigned"
                                {{ request('status') == 'assigned' ? 'selected' : '' }}>

                                Assigned

                            </option>

                            <option value="resolved"
                                {{ request('status') == 'resolved' ? 'selected' : '' }}>

                                Resolved

                            </option>

                            <option value="approved"
                                {{ request('status') == 'approved' ? 'selected' : '' }}>

                                Approved

                            </option>

                            <option value="rejected"
                                {{ request('status') == 'rejected' ? 'selected' : '' }}>

                                Rejected

                            </option>

                        </select>

                    </div>

                    {{-- Magistrate --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">

                            Magistrate

                        </label>

                        <select name="magistrate_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm">

                            <option value="">
                                All Magistrates
                            </option>

                            @foreach($magistrates as $magistrate)

                                <option value="{{ $magistrate->id }}"
                                    {{ request('magistrate_id') == $magistrate->id ? 'selected' : '' }}>

                                    {{ $magistrate->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 mt-5">

                    <button type="submit"
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                        Apply Filters

                    </button>

                    <a href="{{ route('ac.complaints.index') }}"
                    class="w-full sm:w-auto bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg text-center">

                        Reset

                    </a>

                </div>

            </form>
            {{-- Complaints Table --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">

                <div class="hidden md:block overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-100">

                            <tr>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    ID
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Image
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Operator
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Police Station
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Magistrate
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Date
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($complaints as $complaint)

                                <tr>

                                    {{-- ID --}}
                                    <td class="px-4 py-4 font-semibold">

                                        #{{ $complaint->id }}

                                    </td>

                                    {{-- Image --}}
                                    <td class="px-4 py-4">

                                        <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                                             class="w-20 h-20 rounded-lg object-cover border">

                                    </td>

                                    {{-- Operator --}}
                                    <td class="px-4 py-4">

                                        <div class="font-semibold text-gray-800">

                                            {{ $complaint->operator->name ?? '-' }}

                                        </div>

                                        <div class="text-sm text-gray-500">

                                            {{ $complaint->operator->mobile ?? '' }}

                                        </div>

                                    </td>

                                    {{-- Police Station --}}
                                    <td class="px-4 py-4">

                                        {{ $complaint->policeStation->name ?? '-' }}

                                    </td>

                                    {{-- Magistrate --}}
                                    <td class="px-4 py-4">

                                        @if($complaint->magistrate)

                                            <div class="font-semibold text-gray-800">

                                                {{ $complaint->magistrate->name }}

                                            </div>

                                        @else

                                            <span class="text-red-500 text-sm">
                                                Not Assigned
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-4">

                                        @php

                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'assigned' => 'bg-blue-100 text-blue-700',
                                                'resolved' => 'bg-purple-100 text-purple-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                'disposed' => 'bg-gray-100 text-gray-700',
                                            ];

                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">

                                            {{ ucfirst($complaint->status) }}

                                        </span>

                                    </td>

                                    {{-- Date --}}
                                    <td class="px-4 py-4 text-sm text-gray-600">

                                        {{ $complaint->created_at->format('d M Y h:i A') }}

                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-4 text-center">

                                        <a href="{{ route('ac.complaints.show', $complaint->id) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">

                                            View

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="px-4 py-8 text-center text-gray-500">

                                        No complaints found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden divide-y divide-gray-200">

                    @forelse($complaints as $complaint)

                        <div class="p-4">

                            <div class="flex gap-4">

                                {{-- Image --}}
                                <div class="flex-shrink-0">

                                    <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                                        class="w-24 h-24 rounded-xl object-cover border">

                                </div>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">

                                    {{-- Header --}}
                                    <div class="flex items-start justify-between gap-3">

                                        <h3 class="font-bold text-gray-800">

                                            Complaint #{{ $complaint->id }}

                                        </h3>

                                        @php

                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'assigned' => 'bg-blue-100 text-blue-700',
                                                'resolved' => 'bg-purple-100 text-purple-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                'disposed' => 'bg-gray-100 text-gray-700',
                                            ];

                                        @endphp

                                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                            {{ $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">

                                            {{ ucfirst($complaint->status) }}

                                        </span>

                                    </div>

                                    {{-- Operator --}}
                                    <div class="mt-3">

                                        <p class="text-sm text-gray-700">

                                            <span class="font-semibold">
                                                Operator:
                                            </span>

                                            {{ $complaint->operator->name ?? '-' }}

                                        </p>

                                        <p class="text-sm text-gray-500">

                                            {{ $complaint->operator->mobile ?? '' }}

                                        </p>

                                    </div>

                                    {{-- Police Station --}}
                                    <p class="mt-2 text-sm text-gray-700">

                                        <span class="font-semibold">
                                            Police Station:
                                        </span>

                                        {{ $complaint->policeStation->name ?? '-' }}

                                    </p>

                                    {{-- Magistrate --}}
                                    <p class="mt-2 text-sm text-gray-700">

                                        <span class="font-semibold">
                                            Magistrate:
                                        </span>

                                        @if($complaint->magistrate)

                                            {{ $complaint->magistrate->name }}

                                        @else

                                            <span class="text-red-500">
                                                Not Assigned
                                            </span>

                                        @endif

                                    </p>

                                    {{-- Date --}}
                                    <p class="mt-2 text-xs text-gray-500">

                                        {{ $complaint->created_at->format('d M Y h:i A') }}

                                    </p>

                                    {{-- Action --}}
                                    <div class="mt-4">

                                        <a href="{{ route('ac.complaints.show', $complaint->id) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">

                                            View Complaint

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="p-6 text-center text-gray-500">

                            No complaints found.

                        </div>

                    @endforelse

                </div>

                {{-- Pagination --}}
                <div class="p-4 overflow-x-auto">

                    {{ $complaints->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>