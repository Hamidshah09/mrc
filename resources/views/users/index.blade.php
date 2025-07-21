<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
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
