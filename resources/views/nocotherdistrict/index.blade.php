<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('NOC to other District Letters') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('noc-other-district.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New Letter</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4 m-2">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 m-2">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center space-x-4 m-2 mb-4">
            <form action="{{route('noc-other-district.index')}}" method="GET" class="mt-3">
                <div class="flex flex-row flex-wrap items-center">
                    <x-text-input id="search" class="mt-1 w-48 p-2 mx-2" type="text" name="search" value="{{ old('search') }}" autofocus autocomplete="cnic" />
                    <select name="search_type" id="search_type" class= "w-48 mt-1 border-gray-600 focus:ring-indigo-500  rounded-md shadow-sm" autofocus autocomplete="gender">
                        <option value="cnic" {{ old('search_type') == 'cnic' ? 'selected' : '' }}>CNIC </option> 
                        <option value="name" {{ old('search_type') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="id" {{ old('search_type') == 'id' ? 'selected' : '' }}>id</option>
                        <option value="dispatch_no" {{ old('search_type') == 'dispatch_no' ? 'selected' : '' }}>Dispatch_No</option> 
                    </select>
                    <label for="from_date" class="mt-1 p-2">From</label>
                    <x-text-input id="from_date" class="mt-1 w-48 p-2 mx-2" type="date" name="from_date" value="{{ old('from_date') }}" autofocus autocomplete="from_date" />
                    <label for="to_date" class="mt-1 p-2">To</label>
                    <x-text-input id="to_date" class="mt-1 w-48 p-2 mx-2" type="date" name="to_date" value="{{ old('to_date') }}" autofocus autocomplete="to_date" />
                    <x-primary-button class="mt-1 ms-3" type="submit">
                        {{ __('Search') }}
                    </x-primary-button>
                    
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Letter Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dispatch No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sent To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant CNIC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NITB Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($letters as $letter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_ID }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->Letter_Date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->dispatchDiary->Dispatch_No ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->NOC_Issued_To }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->applicants[0]->CNIC ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $letter->applicants[0]->Applicant_Name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">

                            @if($letter->nitb_status === 1)

                                <x-heroicon-o-exclamation-circle class="w-7 h-7 text-red-400" />
                                

                            @elseif($letter->nitb_status === 0)

                               <x-elusive-ok-circle class="w-7 h-7 text-green-400"/>

                            @else

                                {{-- Unknown --}}
                                <x-heroicon-o-question-mark-circle class="w-7 h-7 text-gray-400" />

                            @endif

                        </td>
                        <td class="px-6 py-4 flex flex-row space-between">
                            <a href="{{ route('noc-other-district.edit', $letter->Letter_ID) }}" ><x-heroicon-s-pencil title="Edit" class="w-7 h-7 text-indigo-400 hover:text-indigo-600 transition"/></a>
                            <a href="{{ route('noc-other-district.letter', $letter->Letter_ID) }}" ><x-heroicon-s-document-check title="Issue Letter" class="w-7 h-7 text-green-400 hover:text-green-600 transition"/></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center">No letters found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $letters->links() }}
        </div>
    </div>
</x-app-layout>
