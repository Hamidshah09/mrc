<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Marriage') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-md border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mrc.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="block text-sm font-medium">Union Council</label>
                    <select name="union_council_id" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">-- Select Union Council --</option>
                        @foreach($unionCouncils as $uc)
                            <option value="{{ $uc->id }}" {{ (string)old('union_council_id', $last) === (string)$uc->id ? 'selected' : '' }}>{{ $uc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Register No</label>
                    <input type="text" name="register_no"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('register_no') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Groom Name</label>
                    <input type="text" name="groom_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride Name</label>
                    <input type="text" name="bride_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom's Father Name</label>
                    <input type="text" name="groom_father_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_father_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride's Father Name</label>
                    <input type="text" name="bride_father_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_father_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom Passport</label>
                    <input type="text" name="groom_passport"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_passport') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride Passport</label>
                    <input type="text" name="bride_passport"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_passport') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom CNIC</label>
                    <input id="groom_cnic" type="text" name="groom_cnic"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_cnic') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride CNIC</label>
                    <input id="bride_cnic" type="text" name="bride_cnic"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_cnic') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Marriage Date</label>
                    <input type="date" name="marriage_date"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('marriage_date') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Registration Date</label>
                    <input type="date" name="registration_date"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('registration_date') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Registrar Name</label>
                    <select id="registrar_name_select" name="registrar_name"
                            class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">-- Select Registrar --</option>
                    </select>

                    <div id="new_registrar_wrapper" class="mt-2 hidden">
                        <label class="block text-sm font-medium">New Registrar Name</label>
                        <input type="text" id="new_registrar_name" name="new_registrar_name"
                               class="w-full border-gray-300 rounded shadow-sm"
                               placeholder="Enter new registrar name"
                               value="{{ old('new_registrar_name') }}">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium">Remarks</label>
                    <textarea name="remarks" rows="3"
                              class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Upload Nikkahnama (page 1)</label>
                    <input type="file" name="image"
                           class="w-full border-gray-300 rounded shadow-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Restrict all text/email inputs to English letters, numbers, basic symbols
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="search"], input[type="password"]')
            .forEach(inp => {
                inp.addEventListener("keypress", function (e) {
                    let char = String.fromCharCode(e.which);

                    // Allow English letters, numbers, space, punctuation, @, _, and -
                    let regex = /[a-zA-Z0-9\s@._-]/;

                    // Allow control keys (Backspace, Delete, Tab, etc.)
                    if (e.key.length > 1) return;

                    if (!regex.test(char)) {
                        e.preventDefault(); // Block Urdu / non-English characters
                    }
                });
            });

        // Restrict CNIC fields to 13 digits
        ["groom_cnic", "bride_cnic"].forEach(id => {
            let input = document.getElementById(id);

            input.addEventListener("keypress", function (e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
                if (this.value.length >= 13) {
                    e.preventDefault();
                }
            });

            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, ""); // remove non-digits
                if (this.value.length > 13) {
                    this.value = this.value.slice(0, 13); // enforce 13 limit
                }
            });
        });

        // ===================== Registrar Name Select2 =====================
        const NEW_REGISTRAR = '__NEW__';

        function toggleNewRegistrarInput() {
            const select = document.getElementById('registrar_name_select');
            const wrapper = document.getElementById('new_registrar_wrapper');

            if (select.value === NEW_REGISTRAR) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function loadRegistrarNames(unionCouncilId, selectedRegistrar) {
            const select = $('#registrar_name_select');

            select.empty().append('<option value="">-- Select Registrar --</option>');

            if (!unionCouncilId) {
                select.trigger('change');
                return;
            }

            $.ajax({
                url: '{{ route('mrc.registrar-names') }}',
                type: 'GET',
                data: { union_council_id: unionCouncilId },
                dataType: 'json',
                success: function (names) {
                    names.forEach(function (name) {
                        select.append(
                            $('<option></option>')
                                .val(name)
                                .text(name)
                        );
                    });

                    // Extra "New" option
                    select.append(
                        $('<option></option>')
                            .val(NEW_REGISTRAR)
                            .text('New')
                    );

                    if (selectedRegistrar) {
                        // Keep the saved value selectable even if it is not
                        // in the fetched list (e.g. previously entered via "New")
                        const exists = select.find('option').toArray()
                            .some(function (o) { return o.value === selectedRegistrar; });

                        if (!exists) {
                            select.append(
                                $('<option></option>')
                                    .val(selectedRegistrar)
                                    .text(selectedRegistrar)
                            );
                        }

                        select.val(selectedRegistrar).trigger('change');
                    }
                    toggleNewRegistrarInput();
                },
                error: function () {
                    console.error('Failed to load registrar names.');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const ucSelect = document.querySelector('select[name="union_council_id"]');
            const registrarSelect = document.getElementById('registrar_name_select');

            // Initialize Select2
            $('#registrar_name_select').select2({
                placeholder: '-- Select Registrar --',
                allowClear: true,
                width: '100%'
            });

            // Load registrars when union council changes
            ucSelect.addEventListener('change', function () {
                loadRegistrarNames(this.value, null);
            });

            // Show/hide the "New" input when selection changes
            registrarSelect.addEventListener('change', toggleNewRegistrarInput);

            // Preload on page load (validation errors / old input),
            // otherwise default to the last saved registrar name
            const preselected = '{{ old('registrar_name', $lastRegistrar) }}';
            const preselectedUc = '{{ old('union_council_id', $last) }}';
            if (preselectedUc) {
                loadRegistrarNames(preselectedUc, preselected);
            }
        });
    </script>
</x-app-layout>
