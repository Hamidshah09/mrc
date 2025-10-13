<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Employee Picture --}}
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $employee->pic) }}"
                             alt="Employee Picture"
                             class="w-36 h-auto rounded shadow">
                    </div>

                    {{-- Update Form --}}
                    <form method="POST" action="{{ route('Employee.update', $employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            {{-- CNIC --}}
                            <div>
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="mt-1 block w-full"
                                              type="text" name="cnic"
                                              :value="old('cnic', $employee->cnic)" required autofocus />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>

                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Employee Name')" />
                                <x-text-input id="name" class="mt-1 block w-full"
                                              type="text" name="name"
                                              :value="old('name', $employee->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Father Name --}}
                            <div>
                                <x-input-label for="father_name" :value="__('Father Name')" />
                                <x-text-input id="father_name" class="mt-1 block w-full"
                                              type="text" name="father_name"
                                              :value="old('father_name', $employee->father_name)" required />
                                <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                            </div>

                            {{-- Date of Birth --}}
                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="mt-1 block w-full"
                                              type="date" name="date_of_birth"
                                              :value="old('date_of_birth', $employee->date_of_birth)" required />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            {{-- Date of Joining --}}
                            <div>
                                <x-input-label for="date_of_joining" :value="__('Date of Joining')" />
                                <x-text-input id="date_of_joining" class="mt-1 block w-full"
                                              type="date" name="date_of_joining"
                                              :value="old('date_of_joining', $employee->date_of_joining)" required />
                                <x-input-error :messages="$errors->get('date_of_joining')" class="mt-2" />
                            </div>

                            {{-- Designation --}}
                            <div>
                                <x-input-label for="designation_id" :value="__('Designation')" />
                                <select name="designation_id" id="designation_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                            @if ($employee->designation_id == $designation->id) selected @endif>
                                            {{ $designation->designation }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('designation_id')" class="mt-2" />
                            </div>

                            {{-- Department --}}
                            <div>
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select name="department_id" id="department_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            @if ($employee->department_id == $department->id) selected @endif>
                                            {{ $department->department }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            {{-- Employee Status --}}
                            <div>
                                <x-input-label for="emp_type_id" :value="__('Employee Status')" />
                                <select name="emp_type_id" id="emp_type_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1" @if($employee->emp_type_id == 1) selected @endif>Daily Wages</option>
                                    <option value="2" @if($employee->emp_type_id == 2) selected @endif>Regular</option>
                                </select>
                                <x-input-error :messages="$errors->get('emp_type_id')" class="mt-2" />
                            </div>

                            {{-- Employee Pic --}}
                            <div>
                                <x-input-label for="pic" :value="__('Employee Picture')" />
                                <x-text-input type="file" id="pic" name="pic"
                                              class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>

                    {{-- Cards History --}}
                    <hr class="my-6">
                    <h1 class="text-2xl font-bold py-2">Cards History</h1>
                    <div class="overflow-x-auto">
                        <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="border px-4 py-2">Card No</th>
                                    <th class="border px-4 py-2">Date of Issue</th>
                                    <th class="border px-4 py-2">Expiry Date</th>
                                    <th class="border px-4 py-2">Issued By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee_cards as $card)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $card->card_no }}</td>
                                        <td class="border px-4 py-2">{{ $card->issue_date }}</td>
                                        <td class="border px-4 py-2">
                                            {{ $card->expiry_date ?? 'Till Service' }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{-- Uncomment if relationship works --}}
                                            {{-- {{ $card->users->name ?? '' }} --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
