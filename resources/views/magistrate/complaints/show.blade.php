<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">

                <h2 class="text-3xl font-bold text-gray-800">

                    Complaint #{{ $complaint->id }}

                </h2>

            </div>

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Complaint Image --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-4">

                        Complaint Image

                    </h3>

                    <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                         class="w-full rounded-xl border object-cover">

                </div>

                {{-- Resolution Image --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-4">

                        Resolution Image

                    </h3>

                    @if($complaint->after_image)

                        <img src="{{ asset('storage/complaints/'.$complaint->after_image) }}"
                             class="w-full rounded-xl border object-cover">

                    @else

                        <div class="flex items-center justify-center h-64 border rounded-xl bg-gray-50">

                            <span class="text-gray-500">

                                Resolution image not uploaded yet

                            </span>

                        </div>

                    @endif

                </div>

            </div>

            {{-- Complaint Details --}}
            <div class="bg-white shadow rounded-xl p-6 mt-6">

                <h3 class="text-xl font-bold text-gray-800 mb-6">

                    Complaint Details

                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <div class="mb-4">

                            <span class="font-semibold text-gray-700">

                                Operator:

                            </span>

                            <div class="text-gray-800 mt-1">

                                {{ $complaint->operator->name ?? '-' }}

                            </div>

                        </div>

                        <div class="mb-4">

                            <span class="font-semibold text-gray-700">

                                Sub Division:

                            </span>

                            <div class="text-gray-800 mt-1">

                                {{ $complaint->subDivision->name ?? '-' }}

                            </div>

                        </div>

                        <div class="mb-4">

                            <span class="font-semibold text-gray-700">

                                Police Station:

                            </span>

                            <div class="text-gray-800 mt-1">

                                {{ $complaint->policeStation->name ?? '-' }}

                            </div>

                        </div>

                    </div>

                    <div>

                        <div class="mb-4">

                            <span class="font-semibold text-gray-700">

                                Status:

                            </span>

                            <div class="mt-2">

                                @php

                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'assigned' => 'bg-blue-100 text-blue-700',
                                        'resolved' => 'bg-purple-100 text-purple-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'disposed' => 'bg-gray-100 text-gray-700',
                                    ];

                                @endphp

                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-700' }}">

                                    {{ ucfirst($complaint->status) }}

                                </span>

                            </div>

                        </div>

                        <div class="mb-4">

                            <span class="font-semibold text-gray-700">

                                Submitted At:

                            </span>

                            <div class="text-gray-800 mt-1">

                                {{ $complaint->created_at->format('d M Y h:i A') }}

                            </div>

                        </div>

                        @if($complaint->google_map_link)

                            <div class="mt-4">

                                <a href="{{ $complaint->google_map_link }}"
                                   target="_blank"
                                   class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg">

                                    Open Location

                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Operator Remarks --}}
            @if($complaint->operator_remarks)

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-4">

                        Operator Remarks

                    </h3>

                    <p class="text-gray-700 leading-relaxed">

                        {{ $complaint->operator_remarks }}

                    </p>

                </div>

            @endif

            {{-- AC Remarks --}}
            @if($complaint->ac_remarks)

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-4">

                        AC Remarks

                    </h3>

                    <p class="text-gray-700 leading-relaxed">

                        {{ $complaint->ac_remarks }}

                    </p>

                </div>

            @endif

            {{-- Resolve Form --}}
            @if(in_array($complaint->status, ['assigned', 'rejected']))

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold text-gray-800 mb-6">

                        Upload Resolution

                    </h3>

                    @if ($errors->any())

                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

                            <ul class="list-disc pl-5">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('magistrate.complaints.resolve', $complaint->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- Resolution Image --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Resolution Image

                            </label>

                            <input type="file"
                                   name="after_image"
                                   accept="image/*"
                                   capture="environment"
                                   required
                                   class="w-full border border-gray-300 rounded-lg p-2">

                        </div>

                        {{-- Remarks --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Remarks

                            </label>

                            <textarea name="magistrate_remarks"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>

                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                            Mark As Resolved

                        </button>

                    </form>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>