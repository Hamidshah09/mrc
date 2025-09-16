<x-guest-layout>
    <x-navbar/>
    <!-- Hero Section -->
    <section class="mt-20">
        <div class="flex items-center justify-center">
             <h1 class="text-3xl text-center md:text-4xl font-bold bg-clip-text blue-400 drop-shadow-lg">
            Birth Certificate
        </h1>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto sm:px-6 mt-5 grid sm:grid-cols-3">
        <!-- Left: Info -->
        <div class="sm:col-span-2 mt-3 bg-white/50 backdrop-blur-md border border-white/30 rounded-xl py-8 shadow p-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Overview</h2>
            <p class="text-gray-700 mb-6 leading-relaxed text-justify">
                Birth certificate is an official document issued to record a person’s birth. It is required by NADRA for issuane of Form B and also required by embassies for issuance of Visa. Here is the step-by-step process.
            </p>

            <div class="space-y-4">
                <div class="">
                    <h3 class="font-semibold text-lg text-gray-900">Step One:-</h3>
                    <p class="ml-5">Check your eligiblty from following documents, to apply for Birth Certificate:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">
                        <li class="text-justify">At least one address of sectorial area of Islamabad should be written on CNIC or Birth should be taken place at Islamabad.</li>
                        <li class="text-justify">In case, address is of rural of Islamabad or any other region of Pakistan, the applicant should apply to conerned union councel</li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Two:-</h3>
                    <p class="ml-5">Required documents:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Copy of CNIC of Mother and Father</li>
                        <li class="text-justify">Brith Certificate issued by Hospital or Affidavit of Midwife (incase brith took place at home)</li>
                        <li class="text-justify">NOC from HVC (Tehsil Office F-8 markaz) if birht repored after 5 years.</li>
                        <li class="text-justify">Application Form duly filled and signed by applicant <a class="underline text-blue-800 font-semibold" href="https://www.cda.gov.pk/public/Assets/pdf/1710232742_f5330bd8_44e2_4dae_8ba1_f24c1485798d_.pdf">Download</a></li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Three:-</h3>
                    <p class="ml-5">Visit CFC (first visit)</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Get a token from que machine and wait for your turn</li>
                        <li class="text-justify">Upon your turn submit documents on counter and get a proof reading document.</li>
                        <li class="text-justify">After verificatin of particulars Birth Certificate will be issued.</li>
                    </ul>    
            </div>
        </div>

        <!-- Right: Apply Section -->
        <div id="search" class="col-span-1 mt-3">
            {{-- <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow ">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Check Your Application Status</h2>
                <form action="{{route('domicile.check')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">CNIC Number</label>
                        <input placeholder="xxxxx-xxxxxxx-x" type="text" name="cnic" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
                        Submit
                    </button>
                </form>
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300 mt-3">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                
                @elseif(session('status'))
                    @php
                        $class_type = 'blue';
                        if (session('status')['Status']=="Approval Received"){
                            $class_type = 'green';
                            $current_status = 'Documents Approved';
                        }elseif (session('status')['Status']=="Sent for Approval"){
                            $class_type = 'yellow';
                            $current_status = 'Documents sent for approval';
                        }elseif (session('status')['Status']=="Objection"){
                            $class_type = 'red';
                            $current_status = 'Objection';
                        }elseif (session('status')['Status']=="Exported"){
                            $class_type = 'blue';
                            $current_status = 'Domicile Issued';
                        }
                        
                    @endphp
                    <div class="mt-4 bg-{{$class_type}}-100 border border-{{$class_type}}-400 text-{{$class_type}}-700 px-4 py-3 rounded">
                        <h3 class="font-semibold text-lg text-center">Domicile Status</h3>
                        <p><strong>Receipt No:</strong> {{ session('status')['receipt_no'] }}</p>
                        <p><strong>Applicant Name:</strong> {{ session('status')['First_Name'] }}</p>
                        <p><strong>Status:</strong> {{ $current_status }}</p>
                    </div>
                @endif
            </div> --}}
            
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Office timinings for Birth Certificate service.</h3>
                <p class="text-gray-700">Mondy to Friday : 09:00 am to 05:00 pm.</p>
                <p class="text-gray-700">Satuarday : 09:00 am to 04:00 pm.</p>
                <p class="text-gray-700">Jumma Prayer Braek : 12:30 am to 02:30 pm.</p>
            </div>

            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Help Line</h3>
                <p class="text-gray-700">051-8899611</p>
                <p class="text-gray-700">051-8899622</p>
            </div>
        </div>
    </div>
    
</x-guest-layout>