<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Surety Record') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-2 text-gray-700">New Surety Record</h2>

        <form action="{{ route('surety.store') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Register ID</label>
                    <input type="number" name="register_id" value="{{ old('register_id') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('register_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Guarantor Name</label>
                    <input type="text" name="guarantaor_name" value="{{ old('guarantaor_name') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('guarantaor_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile No</label>
                    <input type="tel" name="mobile_no" value="{{ old('mobile_no') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('mobile_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Receipt No</label>
                    <input type="text" name="receipt_no" value="{{ old('receipt_no') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('receipt_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Receipt Date</label>
                    <input type="date" name="receipt_date" value="{{ old('receipt_date') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('receipt_date')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Police Station ID</label>
                    <select name="police_station_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Police Station</option>
                        @foreach($policeStations as $station)
                            <option value="{{ $station->id }}" {{ old('police_station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    @error('police_station_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Section of Law</label>
                    <input type="text" name="section_of_law" value="{{ old('section_of_law') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('section_of_law')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Accused Name</label>
                    <input type="text" name="accused_name" value="{{ old('accused_name') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('accused_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" step="1" min="0" value="{{ old('amount') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('amount')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Surety Type</label>
                    <select name="surety_type_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Type</option>
                        
                        @foreach($suretyTypes as $t)
                            <option value="{{ $t->id }}" {{ old('surety_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('surety_type_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Surety Status</label>
                    <select name="surety_status_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Status</option>
                        @foreach($surityStatuses as $s)
                            <option value="{{ $s->id }}" {{ old('surety_status_id') == $s->id ? 'selected' : '' }}>{{ $s->status_name}}</option>
                        @endforeach
                    </select>
                    @error('surety_status_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('surety.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
