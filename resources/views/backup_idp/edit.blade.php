<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for IDP') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 d">
                    <h2 class="text-2xl font-bold text-gray-800 text-center w-full">New IDP</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:red;">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('idp.update', $idp->id)}}" method="Post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                            <div class="form-control">
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="block mt-1 w-full p-2" type="text" name="cnic" maxlength="13" :value="old('cnic',  $idp->cnic)" max="13" required autofocus autocomplete="cnic" />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>
        
                            <div class="form-control">
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full p-2" type="text" name="first_name" :value="old('first_name', $idp->first_name)" max="60" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="last_name" :value="__('First Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full p-2" type="text" name="last_name" :value="old('last_name', $idp->last_name)" max="60" required autofocus autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="father_name" :value="__('Father/Husband Name')" />
                                <x-text-input id="father_name" class="block mt-1 w-full p-2" type="text" name="father_name" :value="old('father_name', $idp->father_name)" max="60" required autofocus autocomplete="father_name" />
                                <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full p-2" type="date" name="date_of_birth" :value="old('date_of_birth', $idp->date_of_birth)" required autofocus autocomplete="date_of_birth" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="gender_id" :value="__('Gender')" />
                                <select name="gender_id" id="gender_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('gender_id')" required autofocus autocomplete="gender_id">
                                        @foreach ($genders as $gender)
                                            @if ($gender->id == $idp->gender_id)
                                                <option value="{{$gender->id}}" selected>{{$gender->name}}</option>
                                            @else
                                                <option value="{{$gender->id}}" >{{$gender->name}}</option>
                                            @endif                                            
                                        @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('gender_id')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="place_of_birth" :value="__('City of Birth')" />
                                <x-text-input id="place_of_birth" class="block mt-1 w-full p-2" type="text" name="place_of_birth" :value="old('place_of_birth',  $idp->place_of_birth)" max="45" required autofocus autocomplete="place_of_birth" />
                                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="qualification_id" :value="__('Qualification')" />
                                <select name="qualification_id" id="qualification_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('qualification_id')" autofocus autocomplete="qualification_id">
                                    @foreach ($qualifications as $qualification)
                                        @if($qualification->id == $idp->qualification_id)
                                            <option selected value="{{$qualification->id}}">{{$qualification->name}}</option>
                                        @else
                                            <option value="{{$qualification->id}}">{{$qualification->name}}</option>        
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('qualification_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="occupation_id" :value="__('Ocupation')" />
                                <select name="occupation_id" id="occupation_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('occupation_id')" autofocus autocomplete="occupation_id">
                                        @foreach ($occupations as $occupation)
                                            @if ($occupation->id == $idp->occupation_id)
                                                <option selected value="{{$occupation->id}}">{{$occupation->occupation}}</option>
                                            @else
                                                <option value="{{$occupation->id}}">{{$occupation->occupation}}</option>
                                            @endif
                                        @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('occupation_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="contact" :value="__('Contact')" />
                                <x-text-input id="contact" class="block mt-1 w-full p-2" type="text" max="11" name="contact" :value="old('contact', $idp->contact)" min="11" max=11 autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_province_id" :value="__('Present Province')" />
                                <select name="temporaryAddress_province_id" id="temp_province_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress[province_id]')" required autofocus autocomplete="temp_province_id">
                                    @foreach ($provinces as $province)
                                        @if ($province->ID == $idp->id)
                                            <option selected value="{{$province->ID}}">{{$province->Province}}</option>
                                        @else
                                            <option value="{{$province->ID}}">{{$province->Province}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('temporaryAddress_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_district_id" :value="__('Present District')" />
                                <select name="temporaryAddress_district_id" id="temp_district_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress_district_id')" required autofocus autocomplete="temp_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        
                                        @if ($district->ID==664)
                                            <option selected value="{{$district->ID}}" >{{$district->Dis_Name}}</option>
                                        @else    
                                            <option value="{{$district->ID}}" >{{$district->Dis_Name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('temporaryAddress_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_tehsil_id" :value="__('Present Tehsil')" />
                                <select name="temporaryAddress_tehsil_id" id="temp_tehsil_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress_tehsil_id')" required autofocus autocomplete="temp_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->ID==665)
                                            <option selected value="{{$tehsil->ID}}" >{{$tehsil->Teh_name}}</option>
                                        @else
                                            <option value="{{$tehsil->ID}}" >{{$tehsil->Teh_name}}</option>    
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('temporaryAddress_tehsil_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_address" :value="__('Present Address')" />
                                <x-text-input id="temp_address" class="block mt-1 w-full p-2" type="text" name="temporary_address" :value="old('temporary_address', $idp->temporary_address)" required autofocus autocomplete="temporary_address" />
                                <x-input-error :messages="$errors->get('temporary_address')" class="mt-2" />
                            </div>
                            
                            <!-- Driving License Number -->
                            <div class="form-control">
                                <x-input-label for="driving_license_number" :value="__('Driving License Number')" />
                                <x-text-input id="driving_license_number" class="block mt-1 w-full"
                                            type="text" name="driving_license_number"
                                            :value="old('driving_license_number', $idp->driving_license_number)"
                                            maxlength="100" autocomplete="driving_license_number" />
                                <x-input-error :messages="$errors->get('driving_license_number')" class="mt-2" />
                            </div>

                            <!-- Driving License Issue Date -->
                            <div class="form-control">
                                <x-input-label for="driving_license_issue_date" :value="__('Driving License Issue Date')" />
                                <x-text-input id="driving_license_issue_date" class="block mt-1 w-full"
                                            type="date" name="driving_license_issue_date"
                                            :value="old('driving_license_issue_date', $idp->driving_license_issue_date ?? '')"
                                            autocomplete="driving_license_issue_date" />
                                <x-input-error :messages="$errors->get('driving_license_issue_date')" class="mt-2" />
                            </div>

                            <!-- Driving License Expiry Date -->
                            <div class="form-control">
                                <x-input-label for="driving_license_expiry_date" :value="__('Driving License Expiry Date')" />
                                <x-text-input id="driving_license_expiry_date" class="block mt-1 w-full"
                                            type="date" name="driving_license_expiry_date"
                                            :value="old('driving_license_expiry_date', $idp->driving_license_expiry_date ?? '')"
                                            autocomplete="driving_license_expiry_date" />
                                <x-input-error :messages="$errors->get('driving_license_expiry_date')" class="mt-2" />
                            </div>

                            <!-- Driving License Vehicle Type -->
                            <div class="form-control hidden">
                                <x-input-label for="driving_license_vehicle_type_id" :value="__('Vehicle Type')" />
                                <select name="driving_license_vehicle_type_id" id="driving_license_vehicle_type_id"
                                        class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1" selected>Motor Car</option>
                                </select>
                                <x-input-error :messages="$errors->get('driving_license_vehicle_type_id')" class="mt-2" />
                            </div>

                            <!-- Driving License Issuing Authority -->
                            <div class="form-control">
                                <x-input-label for="driving_license_issuing_authority" :value="__('Issuing Authority')" />
                                <x-text-input id="driving_license_issuing_authority" class="block mt-1 w-full"
                                            type="text" name="driving_license_issuing_authority"
                                            :value="old('driving_license_issuing_authority', $idp->driving_license_issuing_authority ?? '')"
                                            maxlength="20" autocomplete="driving_license_issuing_authority" />
                                <x-input-error :messages="$errors->get('driving_license_issuing_authority')" class="mt-2" />
                            </div>

                            <!-- Passport Number -->
                            <div class="form-control">
                                <x-input-label for="passport_number" :value="__('Passport Number')" />
                                <x-text-input id="passport_number" class="block mt-1 w-full"
                                            type="text" name="passport_number"
                                            :value="old('passport_number', $idp->passport_number ?? '')"
                                            maxlength="20" autocomplete="passport_number" />
                                <x-input-error :messages="$errors->get('passport_number')" class="mt-2" />
                            </div>

                            <!-- Passport Issue Date -->
                            <div class="form-control">
                                <x-input-label for="passport_issue_date" :value="__('Passport Issue Date')" />
                                <x-text-input id="passport_issue_date" class="block mt-1 w-full"
                                            type="date" name="passport_issue_date"
                                            :value="old('passport_issue_date', $idp->passport_issue_date ?? '')"
                                            autocomplete="passport_issue_date" />
                                <x-input-error :messages="$errors->get('passport_issue_date')" class="mt-2" />
                            </div>

                            <!-- Passport Expiry Date -->
                            <div class="form-control">
                                <x-input-label for="passport_expiry_date" :value="__('Passport Expiry Date')" />
                                <x-text-input id="passport_expiry_date" class="block mt-1 w-full"
                                            type="date" name="passport_expiry_date"
                                            :value="old('passport_expiry_date', $idp->passport_expiry_date ?? '')"
                                            autocomplete="passport_expiry_date" />
                                <x-input-error :messages="$errors->get('passport_expiry_date')" class="mt-2" />
                            </div>

                            <!-- Passport Type -->
                            <div class="form-control">
                                <x-input-label for="passport_type_id" :value="__('Passport Type')" />
                                <select name="passport_type_id" id="passport_type_id"
                                        class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @if ($idp->passport_type_id == 1)
                                        <option selected value="1" {{ old('passport_type_id')}}>
                                            Regular
                                        </option>
                                        <option value="2" {{ old('passport_type_id') }}>
                                            Official
                                        </option>
                                    @else
                                        <option value="1" {{ old('passport_type_id')}}>
                                            Regular
                                        </option>
                                        <option selected value="2" {{ old('passport_type_id') }}>
                                            Official
                                        </option>
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('passport_type_id')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="passcode" :value="__('Please write down this Passcode')" class="text-red-500" />
                                <x-text-input id="passcode" class="block mt-1 w-full p-2" type="text" name="passcode" :value="old('passcode')" min="6" max=6 autofocus autocomplete="passcode" />
                                <x-input-error :messages="$errors->get('passcode')" class="mt-2" />
                            </div>
                        </div>
                        
                        
                        <div class="flex flex-row justify-center mt-3">
                            <button class="p-2 text-center text-white w-full bg-blue-400 rounded-lg" type="submit">Save</button>
                            {{-- <x-primary-button class="w-full p-3 text-center" type="submit">
                                {{ __('Apply') }}
                            </x-primary-button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
            
        document.getElementById('cnic').addEventListener('blur', validate13DigitNumber);
        function validate13DigitNumber() {
        const input = document.getElementById('cnic').value;

        // Regular expression: exactly 13 digits
        const regex = /^\d{13}$/;

        if (!regex.test(input)) {
            alert("Please enter exactly 13 digits (numbers only).");
            return false; // Prevent form submission
        } else {
            return ture;
        }
        }
    </script>
</x-guest-layout>
