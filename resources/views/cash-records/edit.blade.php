<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight mb-4">Edit Cash Record</h2>

        <form method="POST" action="{{ route('cash-records.update', $record->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" value="{{ old('date', $record->date) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $record->name) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">CNIC</label>
                    <input type="text" name="cnic" value="{{ old('cnic', $record->cnic) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile</label>
                    <input type="text" name="mobile" value="{{ old('mobile', $record->mobile) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Service Type</label>
                    <select name="service_type" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select</option>
                        <option value="online" {{ old('service_type', $record->service_type)=='online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('service_type', $record->service_type)=='offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Request Type</label>
                    <input type="text" name="request_type" value="{{ old('request_type', $record->request_type) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Domicile Number</label>
                    <input type="text" name="domicile_number" value="{{ old('domicile_number', $record->domicile_number) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <input type="text" name="status" value="{{ old('status', $record->status) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Operator Name</label>
                    <input type="text" name="operator_name" value="{{ old('operator_name', $record->operator_name) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('cash-records.index') }}" class="px-4 py-2 mr-2 bg-gray-200 rounded">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
