@csrf
@php
    $formMode = $formMode ?? ($divorceCase->entry_type === 'old' ? 'old' : 'live');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Case No</label>
        <input type="text" name="case_no" class="w-full border-gray-300 rounded shadow-sm"
               value="{{ old('case_no', $divorceCase->case_no) }}" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Type of Divorce</label>
        <select name="divorce_type" class="w-full border-gray-300 rounded shadow-sm">
            @foreach (['Talaq', 'Khula', 'Talaq Tafveez'] as $type)
                <option value="{{ $type }}" @selected(old('divorce_type', $divorceCase->divorce_type) === $type)>{{ $type }}</option>
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

    @if ($formMode === 'live-create')
        <div>
            <label class="block text-sm font-medium text-gray-700">First Notice Date</label>
            <input type="date" name="notice_date" class="w-full border-gray-300 rounded shadow-sm"
                   value="{{ old('notice_date') }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">First Hearing Date</label>
            <input type="date" name="hearing_date" class="w-full border-gray-300 rounded shadow-sm"
                   value="{{ old('hearing_date') }}" required>
        </div>
    @endif
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
    @if ($formMode === 'old')
        <div>
            <label class="block text-sm font-medium text-gray-700">Decision Date</label>
            <input type="date" name="decision_date" class="w-full border-gray-300 rounded shadow-sm"
                   value="{{ old('decision_date', optional($divorceCase->decision_date)->format('Y-m-d')) }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date of Issue</label>
            <input type="date" name="issue_date" class="w-full border-gray-300 rounded shadow-sm"
                   value="{{ old('issue_date', optional($divorceCase->issue_date)->format('Y-m-d')) }}" required>
        </div>
    @endif

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Remarks</label>
        <textarea name="remarks" rows="3" class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks', $divorceCase->remarks) }}</textarea>
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

<script>
    ["groom_cnic", "bride_cnic"].forEach(function (id) {
        const input = document.getElementById(id);
        if (!input) return;

        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 13);
        });
    });
</script>
