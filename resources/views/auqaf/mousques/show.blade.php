<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mosque Details
            </h2>

            <a href="{{ route('mousques.edit', $mousque->id) }}"
               class="bg-green-600 text-white px-4 py-2 rounded text-sm">
                Edit Mosque
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded mt-10 space-y-10">

        {{-- ===================== MOSQUE DETAILS ===================== --}}
        <div>
            <div class="bg-blue-50 border-l-4 border-blue-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-blue-900">Mosque Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div><strong>Name:</strong> {{ $mousque->name }}</div>
                <div><strong>Sector:</strong> {{ $mousque->sector->name ?? '—' }}</div>
                <div><strong>Sub Sector:</strong> {{ $mousque->sub_sector ?? '—' }}</div>

                <div><strong>Sect:</strong> {{ $mousque->sect ?? '—' }}</div>
                <div><strong>Status:</strong>
                    <span class="px-2 py-1 text-xs rounded {{ $mousque->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $mousque->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div><strong>Location:</strong> {{ $mousque->location ?? '—' }}</div>

                <div class="md:col-span-3">
                    <strong>Address:</strong>
                    <p class="text-gray-700 mt-1">{{ $mousque->address ?? '—' }}</p>
                </div>
            </div>
        </div>
        {{-- MOUSQUE MAP LOCATION--}}
        {{-- ===================== MAP LOCATION ===================== --}}
        <div>
            <div class="bg-red-50 border-l-4 border-red-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-red-900">Location Map</h3>
            </div>

            @if($mousque->location)
                <div class="max-w-md border rounded shadow-sm overflow-hidden">
                    <iframe
                        src="{{ $mousque->location }}"
                        class="w-full h-64 border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <div class="p-3 bg-gray-50 text-sm flex justify-between items-center">
                        <span class="text-gray-600">Google Maps</span>

                        <a href="{{ $mousque->location }}"
                        target="_blank"
                        class="text-blue-600 hover:underline">
                            Open in Maps
                        </a>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500">Location not available.</p>
            @endif
        </div>

        {{-- ===================== MOSQUE IMAGES ===================== --}}
        <div>
            <div class="bg-indigo-50 border-l-4 border-indigo-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-indigo-900">Mosque Pictures</h3>
            </div>

            @if($mousque->images->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($mousque->images as $image)
                        <div class="border rounded shadow-sm overflow-hidden">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                 class="w-full h-48 object-cover"
                                 alt="Mosque Image">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No images available.</p>
            @endif
        </div>

        {{-- ===================== OFFICIALS ===================== --}}
        <div>
            <div class="bg-purple-50 border-l-4 border-purple-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-purple-900">Officials</h3>
            </div>

            @if($mousque->officials->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($mousque->officials as $official)
                        <div class="border rounded-lg shadow-sm p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-full overflow-hidden border">
                                    @if($official->profile_image)
                                        <img src="{{ asset('storage/' . $official->profile_image) }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                <div class="text-sm">
                                    <p class="font-semibold">{{ $official->name }}</p>
                                    <p class="text-gray-600">Father: {{ $official->father_name }}</p>
                                    <p class="text-gray-600">cnic: {{ $official->cnic }}</p>
                                    <p class="text-gray-600">Type: {{ $official->type }}</p>
                                    <p class="text-gray-600">Designation: {{ $official->position_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No officials assigned.</p>
            @endif
        </div>

        {{-- ===================== SHOPS ===================== --}}
        <div>
            <div class="bg-green-50 border-l-4 border-green-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-green-900">Shops</h3>
            </div>

            @if($mousque->shops->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($mousque->shops as $shop)
                        <div class="border rounded-lg shadow-sm overflow-hidden bg-white">

                            {{-- Shop Image --}}
                            <div class="h-40 bg-gray-100">
                                @if($shop->shop_image)
                                    <img src="{{ asset('storage/' . $shop->shop_image) }}"
                                        alt="Shop Image"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            {{-- Shop Info --}}
                            <div class="p-4 text-sm space-y-1">
                                <p>
                                    <span class="font-semibold">Occupier:</span>
                                    {{ $shop->occupier_name }}
                                </p>

                                <p>
                                    <span class="font-semibold">Description:</span>
                                    {{ $shop->shop_description }}
                                </p>

                                <p>
                                    <span class="font-semibold">Rent:</span>
                                    Rs. {{ number_format($shop->rent_amount) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No shops registered.</p>
            @endif
        </div>


        {{-- ===================== MADARSA ===================== --}}
        <div>
            <div class="bg-yellow-50 border-l-4 border-yellow-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-yellow-900">Madrassa</h3>
            </div>

            @if($mousque->maddarsa)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm m-2">
                    <div><strong>Name:</strong> {{ $mousque->maddarsa->name }}</div>
                    <div><strong>Students:</strong> {{ $mousque->maddarsa->no_of_students }}</div>
                    <div><strong>Mohtamim:</strong> {{ $mousque->maddarsa->mohtamim_name }}</div>
                </div>
            @else
                <p class="text-sm text-gray-500">No madrassa information available.</p>
            @endif
        </div>
        {{-- ===================== UTILITY CONNECTIONS ===================== --}}
        <div>
            <div class="bg-teal-50 border-l-4 border-teal-600 px-4 py-3 rounded mb-4">
                <h3 class="text-lg font-semibold text-teal-900">Utility Connections</h3>
            </div>

            @if($mousque->utilities->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($mousque->utilities as $utility)
                        <div class="border rounded-lg p-4 shadow-sm text-sm">
                            <p class="mb-1">
                                <strong>Utility:</strong>
                                <span class="px-2 py-1 text-xs rounded bg-gray-100">
                                    {{ $utility->utility_type }}
                                </span>
                            </p>

                            <p class="mb-1">
                                <strong>Reference #:</strong>
                                {{ $utility->reference_number }}
                            </p>

                            <p>
                                <strong>Beneficiary:</strong>
                                {{ $utility->benificiary_type }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">
                    No utility connections available.
                </p>
            @endif
        </div>


    </div>
</x-app-layout>
