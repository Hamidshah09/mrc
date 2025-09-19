<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MRC Status Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        
        <div class="w-full flex justify-end">
            <a href="{{ route('mrc_status.create') }}"
               class="mb-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                New
            </a>
        </div>

        <!-- Filters -->
        <div class="w-full">
            <form action="" class="flex flex-col space-y-2 md:flex-row md:items-center md:space-x-2 md:space-y-0 mb-4 w-full">
                <input type="text" name="search" placeholder="Search by Tracking ID or Applicant Name"
                       class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3 lg:w-1/2"
                       value="{{ request('search') }}">

                <select name="certificate_type"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">All Certificate Types</option>
                    <option value="Marriage" {{ request('certificate_type')=='Marriage'?'selected':'' }}>Marriage</option>
                    <option value="Divorce" {{ request('certificate_type')=='Divorce'?'selected':'' }}>Divorce</option>
                </select>

                <label for="from">From</label>
                <input type="date" name="from"
                       class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3"
                       value="{{ request('from') }}">

                <label for="to">To</label>
                <input type="date" name="to"
                       class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3"
                       value="{{ request('to') }}">

                <label for="status">Status</label>
                <select name="status"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">All</option>
                    <option value="Certificate Signed" {{ request('status')=='Certificate Signed'?'selected':'' }}>Certificate Signed</option>
                    <option value="Sent for Verification" {{ request('status')=='Sent for Verification'?'selected':'' }}>Sent for Verification</option>
                    <option value="Objection" {{ request('status')=='Objection'?'selected':'' }}>Objection</option>
                </select>

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

        <!-- Table View (Desktop) -->
        <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tracking ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Applicant</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Certificate Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Processing Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($mrcStatuses as $status)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $status->tracking_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $status->applicant_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $status->applicant_cnic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $status->certificate_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $status->processing_date }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span id="status-{{ $status->id }}"
                                    class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                        {{
                                            $status->status === 'Certificate Signed' ? 'bg-green-100 text-green-800' :
                                            ($status->status === 'Sent for Verification' ? 'bg-blue-100 text-blue-800' :
                                            'bg-red-100 text-red-800')
                                        }}">
                                    {{ $status->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('mrc_status.edit', $status->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <x-icons.pencil-square />
                                    </a>

                                    {{-- Certificate Signed --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Certificate Signed')"
                                            class="text-green-600 hover:text-green-800"
                                            title="Mark as Certificate Signed">
                                        <x-icons.check-circle />
                                    </button>

                                    {{-- Sent for Verification --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Sent for Verification')"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Send for Verification">
                                        <x-icons.paper-plane />
                                    </button>

                                    {{-- Objection --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Objection')"
                                            class="text-red-600 hover:text-red-800"
                                            title="Mark as Objection">
                                        <x-icons.exclamation-triangle />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $mrcStatuses->links() }}
            </div>
        </div>

        <!-- Card View (Mobile) -->
        <div class="md:hidden space-y-4">
            @foreach ($mrcStatuses as $status)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Tracking ID:</td>
                            <td class="p-3 text-gray-900">{{ $status->tracking_id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Applicant:</td>
                            <td class="p-3 text-gray-900">{{ $status->applicant_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $status->applicant_cnic }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Type:</td>
                            <td class="p-3 text-gray-900">{{ $status->certificate_type }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Date:</td>
                            <td class="p-3 text-gray-900">{{ $status->processing_date }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span id="status-{{ $status->id }}"
                                    class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                        {{
                                            $status->status === 'Certificate Signed' ? 'bg-green-100 text-green-800' :
                                            ($status->status === 'Sent for Verification' ? 'bg-blue-100 text-blue-800' :
                                            'bg-red-100 text-red-800')
                                        }}">
                                    {{ $status->status }}
                                </span>
                            </td>
                        </tr>

                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="p-3">
                                <div class="flex items-center space-x-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('mrc_status.edit', $status->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <x-icons.pencil-square />
                                    </a>

                                    {{-- Certificate Signed --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Certificate Signed')"
                                            class="text-green-600 hover:text-green-800"
                                            title="Mark as Certificate Signed">
                                        <x-icons.check-circle />
                                    </button>

                                    {{-- Sent for Verification --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Sent for Verification')"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Send for Verification">
                                        <x-icons.paper-plane />
                                    </button>

                                    {{-- Objection --}}
                                    <button type="button"
                                            onclick="updateStatus({{ $status->id }}, 'Objection')"
                                            class="text-red-600 hover:text-red-800"
                                            title="Raise Objection">
                                        <x-icons.exclamation-triangle />
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            @endforeach
        </div>
    </div>

    <script>
        async function updateStatus(id, status) {
            try {
                let response = await fetch(`/mrc_status/update_status/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({ status: status }),
                });

                if (response.ok) {
                    let result = await response.json();

                    // Update badge text
                    const statusEl = document.getElementById(`status-${id}`);
                    statusEl.innerText = result.status;

                    // Reset classes
                    statusEl.className = "inline-block px-2 py-1 rounded-full text-xs font-medium";

                    // Apply new color
                    if (result.status === "Certificate Signed") {
                        statusEl.classList.add("bg-green-100", "text-green-800");
                    } else if (result.status === "Sent for Verification") {
                        statusEl.classList.add("bg-blue-100", "text-blue-800");
                    } else {
                        statusEl.classList.add("bg-red-100", "text-red-800");
                    }

                } else {
                    alert("Failed to update status");
                }
            } catch (error) {
                console.error(error);
                alert("Error occurred while updating status.");
            }
        }
    </script>

</x-app-layout>
