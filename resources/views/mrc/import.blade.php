<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">
    <h2 class="text-2xl font-semibold mb-6">Upload Excel</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-600 rounded">
            {{session('success')}}
        </div>
    @endif

    <form action="{{ route('mrc.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Select File</label>
                <input type="file" name="file" class="border p-2">
            </div>

            

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit
            </button>
        </div>
    </form>
</div>
</x-app-layout>
