<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <h2 class="text-2xl font-semibold mb-6">Register Marriage</h2>

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

        <form action="{{ route('mrc.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Groom Name</label>
                    <input type="text" name="groom_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride Name</label>
                    <input type="text" name="bride_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom's Father Name</label>
                    <input type="text" name="groom_father_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_father_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride's Father Name</label>
                    <input type="text" name="bride_father_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_father_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom Passport</label>
                    <input type="text" name="groom_passport"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_passport') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride Passport</label>
                    <input type="text" name="bride_passport"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_passport') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Groom CNIC</label>
                    <input id="groom_cnic" type="text" name="groom_cnic"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('groom_cnic') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Bride CNIC</label>
                    <input id="bride_cnic" type="text" name="bride_cnic"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('bride_cnic') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Marriage Date</label>
                    <input type="date" name="marriage_date"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('marriage_date') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Registration Date</label>
                    <input type="date" name="registration_date"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('registration_date') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Register No</label>
                    <input type="text" name="register_no"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('register_no') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium">Remarks</label>
                    <textarea name="remarks" rows="3"
                              class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium">Upload Nikkahnama (page 1)</label>
                    <input type="file" required name="image"
                           class="w-full border-gray-300 rounded shadow-sm">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <script>
        // Restrict all text/email inputs to English letters, numbers, basic symbols
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="search"], input[type="password"]')
            .forEach(inp => {
                inp.addEventListener("keypress", function (e) {
                    let char = String.fromCharCode(e.which);

                    // Allow English letters, numbers, space, punctuation, @, _, and -
                    let regex = /[a-zA-Z0-9\s@._-]/;

                    // Allow control keys (Backspace, Delete, Tab, etc.)
                    if (e.key.length > 1) return;

                    if (!regex.test(char)) {
                        e.preventDefault(); // Block Urdu / non-English characters
                    }
                });
            });

        // Restrict CNIC fields to 13 digits
        ["groom_cnic", "bride_cnic"].forEach(id => {
            let input = document.getElementById(id);

            input.addEventListener("keypress", function (e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
                if (this.value.length >= 13) {
                    e.preventDefault();
                }
            });

            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, ""); // remove non-digits
                if (this.value.length > 13) {
                    this.value = this.value.slice(0, 13); // enforce 13 limit
                }
            });
        });
    </script>
</x-app-layout>
