<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Auqaf Official') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auqaf-officials.update', $auqafOfficial->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $auqafOfficial->name) }}"
                           class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- Father Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Father Name</label>
                    <input type="text" name="father_name"
                           value="{{ old('father_name', $auqafOfficial->father_name) }}"
                           class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- Position --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <select name="position"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Position</option>
                        @foreach ($positions as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('position', $auqafOfficial->position) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Contact Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number"
                           value="{{ old('contact_number', $auqafOfficial->contact_number) }}"
                           class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- CNIC --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">CNIC</label>
                    <input type="text" name="cnic"
                           value="{{ old('cnic', $auqafOfficial->cnic) }}"
                           class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Type</option>
                        @foreach (['Regular', 'Shrine', 'Private'] as $type)
                            <option value="{{ $type }}"
                                {{ old('type', $auqafOfficial->type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mosque --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mosque</label>
                    <select name="mousque_id"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select Mosque</option>
                        @foreach ($mosques as $mosque)
                            <option value="{{ $mosque->id }}"
                                {{ old('mousque_id', $auqafOfficial->mousque_id) == $mosque->id ? 'selected' : '' }}>
                                {{ $mosque->name }} — {{ $mosque->sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Profile Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Profile Image</label>

                    @if ($auqafOfficial->profile_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $auqafOfficial->profile_image) }}"
                                 class="w-24 h-24 rounded object-cover border">
                        </div>
                    @endif

                    <input type="file" name="profile_image"
                           class="mt-1 w-full text-sm text-gray-600
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100">
                </div>

            </div>

            {{-- Buttons --}}
            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('auqaf-officials.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
