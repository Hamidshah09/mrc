<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight mb-4">Edit Office Letter</h2>

        <form method="POST" action="{{ route('domicile.office_letters.update', $letter->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="letter_date" value="{{ old('letter_date', $letter->letter_date) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">To</label>
                    <input type="text" name="letter_to" value="{{ old('letter_to', $letter->letter_to) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject', $letter->subject) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('domicile.office_letters.index') }}" class="px-4 py-2 mr-2 bg-gray-200 rounded">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
