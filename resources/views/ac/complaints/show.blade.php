<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6">

                <h2 class="text-3xl font-bold text-gray-800">

                    Complaint #{{ $complaint->id }}

                </h2>

            </div>

            {{-- Success --}}
            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Before Image --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold mb-4 text-gray-800">

                        Complaint Image

                    </h3>

                    <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                         class="w-full rounded-xl border">

                </div>

                {{-- After Image --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold mb-4 text-gray-800">

                        Resolution Image

                    </h3>

                    @if($complaint->after_image)

                        <img src="{{ asset('storage/complaints/'.$complaint->after_image) }}"
                             class="w-full rounded-xl border">

                    @else

                        <div class="text-gray-500">

                            Resolution image not uploaded yet.

                        </div>

                    @endif

                </div>

            </div>

            {{-- Complaint Details --}}
            <div class="bg-white shadow rounded-xl p-6 mt-6">

                <h3 class="text-xl font-bold mb-6 text-gray-800">

                    Complaint Details

                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <p class="mb-3">

                            <span class="font-semibold">
                                Operator:
                            </span>

                            {{ $complaint->operator->name ?? '-' }}

                        </p>

                        <p class="mb-3">

                            <span class="font-semibold">
                                Sub Division:
                            </span>

                            {{ $complaint->subDivision->name ?? '-' }}

                        </p>

                        <p class="mb-3">

                            <span class="font-semibold">
                                Police Station:
                            </span>

                            {{ $complaint->policeStation->name ?? '-' }}

                        </p>

                    </div>

                    <div>

                        <p class="mb-3">

                            <span class="font-semibold">
                                Status:
                            </span>

                            {{ ucfirst($complaint->status) }}

                        </p>

                        <p class="mb-3">

                            <span class="font-semibold">
                                Submitted:
                            </span>

                            {{ $complaint->created_at->format('d M Y h:i A') }}

                        </p>

                        @if($complaint->google_map_link)

                            <a href="{{ $complaint->google_map_link }}"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">

                                Open Location

                            </a>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Operator Remarks --}}
            @if($complaint->operator_remarks)

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold mb-4 text-gray-800">

                        Operator Remarks

                    </h3>

                    <p class="text-gray-700">

                        {{ $complaint->operator_remarks }}

                    </p>

                </div>

            @endif

            {{-- Assign Magistrate --}}
            @if(in_array($complaint->status, ['pending', 'assigned', 'rejected']))

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold mb-6 text-gray-800">

                        Assign Magistrate

                    </h3>

                    <form action="{{ route('ac.complaints.assign', $complaint->id) }}"
                          method="POST">

                        @csrf

                        {{-- Magistrate --}}
                        @if($complaint->magistrate)

                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">

                                <p class="text-sm text-blue-700">

                                    <span class="font-semibold">
                                        Currently Assigned To:
                                    </span>

                                    {{ $complaint->magistrate->name }}

                                </p>

                            </div>

                        @endif
                        <div class="mb-5">

                            <label class="block mb-2 font-medium text-gray-700">

                                Select Magistrate

                            </label>

                            <select name="magistrate_id"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm">

                                <option value="">
                                    Select Magistrate
                                </option>

                                @foreach($magistrates as $magistrate)

                                    <option value="{{ $magistrate->id }}">

                                        {{ $magistrate->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Remarks --}}
                        <div class="mb-5">

                            <label class="block mb-2 font-medium text-gray-700">

                                Remarks

                            </label>

                            <textarea name="ac_remarks"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>

                        </div>

                        {{-- Button --}}
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                            Assign Complaint

                        </button>

                    </form>

                </div>

            @endif

            {{-- Approve / Reject --}}
            @if($complaint->status == 'resolved')

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold mb-6 text-gray-800">

                        Resolution Decision

                    </h3>

                    <div class="flex flex-col md:flex-row gap-4">

                        {{-- Approve --}}
                        <form action="{{ route('ac.complaints.approve', $complaint->id) }}"
                              method="POST">

                            @csrf

                            <textarea name="ac_remarks"
                                      placeholder="Approval remarks"
                                      rows="3"
                                      class="w-full border-gray-300 rounded-lg shadow-sm mb-3"></textarea>

                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                                Approve Complaint

                            </button>

                        </form>

                        {{-- Reject --}}
                        <form action="{{ route('ac.complaints.reject', $complaint->id) }}"
                              method="POST">

                            @csrf

                            <textarea name="ac_remarks"
                                      placeholder="Rejection remarks"
                                      rows="3"
                                      required
                                      class="w-full border-gray-300 rounded-lg shadow-sm mb-3"></textarea>

                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg">

                                Reject Complaint

                            </button>

                        </form>

                    </div>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>