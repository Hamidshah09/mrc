<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arms Records') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="flex flex-col md:flex-row md:items-center gap-6 mb-5 px-6">

            <!-- 🔍 Search Block -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-md p-4 w-full md:w-auto">
                <form action="" class="flex flex-col md:flex-row md:items-center gap-4">
                    <input type="text" name="keyword" placeholder="Search..." value="{{ request('keyword') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto" />

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 w-full md:w-auto">
                        Search
                    </button>
                </form>
            </div>

            <!-- 📅 Report Block -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-md p-4 w-full md:w-auto">
                <form action="{{ route('arms.pdf') }}" class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex flex-col md:flex-row md:items-center gap-2">
                        <label for="report_date1" class="text-sm font-medium text-gray-700">From</label>
                        <select name="report_date1" id="report_date1"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-8 w-full md:w-auto">
                            @foreach ($dates as $date)
                                <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center gap-2">
                        <label for="report_date2" class="text-sm font-medium text-gray-700">To</label>
                        <select name="report_date2" id="report_date2"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-8 w-full md:w-auto">
                            @foreach ($dates as $date)
                                <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 w-full md:w-auto">
                        Report
                    </button>
                </form>
            </div>

            <!-- ✅ Action Buttons Block -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-md p-4 flex items-center gap-x-2 w-full md:w-auto">
                <a href="{{ route('arms.approveall') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 w-full md:w-auto text-center">
                    Approve All
                </a>
                <a href="{{ route('arms.trashall') }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 w-full md:w-auto text-center">
                    Trash All
                </a>
            </div>

        </div>


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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Recod ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">License No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Weapon No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Request Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($armsRecords as $arms)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['id'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['cnic'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['name'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['license_no'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['weapon_no'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['request_type'] }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $arms['file_status'] === 'Approved' ? 'bg-green-100 text-green-800' :
                                        ($arms['file_status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($arms['file_status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms['created_at'] }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    @if (auth()->user()->role === 'admin' && $arms['file_status'] === 'Pending')
                                        <a href="{{route('arms.approve', $arms['id'])}}" >
                                            <x-icons.check-circle class="text-green-500 hover:text-green-700" />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{-- {{ $armsRecords->links() }} --}}
            </div>
        </div>

        <!-- Card View (visible only on small screens) -->
        <div class="md:hidden space-y-4">
            @foreach ($armsRecords as $arms)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Id:</td>
                            <td class="p-3 text-gray-900">{{ $arms['id'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $arms['cnic'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Name:</td>
                            <td class="p-3 text-gray-900">{{ $arms['name'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">License No:</td>
                            <td class="p-3 text-gray-900">{{ $arms['license_no'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Weapon No:</td>
                            <td class="p-3 text-gray-900">{{ $arms['weapon_no'] }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $arms['file_status'] === 'Approved' ? 'bg-green-100 text-green-800' :
                                        ($arms['file_status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($arms['file_status']) }}
                                </span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Created At</td>
                            <td class="p-3 text-gray-900">{{ $arms['created_at'] }}</td>
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
            <div>
                {{-- {{ $armsRecords->links() }} --}}
            </div>
        </div>

    </div>
    </x-app-layout>
