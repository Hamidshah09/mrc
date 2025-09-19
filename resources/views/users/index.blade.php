<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="w-full flex justify-end">

            <a href="{{route('users.create')}}" class="mb-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New</a>

        </div>
        <div class="w-full">
            <form action="" class="flex flex-col space-y-2 md:flex-row md:items-center md:space-x-2 md:space-y-0 mb-4 w-full">
                <input type="text" name="search" placeholder="Search" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3 lg:w-1/2" value="{{ request('search') }}">
                <select name="search_type" id="" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option selected>Select Search Type</option>>
                    <option value="cnic">CNIC</option>
                    <option value="name">Name</option>
                    <option value="license_number">License Number</option>
                    <option value="email">Email</option>
                </select>

                <label for="from">From</label>
                <input type="date" name="From" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3" value="{{ request('from') }}">
                <label for="from">to</label>
                <input type="date" name="To" class="border border-gray-300 rounded-md px-3 py-2 w-full md:w-1/3" value="{{ request('to') }}">
                <label for="status">Status</label>
                <select name="status" id="" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option selected>Select Status</option>>
                    <option value="active">Active</option>
                    <option value="not active">Not Active</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">Search</button>
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
        <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">CNIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Father Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">License No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">mobile</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->cnic }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->father_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->license_number ? $user->license_number : 'N/A'}}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->mobile }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $user->status === 'Active' ? 'bg-green-100 text-green-800' :
                                        ($user->status === 'Not Active' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    <a href="{{route('users.edit', $user->id)}}" >
                                        <x-icons.pencil-square class="text-blue-500 hover:text-blue-700" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card View (visible only on small screens) -->
        <div class="md:hidden space-y-4">
            @foreach ($users as $user)
                <table class="w-full border border-gray-200 rounded-lg shadow-sm bg-gray-50 text-sm">
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">CNIC:</td>
                            <td class="p-3 text-gray-900">{{ $user->cnic }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700 w-1/3">Name:</td>
                            <td class="p-3 text-gray-900">{{ $user->name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Father Name:</td>
                            <td class="p-3 text-gray-900">{{ $user->father_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">License No:</td>
                            <td class="p-3 text-gray-900">{{ $user->license_number }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Mobile:</td>
                            <td class="p-3 text-gray-900">{{ $user->mobile }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Role:</td>
                            <td class="p-3 text-gray-900">{{ $user->role }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-3 font-semibold text-gray-700">Status:</td>
                            <td class="p-3">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{
                                        $user->status === 'Active' ? 'bg-green-100 text-green-800' :
                                        ($user->status === 'Not Active' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800')
                                    }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-semibold text-gray-700">Actions:</td>
                            <td class="p-3">
                                <a href="{{route('users.edit', $user->id)}}" >
                                    <x-icons.pencil-square class="text-blue-500 hover:text-blue-700" />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>

    </div>
</x-app-layout>
