<x-app-layout>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">

            <h2 class="text-3xl font-bold text-gray-800">

                Users Management

            </h2>

            <a href="{{ route('admin.users.create') }}"
               class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

                Create User

            </a>

        </div>

        {{-- Success Message --}}
        @if (session('success'))

            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md border border-green-300">

                {{ session('success') }}

            </div>

        @endif

        {{-- Errors --}}
        @if ($errors->any())

            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Image

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Name

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Email

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Mobile

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Role

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Sub Division

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Police Station

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Status

                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody class="bg-white divide-y divide-gray-100">

                    @forelse ($users as $user)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Profile Image --}}
                            <td class="px-6 py-4">

                                @if($user->profile_image)

                                    <img src="{{ asset('storage/profile-images/'.$user->profile_image) }}"
                                         class="w-14 h-14 rounded-full object-cover border">

                                @else

                                    <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">

                                        N/A

                                    </div>

                                @endif

                            </td>

                            {{-- Name --}}
                            <td class="px-6 py-4 text-sm text-gray-800 font-semibold">

                                {{ $user->name }}

                            </td>

                            {{-- Email --}}
                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $user->email }}

                            </td>

                            {{-- Mobile --}}
                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $user->mobile }}

                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $user->role->role ?? '-' }}

                            </td>

                            {{-- Sub Division --}}
                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $user->subDivision->name ?? '-' }}

                            </td>

                            {{-- Police Station --}}
                            <td class="px-6 py-4 text-sm text-gray-700">

                                {{ $user->policeStation->name ?? '-' }}

                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-sm">

                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                    {{
                                        $user->status === 'Active'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-yellow-100 text-yellow-800'
                                    }}">

                                    {{ $user->status }}

                                </span>

                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-sm">

                                <div class="flex items-center gap-3">

                                    <a href="{{ route('users.edit', $user->id) }}">

                                        <x-heroicon-s-pencil
                                            class="w-6 h-6 text-indigo-500 hover:text-indigo-700" />

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="px-6 py-8 text-center text-gray-500">

                                No users found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-4">

            @forelse ($users as $user)

                <div class="border rounded-xl shadow bg-white p-4">

                    <div class="flex items-center gap-4 mb-4">

                        @if($user->profile_image)

                            <img src="{{ asset('storage/profile-images/'.$user->profile_image) }}"
                                 class="w-16 h-16 rounded-full object-cover border">

                        @else

                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">

                                N/A

                            </div>

                        @endif

                        <div>

                            <h3 class="font-bold text-lg text-gray-800">

                                {{ $user->name }}

                            </h3>

                            <p class="text-sm text-gray-500">

                                {{ $user->role->role ?? '-' }}

                            </p>

                        </div>

                    </div>

                    <div class="space-y-2 text-sm">

                        <p>

                            <span class="font-semibold">
                                Email:
                            </span>

                            {{ $user->email }}

                        </p>

                        <p>

                            <span class="font-semibold">
                                Mobile:
                            </span>

                            {{ $user->mobile }}

                        </p>

                        <p>

                            <span class="font-semibold">
                                Sub Division:
                            </span>

                            {{ $user->subDivision->name ?? '-' }}

                        </p>

                        <p>

                            <span class="font-semibold">
                                Police Station:
                            </span>

                            {{ $user->policeStation->name ?? '-' }}

                        </p>

                        <p>

                            <span class="font-semibold">
                                Status:
                            </span>

                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                                {{
                                    $user->status === 'Active'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800'
                                }}">

                                {{ $user->status }}

                            </span>

                        </p>

                    </div>

                    <div class="mt-4">

                        <a href="{{ route('users.edit', $user->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">

                            Edit User

                        </a>

                    </div>

                </div>

            @empty

                <div class="text-center text-gray-500 py-10">

                    No users found.

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-6">

            {{ $users->links() }}

        </div>

    </div>

</x-app-layout>