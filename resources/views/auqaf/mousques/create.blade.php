<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Mosque') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-md border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mousques.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-10">
            @csrf

            {{-- ===================== MOSQUE DETAILS ===================== --}}
            <div>
                <div class="bg-blue-50 border-l-4 border-blue-600 px-4 py-3 rounded mb-4">
                    <h3 class="text-lg font-semibold text-blue-900">Mosque Details</h3>
                    <p class="text-sm text-blue-700">Basic identification and location information</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium">Mosque Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded shadow-sm"
                               value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sector</label>
                        <select name="sector_id" class="w-full border-gray-300 rounded shadow-sm" required>
                            <option value="">Select Sector</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}"
                                    {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sub Sector</label>
                        <input type="text" name="sub_sector" maxlength="10"
                               class="w-full border-gray-300 rounded shadow-sm"
                               value="{{ old('sub_sector') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sect</label>
                        <select name="sect" class="w-full border-gray-300 rounded shadow-sm" required>
                            @foreach (['Barelvi','Deobandi','Ahl-e-Hadith','Shia','Other'] as $sect)
                                <option value="{{ $sect }}"
                                    {{ old('sect') == $sect ? 'selected' : '' }}>
                                    {{ $sect }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Location</label>
                        <input type="text" name="location"
                               class="w-full border-gray-300 rounded shadow-sm"
                               value="{{ old('location') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded shadow-sm">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium">Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full border-gray-300 rounded shadow-sm"
                                  required>{{ old('address') }}</textarea>
                    </div>

                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium">Mosque Images</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="mt-1 w-full text-sm text-gray-600
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100">
                    </div>

                </div>
            </div>
            {{-- ===================== OFFICIALS ===================== --}}
            <div>
                <div class="bg-orange-50 border-l-4 border-orange-600 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-orange-900">Officials</h3>
                        <p class="text-sm text-orange-700">Auqaf officials associated with this mosque</p>
                    </div>

                    <button type="button"
                            onclick="addOfficial()"
                            class="bg-orange-600 text-white px-3 py-1 rounded text-sm">
                        + Add Official
                    </button>
                </div>

                <div id="officials-container" class="space-y-4">

                    {{-- Initial row --}}
                    <div class="official-row border p-4 rounded">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                            <input type="text"
                                name="officials[0][name]"
                                placeholder="Name"
                                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <input type="text"
                                name="officials[0][father_name]"
                                placeholder="Father Name"
                                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <input type="text"
                                name="officials[0][contact_number]"
                                placeholder="Contact Number"
                                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <input type="text"
                                name="officials[0][cnic]"
                                placeholder="CNIC"
                                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                            <select name="officials[0][type]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Type</option>
                                <option value="Regular">Regular</option>
                                <option value="Shrine">Shrine</option>
                                <option value="Private">Private</option>
                            </select>

                            
                        
                            <select name="officials[0][position]"
                                    class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Position</option>

                                @foreach ($positions as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('position') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profile Image</label>
                                <input type="file"
                                    name="officials[0][profile_image]"
                                    class="mt-1 w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-orange-50 file:text-orange-700
                                hover:file:bg-orange-100">
                            </div>
                        </div>

                        <div class="text-right mt-2">
                            <button type="button"
                                    onclick="this.closest('.official-row').remove()"
                                    class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                                Remove
                            </button>
                        </div>
                    </div>

                </div>
            </div>


            {{-- ===================== SHOP DETAILS ===================== --}}
            <div>
                <div class="bg-green-50 border-l-4 border-green-600 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-green-900">Shop Details</h3>
                        <p class="text-sm text-green-700">Shops constructed and managed by mosque</p>
                    </div>
                    <button type="button"
                            onclick="addShop()"
                            class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                        + Add Shop
                    </button>
                </div>

                <div id="shops-container" class="space-y-4">

                    {{-- Shop Row --}}
                    <div class="shop-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">

                        <div>
                            <label class="block text-sm font-medium">Occupier Name</label>
                            <input type="text" name="shops[0][occupier_name]"
                                class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Shop Description</label>
                            <input type="text" name="shops[0][shop_description]"
                                class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Rent Amount</label>
                            <input type="number" name="shops[0][rent_amount]"
                                class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Shop Image</label>
                            <input type="file"
                                name="shops[0][image]"
                                accept="image/*"
                                class="mt-1 w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100">
                        </div>

                        <div class="lg:col-span-3 text-right">
                            <button type="button"
                                    onclick="removeRow(this)"
                                    class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                                Remove
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- ===================== MADARSA DETAILS ===================== --}}
            <div>
                <div class="bg-purple-50 border-l-4 border-purple-600 px-4 py-3 rounded mb-4">
                    <h3 class="text-lg font-semibold text-purple-900">Madrassa Details</h3>
                    <p class="text-sm text-purple-700">Religious education institution near mosque</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium">Madrassa Name</label>
                        <input type="text" name="maddarsa_name"
                               class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">No. of Students</label>
                        <input type="number" name="no_of_students"
                               class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Mohtamim Name</label>
                        <input type="text" name="mohtamim_name" max="60"
                               class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                </div>
            </div>

            {{-- ===================== UTILITY CONNECTIONS ===================== --}}
    
            <div>
                <div class="bg-yellow-50 border-l-4 border-yellow-600 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-900">Utility Connections</h3>
                        <p class="text-sm text-yellow-700">Electricity, gas, and water connections</p>
                    </div>
                    <button type="button"
                            onclick="addUtility()"
                            class="bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                        + Add Utility
                    </button>
                </div>

                <div id="utilities-container" class="space-y-4">

                    {{-- Utility Row --}}
                    <div class="utility-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">

                        <div>
                            <label class="block text-sm font-medium">Utility Type</label>
                            <select name="utilities[0][utility_type]"
                                    class="w-full border-gray-300 rounded shadow-sm">
                                <option value="">Select</option>
                                <option value="Electricity">Electricity</option>
                                <option value="Water">Water</option>
                                <option value="Gas">Gas</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Reference Number</label>
                            <input type="text" name="utilities[0][reference_number]"
                                class="w-full border-gray-300 rounded shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Beneficiary Type</label>
                            <select name="utilities[0][benificiary_type]"
                                    class="w-full border-gray-300 rounded shadow-sm">
                                <option value="">Select</option>
                                <option value="Khateeb">Khateeb</option>
                                <option value="Moazin">Moazin</option>
                                <option value="Khadim">Khadim</option>
                            </select>
                        </div>

                        <div class="lg:col-span-3 text-right">
                            <button type="button"
                                    onclick="removeRow(this)"
                                    class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                                Remove
                            </button>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Submit --}}
            <div class="pt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>

        </form>
    </div>
    <script>
        let shopIndex = 1;
        let utilityIndex = 1;

        function addShop() {
            const container = document.getElementById('shops-container');

            container.insertAdjacentHTML('beforeend', `
                <div class="shop-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">
                    <div>
                        <label class="block text-sm font-medium">Occupier Name</label>
                        <input type="text" name="shops[${shopIndex}][occupier_name]"
                            class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Shop Description</label>
                        <input type="text" name="shops[${shopIndex}][shop_description]"
                            class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Rent Amount</label>
                        <input type="number" name="shops[${shopIndex}][rent_amount]"
                            class="w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Shop Image</label>
                        <input type="file"
                            name="shops[${shopIndex}][image]"
                            accept="image/*"
                            class="mt-1 w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100">
                    </div>
                    <div class="lg:col-span-3 text-right">
                        <button type="button" onclick="removeRow(this)"
                                class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">Remove</button>
                    </div>
                </div>
            `);

            shopIndex++;
        }

        function addUtility() {
            const container = document.getElementById('utilities-container');

            container.insertAdjacentHTML('beforeend', `
                <div class="utility-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">
                    <div>
                        <label class="block text-sm font-medium">Utility Type</label>
                        <select name="utilities[${utilityIndex}][utility_type]"
                                class="w-full border-gray-300 rounded shadow-sm">
                            <option value="">Select</option>
                            <option value="Electricity">Electricity</option>
                            <option value="Water">Water</option>
                            <option value="Gas">Gas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Reference Number</label>
                        <input type="text" name="utilities[${utilityIndex}][reference_number]"
                            class="w-full border-gray-300 rounded shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Beneficiary Type</label>
                        <select name="utilities[${utilityIndex}][benificiary_type]"
                                class="w-full border-gray-300 rounded shadow-sm">
                            <option value="">Select</option>
                            <option value="Khateeb">Khateeb</option>
                            <option value="Moazin">Moazin</option>
                            <option value="Khadim">Khadim</option>
                        </select>
                    </div>

                    <div class="lg:col-span-3 text-right">
                        <button type="button" onclick="removeRow(this)"
                                class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">Remove</button>
                    </div>
                </div>
            `);

            utilityIndex++;
        }

        function removeRow(button) {
            button.closest('.shop-row, .utility-row').remove();
        }
        let officialIndex = 1;

        function addOfficial() {
            document.getElementById('officials-container')
                .insertAdjacentHTML('beforeend', `
                <div class="official-row border p-4 rounded">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                        <input name="officials[${officialIndex}][name]" placeholder="Name" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][father_name]" placeholder="Father Name" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][contact_number]" placeholder="Contact Number" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][cnic]" placeholder="CNIC" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        <select name="officials[${officialIndex}][type]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Type</option>
                            <option value="Regular">Regular</option>
                            <option value="Shrine">Shrine</option>
                            <option value="Private">Private</option>
                        </select>

                        <select name="officials[${officialIndex}][position]"
                                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Position</option>

                            @foreach ($positions as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('position') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <input type="file" name="officials[${officialIndex}][profile_image]" class="mt-1 w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-orange-50 file:text-orange-700
                                hover:file:bg-orange-100">
                    </div>

                    <div class="text-right mt-2">
                        <button type="button"
                                onclick="this.closest('.official-row').remove()"
                                class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                            Remove
                        </button>
                    </div>
                </div>
            `);

            officialIndex++;
        }
    </script>

</x-app-layout>
