<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Postal Service Record') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <form action="{{ route('postalservice.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Article Number -->
            <div class="mb-6">
                <label for="article_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Article Number <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="article_number" 
                    id="article_number" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('article_number') border-red-500 @enderror" 
                    placeholder="Enter article number" 
                    value="{{ old('article_number', $record->article_number) }}" 
                    >
                @error('article_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Receiver Name -->
            <div class="mb-6">
                <label for="receiver_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Receiver Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="receiver_name" 
                    id="receiver_name" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('receiver_name') border-red-500 @enderror" 
                    placeholder="Enter receiver name" 
                    value="{{ old('receiver_name', $record->receiver_name) }}" 
                    required>
                @error('receiver_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Receiver Address -->
            <div class="mb-6">
                <label for="receiver_address" class="block text-sm font-medium text-gray-700 mb-2">
                    Receiver Address <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="receiver_address" 
                    id="receiver_address" 
                    rows="3"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('receiver_address') border-red-500 @enderror" 
                    placeholder="Enter receiver address" 
                    required>{{ old('receiver_address', $record->receiver_address) }}</textarea>
                @error('receiver_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-6">
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number
                </label>
                <input type="text" 
                    name="phone_number" 
                    id="phone_number" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror" 
                    placeholder="Enter phone number" 
                    value="{{ old('phone_number', $record->phone_number) }}">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Weight -->
            <div class="mb-6">
                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                    Weight <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="weight" 
                    id="weight" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('weight') border-red-500 @enderror" 
                    placeholder="Enter weight (e.g., 500g, 1kg)" 
                    value="{{ old('weight', $record->weight) }}" 
                    >
                @error('weight')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rate -->
            <div class="mb-6">
                <label for="rate" class="block text-sm font-medium text-gray-700 mb-2">
                    Rate <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="rate" 
                    id="rate" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rate') border-red-500 @enderror" 
                    placeholder="Enter rate" 
                    value="{{ old('rate', $record->rate) }}" 
                    >
                @error('rate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    name="status_id" 
                    id="status_id" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status_id') border-red-500 @enderror" 
                    required>
                    <option value="">Choose a status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id', $record->status_id) == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('postalservice.index') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
