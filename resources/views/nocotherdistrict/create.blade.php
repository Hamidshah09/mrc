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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Type
                    </label>
                    @php $lt = old('letter_type', 'self'); @endphp
                    <select name="letter_type" id="" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onChange="toggleReferencedLetter(this.value)">
                        <option value="self" {{ $lt === 'self' ? 'selected' : '' }}>Self</option>
                        <option value="official" {{ $lt === 'official' ? 'selected' : '' }}>Official</option>
                    </select>
                </div>
                <div></div>
                <div id="referenced_letter_section" class="{{ old('letter_type') === 'official' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700">
                        Referenced Letter Date
                    </label>
                    <input type="date" name="referenced_letter_date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('referenced_letter_date', date('Y-m-d')) }}">
                </div>

                <div id="referenced_letter_no_section" class="{{ old('letter_type') === 'official' ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700">
                        Referenced Letter No
                    </label>
                    <input type="text" name="referenced_letter_no"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('referenced_letter_no') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Date
                    </label>
                    <input type="date" name="Letter_Date"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ old('Letter_Date', date('Y-m-d')) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Sent To
                    </label>
                          <input type="text" name="NOC_Issued_To"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              value="{{ old('NOC_Issued_To') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Remarks
                    </label>
                          <input type="text" name="Remarks"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              value="{{ old('Remarks') }}">
                </div>
            </div>

            {{-- APPLICANTS --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Applicants
            </h3>

            <div id="applicants-wrapper" class="space-y-4">
                @php $oldApplicants = old('applicants', []); @endphp
                @if(!empty($oldApplicants) && is_array($oldApplicants))
                    @foreach($oldApplicants as $index => $app)
                        <div id="applicant-{{ $index }}" class="border p-4 rounded applicant-row relative">
                            @if($index > 0)
                                <button type="button" onclick="deleteApplicant('applicant-{{ $index }}')" class="absolute top-2 right-2 text-red-600 hover:text-red-800" title="Remove applicant">&times;</button>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="text-sm font-medium">CNIC</label>

                                    <input type="text"
                                        name="applicants[0][CNIC]"
                                        class="mt-1 block w-full border-gray-300 rounded-md cnic-input"
                                        placeholder="xxxxxxxxxxxxx"
                                        value="{{ old('applicants.0.CNIC') }}">

                                    <div class="cnic-check-result mt-2 text-sm hidden"></div>
                                    <div class="other-dist-result mt-2 text-sm hidden"></div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Applicant Name</label>
                                    <input type="text" name="applicants[{{ $index }}][Applicant_Name]"
                                           class="mt-1 block w-full border-gray-300 rounded-md"
                                           value="{{ $app['Applicant_Name'] ?? '' }}">
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Relation</label>
                                    <select name="applicants[{{ $index }}][Relation]" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select Relation</option>
                                        <option value="s/o" {{ (isset($app['Relation']) && $app['Relation'] === 's/o') ? 'selected' : '' }}>S/O</option>
                                        <option value="d/o" {{ (isset($app['Relation']) && $app['Relation'] === 'd/o') ? 'selected' : '' }}>D/O</option>
                                        <option value="w/o" {{ (isset($app['Relation']) && $app['Relation'] === 'w/o') ? 'selected' : '' }}>W/O</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-sm font-medium">Father / Husband Name</label>
                                    <input type="text" name="applicants[{{ $index }}][Applicant_FName]"
                                           class="mt-1 block w-full border-gray-300 rounded-md"
                                           value="{{ $app['Applicant_FName'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="applicant-0" class="border p-4 rounded applicant-row">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="text-sm font-medium">CNIC</label>
                                <input type="text" name="applicants[0][CNIC]"
                                       class="mt-1 block w-full border-gray-300 rounded-md cnic-input"
                                       placeholder="xxxxxxxxxxxxx"
                                       value="{{ old('applicants.0.CNIC') }}">
                                <div class="cnic-check-result mt-2 text-sm hidden"></div>
                                <div class="other-dist-result mt-2 text-sm hidden"></div>
                            </div>
                            

                            <div>
                                <label class="text-sm font-medium">Applicant Name</label>
                                <input type="text" name="applicants[0][Applicant_Name]"
                                       class="mt-1 block w-full border-gray-300 rounded-md"
                                       value="{{ old('applicants.0.Applicant_Name') }}">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Relation</label>
                                <select name="applicants[0][Relation]" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                                    <option value="">Select Relation</option>
                                    <option value="s/o" {{ old('applicants.0.Relation') === 's/o' ? 'selected' : '' }}>S/O</option>
                                    <option value="d/o" {{ old('applicants.0.Relation') === 'd/o' ? 'selected' : '' }}>D/O</option>
                                    <option value="w/o" {{ old('applicants.0.Relation') === 'w/o' ? 'selected' : '' }}>W/O</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium">Father / Husband Name</label>
                                <input type="text" name="applicants[0][Applicant_FName]"
                                       class="mt-1 block w-full border-gray-300 rounded-md"
                                       value="{{ old('applicants.0.Applicant_FName') }}">
                            </div>
                        </div>
                    </div>
                @endif

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

                        <input type="text"
                            name="applicants[${applicantIndex}][CNIC]"
                            class="mt-1 block w-full border-gray-300 rounded-md cnic-input">

                        <div class="cnic-check-result mt-2 text-sm hidden"></div>
                        <div class="other-dist-result mt-2 text-sm hidden"></div>
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

        async function checkApplicantRecords(input) {

            const cnic = input.value.replace(/\D/g, '');

            if (cnic.length !== 13) {
                return;
            }

            const wrapper = input.closest('div');

            const nitbBox =
                wrapper.querySelector('.cnic-check-result');

            const otherDistBox =
                wrapper.querySelector('.other-dist-result');

            /*
            |--------------------------------------------------------------------------
            | Reset UI
            |--------------------------------------------------------------------------
            */

            [nitbBox, otherDistBox].forEach(box => {

                box.classList.remove(
                    'hidden',
                    'text-red-600',
                    'text-green-600'
                );

                box.classList.add('text-gray-500');

                box.innerHTML = 'Checking...';
            });

            try {

                /*
                |--------------------------------------------------------------------------
                | Parallel API Calls
                |--------------------------------------------------------------------------
                */

                const [
                    nitbResponse,
                    otherDistResponse
                ] = await Promise.all([

                    fetch(
                        `https://cfc-ict.com/fastapi/domicile/check-in-nitb/${cnic}`
                    ),

                    fetch(
                        `https://cfc-ict.com/api/domicile/noc-other-district/verify/${cnic}`,
                        {
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json'
                            }
                        }
                    )
                ]);

                /*
                |--------------------------------------------------------------------------
                | Parse JSON In Parallel Too
                |--------------------------------------------------------------------------
                */

                const [
                    nitbData,
                    otherDistData
                ] = await Promise.all([

                    nitbResponse.json(),
                    otherDistResponse.json()
                ]);

                /*
                |--------------------------------------------------------------------------
                | NITB Result
                |--------------------------------------------------------------------------
                */

                nitbBox.classList.remove(
                    'text-gray-500'
                );

                if (
                    nitbData.status === 'success' &&
                    nitbData.records > 0
                ) {

                    nitbBox.classList.add('text-red-600');

                    nitbBox.innerHTML = `
                        Domicile Record already exists in NITB.
                        Total Records: ${nitbData.records}
                    `;

                } else {

                    nitbBox.classList.add('text-green-600');

                    nitbBox.innerHTML =
                        'No existing NITB record found';
                }

                /*
                |--------------------------------------------------------------------------
                | Other District Result
                |--------------------------------------------------------------------------
                */

                otherDistBox.classList.remove(
                    'text-gray-500'
                );

                if (
                    otherDistData.success &&
                    otherDistData.is_letter_issued
                ) {

                    otherDistBox.classList.add('text-red-600');

                    otherDistBox.innerHTML =
                        'NOC to Other District already issued';

                } else {

                    otherDistBox.classList.add('text-green-600');

                    otherDistBox.innerHTML =
                        'No previous NOC found';
                }

            } catch (error) {

                console.error(error);

                [nitbBox, otherDistBox].forEach(box => {

                    box.classList.remove(
                        'text-gray-500',
                        'text-green-600'
                    );

                    box.classList.add('text-red-600');

                    box.innerHTML =
                        'Unable to verify records';
                });
            }
        }

        document.addEventListener('blur', function(e) {

            if (
                e.target.classList.contains('cnic-input')
            ) {

                checkApplicantRecords(e.target);
            }

        }, true);

    </script>
</x-app-layout>
