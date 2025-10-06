<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IDP Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        
        <div class="w-full flex justify-end">
            {{-- <a href="{{ route('idp.create') }}"
               class="mb-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                New
            </a> --}}
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Application Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Request Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Application Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Payment Mode</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Token No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($records as $record)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Application Date'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['CNIC'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Request Type'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Application Type'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Payment Mode'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $record['Token No'] }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span id="status"
                                    class="inline-block px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $record['Status'] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">

                                    <a href="{{ route('idp.check')}}" class="text-blue-600 hover:text-blue-800">
                                        <x-icons.image />
                                    </a>
                                    {{-- Certificate Signed --}}
                                    <form action="{{route('idp.update', $record['Token No'])}}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800"
                                                title="Approve">
                                            <x-icons.check-circle />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card View (Mobile) -->
        <div class="md:hidden space-y-4">
            @foreach ($records as $record)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Application Date:</td>
                            <td class="p-3 text-gray-900">{{ $record['Application Date'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Name:</td>
                            <td class="p-3 text-gray-900">{{ $record['Name'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $record['CNIC'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Request Type:</td>
                            <td class="p-3 text-gray-900">{{ $record['Request Type'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Application Type:</td>
                            <td class="p-3 text-gray-900">{{ $record['Application Type'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Payment Mode:</td>
                            <td class="p-3 text-gray-900">{{ $record['Payment Mode'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Token No:</td>
                            <td class="p-3 text-gray-900">{{ $record['Token No'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span id="status-{{ $record['Token No']}}"
                                    class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                        ">
                                    {{ $record['Status'] }}
                                </span>
                            </td>
                        </tr>

                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="p-3">
                                <div class="flex items-center space-x-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('idp.check')}}" class="text-blue-600 hover:text-blue-800">
                                        <x-icons.image />
                                    </a>

                                    {{-- Certificate Signed --}}
                                    <form action="{{route('idp.update', $record['Token No'])}}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="text-green-600 hover:text-green-800"
                                                title="Approve">
                                            <x-icons.check-circle />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            @endforeach
        </div>
    </div>

    <script>
        async function updateStatus(id) {
            try {
                let response = await fetch(`/idp/update/${id}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                });

                 if (!response.ok) {
                    throw new Error("Failed to update status");
                }

                let result = await response.json();
                console.log("Response:", result);
            } catch (error) {
                console.log(error);
                alert("Error occurred while updating status.");
            }
        }
    </script>

</x-app-layout>
