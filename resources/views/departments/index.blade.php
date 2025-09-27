<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="back-width mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded relative mb-4 m-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 m-2">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center space-x-4 m-2 mb-4">
                    <form action="{{route('departments.index')}}" method="GET" class="mt-3">
                        <div class="flex flex-row flex-wrap items-center">
                            <x-text-input id="search" class="mt-1 w-48 p-2 mx-2" type="text" name="search" value="{{ old('search') }}" autofocus autocomplete="search" />
                            <select name="search_type" id="search_type" class= "w-48 mt-1 border-gray-600 focus:ring-indigo-500  rounded-md shadow-sm" autofocus autocomplete="search_type">
                                <option value="departments" {{ old('search_type') == 'department' ? 'selected' : '' }}>Department</option>
                                <option value="id" {{ old('search_type') == 'id' ? 'selected' : '' }}>id</option> 
                            </select>
                            <x-primary-button class="mt-1 ms-3" type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                            
                        </div>
                    </form>
                    <button onclick="openCreateModal()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-300">+ Create New</button>                            
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
                <div class="px-4 md:block overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Id</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Designation</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($departments as $department)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $department->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $department->department }}</td>
                                    <td>
                                        <button onclick="openEditModal({{ $department->id }}, '{{ $department->department }}')" 
                                                class="px-4 py-2 bg-blue-300 rounded hover:bg-blue-500">
                                            ✎ Edit
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="dynamicModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        
        <!-- Inner Modal -->
        <div class="bg-white rounded-2xl shadow-xl w-[95vw] sm:w-[80vw] md:w-[70vw] lg:w-[50vw] max-h-[90vh] overflow-y-auto p-6">
            
            <!-- Modal Title -->
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Create New Record</h2>

            <!-- Modal Form -->
            <form id="modalForm" method="POST" action="">
                @csrf
                <div id="formFields"><!-- Dynamic fields go here --></div>

                <!-- Footer Buttons -->
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                            onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openCreateModal() {
            document.getElementById("modalTitle").innerText = "Create New Department";

            const form = document.getElementById("modalForm");
            form.action = "{{ route('departments.store') }}"; // store route

            // only replace fields
            document.getElementById("formFields").innerHTML = `
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium">Department</label>
                    <input type="text" name="department" id="department" class="w-full border rounded p-2 mt-1">
                </div>
            `;

            document.getElementById("dynamicModal").classList.remove("hidden");
        }

        function openEditModal(id, nameValue) {
            document.getElementById("modalTitle").innerText = "Edit Designation";

            const form = document.getElementById("modalForm");
            form.action = "{{ url('department') }}/" + id; // update route

            document.getElementById("formFields").innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-4">
                    <label class="block text-sm font-medium">Departments</label>
                    <input type="text" name="department" id="department" class="w-full border rounded p-2 mt-1" value="${nameValue}">
                </div>
            `;

            document.getElementById("dynamicModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("dynamicModal").classList.add("hidden");
        }
    </script>
</x-app-layout>
