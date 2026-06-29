<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for New Domicile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
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
                            <div class="col-span-4">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 text-white px-5 py-3 rounded-xl shadow mb-2">
                                    <h3 class="text-lg font-semibold tracking-wide">
                                        Personal Information
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="form-control">
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" placeholder="13 digit CNIC No without dashes" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="cnic" maxlength="13" :value="old('cnic')" required autofocus autocomplete="cnic" />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>
        
                            <div class="form-control">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" placeholder="Name of the domicile applicant" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="father_name" :value="__('Father/Husband Name')" />
                                <x-text-input id="father_name" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="father_name" :value="old('father_name')" required autofocus autocomplete="father_name" />
                                <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="spouse_name" :value="__('Spouse Name')" />
                                <x-text-input id="spouse_name" placeholder="type nill if unmarried" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="spouse_name" :value="old('spouse_name')" required autofocus autocomplete="spouse_name" />
                                <x-input-error :messages="$errors->get('spouse_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="date" name="date_of_birth" :value="old('date_of_birth')" required autofocus autocomplete="date_of_birth" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="gender_id" :value="__('Gender')" />
                                <select name="gender_id" id="gender_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('gender_id')" required autofocus autocomplete="gender_id">
                                        <option value="">Select Gender</option>
                                        <option selected value="1">Male </option>
                                        <option value="2">Female</option>
                                        <option value="3">Transgender</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender_id')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="place_of_birth" :value="__('City of Birth')" />
                                <x-text-input id="place_of_birth" placeholder="name of the city only" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="place_of_birth" :value="old('place_of_birth')" max="45" required autofocus autocomplete="place_of_birth" />
                                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="marital_status_id" :value="__('Marital Status')" />
                                <select name="marital_status_id" id="marital_status_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('marital_status_id')" required autofocus autocomplete="marital_status">
                                    
                                    <option value="">Select Marital Status</option>
                                    <option selected value="1">Single</option>
                                    <option value="2">Married</option>
                                    <option value="3">Divorced</option>
                                    <option value="4">Widowed</option>
                                    <option value="5">Widower</option>
                                                    
                                </select>
                                <x-input-error :messages="$errors->get('marital_status_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="religion" :value="__('Religion')" />
                                <x-text-input id="religion" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" max="45" name="religion" :value="old('religion', 'Islam')" required autofocus autocomplete="religion" />
                                <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="qualification_id" :value="__('Qualification')" />
                                <select name="qualification_id" id="qualification_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('qualification_id')" autofocus autocomplete="qualification_id">
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
                                <select name="occupation_id" id="occupation_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('occupation_id')" autofocus autocomplete="occupation_id">
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
                                <x-text-input id="contact" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" required name="contact" :value="old('contact')" min="11" max=11 autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="arrival_date" :value="__('Date of arrival in Islamabad')" />
                                <x-text-input id="arrival_date" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="date" name="arrival_date" :value="old('arrival_date')" autofocus autocomplete="arrival_date" />
                                <x-input-error :messages="$errors->get('arrival_date')" class="mt-2" />
                            </div>
                            <div class="col-span-4">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 text-white px-5 py-3 rounded-xl shadow mb-2">
                                    <h3 class="text-lg font-semibold tracking-wide">
                                        Address Information
                                    </h3>
                                </div>
                            </div>
                            <div class="form-control">
                                <x-input-label for="present_province_id" :value="__('Present Province')" />
                                <select name="present_province_id" id="present_province_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_province_id')" required autofocus autocomplete="present_province_id">
                                    <option value="" disabled="">Select Province</option>
                                    <option value="694"> Azad Jammu and Kashmir</option>
                                    <option value="491"> Balochistan</option>
                                    <option selected value="663"> Federal Capital</option>
                                    <option value="666"> Gilgit-Baltistan</option>
                                    <option value="1"> Khyber Pakhtunkhwa</option>
                                    <option value="167"> Punjab</option>
                                    <option value="344"> Sindh</option>
                                </select>
                                <x-input-error :messages="$errors->get('present_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="present_district_id" :value="__('Present District')" />
                                <select name="present_district_id" id="present_district_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_district_id')" required autofocus autocomplete="present_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        
                                        @if ($district->id==664)
                                            <option selected value="{{$district->id}}" >{{$district->name}}</option>
                                        @else    
                                            <option value="{{$district->id}}" >{{$district->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('present_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="present_tehsil_id" :value="__('Present Tehsil')" />
                                <select name="present_tehsil_id" id="present_tehsil_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_tehsil_id')" required autofocus autocomplete="present_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->id==665)
                                            <option selected value="{{$tehsil->id}}" >{{$tehsil->name}}</option>
                                        @else
                                            <option value="{{$tehsil->id}}" >{{$tehsil->name}}</option>    
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('present_tehsil_id')" class="mt-2" />
                            </div>
                            <div class="form-control col-span-4">
                                <x-input-label for="present_address" :value="__('Present Address')" />
                                <x-text-input id="present_address" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="present_address" :value="old('present_address')" required autofocus autocomplete="present_address" />
                                <x-input-error :messages="$errors->get('present_address')" class="mt-2" />
                            </div>
                            <div class="col-span-4">
                                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 flex items-center">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox"
                                            id="same_as_above"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">

                                        <span class="text-sm font-medium text-gray-700">
                                            Permanent Address Same as Present Address
                                        </span>
                                    </label>
                                </div>
                            </div>
                        
                            <div class="form-control">
                                <x-input-label for="permanent_province_id" :value="__('Permanent Province')" />
                                <select name="permanent_province_id" id="permanent_province_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_province_id')" required autofocus autocomplete="permanent_province_id">
                                    <option value="" selected="" disabled="">Select Province</option>
                                    <option value="694"> Azad Jammu and Kashmir</option>
                                    <option value="491"> Balochistan</option>
                                    <option value="663"> Federal Capital</option>
                                    <option value="666"> Gilgit-Baltistan</option>
                                    <option value="1"> Khyber Pakhtunkhwa</option>
                                    <option value="167"> Punjab</option>
                                    <option value="344"> Sindh</option>
                                </select>
                                <x-input-error :messages="$errors->get('permanent_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_district_id" :value="__('Permanent District')" />
                                <select name="permanent_district_id" id="permanent_district_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_district_id')" required autofocus autocomplete="permanent_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        <option value="{{$district->id}}" >{{$district->name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanent_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_tehsil_id" :value="__('Permanent Tehsil')" />
                                <select name="permanent_tehsil_id" id="permanent_tehsil_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_tehsil_id')" required autofocus autocomplete="permanent_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        <option value="{{$tehsil->id}}" >{{$tehsil->name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanent_tehsil_id')" class="mt-2" />
                            </div>
                            <div class="form-control col-span-4">
                                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                                <x-text-input id="permanent_address" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="permanent_address" :value="old('permanent_address')" required autofocus autocomplete="permanent_address" />
                                <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
                            </div>
                            <div class="form-control col-span-4">
                                <x-input-label for="remarks" :value="__('Remarks')" />

                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="3"
                                    class="block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Additional remarks or notes">{{ old('remarks') }}</textarea>

                                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                            </div>
                            <div class="form-control col-span-4">
                                <x-input-label for="picture" :value="__('Applicant Picture (optional)')" />
                                <input type="file" name="picture" id="picture" accept="image/*" class="block w-full p-2 rounded-md border border-gray-300" />
                                <p class="text-sm text-gray-500 mt-1">Optional: upload JPG/PNG up to 5MB.</p>
                                <x-input-error :messages="$errors->get('picture')" class="mt-2" />
                            </div>
                            <div class="col-span-4">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 text-white px-5 py-3 rounded-xl shadow mb-2">
                                    <h3 class="text-lg font-semibold tracking-wide">
                                        Service Information
                                    </h3>
                                </div>
                            </div>
                            <div class="form-control">
                                <x-input-label for="request_type_id" :value="__('Request Type')" />
                                <select name="request_type_id" id="request_type_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('request_type_id')" autofocus autocomplete="request_type_id">
                                    <option value="">Select Request Type</option>
                                    @foreach($request_types as $rt)
                                        <option value="{{ $rt->id }}" {{ old('request_type_id') == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('request_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="service_type_id" :value="__('Service Type')" />
                                <select name="service_type_id" id="service_type_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('service_type_id')" autofocus autocomplete="service_type_id">
                                    <option value="">Select Service Type</option>
                                    @foreach($service_types as $st)
                                        <option value="{{ $st->id }}" {{ old('service_type_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('service_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="payment_type_id" :value="__('Payment Type')" />
                                <select name="payment_type_id" id="payment_type_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('payment_type_id')" autofocus autocomplete="payment_type_id">
                                    <option value="">Select Payment Type</option>
                                    @foreach($payment_types as $pt)
                                        <option value="{{ $pt->id }}" {{ old('payment_type_id') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('payment_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="purpose" :value="__('Purpose')" />
                                    <select name="purpose" id="purpose" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('purpose')" required autofocus autocomplete="purpose">
                                        <option value="" selected disabled="">Select Purpose</option>
                                        <option value="study"> Study</option>
                                        <option value="job" >Job</option>
                                        
                                    </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="approver_id" :value="__('Approver')" />
                                <select name="approver_id" id="approver_id" class="w-full rounded-xl p-3 border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('approver_id')" autofocus autocomplete="approver_id">
                                    <option value="">Select Approver</option>
                                    @foreach($approvers as $approver)
                                        <option value="{{ $approver->id }}" {{ old('approver_id') == $approver->id ? 'selected' : '' }}>{{ $approver->name ?? $approver->approver ?? 'Approver' }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('approver_id')" class="mt-2" />
                            </div>
                            <div class="col-span-4">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 text-white px-5 py-3 rounded-xl shadow mb-2">
                                    <h3 class="text-lg font-semibold tracking-wide">
                                        Faimly Information
                                    </h3>
                                </div>
                            </div>
                            <div class="my-2 mx-3 hidden" id="children_div">
                                <label class="">
                                    <input name="children_checkbox" value="1" id="children_checkbox" type="checkbox" class="rounded">
                                    <span class="input-span"></span>Have Children
                                </label>
                            </div>
                            
                        </div>
                        
                        <div class="mt-2">
                            <div class="space-y-4" id="table-responsive">
                                <div id="table-body">
                                    
                                </div>
                            </div>
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
                            <button  class="w-full py-4 text-lg font-semibold tracking-wide text-white bg-gradient-to-r from-indigo-500 to-blue-400 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-600 transition duration-200" type="submit">
                            Save
                            </button>
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
                <tr id="child-row-${applicantCounter}">
                    <td colspan="100" class="py-2">

                        <div class="border border-gray-200 rounded-2xl shadow-sm bg-gray-50 p-5">

                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-md font-semibold text-indigo-700">
                                    Child #${applicantCounter}
                                </h3>

                                <button
                                    type="button"
                                    onclick="document.getElementById('child-row-${applicantCounter}').remove()"
                                    class="text-red-600 hover:text-red-800 text-xl font-bold">
                                    &times;
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Child Name
                                    </label>

                                    <input
                                        type="text"
                                        required
                                        name="children[${applicantCounter - 1}][name]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        B-Form / CNIC
                                    </label>

                                    <input
                                        type="text"
                                        required
                                        maxlength="13"
                                        name="children[${applicantCounter - 1}][cnic]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Date of Birth
                                    </label>

                                    <input
                                        type="date"
                                        required
                                        name="children[${applicantCounter - 1}][dob]"
                                        class="block mt-1 w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

                                <div class="form-control">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Gender
                                    </label>

                                    <select
                                        required
                                        name="children[${applicantCounter - 1}][gender_id]"
                                        class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">

                                        <option value="1">Male</option>
                                        <option value="2">Female</option>

                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="text-sm font-medium text-gray-700 mr-3">
                                        Is applied for Domicile?
                                    </label>
                                    <input
                                        type="checkbox"
                                        name="children[${applicantCounter - 1}][is_domicile_applicant]"
                                        class="block mt-1 p-3 rounded border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>

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

                tbody.lastElementChild.remove();

                if (applicantCounter > 0) {
                    applicantCounter--;
                }
            }
        }
        document.getElementById('same_as_above').addEventListener('click', function() { 
            document.getElementById('permanent_province_id').selectedIndex = document.getElementById('present_province_id').selectedIndex;
            document.getElementById('permanent_tehsil_id').selectedIndex = document.getElementById('present_tehsil_id').selectedIndex;
            document.getElementById('permanent_district_id').selectedIndex = document.getElementById('present_district_id').selectedIndex;
            document.getElementById('permanent_address').value = document.getElementById('present_address').value;
        });
        
        var maritalStatusSelect = document.getElementById('marital_status_id'); 
        var childrenDiv = document.getElementById('children_div'); 
        maritalStatusSelect.addEventListener('change', function() { 
            console.log(maritalStatusSelect.value);
            if (maritalStatusSelect.value != "1") { 
                childrenDiv.classList.remove('hidden');
                var child_input = document.getElementById('children_checkbox');
                if (child_input.checked){
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
</x-app-layout>
