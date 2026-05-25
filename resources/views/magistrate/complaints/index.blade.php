<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">

                Assigned Complaints

            </h2>

            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

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

                                <tr>

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

                                        {{ ucfirst($complaint->status) }}

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

                <div class="p-4">

                    {{ $complaints->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>