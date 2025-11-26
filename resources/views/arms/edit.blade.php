<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Arms License Record') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-md border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('arms.update', $armsLicense->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('name', $armsLicense->name) }}">
                </div>

                <!-- CNIC -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">CNIC</label>
                    <input type="text" name="cnic" maxlength="13"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('cnic', $armsLicense->cnic) }}">
                </div>

                <!-- Guardian Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Guardian Name</label>
                    <input type="text" name="guardian_name"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('guardian_name', $armsLicense->guardian_name) }}">
                </div>

                <!-- Mobile -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile</label>
                    <input type="text" name="mobile" maxlength="15"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('mobile', $armsLicense->mobile) }}">
                </div>

                <!-- Weapon Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weapon Number</label>
                    <input type="text" name="weapon_number"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('weapon_number', $armsLicense->weapon_number) }}">
                </div>

                <!-- License Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">License Number</label>
                    <input type="text" name="license_number"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('license_number', $armsLicense->license_number) }}">
                </div>

                <!-- Caliber -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Caliber</label>
                    <input type="text" name="caliber"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('caliber', $armsLicense->caliber) }}">
                </div>

                <!-- Weapon Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weapon Type</label>
                    <input type="text" name="weapon_type"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('weapon_type', $armsLicense->weapon_type) }}">
                </div>

                <!-- Issue Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                    <input type="date" name="issue_date"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('issue_date', $armsLicense->issue_date) }}">
                </div>

                <!-- Expire Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Expire Date</label>
                    <input type="date" name="expire_date"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('expire_date', $armsLicense->expire_date) }}">
                </div>

                <!-- Address -->
                <div class="md:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('address', $armsLicense->address) }}">
                </div>

                <!-- Approver ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Approver</label>
                    <select name="approver_id"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('approver_id', $armsLicense->approver_id) == 1 ? 'selected' : '' }}>DC</option>
                        <option value="2" {{ old('approver_id', $armsLicense->approver_id) == 2 ? 'selected' : '' }}>ADCG</option>
                    </select>
                </div>

                <!-- Character Certificate -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Character Certificate</label>
                    <select name="character_certificate"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('character_certificate', $armsLicense->character_certificate) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('character_certificate', $armsLicense->character_certificate) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Address on CNIC -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address on CNIC</label>
                    <select name="address_on_cnic"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('address_on_cnic', $armsLicense->address_on_cnic) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('address_on_cnic', $armsLicense->address_on_cnic) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Affidavit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Affidavit</label>
                    <select name="affidavit"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('affidavit', $armsLicense->affidavit) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('affidavit', $armsLicense->affidavit) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <!-- should cancel -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Should We Cancel it</label>
                    <select name="should_cancel"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('should_cancel', $armsLicense->should_cancel) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('should_cancel', $armsLicense->should_cancel) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">File Status</label>
                    <select name="status_id"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('status_id', $armsLicense->status_id) == 1 ? 'selected' : '' }}>Approved</option>
                        <option value="0" {{ old('status_id', $armsLicense->status_id) == 0 ? 'selected' : '' }}>Not Approved</option>
                    </select>
                </div>
                <!-- Phone call -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Called for Character Certificate?</label>
                    <select name="called"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('called', $armsLicense->called) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="2" {{ old('called', $armsLicense->called) == 2 ? 'selected' : '' }}>No Answer</option>
                        <option value="3" {{ old('called', $armsLicense->called) == 3 ? 'selected' : '' }}>Wrong Number</option>
                    </select>
                </div>
                <!-- Response -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Should We Cancel it</label>
                    <select name="called"
                            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="1" {{ old('called', $armsLicense->called) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('called', $armsLicense->called) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
