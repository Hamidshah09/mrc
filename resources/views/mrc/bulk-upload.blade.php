<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bulk Upload Nikkahnama Documents
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form
                method="POST"
                action="{{ route('mrc.bulk-upload.store') }}"
                enctype="multipart/form-data"
            >

                @csrf

                <label class="block font-medium mb-2">
                    Select document images
                </label>

                <input
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/png"
                    class="w-full border rounded p-2"
                >

                <p class="text-sm text-gray-500 mt-2">
                    You can select multiple document images.
                </p>

                <button
                    type="submit"
                    class="mt-6 bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
                >
                    Upload Documents
                </button>

            </form>

        </div>

    </div>

</x-app-layout>