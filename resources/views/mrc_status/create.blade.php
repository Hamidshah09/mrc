<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Certificate Status') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">New Record</h2>

        <form action="{{ route('mrc_status.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tracking ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tracking ID</label>
                <input type="text" name="tracking_id" value="{{ old('tracking_id') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                @error('tracking_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Certificate Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Certificate Type</label>
                <select name="certificate_type"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Select</option>
                    <option value="Marriage" {{ old('certificate_type')=='Marriage'?'selected':'' }}>Marriage</option>
                    <option value="Divorce" {{ old('certificate_type')=='Divorce'?'selected':'' }}>Divorce</option>
                </select>
                @error('certificate_type')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Applicant Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Applicant Name</label>
                <input type="text" name="applicant_name" value="{{ old('applicant_name') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                @error('applicant_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Applicant CNIC -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Applicant CNIC</label>
                <input type="text" name="applicant_cnic" value="{{ old('applicant_cnic') }}"
                       placeholder="e.g. 12345-1234567-1"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                @error('applicant_cnic')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Processing Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Processing Date</label>
                <input type="date" name="processing_date" value="{{ old('processing_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                @error('processing_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Select</option>
                    <option value="Certificate Signed" {{ old('status')=='Certificate Signed'?'selected':'' }}>Certificate Signed</option>
                    <option value="Sent for Verification" {{ old('status')=='Sent for Verification'?'selected':'' }}>Sent for Verification</option>
                    <option value="Objection" {{ old('status')=='Objection'?'selected':'' }}>Objection</option>
                </select>
                @error('status')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('mrc_status.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
