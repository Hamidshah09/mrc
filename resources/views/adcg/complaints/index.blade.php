<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <h2 class="text-3xl font-bold text-gray-800">

                    All Complaints

                </h2>

            </div>

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

            {{-- Table --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">

                <div class="overflow-x-auto">

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
                                    Sub Division
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Police Station
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    AC
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Magistrate
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($complaints as $complaint)

                                <tr>

                                    {{-- ID --}}
                                    <td class="px-4 py-4">

                                        #{{ $complaint->id }}

                                    </td>

                                    {{-- Image --}}
                                    <td class="px-4 py-4">

                                        <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                                             class="w-20 h-20 rounded-lg object-cover border">

                                    </td>

                                    {{-- Sub Division --}}
                                    <td class="px-4 py-4">

                                        {{ $complaint->subDivision->name ?? '-' }}

                                    </td>

                                    {{-- Police Station --}}
                                    <td class="px-4 py-4">

                                        {{ $complaint->policeStation->name ?? '-' }}

                                    </td>

                                    {{-- AC --}}
                                    <td class="px-4 py-4">

                                        {{ $complaint->ac->name ?? '-' }}

                                    </td>

                                    {{-- Magistrate --}}
                                    <td class="px-4 py-4">

                                        {{ $complaint->magistrate->name ?? '-' }}

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

                                    {{-- Action --}}
                                    <td class="px-4 py-4">

                                        <a href="{{ route('adcg.complaints.show', $complaint->id) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">

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

                {{-- Pagination --}}
                <div class="p-4 overflow-x-auto">

                    {{ $complaints->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>