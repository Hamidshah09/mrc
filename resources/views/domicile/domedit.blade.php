<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Domicile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 d">
                    <h2 class="text-2xl font-bold text-gray-800 text-center w-full">Update Domicile</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:red;">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('domicile.update', $applicant->id)}}" method="Post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                            <div class="form-control">
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="block mt-1 w-full p-2" type="text" name="cnic" maxlength="13" :value="old('cnic', $applicant->cnic)" required autofocus autocomplete="cnic" />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>
        
                            <div class="form-control">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full p-2" type="text" name="name" :value="old('name', $applicant->name)" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="fathername" :value="__('Father/Husband Name')" />
                                <x-text-input id="fathername" class="block mt-1 w-full p-2" type="text" name="fathername" :value="old('fathername', $applicant->fathername)" required autofocus autocomplete="fathername" />
                                <x-input-error :messages="$errors->get('fathername')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="spousename" :value="__('Spouse Name')" />
                                <x-text-input id="spousename" class="block mt-1 w-full p-2" type="text" name="spousename" :value="old('spousename', $applicant->spousename)" required autofocus autocomplete="spousename" />
                                <x-input-error :messages="$errors->get('spousename')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full p-2" type="date" name="date_of_birth" :value="old('date_of_birth', $applicant->date_of_birth)" required autofocus autocomplete="date_of_birth" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select name="gender_id" id="gender_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('gender_id', $applicant->gender_id)" required autofocus autocomplete="gender">
                                    <option value="">Select Gender</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ old('gender_id', $applicant->gender_id ?? '') == $gender->id ? 'selected' : '' }}>
                                            {{ $gender->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="place_of_birth" :value="__('City of Birth')" />
                                <x-text-input id="place_of_birth" class="block mt-1 w-full p-2" type="text" name="place_of_birth" :value="old('place_of_birth', $applicant->place_of_birth)" max="45" required autofocus autocomplete="place_of_birth" />
                                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="marital_status" :value="__('Marital Status')" />
                                <select name="marital_status_id" id="marital_status_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('marital_status_id', $applicant->marital_status_id)" required autofocus autocomplete="marital_status">
                                    <option value="">Select Marital Status</option>
                                    @foreach ($maritalStatuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('marital_status_id', $applicant->marital_status_id ?? '') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach                
                                </select>
                                <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="religion" :value="__('Religion')" />
                                <x-text-input id="religion" class="block mt-1 w-full p-2" type="text" max="45" name="religion" :value="old('religion', $applicant->religion)" required autofocus autocomplete="religion" />
                                <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="qualification_id" :value="__('Qualification')" />
                                <select name="qualification_id" id="qualification_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('qualification_id', $applicant->qualification_id)" autofocus autocomplete="qualification_id">
                                    <option value="">Select Qualification</option>
                                    @foreach ($qualifications as $qualification)
                                        <option value="{{ $qualification->id }}" 
                                            {{ old('qualification_id', $applicant->qualification_id ?? '') == $qualification->id ? 'selected' : '' }}>
                                            {{ $qualification->name }}
                                        </option>
                                    @endforeach            
                                </select>
                                <x-input-error :messages="$errors->get('qualification_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="occupation_id" :value="__('Ocupation')" />
                                <select name="occupation_id" id="occupation_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('occupation_id', , $applicant->occupation_id)" autofocus autocomplete="occupation_id">
                                    <option value="">Select Occupation</option>
                                    @foreach ($occupations as $occupation)
                                        <option value="{{ $occupation->id }}"
                                            {{ old('occupation_id', $applicant->occupation_id ?? '') == $occupation->id ? 'selected' : '' }}>
                                            {{ $occupation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('occupation_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="contact" :value="__('Contact')" />
                                <x-text-input id="contact" class="block mt-1 w-full p-2" type="text" max="11" name="contact" :value="old('contact', $applicant->contact)" min="11" max=11 autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="date_of_arrival" :value="__('Date of arrival in Islamabad')" />
                                <x-text-input id="date_of_arrival" class="block mt-1 w-full p-2" type="date" name="date_of_arrival" :value="old('date_of_arrival', $applicant->date_of_arrival)" autofocus autocomplete="date_of_arrival" />
                                <x-input-error :messages="$errors->get('date_of_arrival')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_province_id" :value="__('Present Province')" />
                                <select name="temporaryAddress_province_id" id="temp_province_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress_province_id', $applicant->temporaryAddress_province_id)" required autofocus autocomplete="temp_province_id">
                                    @foreach ($provinces as $province)
                                        @if ($province->ID==$applicant->temporaryAddress_province_id)
                                            <option value="{{$province->ID}}" selected>{{$province->Province}}</option>
                                        @else
                                            <option value="{{$province->ID}}">{{$province->Province}}</option>
                                        @endif    
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('temporaryAddress_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_district_id" :value="__('Present District')" />
                                <select name="temporaryAddress_district_id" id="temp_district_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress_district_id', $applicant->temporaryAddress_district_id)" required autofocus autocomplete="temp_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                        @foreach ($districts as $district)
                                            @if ($district->ID==$applicant->temporaryAddress_district_id)
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
                                <select name="temporaryAddress_tehsil_id" id="temp_tehsil_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress_tehsil_id', $applicant->temporaryAddress_tehsil_id)" required autofocus autocomplete="temp_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->ID==$applicant->temporaryAddress_tehsil_id)
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
                                <x-text-input id="temp_address" class="block mt-1 w-full p-2" type="text" name="temporaryAddress" :value="old('temporaryAddress', $applicant->temporaryAddress)" required autofocus autocomplete="temporaryAddress" />
                                <x-input-error :messages="$errors->get('temporaryAddress')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <label class="float-start">
                                    <input type="checkbox" id="same_as_above" class="rounded">
                                    <span>Same as above</span>
                                </label>
                            </div>
                        
                            <div class="form-control">
                                <x-input-label for="permanent_province_id" :value="__('Permanent Province')" />
                                <select name="permanentAddress_province_id" id="permanent_province_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_province_id', $applicant->permanentAddress_province_id)" required autofocus autocomplete="permanent_province_id">
                                    <option value="" selected="" disabled="">Select Province</option>
                                    @foreach ($provinces as $province)
                                        @if ($province->ID==$applicant->permanentAddress_province_id)
                                            <option value="{{$province->ID}}" selected>{{$province->Province}}</option>
                                        @else
                                            <option value="{{$province->ID}}">{{$province->Province}}</option>
                                        @endif    
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_district_id" :value="__('Permanent District')" />
                                <select name="permanentAddress_district_id" id="permanent_district_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_district_id', $applicant->permanentAddress_district_id)" required autofocus autocomplete="permanent_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        @if ($district->ID==$applicant->permanentAddress_district_id)
                                            <option selected value="{{$district->ID}}" >{{$district->Dis_Name}}</option>
                                        @else
                                            <option value="{{$district->ID}}" >{{$district->Dis_Name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_tehsil_id" :value="__('Permanent Tehsil')" />
                                <select name="permanentAddress_tehsil_id" id="permanent_tehsil_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_tehsil_id', $applicant->permanentAddress_tehsil_id)" required autofocus autocomplete="permanent_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->ID==$applicant->permanentAddress_tehsil_id)
                                            <option selected value="{{$tehsil->ID}}" >{{$tehsil->Teh_name}}</option>
                                        @else
                                            <option value="{{$tehsil->ID}}" >{{$tehsil->Teh_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_tehsil_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                                <x-text-input id="permanent_address" class="block mt-1 w-full p-2" type="text" name="permanentAddress" :value="old('permanentAddress', $applicant->permanentAddress)" required autofocus autocomplete="permanentAddress" />
                                <x-input-error :messages="$errors->get('permanentAddress')" class="mt-2" />
                            </div>
                            <div class="my-2 mx-3 hidden" id="children_div">
                                <label class="">
                                    <input name="children_checkbox" value="1" id="children_checkbox" type="checkbox" class="rounded">
                                    <span class="input-span"></span>Have Children
                                </label>
                            </div>
                            <div class="form-control">
                                <x-input-label for="purpose" :value="__('Purpose')" />
                                    <select name="purpose" id="purpose" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('purpose')" required autofocus autocomplete="purpose">
                                        <option value="" selected disabled="">Select Purpose</option>
                                        @if ($applicant->purpose=='study')
                                            <option selected value="study"> Study</option>
                                            <option value="job" >Job</option>                                            
                                        @else
                                            <option value="study"> Study</option>
                                            <option selected value="job" >Job</option>
                                            
                                        @endif    
                                    </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="passcode" :value="__('Please provide Passcode')" class="text-red-500" />
                                <x-text-input id="passcode" class="block mt-1 w-full p-2" type="text" name="passcode" :value="old('passcode')" min="6" max=6 autofocus autocomplete="passcode" />
                                <x-input-error :messages="$errors->get('passcode')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <table>
                            <tbody id="table-body">
                                @foreach ($applicant->children as $index => $child)
                                    <tr>
                                        <td colspan="100" class="px-4 py-2">
                                            <div class="bg-white border border-gray-200 shadow rounded-lg p-4 mb-4 space-y-4">
                                                <input type="hidden" name="children[{{ $index }}][id]" value="{{ $child->id }}">

                                                <div class="flex flex-col">
                                                    <label class="font-semibold text-gray-700">Child #{{ $loop->iteration }}</label>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="font-semibold text-gray-700">CNIC</label>
                                                    <input type="text" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                                        name="children[{{ $index }}][cnic]"
                                                        value="{{ old('children.'.$index.'.cnic', $child->cnic) }}" />
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="font-semibold text-gray-700">Child Name</label>
                                                    <input type="text" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                                        name="children[{{ $index }}][name]"
                                                        value="{{ old('children.'.$index.'.name', $child->child_name) }}" />
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="font-semibold text-gray-700">Date of Birth</label>
                                                    <input type="date" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                                        name="children[{{ $index }}][dob]"
                                                        value="{{ old('children.'.$index.'.dob', $child->date_of_birth) }}" />
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="font-semibold text-gray-700">Relation</label>
                                                    <select name="children[{{ $index }}][gender_id]"
                                                            class="w-full border-2 border-gray-200 rounded-lg p-3">
                                                        <option value="1" {{ $child->gender_id == 1 ? 'selected' : '' }}>Male</option>
                                                        <option value="2" {{ $child->gender_id == 2 ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                            <div class="flex flex-row justify-between mt-2">
                                <x-primary-button class="ms-3" onclick="addApplicant()" type="button">
                                {{ __('Add Child') }}
                                </x-primary-button>
                                <x-secondary-button class="ms-3" onclick="deleteLastApplicant()" type="button">
                                {{ __('Del Child') }}
                                </x-secondary-button>        
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
        var child_input = document.getElementById('children_checkbox');
        
        let applicantCounter = {{ count($applicant->children) }}; // continue after existing children
        console.log(applicantCounter);
        function addApplicant() {
            applicantCounter++;
            const row = `
                <tr>
                    <td colspan="100" class="px-4 py-2">
                        <div class="bg-white border border-gray-200 shadow rounded-lg p-4 mb-4 space-y-4">
                            <div class="flex flex-col">
                                <label class="font-semibold text-gray-700">Child #${applicantCounter}</label>
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-gray-700">CNIC</label>
                                <input type="text" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                    name="children[${applicantCounter - 1}][cnic]" />
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-gray-700">Child Name</label>
                                <input type="text" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                    name="children[${applicantCounter - 1}][name]" />
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-gray-700">Date of Birth</label>
                                <input type="date" class="w-full border-2 border-gray-200 rounded-lg p-3"
                                    name="children[${applicantCounter - 1}][dob]" />
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-gray-700">Relation</label>
                                <select name="children[${applicantCounter - 1}][gender_id]"
                                        class="w-full border-2 border-gray-200 rounded-lg p-3">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
            document.getElementById("table-body").insertAdjacentHTML("beforeend", row);
        }

        function deleteLastApplicant() {
            const tbody = document.getElementById("table-body");
            if (tbody.lastElementChild) {
                tbody.removeChild(tbody.lastElementChild);
                applicantCounter--;
            }
        }

        document.getElementById('same_as_above').addEventListener('click', function() { 
            document.getElementById('permanent_province_id').selectedIndex = document.getElementById('temp_province_id').selectedIndex;
            document.getElementById('permanent_tehsil_id').selectedIndex = document.getElementById('temp_tehsil_id').selectedIndex;
            document.getElementById('permanent_district_id').selectedIndex = document.getElementById('temp_district_id').selectedIndex;
            document.getElementById('permanent_address').value = document.getElementById('temp_address').value;
        });
        
        var maritalStatusSelect = document.getElementById('marital_status_id'); 
        var childrenDiv = document.getElementById('children_div'); 
        maritalStatusSelect.addEventListener('change', function() { 
            console.log(maritalStatusSelect.value);
            if (maritalStatusSelect.value != "1") { 
                childrenDiv.classList.remove('hidden');
                var child_input = document.getElementById('children_checkbox');
                if (child_input.checkbox){
                    document.getElementById('table-responsive').classList.remove('hidden');    
                } 
            } else { 
                childrenDiv.classList.add('hidden');
            } 
        });
            
        document.getElementById('cnic').addEventListener('blur', validate13DigitNumber);
        function validate13DigitNumber() {
        const input = document.getElementById('cnic').value;

        // Regular expression: exactly 13 digits
        const regex = /^\d{13}$/;

        if (!regex.test(input)) {
            alert("Please enter exactly 13 digits (numbers only).");
            return false; // Prevent form submission
        } else {
            return true;
        }
        }
    </script>
</x-guest-layout>
