<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Verification Letter') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('domicile-verification.update', $letter->Letter_ID) }}">
            @csrf
            @method('PUT')

            {{-- LETTER INFORMATION --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Letter Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Date
                    </label>
                    <input type="date" name="Letter_Date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Letter_Date', $letter->Letter_Date ? date('Y-m-d', strtotime($letter->Letter_Date)) : '') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Sent By
                    </label>
                    <input type="text" name="Letter_Sent_by"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Letter_Sent_by', $letter->Letter_Sent_by) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Designation
                    </label>
                    <input type="text" name="Designation"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Designation', $letter->Designation) }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Sender_Address
                    </label>
                    <input type="text" name="Sender_Address"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Sender_Address', $letter->Sender_Address) }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Remarks
                    </label>
                    <input type="text" name="Remarks"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Remarks', $letter->Remarks) }}">
                </div>
            </div>

            {{-- APPLICANTS --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Applicants
            </h3>

            <div id="applicants-wrapper" class="space-y-4">
                @php $index = 0; @endphp
                @forelse($letter->applicants as $app)
                <div id="applicant-{{ $index }}" class="border p-4 rounded applicant-row relative">
                    <button type="button" onclick="deleteApplicant('applicant-{{ $index }}')" class="absolute top-2 right-2 text-red-600 hover:text-red-800" title="Remove applicant">&times;</button>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="hidden" name="applicants[{{ $index }}][App_ID]" value="{{ $app->App_ID ?? 0 }}">
                        <div>
                            <label class="text-sm font-medium">CNIC</label>
                            <input type="text" name="applicants[{{ $index }}][CNIC]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.CNIC", $app->CNIC) }}">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Applicant Name</label>
                            <input type="text" name="applicants[{{ $index }}][Applicant_Name]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.Applicant_Name", $app->Applicant_Name) }}">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Relation</label>
                            <select name="applicants[{{ $index }}][Relation]" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">Select Relation</option>
                                <option value="s/o" {{ old("applicants.$index.Relation", $app->Relation) == 's/o' ? 'selected' : '' }}>S/O</option>
                                <option value="d/o" {{ old("applicants.$index.Relation", $app->Relation) == 'd/o' ? 'selected' : '' }}>D/O</option>
                                <option value="w/o" {{ old("applicants.$index.Relation", $app->Relation) == 'w/o' ? 'selected' : '' }}>W/O</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Father / Husband Name</label>
                            <input type="text" name="applicants[{{ $index }}][Applicant_FName]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.Applicant_FName", $app->Applicant_FName) }}">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Address</label>
                            <input type="text" name="applicants[{{ $index }}][address]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.address", $app->address) }}">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Domicile No</label>
                            <input type="text" name="applicants[{{ $index }}][Domicile_No]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.Domicile_No", $app->Domicile_No) }}">
                        </div>
                        <div>
                            <label class="text-sm font-medium">Domicile Date</label>
                            <input type="date" name="applicants[{{ $index }}][Domicile_Date]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   value="{{ old("applicants.$index.Domicile_Date", $app->Domicile_Date ? date('Y-m-d', strtotime($app->Domicile_Date)) : '') }}">
                        </div>
                    </div>
                </div>
                @php $index++; @endphp
                @empty
                <div id="applicant-0" class="border p-4 rounded applicant-row relative">
                    <button type="button" onclick="deleteApplicant('applicant-0')" class="absolute top-2 right-2 text-red-600 hover:text-red-800" title="Remove applicant">&times;</button>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="hidden" name="applicants[0][App_ID]" value="0">
                        <div>
                            <label class="text-sm font-medium">CNIC</label>
                            <input type="text" name="applicants[0][CNIC]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Applicant Name</label>
                            <input type="text" name="applicants[0][Applicant_Name]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Relation</label>
                            <input type="text" name="applicants[0][Relation]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Father / Husband Name</label>
                            <input type="text" name="applicants[0][Applicant_FName]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>
                @endforelse

            </div>

            <div id="deleted-applicants"></div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-between mt-6">
                <button type="button" onclick="addApplicant()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Add Applicant
                </button>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Record
                </button>
            </div>

        </form>
    </div>

    {{-- SIMPLE JS --}}
    <script>
        let applicantIndex = {{ max(1, $index) }};

        function reindexApplicants() {
            const wrapper = document.getElementById('applicants-wrapper');
            const rows = wrapper.querySelectorAll('.applicant-row');
            rows.forEach((row, idx) => {
                row.id = `applicant-${idx}`;
                row.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                    el.name = el.name.replace(/applicants\[\d+\]/, `applicants[${idx}]`);
                });
            });
            applicantIndex = rows.length;
        }

        function deleteApplicant(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const appIdInput = el.querySelector('input[name$="[App_ID]"]');
            if (appIdInput && appIdInput.value && Number(appIdInput.value) > 0) {
                const container = document.getElementById('deleted-applicants');
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'deleted_applicants[]';
                hidden.value = appIdInput.value;
                container.appendChild(hidden);
            }
            el.remove();
            reindexApplicants();
        }

        function addApplicant() {
            const wrapper = document.getElementById('applicants-wrapper');

            const html = `
            <div id="applicant-${applicantIndex}" class="border p-4 rounded applicant-row relative">
                <button type="button" onclick="deleteApplicant('applicant-${applicantIndex}')" class="absolute top-2 right-2 text-red-600 hover:text-red-800" title="Remove applicant">&times;</button>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="hidden" name="applicants[${applicantIndex}][App_ID]" value="0">
                    <div>
                        <label class="text-sm font-medium">CNIC</label>
                        <input type="text" name="applicants[${applicantIndex}][CNIC]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Applicant Name</label>
                        <input type="text" name="applicants[${applicantIndex}][Applicant_Name]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Relation</label>
                        <select name="applicants[${applicantIndex}][Relation]" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="">Select Relation</option>
                            <option value="s/o">S/O</option>
                            <option value="d/o">D/O</option>
                            <option value="w/o">W/O</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Father / Husband Name</label>
                        <input type="text" name="applicants[${applicantIndex}][Applicant_FName]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Address</label>
                        <input type="text" name="applicants[${applicantIndex}][address]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Domicile No</label>
                        <input type="text" name="applicants[${applicantIndex}][Domicile_No]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Domicile Date</label>
                        <input type="date" name="applicants[${applicantIndex}][Domicile_Date]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);
            applicantIndex++;
            reindexApplicants();
        }
    </script>
</x-app-layout>
