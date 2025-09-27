<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Employee') }}
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

                    <form method="POST" action="{{ route('Employee.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Responsive Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            {{-- CNIC --}}
                            <div>
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="mt-1 block w-full"
                                              type="text" name="cnic" :value="old('cnic')" required autofocus />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>

                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Employee Name')" />
                                <x-text-input id="name" class="mt-1 block w-full"
                                              type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Father Name --}}
                            <div>
                                <x-input-label for="father_name" :value="__('Father Name')" />
                                <x-text-input id="father_name" class="mt-1 block w-full"
                                              type="text" name="father_name" :value="old('father_name')" required />
                                <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                            </div>

                            {{-- Date of Birth --}}
                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="mt-1 block w-full"
                                              type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            {{-- Date of Joining --}}
                            <div>
                                <x-input-label for="date_of_joining" :value="__('Date of Joining')" />
                                <x-text-input id="date_of_joining" class="mt-1 block w-full"
                                              type="date" name="date_of_joining" :value="old('date_of_joining')" required />
                                <x-input-error :messages="$errors->get('date_of_joining')" class="mt-2" />
                            </div>

                            {{-- Designation --}}
                            <div>
                                <x-input-label for="designation_id" :value="__('Designation')" />
                                <select name="designation_id" id="designation_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Designation</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
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
                                        <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>

                            {{-- Employee Status --}}
                            <div>
                                <x-input-label for="emp_type_id" :value="__('Employee Status')" />
                                <select name="emp_type_id" id="emp_type_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option selected value="1">Daily Wages</option>
                                    <option value="2">Regular</option>
                                </select>
                                <x-input-error :messages="$errors->get('emp_type_id')" class="mt-2" />
                            </div>

                            {{-- Employee Picture --}}
                            <div>
                                <x-input-label for="pic" :value="__('Employee Picture')" />
                                <x-text-input type="file" id="pic" name="pic"
                                              class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
