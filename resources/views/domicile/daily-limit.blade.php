<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daily Page View Limit') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CURRENT STATUS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <div class="p-5 bg-blue-50 rounded-lg border border-blue-200">
                <h3 class="text-sm font-medium text-gray-600">
                    Today's Views
                </h3>

                <p class="text-3xl font-bold text-blue-700 mt-2">
                    {{ $todayViews }}
                </p>
            </div>

            <div class="p-5 bg-green-50 rounded-lg border border-green-200">
                <h3 class="text-sm font-medium text-gray-600">
                    Current Daily Limit
                </h3>

                <p class="text-3xl font-bold text-green-700 mt-2">
                    {{ $currentLimit }}
                </p>
            </div>

        </div>

        {{-- UPDATE FORM --}}
        <form method="POST" action="{{ route('daily.limit.update') }}">
            @csrf

            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Update Daily Limit
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium">
                        New Limit
                    </label>

                    <input type="number"
                           name="limit"
                           min="1"
                           value="{{ old('limit', $currentLimit) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           placeholder="Enter new limit">
                </div>

            </div>

            {{-- ACTION BUTTON --}}
            <div class="flex justify-between mt-6">

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Limit
                </button>

            </div>

        </form>

    </div>
    <script>
        setInterval(function () {
            location.reload();
        }, 300000); // 300000 ms = 5 minutes
    </script>

</x-app-layout>