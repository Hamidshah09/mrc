<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Domicile Cancellation Letter') }}
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
        <form method="POST" action="{{ route('domicile.cancellation.update', $letter->Letter_ID) }}">
            @csrf
            @method('PUT')

            {{-- LETTER INFORMATION --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Letter Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div>
                    <label class="text-sm font-medium">CNIC</label>
                    <input type="text" name="CNIC"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            placeholder="xxxxxxxxxxxxx"
                            value="{{ old('CNIC', $letter->CNIC) }}"
                            >
                </div>

                <div>
                    <label class="text-sm font-medium">Applicant Name</label>
                    <input type="text" name="Applicant_Name"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            value="{{ old('Applicant_Name', $letter->Applicant_Name) }}">
                </div>

                <div>
                    <label class="text-sm font-medium">Relation</label>
                    <select name="Relation" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select Relation</option>
                        <option value="s/o" {{ old('Relation', $letter->Relation) == 's/o' ? 'selected' : '' }}>S/O</option>
                        <option value="d/o" {{ old('Relation', $letter->Relation) == 'd/o' ? 'selected' : '' }}>D/O</option>
                        <option value="w/o" {{ old('Relation', $letter->Relation) == 'w/o' ? 'selected' : '' }}>W/O</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Father / Husband Name</label>
                    <input type="text" name="Father_Name"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            value="{{ old('Father_Name', $letter->Father_Name) }}">
                </div>
                <div>
                    <label class="text-sm font-medium">Address</label>
                    <input type="text" name="Address"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            value="{{ old('Address', $letter->Address) }}">
                </div>
                <div>
                    <label class="text-sm font-medium">Domicile No</label>
                    <input type="text" name="Domicile_No"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            value="{{ old('Domicile_No', $letter->Domicile_No) }}">
                </div>
                <div>
                    <label class="text-sm font-medium">Domicile Date</label>
                    <input type="date" name="Domicile_Date"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            value="{{ old('Domicile_Date', $letter->Domicile_Date) }}">
                </div>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-between mt-6">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Record
                </button>
            </div>

        </form>
    </div>

</x-app-layout>
