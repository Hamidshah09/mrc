<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Divorce Registration Cases') }}
        </h2>
    </x-slot>

    <div class="w-[95%] mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap justify-end gap-2 mb-4">
            <a href="{{ route('drc.dashboard') }}" class="px-4 py-2 bg-indigo-700 rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-indigo-600">
                Dashboard
            </a>
            <a href="{{ route('drc.live.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-gray-700">
                New Live Case
            </a>
            <a href="{{ route('drc.old.create') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                Old Completed Case
            </a>
        </div>

        <form action="{{ route('drc.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-5">
            <input type="text" name="search" placeholder="Search" class="border border-gray-300 rounded-md px-3 py-2" value="{{ request('search') }}">
            <select name="search_type" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <option value="">Search By</option>
                <option value="case_no" @selected(request('search_type') === 'case_no')>Case No</option>
                <option value="groom_cnic" @selected(request('search_type') === 'groom_cnic')>Groom CNIC</option>
                <option value="groom_name" @selected(request('search_type') === 'groom_name')>Groom Name</option>
                <option value="bride_cnic" @selected(request('search_type') === 'bride_cnic')>Bride CNIC</option>
                <option value="bride_name" @selected(request('search_type') === 'bride_name')>Bride Name</option>
            </select>
            <select name="status" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <option value="">Status</option>
                <option value="under arbitration" @selected(request('status') === 'under arbitration')>Under Arbitration</option>
                <option value="certificate issued" @selected(request('status') === 'certificate issued')>Certificate Issued</option>
            </select>
            <select name="divorce_type" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <option value="">All Types</option>
                @foreach (['Talaq', 'Khula', 'Talaq Tafveez'] as $type)
                    <option value="{{ $type }}" @selected(request('divorce_type') === $type)>{{ $type }}</option>
                @endforeach
            </select>
            <select name="entry_type" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <option value="">All Entries</option>
                <option value="live" @selected(request('entry_type') === 'live')>Live</option>
                <option value="old" @selected(request('entry_type') === 'old')>Old</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Search
            </button>
        </form>

        <div class="overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Case No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Groom</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Bride</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Decision</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Issue</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($divorceCases as $case)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $case->case_no }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ $case->divorce_type }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">
                                <div>{{ $case->groom_name }}</div>
                                <div class="text-xs text-gray-500">{{ $case->groom_cnic }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800">
                                <div>{{ $case->bride_name }}</div>
                                <div class="text-xs text-gray-500">{{ $case->bride_cnic }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ optional($case->decision_date)->format('d-m-Y') ?? 'Pending' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800">{{ optional($case->issue_date)->format('d-m-Y') ?? 'Pending' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                    {{ $case->status === 'Certificate Issued' ? 'bg-green-100 text-green-800' : ($case->status === 'Ready for Certificate' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $case->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('drc.show', $case) }}" class="text-blue-600 hover:text-blue-800" title="View Details">
                                        <x-heroicon-m-eye class="w-6 h-6" />
                                    </a>
                                    <a href="{{ route('drc.edit', $case) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit Case">
                                        <x-heroicon-m-pencil-square class="w-6 h-6" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">No divorce cases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $divorceCases->links() }}
        </div>
    </div>
</x-app-layout>
