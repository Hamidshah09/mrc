<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">

                AC Dashboard

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Pending --}}
                <div class="bg-yellow-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-yellow-700">
                        Pending
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $pendingCount }}
                    </p>

                </div>

                {{-- Assigned --}}
                <div class="bg-blue-100 p-6 rounded-xl shadow">

                    <h3 class="text-lg font-semibold text-blue-700">
                        Assigned
                    </h3>

                    <p class="text-4xl font-bold mt-3">
                        {{ $assignedCount }}
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

            </div>

        </div>

    </div>

</x-app-layout>