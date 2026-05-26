<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">

                Assigned Complaints

            </h2>

            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

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
                                    Police Station
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($complaints as $complaint)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-4">

                                        #{{ $complaint->id }}

                                    </td>

                                    <td class="px-4 py-4">

                                        <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                                             class="w-20 h-20 rounded-lg object-cover border">

                                    </td>

                                    <td class="px-4 py-4">

                                        {{ $complaint->policeStation->name ?? '-' }}

                                    </td>

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

                                    <td class="px-4 py-4">

                                        <a href="{{ route('magistrate.complaints.show', $complaint->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                            View

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
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

                                {{-- Complaint Image --}}
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

                                    {{-- Police Station --}}
                                    <p class="mt-3 text-sm text-gray-700">

                                        <span class="font-semibold">
                                            Police Station:
                                        </span>

                                        {{ $complaint->policeStation->name ?? '-' }}

                                    </p>

                                    {{-- Date --}}
                                    <p class="mt-2 text-xs text-gray-500">

                                        {{ $complaint->created_at->format('d M Y h:i A') }}

                                    </p>

                                    {{-- Action --}}
                                    <div class="mt-4">

                                        <a href="{{ route('magistrate.complaints.show', $complaint->id) }}"
                                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

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
                <div class="p-4 overflow-x-auto">

                    {{ $complaints->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>