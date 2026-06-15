<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Domicile') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900 d">
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
                    <form action="{{route('domicile.update', $applicant->id)}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-4 mt-2">
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-400 text-white px-5 py-3 rounded-xl shadow mb-2">
                                    <h3 class="text-lg font-semibold tracking-wide">
                                        Personal Information
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="form-control">
                                <x-input-label for="cnic" :value="__('CNIC')" />
                                <x-text-input id="cnic" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="cnic" maxlength="13" :value="old('cnic', $applicant->cnic)" required autofocus autocomplete="cnic" />
                                <x-input-error :messages="$errors->get('cnic')" class="mt-2" />
                            </div>
        
                            <div class="form-control">
                                <x-input-label for="first_name" :value="__('Applicant Name')" />
                                <x-text-input id="first_name" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="first_name" :value="old('first_name', $applicant->first_name)" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="father_name" :value="__('Father/Husband Name')" />
                                <x-text-input id="father_name" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="father_name" :value="old('father_name', $applicant->father_name)" required autofocus autocomplete="father_name" />
                                <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="spouse_name" :value="__('Spouse Name')" />
                                <x-text-input id="spouse_name" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="spouse_name" :value="old('spouse_name', $applicant->spouse_name)" required autofocus autocomplete="spouse_name" />
                                <x-input-error :messages="$errors->get('spouse_name')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="date" name="date_of_birth" :value="old('date_of_birth', $applicant->date_of_birth)" required autofocus autocomplete="date_of_birth" />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="gender_id" :value="__('Gender')" />
                                <select name="gender_id" id="gender_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('gender_id', $applicant->gender_id)" required autofocus autocomplete="gender">
                                    <option value="">Select Gender</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}"
                                            {{ old('gender_id', $applicant->gender_id ?? '') == $gender->id ? 'selected' : '' }}>
                                            {{ $gender->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('gender_id')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="place_of_birth" :value="__('City of Birth')" />
                                <x-text-input id="place_of_birth" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="place_of_birth" :value="old('place_of_birth', $applicant->place_of_birth)" max="45" required autofocus autocomplete="place_of_birth" />
                                <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="marital_status" :value="__('Marital Status')" />
                                <select name="marital_status_id" id="marital_status_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('marital_status_id', $applicant->marital_status_id)" required autofocus autocomplete="marital_status">
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
                                <x-text-input id="religion" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" max="45" name="religion" :value="old('religion', $applicant->religion)" required autofocus autocomplete="religion" />
                                <x-input-error :messages="$errors->get('religion')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="qualification_id" :value="__('Qualification')" />
                                <select name="qualification_id" id="qualification_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('qualification_id', $applicant->qualification_id)" autofocus autocomplete="qualification_id">
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
                                <select name="occupation_id" id="occupation_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('occupation_id', $applicant->occupation_id)" autofocus autocomplete="occupation_id">
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
                                <x-text-input id="contact" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" max="11" name="contact" :value="old('contact', $applicant->contact)" min="11" max=11 autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="arrival_date" :value="__('Date of arrival in Islamabad')" />
                                <x-text-input id="arrival_date" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="date" name="arrival_date" :value="old('arrival_date', $applicant->arrival_date)" autofocus autocomplete="arrival_date" />
                                <x-input-error :messages="$errors->get('arrival_date')" class="mt-2" />
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
                                @if(!empty($applicant->picture_path))
                                    <div class="mb-2">
                                        <img src="{{ $applicant->picture_path }}" alt="Applicant picture" class="w-24 h-24 object-cover rounded-md border" />
                                    </div>
                                @endif
                                <input type="file" name="picture" id="picture" accept="image/*" class="block w-full p-2 rounded-md border border-gray-300" />
                                <p class="text-sm text-gray-500 mt-1">Optional: upload JPG/PNG up to 5MB. Uploading replaces existing picture.</p>
                                <x-input-error :messages="$errors->get('picture')" class="mt-2" />
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
                                <select name="present_province_id" id="present_province_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_province_id', $applicant->present_province_id)" required autofocus autocomplete="present_province_id">
                                    @foreach ($provinces as $province)
                                        @if ($province->ID==$applicant->present_province_id)
                                            <option value="{{$province->ID}}" selected>{{$province->Province}}</option>
                                        @else
                                            <option value="{{$province->ID}}">{{$province->Province}}</option>
                                        @endif    
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('present_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="present_district_id" :value="__('Present District')" />
                                <select name="present_district_id" id="present_district_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_district_id', $applicant->present_district_id)" required autofocus autocomplete="present_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                        @foreach ($districts as $district)
                                            @if ($district->id==$applicant->present_district_id)
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
                                <select name="present_tehsil_id" id="present_tehsil_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('present_tehsil_id', $applicant->present_tehsil_id)" required autofocus autocomplete="present_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->id==$applicant->present_tehsil_id)
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
                                <x-text-input id="present_address" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="present_address" :value="old('present_address', $applicant->present_address)" required autofocus autocomplete="present_address" />
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
                                <select name="permanent_province_id" id="permanent_province_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_province_id', $applicant->permanent_province_id)" required autofocus autocomplete="permanent_province_id">
                                    <option value="" selected="" disabled="">Select Province</option>
                                    @foreach ($provinces as $province)
                                        @if ($province->ID==$applicant->permanent_province_id)
                                            <option value="{{$province->ID}}" selected>{{$province->Province}}</option>
                                        @else
                                            <option value="{{$province->ID}}">{{$province->Province}}</option>
                                        @endif    
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanent_province_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_district_id" :value="__('Permanent District')" />
                                <select name="permanent_district_id" id="permanent_district_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_district_id', $applicant->permanent_district_id)" required autofocus autocomplete="permanent_district_id">
                                    <option value="" selected="" disabled="">Select District</option>
                                    @foreach ($districts as $district)
                                        @if ($district->id==$applicant->permanent_district_id)
                                            <option selected value="{{$district->id}}" >{{$district->name}}</option>
                                        @else
                                            <option value="{{$district->id}}" >{{$district->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanent_district_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="permanent_tehsil_id" :value="__('Permanent Tehsil')" />
                                <select name="permanent_tehsil_id" id="permanent_tehsil_id" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('permanent_tehsil_id', $applicant->permanent_tehsil_id)" required autofocus autocomplete="permanent_tehsil_id">
                                    <option value="" selected="" disabled="">Select Tehsil</option>
                                    @foreach ($tehsils as $tehsil)
                                        @if ($tehsil->id==$applicant->permanent_tehsil_id)
                                            <option selected value="{{$tehsil->id}}" >{{$tehsil->name}}</option>
                                        @else
                                            <option value="{{$tehsil->id}}" >{{$tehsil->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('permanent_tehsil_id')" class="mt-2" />
                            </div>
                            <div class="form-control col-span-4">
                                <x-input-label for="permanent_address" :value="__('Permanent Address')" />
                                <x-text-input id="permanent_address" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="permanent_address" :value="old('permanent_address', $applicant->permanent_address)" required autofocus autocomplete="permanent_address" />
                                <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
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
                                <select name="request_type_id" id="request_type_id" class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('request_type_id', $applicant->request_type_id ?? '')" autofocus autocomplete="request_type_id">
                                    <option value="">Select Request Type</option>
                                    @foreach($request_types as $rt)
                                        <option value="{{ $rt->id }}" {{ old('request_type_id', $applicant->request_type_id ?? '') == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('request_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="service_type_id" :value="__('Service Type')" />
                                <select name="service_type_id" id="service_type_id" class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('service_type_id', $applicant->service_type_id ?? '')" autofocus autocomplete="service_type_id">
                                    <option value="">Select Service Type</option>
                                    @foreach($service_types as $st)
                                        <option value="{{ $st->id }}" {{ old('service_type_id', $applicant->service_type_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('service_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="payment_type_id" :value="__('Payment Type')" />
                                <select name="payment_type_id" id="payment_type_id" class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('payment_type_id', $applicant->payment_type_id ?? '')" autofocus autocomplete="payment_type_id">
                                    <option value="">Select Payment Type</option>
                                    @foreach($payment_types as $pt)
                                        <option value="{{ $pt->id }}" {{ old('payment_type_id', $applicant->payment_type_id ?? '') == $pt->id ? 'selected' : '' }}>{{ $pt->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('payment_type_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="approver_id" :value="__('Approver')" />
                                <select name="approver_id" id="approver_id" class="w-full border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('approver_id', $applicant->approver_id ?? '')" autofocus autocomplete="approver_id">
                                    <option value="">Select Approver</option>
                                    @foreach($approvers as $approver)
                                        <option value="{{ $approver->id }}" {{ old('approver_id', $applicant->approver_id ?? '') == $approver->id ? 'selected' : '' }}>{{ $approver->name ?? $approver->approver ?? 'Approver' }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('approver_id')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="receipt_no" :value="__('Receipt No')" />
                                <x-text-input id="receipt_no" class="block w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" type="text" required name="receipt_no" :value="old('receipt_no', $applicant->receipt_no ?? '')" min="11" max=11 autofocus autocomplete="receipt_no" />
                                <x-input-error :messages="$errors->get('receipt_no')" class="mt-2" />
                            </div>
                            <div class="form-control">
                                <x-input-label for="purpose" :value="__('Purpose')" />
                                    <select name="purpose" id="purpose" class="w-full p-3 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" :value="old('purpose', $applicant->purpose ?? '')" required autofocus autocomplete="purpose">
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
                                                            value="{{ old('children.'.$index.'.name', $child->name) }}" />
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
                                                    <div class="flex flex-col">
                                                        <label class="font-semibold text-gray-700">Is Domicile Applicant?</label>
                                                        <input type="checkbox" 
                                                            name="children[{{ $index }}][is_domicile_applicant]" 
                                                            value="on"
                                                            {{ old('children.'.$index.'.is_domicile_applicant', $child->is_domicile_applicant ?? false) ? 'checked' : '' }}
                                                            class="border-2 border-gray-200 rounded p-3"/>                                                            
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
                            <button
                                class="w-full py-4 text-lg font-semibold tracking-wide text-white bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-600 transition duration-200"
                                type="submit">
                            Update
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
                            <div class="flex flex-col">
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
