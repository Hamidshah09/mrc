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
                    <label class="block text-sm font-medium text-gray-700">
                        Payment Type
                    </label>

                    <select name="payment_type"
                        class="mt-1 block w-full border-gray-300 rounded-md">

                        <option value="">Select</option>

                        <option value="Cash"
                            {{ old('payment_type', $record->payment_type ?? '') == 'Cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option value="1 Link"
                            {{ old('payment_type', $record->payment_type ?? '') == '1 Link' ? 'selected' : '' }}>
                            1 Link
                        </option>

                        <option value="Esahulat"
                            {{ old('payment_type', $record->payment_type ?? '') == 'Esahulat' ? 'selected' : '' }}>
                            Esahulat
                        </option>

                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Priority Type
                    </label>

                    <select name="priority_type"
                        class="mt-1 block w-full border-gray-300 rounded-md">

                        <option value="">Select</option>

                        <option value="1"
                            {{ old('priority_type', $record->priority_type ?? 1) == 1 ? 'selected' : '' }}>
                            Normal
                        </option>

                        <option value="2"
                            {{ old('priority_type', $record->priority_type ?? '') == 2 ? 'selected' : '' }}>
                            Urgent
                        </option>

                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('cash-records.index') }}" class="px-4 py-2 mr-2 bg-gray-200 rounded">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
