<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arms Records') }}
        </h2>
    </x-slot>
    <div class="max-w-full mx-auto px-8 p-6 bg-white shadow-lg rounded-lg mt-10">

        
            <form method="GET" action="{{ route('arms.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6 bg-white p-4 rounded-lg shadow">

                <!-- CNIC -->
                <div>
                    <label class="block text-sm font-medium mb-1">Keyword</label>
                    <input type="text" name="keyword" placeholder="Search by Name, License No, weapon no"
                        class="border border-gray-300 w-full p-2 rounded"
                        value="{{ request('keyword') }}">
                </div>

                <!-- Issue Date -->
                <div>
                    <label class="block text-sm font-medium mb-1">Issue Date</label>
                    <input type="date" name="issue_date"
                        class="border border-gray-300 w-full p-2 rounded"
                        value="{{ request('issue_date') }}">
                </div>

                <!-- Approver -->
                <div>
                    <label class="block text-sm font-medium mb-1">Approver</label>
                    <select name="approver_id" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('approver_id') === "1" ? 'selected' : '' }}>DC</option>
                        <option value="2" {{ request('approver_id') === "2" ? 'selected' : '' }}>ADCG</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status_id" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('status_id') === "1" ? 'selected' : '' }}>Approved</option>
                        <option value="0" {{ request('status_id') === "0" ? 'selected' : '' }}>Not Approved</option>
                    </select>
                </div>

                <!-- Character Certificate -->
                <div>
                    <label class="block text-sm font-medium mb-1">Character Certificate</label>
                    <select name="character_certificate" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('character_certificate') === "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('character_certificate') === "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Address on CNIC -->
                <div>
                    <label class="block text-sm font-medium mb-1">is Islamabad address written on cnic?</label>
                    <select name="address_on_cnic" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('address_on_cnic') === "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('address_on_cnic') === "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Affidavit -->
                <div>
                    <label class="block text-sm font-medium mb-1">Affidavit</label>
                    <select name="affidavit" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('affidavit') === "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('affidavit') === "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Called -->
                <div>
                    <label class="block text-sm font-medium mb-1">Called</label>
                    <select name="called" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('called') === "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('called') === "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Letter Issued -->
                <div>
                    <label class="block text-sm font-medium mb-1">Letter Issued</label>
                    <select name="letter_issued" class="border border-gray-300 w-full p-2 rounded">
                        <option value="">Select</option>
                        <option value="1" {{ request('letter_issued') === "1" ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ request('letter_issued') === "0" ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 flex gap-4 mt-2">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                        Apply Filters
                    </button>

                    <a href="{{ route('arms.index') }}"
                    class="bg-gray-300 text-black px-4 py-2 rounded w-full sm:w-auto text-center">
                        Reset
                    </a>
                </div>

            </form>


        

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md border border-green-300">
                {{ session('success') }}
            </div>
        @endif
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Mobile</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Weapon Type</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Approved By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Updated By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($armsRecords as $arms)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->cnic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->license_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->mobile }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $arms->weapon_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                @if (is_null($arms->status_id))
                                    -
                                @else
                                    {{ $arms->status_id == 1 ? 'Approved' : 'Not Approved' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($arms->user)
                                    <span class="inline-block px-2 py-2 rounded-full text-xs font-medium bg-green-300">
                                        {{
                                            $arms->user->name 
                                            }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ \Carbon\Carbon::parse($arms->issue_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2"> 
                                    <a href="{{ route('arms.edit', $arms->id) }}" >
                                        <x-icons.pencil-square class="text-green-500 hover:text-green-700" />
                                    </a>
                                    <a target="_blank" href="https://admin-icta.nitb.gov.pk/arm/applicant/{{$arms->applicant_id}}/application/show/{{$arms->id}}" >
                                        <x-icons.document-text class="text-yellow-500 hover:text-yellow-700" />
                                    </a>
                                    <a href="{{ route('arms.letter', $arms->id) }}" >
                                        <x-icons.check-circle class="text-blue-500 hover:text-blue-700" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $armsRecords->appends(request()->except('page'))->links() }}

            </div>
        </div>

        <!-- Card View (visible only on small screens) -->
        {{-- <div class="md:hidden space-y-4">
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
            <div> --}}
                {{-- {{ $armsRecords->links() }} --}}
            {{-- </div>
        </div> --}}

    </div>
    </x-app-layout>
