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

            {{-- Images --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Before --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold mb-4 text-gray-800">

                        Complaint Image

                    </h3>

                    <img src="{{ asset('storage/complaints/'.$complaint->before_image) }}"
                         class="w-full rounded-xl border">

                </div>

                {{-- After --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-xl font-bold mb-4 text-gray-800">

                        Resolution Image

                    </h3>

                    @if($complaint->after_image)

                        <img src="{{ asset('storage/complaints/'.$complaint->after_image) }}"
                             class="w-full rounded-xl border">

                    @else

                        <div class="h-64 flex items-center justify-center border rounded-xl bg-gray-50 text-gray-500">

                            Resolution image not uploaded yet

                        </div>

                    @endif

                </div>

            </div>

            {{-- Details --}}
            <div class="bg-white shadow rounded-xl p-6 mt-6">

                <h3 class="text-xl font-bold mb-6 text-gray-800">

                    Complaint Details

                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <p class="mb-4">

                            <span class="font-semibold">
                                Operator:
                            </span>

                            {{ $complaint->operator->name ?? '-' }}

                        </p>

                        <p class="mb-4">

                            <span class="font-semibold">
                                AC:
                            </span>

                            {{ $complaint->ac->name ?? '-' }}

                        </p>

                        <p class="mb-4">

                            <span class="font-semibold">
                                Magistrate:
                            </span>

                            {{ $complaint->magistrate->name ?? '-' }}

                        </p>

                    </div>

                    <div>

                        <p class="mb-4">

                            <span class="font-semibold">
                                Sub Division:
                            </span>

                            {{ $complaint->subDivision->name ?? '-' }}

                        </p>

                        <p class="mb-4">

                            <span class="font-semibold">
                                Police Station:
                            </span>

                            {{ $complaint->policeStation->name ?? '-' }}

                        </p>

                        <p class="mb-4">

                            <span class="font-semibold">
                                Status:
                            </span>

                            {{ ucfirst($complaint->status) }}

                        </p>

                    </div>

                </div>

                {{-- Location --}}
                @if($complaint->google_map_link)

                    <div class="mt-6">

                        <a href="{{ $complaint->google_map_link }}"
                           target="_blank"
                           class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">

                            Open Complaint Location

                        </a>

                    </div>

                @endif

            </div>

            {{-- Remarks --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                {{-- Operator --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-lg font-bold mb-4 text-gray-800">

                        Operator Remarks

                    </h3>

                    <p class="text-gray-700">

                        {{ $complaint->operator_remarks ?? 'No remarks.' }}

                    </p>

                </div>

                {{-- Magistrate --}}
                <div class="bg-white shadow rounded-xl p-6">

                    <h3 class="text-lg font-bold mb-4 text-gray-800">

                        Magistrate Remarks

                    </h3>

                    <p class="text-gray-700">

                        {{ $complaint->magistrate_remarks ?? 'No remarks.' }}

                    </p>

                </div>

            </div>

            {{-- Disposal --}}
            @if($complaint->status == 'approved')

                <div class="bg-white shadow rounded-xl p-6 mt-6">

                    <h3 class="text-xl font-bold mb-6 text-gray-800">

                        Final Disposal

                    </h3>

                    <form action="{{ route('adcg.complaints.dispose', $complaint->id) }}"
                          method="POST">

                        @csrf

                        <div class="mb-5">

                            <label class="block mb-2 font-medium text-gray-700">

                                ADCG Remarks

                            </label>

                            <textarea name="admin_remarks"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>

                        </div>

                        <button type="submit"
                                class="bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-lg">

                            Dispose Complaint

                        </button>

                    </form>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>