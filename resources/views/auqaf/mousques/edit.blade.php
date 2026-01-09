<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Mosque') }}
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

        <form action="{{ route('mousques.update', $mousque->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-10">
            @csrf
            @method('PUT')

            {{-- ===================== MOSQUE DETAILS ===================== --}}
            <div>
                <div class="bg-blue-50 border-l-4 border-blue-600 px-4 py-3 rounded mb-4">
                    <h3 class="text-lg font-semibold text-blue-900">Mosque Details</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <div>
                        <label>Mosque Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $mousque->name) }}"
                               class="w-full border rounded" required>
                    </div>

                    <div>
                        <label>Sector</label>
                        <select name="sector_id" class="w-full border rounded" required>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}"
                                    {{ old('sector_id', $mousque->sector_id) == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Sub Sector</label>
                        <input type="text" name="sub_sector"
                               value="{{ old('sub_sector', $mousque->sub_sector) }}"
                               class="w-full border rounded">
                    </div>

                    <div>
                        <label>Sect</label>
                        <select name="sect" class="w-full border rounded">
                            @foreach(['Barelvi','Deobandi','Ahl-e-Hadith','Shia','Other'] as $sect)
                                <option value="{{ $sect }}"
                                    {{ old('sect', $mousque->sect) == $sect ? 'selected' : '' }}>
                                    {{ $sect }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Location</label>
                        <input type="text" name="location"
                               value="{{ old('location', $mousque->location) }}"
                               class="w-full border rounded">
                    </div>

                    <div>
                        <label>Status</label>
                        <select name="status" class="w-full border rounded">
                            <option value="1" {{ $mousque->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $mousque->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-3">
                        <label>Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full border rounded">{{ old('address', $mousque->address) }}</textarea>
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
                <div class="bg-indigo-50 border-l-4 border-indigo-600 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-900">Officials</h3>
                        <p class="text-sm text-indigo-700">Auqaf officials associated with this mosque</p>
                    </div>

                    <button type="button"
                            onclick="addOfficial()"
                            class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">
                        + Add Official
                    </button>
                </div>

                <div id="officials-container" class="space-y-4">

                    @foreach($mousque->officials as $i => $official)
                        <div class="official-row border p-4 rounded">

                            {{-- Required for edit --}}
                            <input type="hidden" name="officials[{{ $i }}][id]" value="{{ $official->id }}">
                            <input type="hidden" name="officials[{{ $i }}][_delete]" value="0">

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                <input type="text"
                                    name="officials[{{ $i }}][name]"
                                    value="{{ old("officials.$i.name", $official->name) }}"
                                    placeholder="Name"
                                    class="border rounded">

                                <input type="text"
                                    name="officials[{{ $i }}][father_name]"
                                    value="{{ old("officials.$i.father_name", $official->father_name) }}"
                                    placeholder="Father Name"
                                    class="border rounded">

                                <input type="text"
                                    name="officials[{{ $i }}][contact_number]"
                                    value="{{ old("officials.$i.contact_number", $official->contact_number) }}"
                                    placeholder="Contact Number"
                                    class="border rounded">

                                <input type="text"
                                    name="officials[{{ $i }}][cnic]"
                                    value="{{ old("officials.$i.cnic", $official->cnic) }}"
                                    placeholder="CNIC"
                                    class="border rounded">

                                <select name="officials[{{ $i }}][type]" class="border rounded">
                                    @foreach(['Regular','Shrine','Private', 'Shrine Daily Wages', 'Retired'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old("officials.$i.type", $official->type) === $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="officials[{{$i}}][position]"
                                        class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Position</option>

                                    @foreach ($positions as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old("officials.$i.position", $official->position) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="file"
                                    name="officials[{{ $i }}][profile_image]"
                                    class="mt-1 w-full text-sm text-gray-600
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                            </div>

                            <div class="text-right mt-2">
                                <button type="button"
                                        onclick="markOfficialForDeletion(this)"
                                        class="text-red-600 text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- ===================== SHOPS ===================== --}}
            <div>
                <div class="bg-green-50 border-l-4 border-green-600 px-4 py-3 rounded mb-4 flex justify-between">
                    <h3 class="text-lg font-semibold text-green-900">Shop Details</h3>
                    <button type="button" onclick="addShop()" class="bg-green-600 text-white px-3 py-1 rounded">
                        + Add Shop
                    </button>
                </div>

                <div id="shops-container" class="space-y-4">
                    @foreach($mousque->shops as $i => $shop)
                        <div class="shop-row border p-4 rounded">
                            <input type="hidden" name="shops[{{ $i }}][id]" value="{{ $shop->id }}">
                            <input type="hidden" name="shops[{{ $i }}][_delete]" value="0">

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <input name="shops[{{ $i }}][occupier_name]" value="{{ $shop->occupier_name }}" placeholder="Occupier" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <input name="shops[{{ $i }}][shop_description]" value="{{ $shop->shop_description }}" placeholder="Description" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <input type="number" name="shops[{{ $i }}][rent_amount]" value="{{ $shop->rent_amount }}" placeholder="Rent" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <input type="file" name="shops[{{ $i }}][image]" class="mt-1 w-full text-sm text-gray-600
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100">
                            </div>

                            <div class="text-right mt-2">
                                <button type="button" onclick="markForDeletion(this)" class="text-red-600 text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ===================== MADARSA ===================== --}}
            <div>
                <div class="bg-purple-50 border-l-4 border-purple-600 px-4 py-3 rounded mb-4">
                    <h3 class="text-lg font-semibold text-purple-900">Maddarsa Details</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-2 border-gray-300 rounded-md py-4">
                    <input type="hidden" name="maddarsa_id" value="{{ optional($mousque->maddarsa)->id }}">

                    <input name="maddarsa_name"
                           value="{{ old('maddarsa_name', optional($mousque->maddarsa)->name) }}"
                           placeholder="Maddarsa Name"
                           class="border rounded">

                    <input type="number" name="no_of_students"
                           value="{{ old('no_of_students', optional($mousque->maddarsa)->no_of_students) }}"
                           placeholder="No of Students"
                           class="border rounded">

                    <input name="mohtamim_name"
                           value="{{ old('mohtamim_name', optional($mousque->maddarsa)->mohtamim_name) }}"
                           placeholder="Mohtamim Name"
                           class="border rounded">
                </div>
            </div>

            {{-- ===================== UTILITIES ===================== --}}
            <div>
                <div class="bg-yellow-50 border-l-4 border-yellow-600 px-4 py-3 rounded mb-4 flex justify-between">
                    <h3 class="text-lg font-semibold text-yellow-900">Utility Connections</h3>
                    <button type="button" onclick="addUtility()" class="bg-yellow-600 text-white px-3 py-1 rounded">
                        + Add Utility
                    </button>
                </div>

                <div id="utilities-container" class="space-y-4">
                    @foreach($mousque->utilities as $i => $u)
                        <div class="utility-row border p-4 rounded">
                            <input type="hidden" name="utilities[{{ $i }}][id]" value="{{ $u->id }}">
                            <input type="hidden" name="utilities[{{ $i }}][_delete]" value="0">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <select name="utilities[{{ $i }}][utility_type]" class="border rounded">
                                    @foreach(['Electricity','Water','Gas'] as $type)
                                        <option value="{{ $type }}" {{ $u->utility_type == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>

                                <input name="utilities[{{ $i }}][reference_number]"
                                       value="{{ $u->reference_number }}"
                                       class="border rounded">

                                <select name="utilities[{{ $i }}][benificiary_type]" class="border rounded">
                                    @foreach(['Khateeb','Moazin','Khadim'] as $b)
                                        <option value="{{ $b }}" {{ $u->benificiary_type == $b ? 'selected' : '' }}>
                                            {{ $b }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-right mt-2">
                                <button type="button" onclick="markForDeletion(this)" class="text-red-600 text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="pt-6">
                <button class="bg-blue-600 text-white px-6 py-2 rounded">
                    Update Mosque
                </button>
            </div>

        </form>
    </div>

    <script>
        let shopIndex = {{ $mousque->shops->count() }};
        let utilityIndex = {{ $mousque->utilities->count() }};

        function addShop() {
            document.getElementById('shops-container').insertAdjacentHTML('beforeend', `
                <div class="shop-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">
                        
                    <input type="hidden" name="shops[${shopIndex}][id]">
                    <input type="hidden" name="shops[${shopIndex}][_delete]" value="0">
                    <div>
                        <label class="block text-sm font-medium">Occupier Name</label>
                        <input name="shops[${shopIndex}][occupier_name]" placeholder="Occupier" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Shop Description</label>
                        <input name="shops[${shopIndex}][shop_description]" placeholder="Description" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Rent Amount</label>
                        <input type="number" name="shops[${shopIndex}][rent_amount]" placeholder="Rent" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Shop Image</label>
                        <input type="file" name="shops[${shopIndex}][image]" class="mt-1 w-full text-sm text-gray-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100">
                    </div>
                    <div class="lg:col-span-3 text-right">
                        <button type="button" onclick="this.closest('.shop-row').remove()" class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                            Remove
                        </button>
                    </div>
                </div>
            `);
            shopIndex++;
        }

        function addUtility() {
            document.getElementById('utilities-container').insertAdjacentHTML('beforeend', `
                <div class="utility-row grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border p-4 rounded">
                    <input type="hidden" name="utilities[${utilityIndex}][id]">
                    <input type="hidden" name="utilities[${utilityIndex}][_delete]" value="0">
                    <div>
                        <label class="block text-sm font-medium">Utility Type</label>
                        <select name="utilities[${utilityIndex}][utility_type]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option>Electricity</option><option>Water</option><option>Gas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Reference Number</label>
                        <input name="utilities[${utilityIndex}][reference_number]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Beneficiary Type</label>
                        <select name="utilities[${utilityIndex}][benificiary_type]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option>Khateeb</option><option>Moazin</option><option>Khadim</option>
                        </select>
                    </div>
                    <div class="lg:col-span-3 text-right">
                        <button type="button" onclick="this.closest('.utility-row').remove()" class="text-red-600 text-sm bg-red-100 px-2 py-1 rounded">
                            Remove    
                        </button>
                    </div>
                </div>
            `);
            utilityIndex++;
        }

        function markForDeletion(btn) {
            const row = btn.closest('.shop-row, .utility-row');
            row.style.display = 'none';
            row.querySelector('input[name$="[_delete]"]').value = 1;
        }
       
        let officialIndex = {{ $mousque->officials->count() }};

        function addOfficial() {
            document.getElementById('officials-container')
                .insertAdjacentHTML('beforeend', `
                <div class="official-row border p-4 rounded">

                    <input type="hidden" name="officials[${officialIndex}][id]">
                    <input type="hidden" name="officials[${officialIndex}][_delete]" value="0">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                        <input name="officials[${officialIndex}][name]" placeholder="Name" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][father_name]" placeholder="Father Name" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][contact_number]" placeholder="Contact Number" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <input name="officials[${officialIndex}][cnic]" placeholder="CNIC" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        <select name="officials[${officialIndex}][type]" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Regular">Regular</option>
                            <option value="Shrine">Shrine</option>
                            <option value="Private">Private</option>
                            <option value="Shrine Daily Wages">Shrine Daily Wages</option>
                            <option value="Retired">Retired</option>
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

                        <input type="file" name="officials[${officialIndex}][profile_image]" class="border rounded">
                    </div>

                    <div class="text-right mt-2">
                        <button type="button"
                                onclick="this.closest('.official-row').remove()"
                                class="text-red-600 text-sm">
                            Remove
                        </button>
                    </div>
                </div>
            `);

            officialIndex++;
        }
    </script>
</x-app-layout>
