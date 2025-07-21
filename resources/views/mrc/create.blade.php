<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">
    <h2 class="text-2xl font-semibold mb-6">Register Marriage</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mrc.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Groom Name</label>
                <input type="text" name="groom_name" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('groom_name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Bride Name</label>
                <input type="text" name="bride_name" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('bride_name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Groom's Father Name</label>
                <input type="text" name="groom_father_name" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('groom_father_name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Bride's Father Name</label>
                <input type="text" name="bride_father_name" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('bride_father_name') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Groom Passport</label>
                <input type="text" name="groom_passport" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('groom_passport') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Bride Passport</label>
                <input type="text" name="bride_passport" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('bride_passport') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Groom CNIC</label>
                <input type="text" name="groom_cnic" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('groom_cnic') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Bride CNIC</label>
                <input type="text" name="bride_cnic" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('bride_cnic') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Marriage Date</label>
                <input type="date" name="marriage_date" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('marriage_date') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Registration Date</label>
                <input type="date" name="registration_date" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('registration_date') }}">
            </div>

            <div>
                <label class="block text-sm font-medium">Register No</label>
                <input type="text" name="register_no" class="w-full border-gray-300 rounded shadow-sm" value="{{ old('register_no') }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Remarks</label>
                <textarea name="remarks" rows="3" class="w-full border-gray-300 rounded shadow-sm">{{ old('remarks') }}</textarea>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>
    </form>
</div>
</x-app-layout>
