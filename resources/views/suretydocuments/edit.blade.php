<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Document</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">

        <form method="POST" action="{{ route('suretydocuments.update', $doc->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Replace File</label>
                <input type="file" name="file" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label>Total Expected Entries</label>
                <input type="number" name="total_expected_entries"
                       value="{{ $doc->total_expected_entries }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label>Total Amount</label>
                <input type="number" step="0.01" name="total_amount"
                       value="{{ $doc->total_amount }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label>Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="uploaded" {{ $doc->status=='uploaded'? 'selected' : '' }}>Uploaded</option>
                    <option value="processing" {{ $doc->status=='processing'? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $doc->status=='completed'? 'selected' : '' }}>Completed</option>
                    <option value="audit failed" {{ $doc->status=='audit failed'? 'selected' : '' }}>Audit Failed</option>
                    <option value="audit ok" {{ $doc->status=='audit ok'? 'selected' : '' }}>Audit Ok</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>

        </form>
    </div>
</x-app-layout>