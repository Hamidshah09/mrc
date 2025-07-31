<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Report') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mt-5 mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Generate Report</h2>
        @if (session('status'))
            <div class="w-full rounded bg-green-300 px-3 py-4">
                {{session('status')}}
            </div>    
        @endif
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('Passcodes.report') }}" class="mt-2">
            @csrf
            <div class="mb-4">
                <label for="date" class="block font-semibold">Date</label>
                <input type="date" name="date" id="date" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Generate
            </button>
        </form>
    </div>


</x-app-layout>