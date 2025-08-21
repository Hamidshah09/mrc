<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for New Domicile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 d">
                    <h2 class="text-2xl font-bold text-gray-800 text-center w-full">New Domicile</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:red;">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('domicile.store')}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                            <div class="form-control">
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="block mt-1 w-full p-2" type="text" name="cnic" maxlength="13" :value="old('cnic')" required autofocus autocomplete="cnic" />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>
        
                            <div class="form-control">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full p-2" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="fathername" :value="__('Father/Husband Name')" />
                                <x-text-input id="fathername" class="block mt-1 w-full p-2" type="text" name="fathername" :value="old('fathername')" required autofocus autocomplete="fathername" />
                                <x-input-error :messages="$errors->get('fathername')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="spousename" :value="__('Spouse Name')" />
                                <x-text-input id="spousename" class="block mt-1 w-full p-2" type="text" name="spousename" :value="old('spousename')" required autofocus autocomplete="spousename" />
                                <x-input-error :messages="$errors->get('spousename')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full p-2" type="date" name="date_of_birth" :value="old('date_of_birth')" required autofocus autocomplete="date_of_birth" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select name="gender_id" id="gender_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('gender_id')" required autofocus autocomplete="gender">
                                        <option value="">Select Gender</option>
                                        <option selected value="1">Male </option>
                                        <option value="2">Female</option>
                                        <option value="3">Transgender</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="place_of_birth" :value="__('City of Birth')" />
                                <x-text-input id="place_of_birth" class="block mt-1 w-full p-2" type="text" name="place_of_birth" :value="old('place_of_birth')" max="45" required autofocus autocomplete="place_of_birth" />
                                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="marital_status" :value="__('Marital Status')" />
                                <select name="marital_status_id" id="marital_status_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('marital_status_id')" required autofocus autocomplete="marital_status">
                                    
                                    <option value="">Select Marital Status</option>
                                    <option selected value="1">Single</option>
                                    <option value="2">Married</option>
                                    <option value="3">Divorced</option>
                                    <option value="4">Widowed</option>
                                    <option value="5">Widower</option>
                                                    
                                </select>
                                <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="religion" :value="__('Religion')" />
                                <x-text-input id="religion" class="block mt-1 w-full p-2" type="text" max="45" name="religion" :value="old('religion', 'Islam')" required autofocus autocomplete="religion" />
                                <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="qualification_id" :value="__('Qualification')" />
                                <select name="qualification_id" id="qualification_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('qualification_id')" autofocus autocomplete="qualification_id">
                                    <option value="">Select Qualification</option>
                                    <option value="1">Primary</option>
                                    <option value="2">Middle</option>
                                    <option selected value="3">SSC</option>
                                    <option value="4">HSSC</option>
                                    <option value="5">Bachelors</option>
                                    <option value="6">Masters</option>
                                    <option value="7">PhD</option>
                                    <option value="8">Not Available</option>
                                    <option value="9">Other</option>
                                    <option value="10">Islamic Education</option>                    
                                </select>
                                <x-input-error :messages="$errors->get('qualification_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="occupation_id" :value="__('Ocupation')" />
                                <select name="occupation_id" id="occupation_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('occupation_id')" autofocus autocomplete="occupation_id">
                                        <option value="">Select Occupation</option>
                                        <option value="1">Government Employee</option>
                                        <option value="2">Non Government Employee</option>
                                        <option value="3">Own Business</option>
                                        <option value="4">Student</option>
                                        <option selected value="5">Other</option>
                                        <option value="6">House wife</option>
                                        <option value="7">Private Job</option>
                                </select>
                                <x-input-error :messages="$errors->get('occupation_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="contact" :value="__('Contact')" />
                                <x-text-input id="contact" class="block mt-1 w-full p-2" type="text" max="11" name="contact" :value="old('contact')" min="11" max=11 autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="date_of_arrival" :value="__('Date of arrival in Islamabad')" />
                                <x-text-input id="date_of_arrival" class="block mt-1 w-full p-2" type="date" name="date_of_arrival" :value="old('date_of_arrival')" autofocus autocomplete="date_of_arrival" />
                                <x-input-error :messages="$errors->get('date_of_arrival')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="temp_province_id" :value="__('Present Province')" />
                                <select name="temporaryAddress_province_id" id="temp_province_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('temporaryAddress[province_id]')" required autofocus autocomplete="temp_province_id">
                                    <option value="" disabled="">Select Province</option>
                                    <option value="694"> Azad Jammu and Kashmir</option>
                                    <option value="491"> Balochistan</option>
                                    <option selected value="663"> Federal Capital</option>
                                    <option value="666"> Gilgit-Baltistan</option>
                                    <option value="1"> Khyber Pakhtunkhwa</option>
                                    <option value="167"> Punjab</option>
                                    <option value="344"> Sindh</option>
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
                                <x-text-input id="temp_address" class="block mt-1 w-full p-2" type="text" name="temporaryAddress" :value="old('temporaryAddress')" required autofocus autocomplete="temporaryAddress" />
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
                                <select name="permanentAddress_province_id" id="permanent_province_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_province_id')" required autofocus autocomplete="permanent_province_id">
                                    <option value="" selected="" disabled="">Select Province</option>
                                    <option value="694"> Azad Jammu and Kashmir</option>
                                    <option value="491"> Balochistan</option>
                                    <option value="663"> Federal Capital</option>
                                    <option value="666"> Gilgit-Baltistan</option>
                                    <option value="1"> Khyber Pakhtunkhwa</option>
                                    <option value="167"> Punjab</option>
                                    <option value="344"> Sindh</option>
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_district_id" :value="__('Permanent District')" />
                                <select name="permanentAddress_district_id" id="permanent_district_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_district_id')" required autofocus autocomplete="permanent_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        <option value="{{$district->ID}}" >{{$district->Dis_Name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_tehsil_id" :value="__('Permanent Tehsil')" />
                                <select name="permanentAddress_tehsil_id" id="permanent_tehsil_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('permanentAddress_tehsil_id')" required autofocus autocomplete="permanent_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        <option value="{{$tehsil->ID}}" >{{$tehsil->Teh_name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanentAddress_tehsil_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                                <x-text-input id="permanent_address" class="block mt-1 w-full p-2" type="text" name="permanentAddress" :value="old('permanentAddress')" required autofocus autocomplete="permanentAddress" />
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
                                        <option value="study"> Study</option>
                                        <option value="job" >Job</option>
                                        
                                    </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="passcode" :value="__('Please write down this Passcode')" class="text-red-500" />
                                <x-text-input id="passcode" class="block mt-1 w-full p-2" type="text" name="passcode" :value="old('passcode', $passcode->code)" min="6" max=6 autofocus autocomplete="passcode" />
                                <x-input-error :messages="$errors->get('passcode')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <table class="" id="table-responsive">
                                <h1 class="p-3 text-center bg-gray-500 text-white text-bold mb-2 rounded">Childern Details</h1>
                                <tbody id="table-body">
                                    
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
        
        let applicantCounter=0
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
                                    <input type="text" id="cnic" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="children[${applicantCounter - 1}][cnic]" />
                                </div>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-gray-700">Childd Name</label>
                                    <input type="text" id="name" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="children[${applicantCounter - 1}][name]"  />
                                </div>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-gray-700">Date of Birth</label>
                                    <input type="date" id="dob" required class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="children[${applicantCounter - 1}][dob]"  />
                                </div>
                                <div class="flex flex-col">
                                    <label class="font-semibold text-gray-700">Relation</label>
                                    <select required name="children[${applicantCounter - 1}][gender_id]" id="gendder_id" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
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
            return ture;
        }
        }
    </script>
</x-guest-layout>
