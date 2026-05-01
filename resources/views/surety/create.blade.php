<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Surety Record') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <h3 class="font-semibold mb-2">Document Preview</h3>

            <div class="flex justify-between mb-2">
                <button onclick="zoomIn()" class="px-2 py-1 bg-gray-200 rounded">+</button>
                <button onclick="zoomOut()" class="px-2 py-1 bg-gray-200 rounded">-</button>
            </div>

            <div class="border overflow-auto" style="height: 200px;">
                @php
                    $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                @endphp

                @if(in_array($ext, ['jpg','jpeg','png']))
                    <img id="docImage"
                         src="{{ asset('storage/'.$doc->file_path) }}"
                         class="mx-auto block" style="width: 100%; max-width: none;">
                @else
                    <iframe src="{{ asset('storage/'.$doc->file_path) }}"
                            class="w-full"
                            style="height: 200px;"></iframe>
                @endif
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700">
                    Data Entry
                </h2>

                <div class="text-right">
                    <div class="text-sm text-gray-600">
                        Progress:
                        <span id="progressText">
                            {{ $doc->entered_entries }} / {{ $doc->total_expected_entries ?? '?' }}
                        </span>
                    </div>

                    <div class="w-48 bg-gray-200 rounded h-2 mt-1">
                        <div id="progressBar"
                            class="bg-blue-600 h-2 rounded"
                            style="width: {{ $doc->total_expected_entries ? ($doc->entered_entries / $doc->total_expected_entries) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
            <form id="entryForm" action="{{ route('surety.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Register ID</label>
                        <input type="number" id="register_id" name="register_id" value="{{ old('register_id') }}" autofocus
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('register_id')
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
                        <label class="block text-sm font-medium text-gray-700">Mobile No</label>
                        <input type="tel" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('mobile_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Receipt No</label>
                        <input type="text" id="receipt_no" name="receipt_no" value="{{ old('receipt_no') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('receipt_no')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Receipt Date</label>
                        <input type="date" id="receiving_date" name="receiving_date" value="{{ old('receiving_date') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('receiving_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Police Station ID</label>
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
                                <option value="{{ $t->id }}" {{ old('surety_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('surety_type_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="document_id" value="{{ $doc->id }}">

                    
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('surety.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
        
    </div>
    <script>
        let scale = 1;

        function zoomIn() {
            let img = document.getElementById('docImage');
            if (!img) return;

            scale += 0.2;
            img.style.width = (scale * 100) + '%';
        }

        function zoomOut() {
            let img = document.getElementById('docImage');
            if (!img) return;

            scale = Math.max(0.5, scale - 0.2);
            img.style.width = (scale * 100) + '%';
        }
        document.getElementById('entryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);
            form.querySelector('button[type="submit"]').disabled = true;
            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json' // IMPORTANT
                }
            })
            .then(async res => {

                // Handle validation error
                if (res.status === 422) {
                    let data = await res.json();
                    showValidationErrors(data.errors);
                    throw new Error("Validation failed");
                }

                return res.json();
            })
            .then(data => {
                if (data.success) {

                    form.reset();
                    form.querySelector('input, select').focus();
                    showToast("Saved successfully");

                    // ✅ Update progress text
                    document.getElementById('progressText').innerText =
                        `${data.entered} / ${data.total ?? '?'}`;

                    // ✅ Update progress bar
                    if (data.total) {
                        let percent = (data.entered / data.total) * 100;
                        document.getElementById('progressBar').style.width = percent + '%';
                    }
                if (data.total && data.entered >= data.total) {
                    showToast("Document completed 🎉");

                    // Optional: redirect after completion
                    setTimeout(() => {
                        window.location.href = "{{ route('suretydocuments.index') }}";
                    }, 1500);
                }

                } else {
                    alert("Something went wrong");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error saving data");
            })
            .finally(() => {
                form.querySelector('button[type="submit"]').disabled = false;
            });
        });
        function showValidationErrors(errors) {

            // remove old errors
            document.querySelectorAll('.error-text').forEach(el => el.remove());

            Object.keys(errors).forEach(field => {

                let input = document.querySelector(`[name="${field}"]`);

                if (input) {
                    let error = document.createElement('p');
                    error.className = "text-sm text-red-600 mt-1 error-text";
                    error.innerText = errors[field][0];

                    input.parentNode.appendChild(error);
                }
            });

            showToast("Please fix the errors");
        }
        function showToast(msg) {
            let toast = document.createElement('div');
            toast.innerText = msg;
            toast.className = "fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow";
            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        }
        document.getElementById('register_id').addEventListener('blur', function() {

            let registerId = this.value;

            if (!registerId) return;

            fetch(`/surety/fetch/${registerId}`)
                .then(res => res.json())
                .then(res => {

                    if (!res.found) {
                        console.log("No previous record");
                        return;
                    }

                    let data = res.data;

                    // ✅ Fill fields
                    document.getElementById('guarantor_name').value = data.guarantaor_name ?? '';
                    document.getElementById('mobile_no').value = data.mobile_no ?? '';
                    document.getElementById('receipt_no').value = data.receipt_no ?? '';
                    document.getElementById('receiving_date').value = data.receipt_date ?? '';
                    document.getElementById('police_station_id').value = data.police_station_id ?? '';
                    document.getElementById('section_of_law').value = data.section_of_law ?? '';
                    document.getElementById('accused_name').value = data.accused_name ?? '';
                    document.getElementById('amount').value = data.amount ?? '';
                    document.getElementById('surety_type_id').value = data.surety_type_id ?? '';
                    showToast("Previous record loaded");

                })
                .catch(err => console.error(err));
        });

    </script>
</x-app-layout>
