<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Downloads') }}
        </h2>
    </x-slot>
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->role->role == 'admin')  
        <div x-data="{ openUpload: false }" class="mb-4">
            <button @click="openUpload = true" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Upload File</button>
            <div x-show="openUpload" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="openUpload = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Upload Document</h3>
                        <button @click="openUpload = false" class="text-gray-500 hover:text-gray-800">✕</button>
                    </div>

                    <form action="{{ route('downloads.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" maxlength="100" value="" placeholder="Short description" class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Choose File</label>
                            <input type="file" name="file" required class="w-full">
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <button type="button" @click="openUpload = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Upload</button>
                        </div>
                        <div class="text-sm text-gray-600">Max file size: 100 MB. Allowed: zip, rar, 7z, pdf, doc, docx, xls, xlsx, txt</div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">File</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Size</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Uploaded</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            @forelse($documents ?? [] as $doc)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $doc->original_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $doc->description }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-800">{{ number_format($doc->size / 1024, 2) }} KB</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-800">{{ $doc->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-800">
                        <a href="{{ route('downloads.download', $doc->id) }}" class="inline-block px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Download</a>
                        @if (auth()->user()->role->role== 'admin')
                            <form action="{{ route('downloads.destroy', $doc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">No files uploaded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
