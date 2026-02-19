<x-guest-layout>

    {{-- Flash messages: success, fail, or validation errors --}}
    @if(session('success') || session('fail') || session('error') || $errors->any())
        <div class="max-w-4xl mx-auto mt-6 px-4">
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex-1 text-sm">
                            <p class="font-semibold">Success</p>
                            <p class="mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('fail') || session('error'))
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3a1 1 0 002 0V7zm-1 7a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5z" clip-rule="evenodd"></path></svg>
                        <div class="flex-1 text-sm">
                            <p class="font-semibold">Error</p>
                            <p class="mt-1">{{ session('fail') ?? session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l5.516 9.8c.75 1.333-.213 2.99-1.742 2.99H4.483c-1.53 0-2.492-1.657-1.742-2.99l5.516-9.8z"></path></svg>
                        <div class="flex-1 text-sm">
                            <p class="font-semibold">There were some problems with your input:</p>
                            <ul class="mt-2 list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                {{ __('Apply for Postal Service') }}
        </h1>
            
        
        <form action="{{ route('postalservice.store') }}" method="POST">
            @csrf

            <!-- Article Number -->
            {{-- <div class="mb-6">
                <label for="article_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Article Number <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="article_number" 
                    id="article_number" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('article_number') border-red-500 @enderror" 
                    placeholder="Enter article number" 
                    value="{{ old('article_number') }}" 
                    required>
                @error('article_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

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
                    value="{{ old('receiver_name') }}" 
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
                    required>{{ old('receiver_address') }}</textarea>
                @error('receiver_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Reciver City --}}
            
            <div class="mb-6">
                <label for="receiver_city_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Receiver City <span class="text-red-500">*</span>
                </label>
                <select name="receiver_city_id" id="receiver_city_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('receiver_city_id') border-red-500 @enderror">
                    <option value="">Select a city</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('receiver_city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('receiver_city_id')
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
                    value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Weight -->
            {{-- <div class="mb-6">
                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                    Weight <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="weight" 
                    id="weight" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('weight') border-red-500 @enderror" 
                    placeholder="Enter weight (e.g., 500g, 1kg)" 
                    value="{{ old('weight') }}" 
                    required>
                @error('weight')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <!-- Rate -->
            {{-- <div class="mb-6">
                <label for="rate" class="block text-sm font-medium text-gray-700 mb-2">
                    Rate <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                    name="rate" 
                    id="rate" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rate') border-red-500 @enderror" 
                    placeholder="Enter rate" 
                    value="{{ old('rate') }}" 
                    required>
                @error('rate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <!-- Status -->
            {{-- <div class="mb-6">
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
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                            {{ ucfirst($status->status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}
            <div class="mb-6">
                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Service <span class="text-red-500">*</span>
                </label>
                <select 
                    name="service_id" 
                    id="service_id" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_id') border-red-500 @enderror" 
                    required>
                    <option value="">Choose a Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ ucfirst($service->service) }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('postalservice.create') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                    Create Record
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
