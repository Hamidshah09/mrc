<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Marriage') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">

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

        <form action="{{ route('mrc.correction') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                
                
                <div>
                    <label class="block text-sm font-medium">Wrong Registrar Name</label>
                    <input type="text" name="wrong_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('wrong_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium">Correct Registrar Name</label>
                    <input type="text" name="correct_name"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('correct_name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Passkey</label>
                    <input type="text" name="passkey"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('passkey') }}">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded shadow-sm hover:bg-blue-700">
                    Submit Correction
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
