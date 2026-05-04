<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documents') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">

        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Document List</h2>

            <a href="{{ route('suretydocuments.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Upload Document
            </a>
        </div>
        <form method="GET" class="mb-4 flex flex-wrap gap-3 items-end">

        {{-- Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">All</option>
                <option value="uploaded" {{ request('status')=='uploaded'?'selected':'' }}>Uploaded</option>
                <option value="processing" {{ request('status')=='processing'?'selected':'' }}>Processing</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
            </select>
        </div>

        {{-- Entries --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Entries Min</label>
            <input type="number" name="entries_min" value="{{ request('entries_min') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Entries Max</label>
            <input type="number" name="entries_max" value="{{ request('entries_max') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        {{-- Amount --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Amount Min</label>
            <input type="number" name="amount_min" value="{{ request('amount_min') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Amount Max</label>
            <input type="number" name="amount_max" value="{{ request('amount_max') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
        </div>

        {{-- Buttons --}}
        <div class="flex gap-2">
            <button class="px-3 py-1 bg-blue-600 text-white rounded">
                Filter
            </button>

            <a href="{{ route('suretydocuments.index') }}"
            class="px-3 py-1 bg-gray-300 rounded">
            Reset
            </a>
        </div>

    </form>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Document ID</th>
                        <th class="px-4 py-2 text-left">File</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Progress</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Locked By</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $doc->id }}</td>
                            <td class="px-4 py-2">{{ $doc->original_name }}</td>

                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($doc->status == 'uploaded') bg-gray-200
                                    @elseif($doc->status == 'processing') bg-yellow-200
                                    @else bg-green-200 @endif">
                                    {{ ucfirst($doc->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                {{ $doc->entered_entries }} / {{ $doc->total_expected_entries ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $doc->total_amount_so_far ?? '-' }} / {{ $doc->total_amount ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                @if($doc->locked_by)

                                    @if($doc->locked_by === auth()->id())
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            You
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            {{ $doc->locker->name ?? 'User '.$doc->locked_by }}
                                        </span>
                                    @endif

                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                        Available
                                    </span>
                                @endif
                            </td>

                            <td class="flex items-center px-4 py-2">
                                <form method="POST" action="{{ route('suretydocuments.lock', $doc->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Open
                                    </button>
                                </form>

                                 {{-- Admin only edit --}}
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('suretydocuments.edit', $doc->id) }}"
                                        class="ml-2 px-3 py-1 bg-yellow-500 text-white rounded">
                                    Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                No documents found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>