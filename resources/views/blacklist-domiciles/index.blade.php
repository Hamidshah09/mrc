<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Black List CNICs for Domicile Applications') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('domicile.blacklist.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Letter</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-700">{{ session('error') }}</div>
        @endif
        <div class="flex justify-between items-center space-x-4 m-2 mb-4">
            <form action="{{route('domicile.blacklist.index')}}" method="GET" class="mt-3">
                <div class="flex flex-row flex-wrap items-center">
                    <x-text-input id="search" class="mt-1 w-48 p-2 mx-2" type="text" name="search" value="{{ old('search') }}" autofocus autocomplete="cnic" />
                    <select name="search_type" id="search_type" class= "w-48 mt-1 border-gray-600 focus:ring-indigo-500  rounded-md shadow-sm" autofocus autocomplete="gender">
                        <option value="cnic" {{ old('search_type') == 'cnic' ? 'selected' : '' }}>CNIC </option> 
                        <option value="reason" {{ old('search_type') == 'reason' ? 'selected' : '' }}>Reason</option> 
                        <option value="id" {{ old('search_type') == 'id' ? 'selected' : '' }}>id</option>
                        
                    </select>
                    <select name="status" id="status" class= "w-48 mt-1 border-gray-600 focus:ring-indigo-500  rounded-md shadow-sm mx-2" autofocus autocomplete="gender">
                        <option value="Blocked" {{ old('status') == 'Blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="Unblocked" {{ old('status') == 'Unblocked' ? 'selected' : '' }}>Unblocked</option>
                    </select>
                    <label for="from_date" class="mt-1 p-2">From</label>
                    <x-text-input id="from_date" class="mt-1 w-48 p-2 mx-2" type="date" name="from_date" value="{{ old('from_date') }}" autofocus autocomplete="from_date" />
                    <label for="to_date" class="mt-1 p-2">To</label>
                    <x-text-input id="to_date" class="mt-1 w-48 p-2 mx-2" type="date" name="to_date" value="{{ old('to_date') }}" autofocus autocomplete="to_date" />
                    <x-primary-button class="mt-1 ms-3" type="submit">
                        {{ __('Search') }}
                    </x-primary-button>
                    
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated by</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blacklists as $letter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->black_list_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->cnic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('domicile.cancellation.edit', $letter->black_list_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No letters found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $blacklists->links() }}
        </div>
    </div>
</x-app-layout>
