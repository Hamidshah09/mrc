<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Surety Record') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">
                    Data Entry
                </h2>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color:red;">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="entryForm" action="{{ route('surety.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Guarantor CNIC</label>
                        <input type="text" id="guarantor_cnic" name="guarantor_cnic" value="{{ old('guarantor_cnic') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('guarantor_cnic')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Guarantor Name</label>
                        <input type="text" id="guarantor_name" name="guarantor_name" value="{{ old('guarantor_name') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('guarantor_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Guarantor Father's Name</label>
                        <input type="text" id="guarantor_father_name" name="guarantor_father_name" value="{{ old('guarantor_father_name') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('guarantor_father_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Police Station</label>
                        <select id="police_station_id" name="police_station_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
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
                        <input type="text" id="section_of_law" name="section_of_law" value="{{ old('section_of_law') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('section_of_law')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Accused Name</label>
                        <input type="text" id="accused_name" name="accused_name" value="{{ old('accused_name') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('accused_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mobile No</label>
                        <input type="tel" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('mobile_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" id="amount" name="amount" step="1" min="0" value="{{ old('amount') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('amount')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Surety Type</label>
                        <select id="surety_type_id" name="surety_type_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Select Type</option>
                            @foreach($suretyTypes as $t)
                                <option value="{{ $t->id }}" {{ old('surety_type_id') == $t->id ? 'selected' : '' }}>{{ ucwords($t->name) }}</option>
                            @endforeach
                        </select>
                        @error('surety_type_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Court</label>
                        <select id="court_id" name="court_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Select Court</option>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}" {{ old('court_id') == $court->id ? 'selected' : '' }}>{{ $court->name }}</option>
                            @endforeach
                        </select>
                        @error('court_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Mode</label>
                        <select id="payment_mode" name="payment_mode" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="pay order" {{ old('payment_mode') == 'pay order' ? 'selected' : '' }}>Pay Order</option>
                            <option value="deposited in bank" {{ old('payment_mode') == 'deposited in bank' ? 'selected' : '' }}>Deposited in Bank</option>
                        </select>
                        @error('payment_mode')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">PO No</label>
                        <input type="text" id="po_no" name="po_no" value="{{ old('po_no') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('po_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank</label>
                        <select id="bank_id" name="bank_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('bank_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Branch Name</label>
                        <input type="text" id="branch_name" name="branch_name" value="{{ old('branch_name') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('branch_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Receiving Date</label>
                        <input type="date" id="receiving_date" name="receiving_date" value="{{ old('receiving_date', now()->format('Y-m-d')) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('receiving_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payorder / Document (image or PDF)</label>
                        <input type="file" id="docs" name="docs" accept="image/*,.pdf"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('docs')
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
        
    </div>
    <script>
        
    </script>
</x-app-layout>
