<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="back-width mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                    <form action="{{route('Employee.index')}}" method="GET" class="mt-3">
                        <div class="flex flex-row flex-wrap items-center">
                            <x-text-input id="search" class="mt-1 w-48 p-2 mx-2" type="text" name="search" value="{{ old('search') }}" autofocus autocomplete="cnic" />
                            <select name="search_type" id="search_type" class= "w-48 mt-1 border-gray-600 focus:ring-indigo-500  rounded-md shadow-sm" autofocus autocomplete="gender">
                                <option value="cnic" {{ old('search_type') == 'cnic' ? 'selected' : '' }}>CNIC </option> 
                                <option value="name" {{ old('search_type') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="id" {{ old('search_type') == 'id' ? 'selected' : '' }}>id</option> 
                            </select>
                            <x-primary-button class="mt-1 ms-3" type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                            
                        </div>
                    </form>
                    <a href="{{route('Employee.create')}}" class="mt-3 mr-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New</a>                            
                </div>
                 @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="hidden px-4 md:block overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Id</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">CNIC</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Father Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Designation</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Date of Birth</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Date of Joining</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->cnic }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->father_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->designations->designation }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->departments->department}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->date_of_birth}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $employee->date_of_joining}}</td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('Employee.edit', $employee->id) }}" class="text-blue-600 hover:text-blue-800">
                                                <x-icons.pencil-square />
                                            </a>
                                            @if(file_exists(public_path('\\cards\\'. $employee->name."_".$employee->id.".png")))
                                                <a href="{{asset('/cards/'. $employee->name.'_'.$employee->id.'.png')}}" title="View Card">
                                                    <x-icons.image />
                                                </a>
                                            @endif
                                            <a href="{{route('issueCard', $employee->id)}}" title="Issue Card">
                                                <x-icons.check-circle class="text-green-500 hover:text-green-700" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>