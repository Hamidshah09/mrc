<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Document Crop Templates
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">

        <div class="bg-white rounded shadow p-6">

            <div class="mb-4">

                <label class="block font-medium mb-2">
                    Select Field
                </label>

                <select id="field_name"
                        class="border-gray-300 rounded w-full md:w-96">

                    <option value="">
                        -- Select Field --
                    </option>

                    @foreach($fields as $key => $label)

                        <option value="{{ $key }}">
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="border bg-gray-100 p-4 overflow-auto">

                <img
                    id="document-image"
                    src="{{ asset('images/nikkahnama-template.jpg') }}"
                    class="max-w-full"
                    alt="Document"
                >

            </div>

            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">

                <div>
                    <label>X</label>
                    <input id="crop-x"
                           type="number"
                           class="w-full border rounded">
                </div>

                <div>
                    <label>Y</label>
                    <input id="crop-y"
                           type="number"
                           class="w-full border rounded">
                </div>

                <div>
                    <label>Width</label>
                    <input id="crop-width"
                           type="number"
                           class="w-full border rounded">
                </div>

                <div>
                    <label>Height</label>
                    <input id="crop-height"
                           type="number"
                           class="w-full border rounded">
                </div>

            </div>

            <button
                id="save-template"
                type="button"
                class="mt-6 bg-blue-600 text-white px-5 py-2 rounded">

                Save Template

            </button>

        </div>

    </div>
</x-app-layout>