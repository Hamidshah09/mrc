<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">

                Magistrate Dashboard

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Assigned --}}
                <div class="bg-blue-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-blue-700">

                        Assigned

                    </h3>

                    <p class="text-4xl font-bold mt-3">

                        {{ $pendingCount }}

                    </p>

                </div>

                {{-- Resolved --}}
                <div class="bg-purple-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-purple-700">

                        Resolved

                    </h3>

                    <p class="text-4xl font-bold mt-3">

                        {{ $resolvedCount }}

                    </p>

                </div>

                {{-- Approved --}}
                <div class="bg-green-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-green-700">

                        Approved

                    </h3>

                    <p class="text-4xl font-bold mt-3">

                        {{ $approvedCount }}

                    </p>

                </div>

                {{-- Rejected --}}
                <div class="bg-red-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-red-700">

                        Rejected

                    </h3>

                    <p class="text-4xl font-bold mt-3">

                        {{ $rejectedCount }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>