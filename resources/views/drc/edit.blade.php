<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Arbitraion Case') }}
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

        <form action="{{ route('drc.update', $divorceCase) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Application Date</label>
                    <input type="date"
                        name="application_date"
                        class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('application_date', optional($divorceCase->application_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                        required>
                </div>
            
                <div>
                    <label class="block text-sm font-medium text-gray-700">Case No</label>
                    <input type="text" name="case_no" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('case_no', $divorceCase->case_no) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Type of Arbitration</label>
                    <select name="arbitration_type_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach ($arbitrationTypes as $arbitrationType)
                            <option value="{{ $arbitrationType->id }}" @selected((string)old('arbitration_type_id', (string)($divorceCase->arbitration_type_id ?? '')) === (string)$arbitrationType->id)>{{ $arbitrationType->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Applicant</label>
                    <select name="applicant_side" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="groom" @selected(old('applicant_side', $divorceCase->applicant_side) === 'groom')>Groom</option>
                        <option value="bride" @selected(old('applicant_side', $divorceCase->applicant_side) === 'bride')>Bride</option>
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
                                value="{{ old('groom_cnic', $divorceCase->groom_cnic) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="groom_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('groom_name', $divorceCase->groom_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Father Name</label>
                            <input type="text" name="groom_father_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('groom_father_name', $divorceCase->groom_father_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="groom_address" rows="3" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('groom_address', $divorceCase->groom_address) }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="border border-gray-200 rounded p-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Bride Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input id="bride_cnic" type="text" name="bride_cnic" maxlength="13" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_cnic', $divorceCase->bride_cnic) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="bride_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_name', $divorceCase->bride_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Father Name</label>
                            <input type="text" name="bride_father_name" class="w-full border-gray-300 rounded shadow-sm"
                                value="{{ old('bride_father_name', $divorceCase->bride_father_name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="bride_address" rows="3" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('bride_address', $divorceCase->bride_address) }}</textarea>
                        </div>
                    </div>
                </section>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Application Status</label>
                    <select id="status" name="status_id" class="w-full border-gray-300 rounded shadow-sm">
                        @foreach ($arbitrationStatuses as $arbitrationStatus)
                            <option value="{{ $arbitrationStatus->id }}" @selected((int)old('status_id', $divorceCase->status_id) === $arbitrationStatus->id)>
                                {{ \Illuminate\Support\Str::title($arbitrationStatus->status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="decisionDateContainer">
                    <label class="block text-sm font-medium text-gray-700">Decision Date</label>
                    <input type="date" name="decision_date" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('decision_date', optional($divorceCase->decision_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                </div>

                <div id="issueDateContainer">
                    <label class="block text-sm font-medium text-gray-700">Date of Issue</label>
                    <input type="date" name="issue_date" class="w-full border-gray-300 rounded shadow-sm"
                        value="{{ old('issue_date', optional($divorceCase->issue_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                </div>
                

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" rows="3" class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks', $divorceCase->remarks) }}</textarea>
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
    </div>
</x-app-layout>
