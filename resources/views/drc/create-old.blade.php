<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Old Completed Cases') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('drc.old.store')}}" method="post" enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Application Date</label>
                    <input type="date"
                        name="application_date"
                        class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('application_date', now()->format('Y-m-d')) }}"
                        required>
                </div>
            
                <div>
                    <label class="block text-sm font-medium text-gray-700">Case No</label>
                    <input type="text" name="case_no" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('case_no') }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Type of Arbitration</label>
                    <select name="arbitration_type_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach ($arbitrationTypes as $arbitrationType)
                            <option value="{{ $arbitrationType->id }}" @selected(old('divorce_type') === $arbitrationType->id)>{{ $arbitrationType->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Applicant</label>
                    <select name="applicant_side" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="groom" @selected(old('applicant_side') === 'groom')>Groom</option>
                        <option value="bride" @selected(old('applicant_side') === 'bride')>Bride</option>
                    </select>
                </div>
                
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <section class="border border-gray-200 rounded p-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Groom Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input id="groom_cnic" type="text" name="groom_cnic" maxlength="13" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('groom_cnic') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="groom_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('groom_name') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Father Name</label>
                            <input type="text" name="groom_father_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('groom_father_name') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="groom_address" rows="3" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('groom_address') }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="border border-gray-200 rounded p-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Bride Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input id="bride_cnic" type="text" name="bride_cnic" maxlength="13" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_cnic') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="bride_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_name') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Father Name</label>
                            <input type="text" name="bride_father_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_father_name') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="bride_address" rows="3" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('bride_address') }}</textarea>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Application Status</label>
                    <select id="status" name="status_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach ($arbitrationStatuses as $arbitrationStatus)
                            <option value="{{ $arbitrationStatus->id }}" @selected(old('status') == $arbitrationStatus->id)>
                                {{ \Illuminate\Support\Str::title($arbitrationStatus->status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="decisionDateContainer">
                    <label class="block text-sm font-medium text-gray-700">Decision Date</label>
                    <input type="date" name="decision_date" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('decision_date', now()->format('Y-m-d')) }}" required>
                </div>

                <div id="issueDateContainer">
                    <label class="block text-sm font-medium text-gray-700">Date of Issue</label>
                    <input type="date" name="issue_date" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                </div>
                

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" rows="3" class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks') }}</textarea>
                </div>
            </div>
            <div class="mt-2">
                <div class="space-y-4" id="table-responsive">
                    <div id="table-body">
                        
                    </div>
                </div>
                <div class="flex flex-row justify-between mt-2">
                    <x-primary-button class="ms-3" onclick="addNotice()" type="button">
                    {{ __('Add Notice') }}
                    </x-primary-button>
                    <x-secondary-button class="ms-3" onclick="deleteLastNotice()" type="button">
                    {{ __('Del Notice') }}
                    </x-secondary-button>        
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save
                </button>
                <a href="{{ route('drc.index') }}" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
        
    </div>
    <script>
        ["groom_cnic", "bride_cnic"].forEach(function (id) {
            const input = document.getElementById(id);
            if (!input) return;

            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, "").slice(0, 13);
            });
        });

        let noticeCounter=0
        function addNotice() {
            noticeCounter++;
            if (noticeCounter>3){
                alert('You can send a maximum of Three Notices;')
                return;
            }
            const row = `
                <tr id="notice-row-${noticeCounter}">
                    <td colspan="100" class="py-2">

                        <div class="border border-gray-200 rounded-2xl shadow-sm bg-gray-50 p-5">

                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-indigo-700">
                                    Notice #${noticeCounter}
                                </h3>

                                <button
                                    type="button"
                                    onclick="document.getElementById('notice-row-${noticeCounter}').remove()"
                                    class="text-red-600 hover:text-red-800 text-xl font-bold">
                                    &times;
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Notice Date
                                    </label>
                                    <input
                                        type="hidden"
                                        name="notice[${noticeCounter - 1}][notice_number]"
                                        value="${noticeCounter}"
                                    />
                                    <input
                                        type="date"
                                        required
                                        name="notice[${noticeCounter - 1}][notice_date]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Hearing Date
                                    </label>

                                    <input
                                        type="date"
                                        required
                                        name="notice[${noticeCounter - 1}][hearing_date]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Status
                                    </label>

                                    <select
                                        required
                                        name="notice[${noticeCounter - 1}][status]"
                                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                                        <option value="scheduled">Scheduled</option>
                                        <option value="heard">Heard</option>

                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Proceeding Document
                                    </label>

                                    <input
                                        type="file"
                                        name="notice[${noticeCounter - 1}][proceeding_document]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                
                                <div class="form-control" colspan="4">
                                    <label class="text-sm font-medium text-gray-700 mr-3">
                                        Remarks
                                    </label>
                                    <input
                                        type="text"
                                        name="notice[${noticeCounter - 1}][remarks]"
                                        class="block w-full mt-1 p-2 rounded border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                            </div>

                        </div>

                    </td>
                </tr>
                `;
                document.getElementById("table-body").insertAdjacentHTML("beforeend", row);

        }
        function deleteLastNotice() {

            const tbody = document.getElementById("table-body");

            if (tbody.lastElementChild) {

                tbody.lastElementChild.remove();

                if (noticeCounter > 0) {
                    noticeCounter--;
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {

            const status = document.getElementById("status");
            const decision = document.getElementById("decisionDateContainer");
            const issue = document.getElementById("issueDateContainer");

            function toggleDates() {

                const selected = parseInt(status.value);

                // Hide everything first
                decision.style.display = "none";
                issue.style.display = "none";

                // Certificate Issued
                if (selected === 3) {
                    decision.style.display = "block";
                    issue.style.display = "block";
                }

                // Referred to ADCR, Magistrate, Reconciled
                if ([4, 6, 7].includes(selected)) {
                    decision.style.display = "block";
                }
            }

            status.addEventListener("change", toggleDates);

            // Initial page load
            toggleDates();
        });

    </script>

    
</x-app-layout>
