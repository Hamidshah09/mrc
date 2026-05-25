<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

            {{ __('Edit User') }}

        </h2>

    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">

        {{-- Success Message --}}
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                {{ session('success') }}

            </div>

        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <div class="font-bold mb-2">

                    Please fix the following errors:

                </div>

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form method="POST"
              action="{{ route('users.update', $user->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {{-- CNIC --}}
                <div>

                    <x-input-label for="cnic" :value="__('CNIC')" />

                    <x-text-input
                        id="cnic"
                        name="cnic"
                        type="text"
                        maxlength="13"
                        class="block mt-1 w-full"
                        :value="old('cnic', $user->cnic)"
                    />

                    <x-input-error :messages="$errors->get('cnic')" class="mt-2" />

                </div>

                {{-- Name --}}
                <div>

                    <x-input-label for="name" :value="__('Full Name')" />

                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="block mt-1 w-full"
                        :value="old('name', $user->name)"
                        required
                    />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                </div>

                {{-- Father Name --}}
                <div>

                    <x-input-label for="father_name" :value="__('Father Name')" />

                    <x-text-input
                        id="father_name"
                        name="father_name"
                        type="text"
                        class="block mt-1 w-full"
                        :value="old('father_name', $user->father_name)"
                    />

                    <x-input-error :messages="$errors->get('father_name')" class="mt-2" />

                </div>

                {{-- DOB --}}
                <div>

                    <x-input-label for="dob" :value="__('Date of Birth')" />

                    <x-text-input
                        id="dob"
                        name="dob"
                        type="date"
                        class="block mt-1 w-full"
                        :value="old('dob', $user->dob)"
                    />

                    <x-input-error :messages="$errors->get('dob')" class="mt-2" />

                </div>

                {{-- Mobile --}}
                <div>

                    <x-input-label for="mobile" :value="__('Mobile')" />

                    <x-text-input
                        id="mobile"
                        name="mobile"
                        type="text"
                        maxlength="11"
                        class="block mt-1 w-full"
                        :value="old('mobile', $user->mobile)"
                    />

                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />

                </div>

                {{-- Address --}}
                <div class="sm:col-span-2">

                    <x-input-label for="address" :value="__('Address')" />

                    <x-text-input
                        id="address"
                        name="address"
                        type="text"
                        class="block mt-1 w-full"
                        :value="old('address', $user->address)"
                    />

                    <x-input-error :messages="$errors->get('address')" class="mt-2" />

                </div>

                {{-- Email --}}
                <div>

                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        class="block mt-1 w-full"
                        :value="old('email', $user->email)"
                        required
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                </div>

                {{-- Password --}}
                <div>

                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block mt-1 w-full"
                        autocomplete="new-password"
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>

                {{-- Confirm Password --}}
                <div>

                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="block mt-1 w-full"
                        autocomplete="new-password"
                    />

                </div>

                {{-- Role --}}
                <div>

                    <x-input-label for="role_id" :value="__('Role')" />

                    <select
                        name="role_id"
                        id="role_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">

                        @foreach ($roles as $role)

                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>

                                {{ ucfirst($role->role) }}

                            </option>

                        @endforeach

                    </select>

                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />

                </div>
                {{-- Sub Division --}}
                <div>

                    <x-input-label for="sub_division_id" :value="__('sub_division_id')" />

                    <select
                        name="sub_division_id"
                        id="sub_division_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">

                        @foreach ($subDivisions as $subDivision)

                            <option value="{{ $subDivision->id }}"
                                {{ old('sub_division_id', $user->sub_division_id) == $subDivision->id ? 'selected' : '' }}>

                                {{ ucfirst($subDivision->name) }}

                            </option>

                        @endforeach

                    </select>

                    <x-input-error :messages="$errors->get('sub_division_id')" class="mt-2" />

                </div>
                {{-- Police Station --}}
                <div>

                    <x-input-label for="policestation_id" :value="__('policestation_id')" />

                    <select
                        name="policestation_id"
                        id="policestation_id"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                        @foreach ($policestations as $policestation)

                            <option value="{{ $policestation->id }}"
                                {{ old('policestation_id', $user->policestation_id) == $policestation->id ? 'selected' : '' }}>

                                {{ ucfirst($policestation->name) }}

                            </option>
                            
                        @endforeach


                    </select>

                    <x-input-error :messages="$errors->get('policestation_id')" class="mt-2" />

                </div>

                        
                {{-- Status --}}
                <div>

                    <x-input-label for="status" :value="__('Status')" />

                    <select
                        name="status"
                        id="status"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">

                        <option value="Active"
                            {{ old('status', $user->status) == 'Active' ? 'selected' : '' }}>

                            Active

                        </option>

                        <option value="Not active"
                            {{ old('status', $user->status) == 'Not active' ? 'selected' : '' }}>

                            Not Active

                        </option>

                    </select>

                    <x-input-error :messages="$errors->get('status')" class="mt-2" />

                </div>



                {{-- Profile Image --}}
                <div>

                    <x-input-label for="profile_image" :value="__('Profile Image')" />

                    <x-text-input
                        id="profile_image"
                        name="profile_image"
                        type="file"
                        class="block mt-1 w-full"
                    />

                    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />

                </div>

            </div>

            {{-- Current Image Preview --}}
            @if($user->profile_image)

                <div class="mt-6">

                    <p class="text-sm font-semibold text-gray-700 mb-2">

                        Current Profile Image

                    </p>

                    <img src="{{ asset('storage/'.$user->profile_image) }}"
                         class="w-32 h-32 rounded-xl object-cover border shadow">

                </div>

            @endif

            {{-- Submit --}}
            <div class="flex flex-col sm:flex-row justify-end items-center mt-8 gap-3">

                <x-primary-button class="w-full sm:w-auto justify-center">

                    {{ __('Update User') }}

                </x-primary-button>

            </div>

        </form>

    </div>

</x-app-layout>