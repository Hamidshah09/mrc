<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <h2 class="text-3xl font-bold text-gray-800">

                    Office Letters

                </h2>

            </div>

            <div class="px-4 py-3 border-b bg-white flex justify-end items-center">
                <a href="{{route('domicile.office_letters.create')}}" class="inline-flex items-center px-4 py-2 bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New Letter</a>
            </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            {{-- errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                
            @endif
            {{-- Filter Form --}}
            <div class="px-4 py-3 border-b bg-white">
                <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                    <div>
                        <label class="text-sm text-gray-600">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Subject, Letter to or Dispatch No">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
                        <a href="{{ url()->current() }}" class="px-3 py-2 bg-gray-300 rounded">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-100">

                            <tr>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    ID
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Letter Date
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Subject
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Letter to
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Dispatch No
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Created At
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($letters as $letter)

                                <tr>

                                    {{-- ID --}}
                                    <td class="px-4 py-4">

                                        #{{ $letter->id }}

                                    </td>

                                    {{-- Image --}}
                                    <td class="px-4 py-4">

                                        {{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->format('d-m-Y') : '' }}

                                    </td>

                                    {{-- Sub Division --}}
                                    <td class="px-4 py-4">

                                        {{ $letter->subject }}

                                    </td>

                                    {{-- Police Station --}}
                                    <td class="px-4 py-4">

                                        {{ $letter->letter_to }}

                                    </td>

                                    {{-- AC --}}
                                    <td class="px-4 py-4">

                                        {{ $letter->dispatchDiary->Dispatch_No ?? 'N/A' }}

                                    </td>

                                    {{-- Magistrate --}}
                                    <td class="px-4 py-4">

                                        {{ optional($letter->created_at)->format('d-m-Y H:i') ?? '' }}

                                    </td>

                                    

                                    {{-- Action --}}
                                    <td class="px-4 py-4">

                                        <a href="{{ route('domicile.office_letters.edit', $letter->id) }}"
                                           >
                                           <x-heroicon-s-pencil
                                            title="Edit"
                                            class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/> 
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="px-4 py-8 text-center text-gray-500">

                                        No letters found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                <div class="p-4 overflow-x-auto">

                    {{ $letters->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>