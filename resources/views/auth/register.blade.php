<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200 py-10 px-4">
        <div class="w-full max-w-6xl bg-white shadow-2xl rounded-2xl p-8 md:p-12">

            <!-- Page Title -->
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8">
                {{ __('User Registration Form') }}
            </h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    <!-- CNIC -->
                    <div>
                        <x-input-label for="cnic" :value="__('CNIC')" />
                        <x-text-input id="cnic" name="cnic" type="text" maxlength="13" class="block mt-1 w-full" :value="old('cnic')" required />
                        <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Father Name -->
                    <div>
                        <x-input-label for="father_name" :value="__('Father Name')" />
                        <x-text-input id="father_name" name="father_name" type="text" class="block mt-1 w-full" :value="old('father_name')" required />
                        <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <x-input-label for="dob" :value="__('Date of Birth')" />
                        <x-text-input id="dob" name="dob" type="date" class="block mt-1 w-full" :value="old('dob')" required />
                        <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                    </div>

                    <!-- Mobile -->
                    <div>
                        <x-input-label for="mobile" :value="__('Mobile')" />
                        <x-text-input id="mobile" name="mobile" type="text" maxlength="11" class="block mt-1 w-full" :value="old('mobile')" required />
                        <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                    </div>

                    <!-- Address -->
                    <div class="sm:col-span-2 lg:col-span-2 xl:col-span-2">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" name="address" type="text" class="block mt-1 w-full" :value="old('address')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- License Number -->
                    <div>
                        <x-input-label for="license_number" :value="__('License Number')" />
                        <x-text-input id="license_number" name="license_number" type="text" maxlength="10" class="block mt-1 w-full" :value="old('license_number')" required />
                        <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <x-input-label for="profile_image" :value="__('Profile Image')" />
                        <x-text-input id="profile_image" name="profile_image" type="file" class="block mt-1 w-full" />
                        <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                    </div>

                </div>

                <!-- Submit Row -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600 underline">
                        {{ __('Already registered? Login here') }}
                    </a>
                    <x-primary-button class="w-full sm:w-auto px-6 py-3 text-lg rounded-lg">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
