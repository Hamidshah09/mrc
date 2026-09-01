<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marriage Records') }}
        </h2>
    </x-slot>
    
    <div class="w-[95%] mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
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
        @if (session('success'))
            <div class="text-green-700 bg-green-100 p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="w-full flex justify-end flex-wrap">

            {{-- Dashboard --}}
            <a
                href="{{ route('mrc.dashboard') }}"
                class="mb-2 mx-2 px-4 py-2 bg-gray-800
                    border border-transparent rounded-md
                    font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-gray-700
                    focus:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:ring-2
                    focus:ring-indigo-500 focus:ring-offset-2
                    transition ease-in-out duration-150"
            >
                Dashboard
            </a>

            {{-- Bulk Upload --}}
            <a
                href="{{ route('mrc.bulk-upload.create') }}"
                class="mb-2 mx-2 px-4 py-2 bg-blue-600
                    border border-transparent rounded-md
                    font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-blue-700
                    focus:outline-none focus:ring-2
                    focus:ring-blue-500 focus:ring-offset-2
                    transition ease-in-out duration-150"
            >
                Bulk Upload
            </a>

            {{-- Existing New Record --}}
            <a
                href="{{ route('mrc.create') }}"
                class="mb-2 mx-2 px-4 py-2 bg-gray-800
                    border border-transparent rounded-md
                    font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-gray-700
                    focus:bg-gray-700 active:bg-gray-900
                    focus:outline-none focus:ring-2
                    focus:ring-indigo-500 focus:ring-offset-2
                    transition ease-in-out duration-150"
            >
                New
            </a>

        </div>
        <div class="w-full mb-3">
            @php
                $filterControl =
                    'w-full text-sm bg-white border border-gray-300 rounded-lg
                     px-3 py-2 text-gray-900 shadow-sm transition duration-150
                     focus:outline-none focus:ring-2 focus:ring-blue-500/30
                     focus:border-blue-500 placeholder:text-gray-400';
            @endphp

            <form
                action="{{ route('mrc.index') }}"
                method="GET"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-8
                    bg-gray-50 border border-gray-200 rounded-xl
                    p-4 md:p-5 shadow-sm"
            >
                
                <div class="sm:col-span-2">
                    <label for="search" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Search</label>
                    <input type="text" name="search" id="search" placeholder="Groom CNIC or Name" class="{{ $filterControl }}" value="{{ request('search') }}">
                </div>
                <div>
                    <label for="search_type" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Search Type</label>
                    <select name="search_type" id="search_type" class="{{ $filterControl }}">
                        <option value="" {{ empty(request('search_type')) ? 'selected' : '' }}>Search by</option>
                        <option value="groom_cnic" {{ request('search_type') === 'groom_cnic' ? 'selected' : '' }}>Groom CNIC</option>
                        <option value="id" {{ request('search_type') === 'id' ? 'selected' : '' }}>Id</option>
                        <option value="groom_name" {{ request('search_type') === 'groom_name' ? 'selected' : '' }}>Groom Name</option>
                        <option value="bride_cnic" {{ request('search_type') === 'bride_cnic' ? 'selected' : '' }}>Bride CNIC</option>
                        <option value="bride_name" {{ request('search_type') === 'bride_name' ? 'selected' : '' }}>Bride Name</option>
                        <option value="registrar_name" {{ request('search_type') === 'registrar_name' ? 'selected' : '' }}>Registrar Name</option>
                        <option value="register_no" {{ request('search_type') === 'register_no' ? 'selected' : '' }}>Register No</option>
                    </select>
                </div>

                <div>
                    <label for="union_council_id" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Union Council</label>
                    <select name="union_council_id" id="union_council_id" class="{{ $filterControl }}">
                        <option value="">All Union Councils</option>
                        @foreach($unionCouncils as $uc)
                            <option value="{{ $uc->id }}" {{ (string)request('union_council_id') === (string)$uc->id ? 'selected' : '' }}>{{ $uc->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="from" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">From</label>
                    <input type="date" name="from" id="from" class="{{ $filterControl }}" value="{{ request('from') }}">
                </div>
                <div>
                    <label for="to" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">To</label>
                    <input type="date" name="to" id="to" class="{{ $filterControl }}" value="{{ request('to') }}">
                </div>
                
                    
                <div>
                    <label for="status" class="block mb-1.5 text-xs font-semibold uppercase tracking-wide text-gray-500">Status</label>
                    <select name="status" id="status" class="{{ $filterControl }}">
                        <option
                            value="Pending"
                            {{ request('status') === 'Pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="Completed"
                            {{ request('status', 'Completed') === 'Completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                        <option
                            value="Verified"
                            {{ request('status') === 'Verified' ? 'selected' : '' }}
                        >
                            Verified
                        </option>

                        <option
                            value="all"
                            {{ request('status') === 'all' ? 'selected' : '' }}
                        >
                            All
                        </option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm
                            font-semibold rounded-lg shadow-sm
                            hover:bg-blue-700 focus:outline-none
                            focus:ring-2 focus:ring-blue-500
                            focus:ring-offset-2 transition duration-150"
                    >
                        Search
                    </button>

                    <a
                        href="{{ route('mrc.index') }}"
                        title="Clear all filters"
                        class="px-3 py-2 bg-white text-gray-600 text-sm
                            font-semibold border border-gray-300 rounded-lg
                            hover:bg-gray-100 transition duration-150"
                    >
                        Reset
                    </a>
                </div>
            </form>


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
        <div class="hidden md:block w-full overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 whitespace-nowrap">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Id</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Groom</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Bride</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Registration Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Registrar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Union Council</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($mrcRecords as $mrc)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->id }}</td>

                            {{-- Groom: CNIC on top, name below --}}
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">{{ $mrc->groom_name }}</span>
                                    <span class="text-gray-500 text-xs mt-0.5">{{ $mrc->groom_cnic }}</span>
                                </div>
                            </td>

                            {{-- Bride: CNIC on top, name below --}}
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">{{ $mrc->bride_name }}</span>
                                    <span class="text-gray-500 text-xs mt-0.5">{{ $mrc->bride_cnic }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->registration_date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->user->name ?? '' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->registrar_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $mrc->unionCouncil ? $mrc->unionCouncil->name : '' }}</td>
                            <td class="px-6 py-4 text-sm">

                                @if($mrc->status === 'Pending')

                                    @if($mrc->locked_by)
                                        <span class="inline-flex items-center px-2.5 py-1
                                                    rounded-full text-xs font-semibold
                                                    bg-yellow-100 text-yellow-800">
                                            Locked
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1
                                                    rounded-full text-xs font-semibold
                                                    bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif

                                @elseif($mrc->status === 'Completed')

                                    <span class="inline-flex items-center px-2.5 py-1
                                                rounded-full text-xs font-semibold
                                                bg-green-100 text-green-800">
                                        Completed
                                    </span>

                                @elseif($mrc->status === 'Verified')

                                    <span class="inline-flex items-center px-2.5 py-1
                                                rounded-full text-xs font-semibold
                                                bg-blue-100 text-blue-800">
                                        Verified
                                    </span>

                                @endif

                            </td>
                            <td class="px-6 py-4 text-sm">

                                <div class="flex items-center space-x-3">

                                    {{-- Existing Edit --}}
                                    <a
                                        href="{{ route('mrc.edit', $mrc->id) }}"
                                        title="Edit Record"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        <x-heroicon-c-pencil-square
                                            class="w-7 h-7 text-indigo-400
                                                hover:text-indigo-600 transition"
                                        />
                                    </a>


                                    {{-- Edit With Crops --}}
                                    <a
                                        href="{{ route('mrc.edit-with-crops', $mrc->id) }}"
                                        title="Edit With Document"
                                        class="text-green-600 hover:text-green-800"
                                    >
                                        <x-heroicon-m-document-text
                                            class="w-7 h-7 text-green-500
                                                hover:text-green-700 transition"
                                        />
                                    </a>


                                    {{-- Original Document --}}
                                    @if($mrc->image)

                                        <a
                                            href="{{ asset('storage/' . $mrc->image) }}"
                                            target="_blank"
                                            title="View Original Document"
                                            class="text-yellow-600 hover:text-yellow-800"
                                        >
                                            <x-heroicon-m-photo
                                                class="w-7 h-7 text-yellow-500
                                                    hover:text-yellow-700 transition"
                                            />
                                        </a>

                                    @endif

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
                            <td class="p-3 text-gray-900">{{ $mrc->groom_cnic }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Groom:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->groom_name }}</td>
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
                            <td class="p-3 text-gray-900">{{ $mrc->registrar_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Register No:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->register_no }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">User:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->user->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Union Council:</td>
                            <td class="p-3 text-gray-900">{{ $mrc->unionCouncil ? $mrc->unionCouncil->name : '' }}</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    @if ($user->id=== $mrc->registrar_id)
                                        <a href="{{ route('mrc.edit', $mrc->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <x-heroicon-m-arrow-top-right-on-square title="Update status" class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/>
                                        </a>
                                    @endif
                                    {{-- @if ($user->role->role === 'admin' && $mrc->status === 'Pending' or $user->role->role === 'verifier' && $mrc->status === 'Pending')
                                        <a href="#" onclick="openVerifyModal({{ $mrc->id }})">
                                            <x-heroicon-m-check-circle title="Verify Record" class="w-7 h-7 text-green-500 hover:text-green-700" />
                                        </a>
                                    @endif --}}
                                   
                                    @if($mrc->image)
                                        <a href="{{ asset('storage/' . $mrc->image) }}">
                                            <x-heroicon-m-document-text class="text-yellow-500 hover:text-yellow-700" />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            @endforeach
            <div>
                {{ $mrcRecords->links() }}
            </div>
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
