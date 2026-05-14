<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Domicile Applicants') }}
        </h2>
    </x-slot>
    
    
    <div class="max-w-7xl bg-white mt-3 shadow-md rounded-lg mx-auto overflow-hidden">
        <div class="px-4 py-3 border-b bg-white flex justify-end items-center">
            <a href="{{route('domicile.create')}}" class="inline-flex items-center px-4 py-2 bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New Applicant</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
         {{-- Filter Form --}}
        <div class="px-4 py-3 border-b bg-white">
            <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                <div>
                    <label class="text-sm text-gray-600">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Name, CNIC or ID">
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
        <div class="w-full overflow-x-auto">
            <table class="w-full divide-gray-200 mx-2">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Application Date</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Applicant Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">CNIC</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Contact</th>
                        <th class="px-2 py-3 text-left text-sm font-semibold text-gray-700 text-center">Other Dist status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($records as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $record->id }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ optional($record->created_at)->format('d-m-Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $record->first_name }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $record->cnic }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $record->contact }}</td>
                            <td class="px-2 py-4 text-center">

                                <div class="flex justify-center items-center">

                                    @if($record->other_district_status === 1)

                                        <x-solar-danger-triangle-line-duotone
                                            class="h-6 w-6 text-red-500"
                                            title="Found in Other District"/>

                                    @elseif($record->other_district_status === 0)

                                        <x-heroicon-o-check-circle
                                            class="h-6 w-6 text-green-500"
                                            title="No Record Found"/>

                                    @else

                                        <x-solar-question-circle-linear
                                            class="h-6 w-6 text-gray-500"
                                            title="Not Checked"/>

                                    @endif

                                </div>

                            </td>

                            <td class="px-4 py-4 text-sm">

                                <div class="flex justify-center items-center gap-3">

                                    <a href="{{route('domicile.edit',$record->id)}}">

                                        <x-heroicon-s-pencil
                                            title="Edit"
                                            class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/>

                                    </a>

                                    <a href="{{route('domicile.form_p',$record->id)}}">

                                        <x-heroicon-s-document-check
                                            title="Issue Letter"
                                            class="w-7 h-7 text-green-400 hover:text-green-600 transition"/>

                                    </a>

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mx-6 my-3">
                {{$records->links()}}
            </div>
        </div>
    </div>

</x-app-layout>
