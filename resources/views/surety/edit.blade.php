<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Certificate Status') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Surety Record</h2>

        <form action="{{ route('surety.update', $record->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Register ID</label>
                    <input type="number" name="register_id" value="{{ old('register_id', $record->register_id) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('register_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Guarantor Name</label>
                    <input type="text" name="guarantor_name" value="{{ old('guarantor_name', $record->guarantor_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('guarantor_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Guarantor CNIC</label>
                    <input type="text" name="guarantor_cnic" value="{{ old('guarantor_cnic', $record->guarantor_cnic) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('guarantor_cnic')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Guarantor Father's Name</label>
                    <input type="text" name="guarantor_father_name" value="{{ old('guarantor_father_name', $record->guarantor_father_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('guarantor_father_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile No</label>
                    <input type="tel" name="mobile_no" value="{{ old('mobile_no', $record->mobile_no) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('mobile_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Receipt No</label>
                    <input type="text" name="receipt_no" value="{{ old('receipt_no', $record->receipt_no) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('receipt_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="receiving_date" value="{{ old('receiving_date', optional($record->receiving_date)->format('Y-m-d') ?? $record->receiving_date) }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Police Station ID</label>
                    <select name="police_station_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Police Station</option>
                        @foreach($policeStations as $station)
                            <option value="{{ $station->id }}" {{ old('police_station_id', $record->police_station_id) == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    @error('police_station_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Section of Law</label>
                    <input type="text" name="section_of_law" value="{{ old('section_of_law', $record->section_of_law) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('section_of_law')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Accused Name</label>
                    <input type="text" name="accused_name" value="{{ old('accused_name', $record->accused_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('accused_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" step="1" min="0" value="{{ old('amount', $record->amount) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('amount')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Surety Type</label>
                    <select name="surety_type_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Type</option>
                        @php $types = isset($suretyTypes) ? $suretyTypes : \App\Models\SuretyType::all(); @endphp
                        @foreach($types as $t)
                            <option value="{{ $t->id }}" {{ old('surety_type_id', $record->surety_type_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
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
                        @php $statuses = isset($surityStatuses) ? $surityStatuses : \App\Models\SuretyStatus::all(); @endphp
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('surety_status_id', $record->surety_status_id) == $s->id ? 'selected' : '' }}>{{ $s->status_name ?? $s->name ?? $s->title ?? 'Status '.$s->id }}</option>
                        @endforeach
                    </select>
                    @error('surety_status_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Releasing Date</label>
                    <input type="date" name="releasing_date" value="{{ old('releasing_date', optional($record->releasing_date)->format('Y-m-d') ?? $record->releasing_date) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('releasing_date')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Court</label>
                    <select name="court_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Court</option>
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}" {{ old('court_id', $record->court_id) == $court->id ? 'selected' : '' }}>{{ $court->name }}</option>
                        @endforeach
                    </select>
                    @error('court_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Mode</label>
                    <select name="payment_mode" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="pay order" {{ old('payment_mode', $record->payment_mode) == 'pay order' ? 'selected' : '' }}>pay order</option>
                        <option value="deposited in bank" {{ old('payment_mode', $record->payment_mode) == 'deposited in bank' ? 'selected' : '' }}>deposited in bank</option>
                    </select>
                    @error('payment_mode')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">PO No</label>
                    <input type="text" name="po_no" value="{{ old('po_no', $record->po_no) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('po_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Bank</label>
                    <select name="bank_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Select Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ old('bank_id', $record->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Branch Name</label>
                    <input type="text" name="branch_name" value="{{ old('branch_name', $record->branch_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('branch_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Cheque No</label>
                    <input type="text" name="checque_no" value="{{ old('checque_no', $record->checque_no) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('checque_no')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="user_id" value="{{ old('user_id', $record->user_id) }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Documents</label>
                    @if($record->docs)
                        <div class="mb-2"><a href="{{ asset('storage/'.$record->docs) }}" target="_blank" class="text-blue-600">View existing document</a></div>
                    @endif
                    @if($record->images && $record->images->count())
                        <h4 class="text-md font-medium mb-2">Uploaded Documents</h4>
                        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($record->images as $img)
                                <div class="border rounded shadow-sm overflow-hidden bg-white">
                                    <div class="w-full h-40 overflow-hidden bg-gray-100">
                                        @if(\Illuminate\Support\Str::endsWith($img->path, ['.jpg', '.jpeg', '.png']))
                                            <a href="{{ asset('storage/'.$img->path) }}" target="_blank"><img src="{{ asset('storage/'.$img->path) }}" alt="" class="w-full h-full object-cover" /></a>
                                        @else
                                            <div class="p-4">
                                                <a href="{{ asset('storage/'.$img->path) }}" target="_blank" class="text-blue-600">{{ $img->original_name ?? 'Document' }}</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-2 text-sm text-gray-700">{{ $img->original_name ?? basename($img->path) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="docs[]" accept="image/*,.pdf" multiple class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    @error('docs')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('surety.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
