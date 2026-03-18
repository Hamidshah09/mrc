<?php
// ...existing code...
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
        <form method="POST" action="{{ route('domicile.cancellation.update', $blacklist->black_list_ID) }}">
            @csrf
            @method('PUT')

            {{-- LETTER INFORMATION --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Letter Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                
                <div>
                    <label class="text-sm font-medium">CNIC</label>
                    <input type="text" name="cnic"
                            class="mt-1 block w-full border-gray-300 rounded-md"
                            placeholder="xxxxxxxxxxxxx" value="{{ old('cnic', $blacklist->cnic) }}">
                </div>

                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select name="status" id="" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="">Select Status</option>
                        <option value="Blocked" {{ old('status', $blacklist->status) == 'Blocked' ? 'selected' : '' }}>Blocked</option>
                        <option value="Unblocked" {{ old('status', $blacklist->status) == 'Unblocked' ? 'selected' : '' }}>Unblocked</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Reason</label>
                    <input type="text" name="reason"
                            class="mt-1 block w-full border-gray-300 rounded-md" value="{{ old('reason', $blacklist->reason) }}">
                </div>
                <div>
                    <label class="text-sm font-medium">Clearance Reason</label>
                    <input type="text" name="clearance_reason"
                            class="mt-1 block w-full border-gray-300 rounded-md" value="{{ old('clearance_reason', $blacklist->clearance_reason) }}">
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
