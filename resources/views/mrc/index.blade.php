<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Marriage Records</h2>
        <x-icons.add class="float-right text-green-500 hover:text-green-700" />
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Groom CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Groom Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Bride CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Bride Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Registrar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Verifier</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($mrcRecords as $mrc)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->groom_cnic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->groom_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->bride_cnic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->bride_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->registrar->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->verifier ? $mrc->verifier->name : 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $mrc->status === 'Verified' ? 'bg-green-100 text-green-800' :
                                        ($mrc->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($mrc->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    @if ($user->id=== $mrc->registrar_id)
                                        <a href="{{ route('mrc.edit', $mrc->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-icons.pencil-square />
                                        </a>
                                    @endif
                                    @if ($user->role === 'admin' && $mrc->status === 'pending')
                                        <a href="#" onclick="openVerifyModal({{ $mrc->id }})">
                                            <x-icons.check-circle class="text-green-500 hover:text-green-700" />
                                        </a>
                                    @endif
                                    <a href="#">
                                        <x-icons.document-text class="text-yellow-500 hover:text-yellow-700" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $mrcRecords->links() }}
            </div>
        </div>

        <!-- Card View (visible only on small screens) -->
        <div class="md:hidden space-y-4">
            @foreach ($mrcRecords as $mrc)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Groom CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->grrom_cnic }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Groom:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->grrom_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Bride CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->bride_cnic }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Bride:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->bride_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Registrar:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->registrar->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Verifier:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->verifier ? $mrc->verifier->name : 'N/A' }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $mrc->status === 'approved' ? 'bg-green-100 text-green-800' :
                                        ($mrc->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($mrc->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="p-3">
                                <a href="#" class="text-blue-600 hover:text-blue-800">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>

    </div>
    <!-- Reusable Verification Modal -->
    <div id="verifyModal" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Verify Record</h2>
            <form id="verifyForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" id="remarks" class="mt-1 block w-full border border-gray-300 rounded-md" rows="3" required></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeVerifyModal()" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">Verify</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openVerifyModal(mrcId) {
            const modal = document.getElementById('verifyModal');
            const form = document.getElementById('verifyForm');

            // Construct dynamic route URL
            form.action = `/mrc/verify/${mrcId}`;

            // Show the modal
            modal.classList.remove('hidden');
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
            document.getElementById('verifyForm').reset();
        }
    </script>


    </x-app-layout>
