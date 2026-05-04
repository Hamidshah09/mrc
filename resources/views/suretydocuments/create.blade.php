<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">Upload New Document</h2>

        <form action="{{ route('suretydocuments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Select File (PDF/Image)</label>
                <input type="file" name="document"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">

                @error('document')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Expected Entries</label>
                <input type="number" name="total_expected_entries"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Expected Amount</label>
                <input type="number" name="total_amount"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('suretydocuments.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</x-app-layout>