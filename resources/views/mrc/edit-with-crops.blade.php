<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Marriage Record - Document Assisted
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto p-6">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700
                        rounded-md border border-red-300">

                <ul class="list-disc ml-5 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif


        {{-- Success Message --}}
        @if(session('success'))

            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>

        @endif


        {{-- ============================= --}}

        {{-- TWO COLUMN LAYOUT:            --}}

        {{-- Sticky preview + scrollable   --}}

        {{-- form                          --}}

        {{-- ============================= --}}

        <div class="flex flex-col lg:flex-row lg:items-start gap-6">


            {{-- ============================= --}}
            {{-- DOCUMENT PREVIEW (STICKY)     --}}
            {{-- ============================= --}}

            <div class="w-full lg:w-1/2 lg:sticky lg:top-4 lg:self-start">

                <div class="bg-white shadow-md rounded-lg p-6">

                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Document Preview
                    </h3>

                    <div class="flex justify-between mb-2">

                        <button
                            type="button"
                            onclick="zoomIn()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                        >+</button>

                        <button
                            type="button"
                            onclick="zoomOut()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                        >-</button>

                    </div>

                    <div
                        id="docPreview"
                        class="border overflow-auto"
                        style="height: 600px;"
                    >

                        @php
                            $ext = pathinfo($mrc->image, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($ext, ['jpg', 'jpeg', 'png']))

                            <img
                                id="docImage"
                                src="{{ asset('storage/' . $mrc->image) }}"
                                alt="Nikkahnama Document"
                                class="mx-auto block"
                                style="width: 100%; max-width: none;"
                            >

                        @else

                            <iframe
                                src="{{ asset('storage/' . $mrc->image) }}"
                                class="w-full"
                                style="height: 600px;"
                            ></iframe>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ============================= --}}
            {{-- FORM COLUMN (SCROLLABLE)      --}}
            {{-- ============================= --}}

            <div class="w-full lg:w-1/2">

                <form
                    action="{{ route('mrc.update-with-crops', $mrc->id) }}"
                    method="POST"
                    class="space-y-6"
                >

            @csrf
            @method('PUT')


            {{-- ============================= --}}
            {{-- BASIC INFORMATION               --}}
            {{-- ============================= --}}

            <div class="bg-white shadow-md rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Marriage Information
                </h3>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Union Council --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Union Council
                        </label>

                        <select
                            name="union_council_id"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >

                            <option value="">
                                -- Select Union Council --
                            </option>

                            @foreach($unionCouncils ?? [] as $uc)

                                <option
                                    value="{{ $uc->id }}"
                                    {{ (string)old(
                                        'union_council_id',
                                        $mrc->union_council_id
                                    ) === (string)$uc->id
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $uc->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>
                    {{-- Groom Name --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Groom Name
                        </label>

                        <input
                            id="groom_name"
                            type="text"
                            name="groom_name"
                            value="{{ old('groom_name', $mrc->groom_name) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Bride Name --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bride Name
                        </label>

                        <input
                            id="bride_name"
                            type="text"
                            name="bride_name"
                            value="{{ old('bride_name', $mrc->bride_name) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Groom's Father Name --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Groom's Father Name
                        </label>

                        <input
                            id="groom_father_name"
                            type="text"
                            name="groom_father_name"
                            value="{{ old('groom_father_name', $mrc->groom_father_name) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Bride's Father Name --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bride's Father Name
                        </label>

                        <input
                            id="bride_father_name"
                            type="text"
                            name="bride_father_name"
                            value="{{ old('bride_father_name', $mrc->bride_father_name) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Groom Passport --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Groom Passport
                        </label>

                        <input
                            id="groom_passport"
                            type="text"
                            name="groom_passport"
                            value="{{ old('groom_passport', $mrc->groom_passport) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Bride Passport --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bride Passport
                        </label>

                        <input
                            id="bride_passport"
                            type="text"
                            name="bride_passport"
                            value="{{ old('bride_passport', $mrc->bride_passport) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Groom CNIC --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Groom CNIC
                        </label>

                        <input
                            id="groom_cnic"
                            type="text"
                            name="groom_cnic"
                            maxlength="13"
                            value="{{ old('groom_cnic', $mrc->groom_cnic) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Bride CNIC --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bride CNIC
                        </label>

                        <input
                            id="bride_cnic"
                            type="text"
                            name="bride_cnic"
                            maxlength="13"
                            value="{{ old('bride_cnic', $mrc->bride_cnic) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Marriage Date --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Marriage Date
                        </label>

                        <input
                            type="date"
                            name="marriage_date"
                            value="{{ old('marriage_date', $mrc->marriage_date) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Registration Date --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Registration Date
                        </label>

                        <input
                            type="date"
                            name="registration_date"
                            value="{{ old('registration_date', $mrc->registration_date) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>


                    {{-- Registrar Name --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Registrar Name
                        </label>

                        <select
                            id="registrar_name_select"
                            name="registrar_name"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option value="">-- Select Registrar --</option>
                        </select>

                        <div id="new_registrar_wrapper" class="mt-2 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                New Registrar Name
                            </label>
                            <input
                                id="new_registrar_name"
                                type="text"
                                name="new_registrar_name"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Enter new registrar name"
                                value="{{ old('new_registrar_name') }}"
                            >
                        </div>

                    </div>


                    {{-- Register No --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Register No
                        </label>

                        <input
                            id="register_no"
                            type="text"
                            name="register_no"
                            value="{{ old('register_no', $mrc->register_no) }}"
                            class="w-full border-gray-300
                                   rounded-md shadow-sm"
                        >

                    </div>
                    {{-- Remarks --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                        >{{ old('remarks', $mrc->remarks) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- ============================= --}}
            {{-- BUTTONS                        --}}
            {{-- ============================= --}}

            <div class="flex items-center gap-3">

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2
                           rounded-md hover:bg-blue-700"
                >
                    Save Record
                </button>


                <a
                    href="{{ route('mrc.index') }}"
                    class="bg-gray-500 text-white px-6 py-2
                           rounded-md hover:bg-gray-600"
                >
                    Cancel
                </a>

            </div>


        </form>

            </div>

        </div>

    </div>


    <script>

        /*
         * Document image zoom
         *
         * Initial scale = 2 (zoomed in twice
         * the normal size on page load).
         */
        let scale = 3;

        function applyZoom() {

            let img = document.getElementById('docImage');

            if (!img) {
                return;
            }

            img.style.width = (scale * 100) + '%';

        }

        function scrollPreviewRight() {

            let container = document.getElementById('docPreview');

            if (!container) {
                return;
            }

            container.scrollLeft = container.scrollWidth;

        }

        /*
         * Apply initial settings on page load:
         * image zoomed 2x and scrolled to
         * the right side.
         */
        document.addEventListener('DOMContentLoaded', function () {

            applyZoom();

            scrollPreviewRight();

        });

        function zoomIn() {

            scale += 0.2;

            applyZoom();

        }

        function zoomOut() {

            scale = Math.max(0.5, scale - 0.2);

            applyZoom();

        }


        /*
         * CNIC validation
         */
        ["groom_cnic", "bride_cnic"].forEach(function (id) {

            const input = document.getElementById(id);

            if (!input) {
                return;
            }

            input.addEventListener("input", function () {

                this.value = this.value
                    .replace(/[^0-9]/g, '')
                    .slice(0, 13);

            });

        });


        /*
         * English-only text fields
         */
        document
            .querySelectorAll(
                'input[type="text"]'
            )
            .forEach(function (input) {

                input.addEventListener("keypress", function (e) {

                    if (
                        this.id === 'groom_cnic' ||
                        this.id === 'bride_cnic'
                    ) {
                        return;
                    }

                    let char = String.fromCharCode(e.which);

                    let regex =
                        /[a-zA-Z0-9\s@._-]/;

                    if (e.key.length > 1) {
                        return;
                    }

                    if (!regex.test(char)) {
                        e.preventDefault();
                    }

                });

            });

    </script>

    {{-- Select2 assets --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        /*
         * Registrar Name Select2
         */
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

            // Preload on page load (validation errors / old input)
            const preselected = '{{ old('registrar_name', $mrc->registrar_name) }}';
            const preselectedUc = '{{ old('union_council_id', $mrc->union_council_id) }}';
            if (preselectedUc) {
                loadRegistrarNames(preselectedUc, preselected);
            }

        });
    </script>

</x-app-layout>