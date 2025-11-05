<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Grid: Single column on mobile, two on md+ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

                <!-- CNIC -->
                <div>
                    <x-input-label for="cnic" :value="__('CNIC')" />
                    <x-text-input id="cnic" name="cnic" type="text" maxlength="13" class="block mt-1 w-full"
                                :value="old('cnic', $user->cnic)" required />
                    <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                </div>

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full"
                                :value="old('name', $user->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Father Name -->
                <div>
                    <x-input-label for="father_name" :value="__('Father Name')" />
                    <x-text-input id="father_name" name="father_name" type="text" class="block mt-1 w-full"
                                :value="old('father_name', $user->father_name)" required />
                    <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-input-label for="dob" :value="__('Date of Birth')" />
                    <x-text-input id="dob" name="dob" type="date" class="block mt-1 w-full"
                                :value="old('dob', $user->dob)" required />
                    <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                </div>

                <!-- Mobile -->
                <div>
                    <x-input-label for="mobile" :value="__('Mobile')" />
                    <x-text-input id="mobile" name="mobile" type="text" maxlength="11" class="block mt-1 w-full"
                                :value="old('mobile', $user->mobile)" required />
                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="block mt-1 w-full"
                                :value="old('address', $user->address)" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="block mt-1 w-full"
                                :value="old('email', $user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="block mt-1 w-full"
                                autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                class="block mt-1 w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select name="role" id="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ $user->role->role === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                        @if ($user->status === 'Active')
                            <option value="Active" selected>Active</option>
                            <option value="Not active">Not Active</option>

                        @elseif ($user->status === 'Not active')
                            <option value="Active">Active</option>
                            <option value="Not active" selected>Not Active</option>
                        @endif
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <!-- Profile Image -->
                <div>
                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                    <x-text-input id="profile_image" name="profile_image" type="file" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                </div>



            </div>

            <!-- Submit Row -->
            <div class="flex flex-col sm:flex-row justify-end items-center mt-6 gap-2">
                <x-primary-button class="w-full sm:w-auto">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
