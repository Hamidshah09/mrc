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

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">File</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Progress</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr class="border-t">
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
                                <form method="POST" action="{{ route('suretydocuments.lock', $doc->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Open
                                    </button>
                                </form>
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