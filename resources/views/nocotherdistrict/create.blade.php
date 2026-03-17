<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('NOC to Other District') }}
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
        <form method="POST" action="{{ route('noc-other-district.store') }}">
            @csrf

            {{-- LETTER INFORMATION --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Letter Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Type
                    </label>
                    <select name="letter_type" id="" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onChange="toggleReferencedLetter(this.value)">
                        <option selected value="self">Self</option>
                        <option value="official">Official</option>
                    </select>
                </div>
                <div></div>
                <div id="referenced_letter_section" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">
                        Referenced Letter Date
                    </label>
                    <input type="date" name="referenced_letter_date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ date('Y-m-d') }}">
                </div>

                <div id="referenced_letter_no_section" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">
                        Referenced Letter No
                    </label>
                    <input type="text" name="referenced_letter_no"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Date
                    </label>
                    <input type="date" name="Letter_Date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ date('Y-m-d') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Sent To
                    </label>
                    <input type="text" name="NOC_Issued_To"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Remarks
                    </label>
                    <input type="text" name="Remarks"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            {{-- APPLICANTS --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Applicants
            </h3>

            <div id="applicants-wrapper" class="space-y-4">

                {{-- Applicant Row --}}
                <div id="applicant-0" class="border p-4 rounded applicant-row">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-sm font-medium">CNIC</label>
                            <input type="text" name="applicants[0][CNIC]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   placeholder="xxxxxxxxxxxxx">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Applicant Name</label>
                            <input type="text" name="applicants[0][Applicant_Name]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Relation</label>
                            <select name="applicants[0][Relation]" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">Select Relation</option>
                                <option value="s/o">S/O</option>
                                <option value="d/o">D/O</option>
                                <option value="w/o">W/O</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Father / Husband Name</label>
                            <input type="text" name="applicants[0][Applicant_FName]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-between mt-6">
                <button type="button" onclick="addApplicant()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Add Applicant
                </button>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Record
                </button>
            </div>

        </form>
    </div>

    {{-- SIMPLE JS --}}
    <script>
        let applicantIndex = 1;

        function reindexApplicants() {
            const wrapper = document.getElementById('applicants-wrapper');
            const rows = wrapper.querySelectorAll('.applicant-row');
            rows.forEach((row, idx) => {
                // set sequential id
                row.id = `applicant-${idx}`;
                // update names to sequential indexes
                row.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                    el.name = el.name.replace(/applicants\[\d+\]/, `applicants[${idx}]`);
                });
            });
            applicantIndex = rows.length;
        }

        function deleteApplicant(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.remove();
            reindexApplicants();
        }

        function addApplicant() {
            const wrapper = document.getElementById('applicants-wrapper');

            const html = `
            <div id="applicant-${applicantIndex}" class="border p-4 rounded applicant-row relative">
                <button type="button" onclick="deleteApplicant('applicant-${applicantIndex}')" class="absolute top-2 right-2 text-red-600 hover:text-red-800" title="Remove applicant">&times;</button>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <select name="applicants[${applicantIndex}][Relation]" id="" class="mt-1 block w-full border-gray-300 rounded-md">
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
                </div>
            </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);
            applicantIndex++;
            reindexApplicants();
        }
        function toggleReferencedLetter(value) {
            const refLetterNoSection = document.getElementById('referenced_letter_no_section');
            const refLetterDateSection = document.getElementById('referenced_letter_section');

            if (value === 'official') {
                refLetterNoSection.classList.remove('hidden');
                refLetterDateSection.classList.remove('hidden');
            } else {
                refLetterNoSection.classList.add('hidden');
                refLetterDateSection.classList.add('hidden');
            }
        }

    </script>
</x-app-layout>
