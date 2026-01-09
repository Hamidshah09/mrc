<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('NOC – ICT Applicants') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        <form method="POST" action="{{ route('noc-ict.store') }}">
            @csrf

            {{-- LETTER INFORMATION --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Letter Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Date
                    </label>
                    <input type="date" name="letter[Letter_Date]"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           value="{{ date('Y-m-d') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Letter Sent To
                    </label>
                    <input type="text" name="letter[Letter_Sent_to]"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Remarks
                    </label>
                    <input type="text" name="letter[Remarks]"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            {{-- APPLICANTS --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Applicants
            </h3>

            <div id="applicants-wrapper" class="space-y-4">

                {{-- Applicant Row --}}
                <div class="border p-4 rounded applicant-row">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-sm font-medium">CNIC</label>
                            <input type="text" name="applicants[0][CNIC]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   placeholder="xxxxx-xxxxxxx-x">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Applicant Name</label>
                            <input type="text" name="applicants[0][Applicant_Name]"
                                   class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Relation</label>
                            <input type="text" name="applicants[0][Relation]"
                                   class="mt-1 block w-full border-gray-300 rounded-md"
                                   placeholder="S/O, D/O, W/O">
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

        function addApplicant() {
            const wrapper = document.getElementById('applicants-wrapper');

            const html = `
            <div class="border p-4 rounded applicant-row">
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
                        <input type="text" name="applicants[${applicantIndex}][Relation]"
                               class="mt-1 block w-full border-gray-300 rounded-md">
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
        }
    </script>
</x-app-layout>
