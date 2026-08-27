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


                    @foreach($cropFields as $field => $label)

                        @php
                            $template = $templates->get($field);

                            $cropPath = $template
                                ? 'storage/documents/' .
                                  $mrc->id .
                                  '/crops/' .
                                  $field .
                                  '.jpg'
                                : null;
                        @endphp


                        <div
                            class="{{ in_array($field, [
                                'groom_name',
                                'bride_name',
                                'groom_father_name',
                                'bride_father_name',
                                'groom_cnic',
                                'bride_cnic',
                            ]) ? '' : '' }}"
                        >

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $label }}
                            </label>


                            {{-- Crop Image --}}
                            @if($template && $cropPath)

                                <div class="mb-3 bg-gray-100 border
                                            rounded-md p-2">

                                    <img
                                        src="{{ asset($cropPath) }}"
                                        alt="{{ $label }}"
                                        class="w-full max-h-48 object-contain
                                               rounded"
                                    >

                                </div>

                            @else

                                <div class="mb-3 p-4 bg-gray-100
                                            border rounded text-sm
                                            text-gray-500">

                                    No crop available for this field.

                                </div>

                            @endif


                            {{-- Input --}}
                            @if(in_array($field, [
                                'marriage_date',
                                'registration_date'
                            ]))

                                <input
                                    type="date"
                                    name="{{ $field }}"
                                    value="{{ old(
                                        $field,
                                        $mrc->{$field}
                                    ) }}"
                                    class="w-full border-gray-300
                                           rounded-md shadow-sm"
                                >

                            @elseif(in_array($field, [
                                'groom_cnic',
                                'bride_cnic'
                            ]))

                                <input
                                    id="{{ $field }}"
                                    type="text"
                                    name="{{ $field }}"
                                    maxlength="13"
                                    value="{{ old(
                                        $field,
                                        $mrc->{$field}
                                    ) }}"
                                    class="w-full border-gray-300
                                           rounded-md shadow-sm"
                                >

                            @else

                                <input
                                    id="{{ $field }}"
                                    type="text"
                                    name="{{ $field }}"
                                    value="{{ old(
                                        $field,
                                        $mrc->{$field}
                                    ) }}"
                                    class="w-full border-gray-300
                                           rounded-md shadow-sm"
                                >

                            @endif

                        </div>

                    @endforeach


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


    <script>

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

</x-app-layout>