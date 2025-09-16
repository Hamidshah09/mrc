<x-guest-layout>
    <x-navbar/>
    <!-- Hero Section -->
    <section class="mt-20">
        <div class="flex items-center justify-center">
             <h1 class="text-3xl text-center md:text-4xl font-bold bg-clip-text blue-400 drop-shadow-lg">
            International Driving Permit
        </h1>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto sm:px-6 mt-5 grid sm:grid-cols-3">
        <!-- Left: Info -->
        <div class="sm:col-span-2 mt-3 bg-white/50 backdrop-blur-md border border-white/30 rounded-xl py-8 shadow p-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Overview</h2>
            <p class="text-gray-700 mb-6 leading-relaxed text-justify">
                An International Driving Permit (IDP) is an identity document that allows the holder to drive a private motor vehicle in any country that recognizes IDPs. IDP is issued to the foreign travelers from Pakistan in accordance with the Vienna Convention, 1968. The IDP must be accompanied by a valid driving license. Here is the step-by-step process.
            </p>

            <div class="space-y-4">
                <div class="">
                    <h3 class="font-semibold text-lg text-gray-900">Step One:-</h3>
                    <p class="ml-5">Check your eligiblty to apply for IDP:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">
                        <li class="text-justify">Applicant should have a valid pakistani license</li>
                        <li class="text-justify">If a local license validity is less than year then IDP will be issued till the expiry of local license</li>
                        <li class="text-justify">An IDP will be issued for a maximum period of one years</li>
                        <li class="text-justify">Applicant must be present at CFC for biomatric and live picture.</li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Two:-</h3>
                    <p class="ml-5">Required documents:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Copy of CNIC</li>
                        <li class="text-justify">Copy of Valid local License</li>
                        <li class="text-justify">Copy of Passport</li>
                        <li class="text-justify">Copy of visa (optional)</li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Three:-</h3>
                    <p class="ml-5">Visit CFC</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Get a token from que machine and wait for your turn</li>
                        <li class="text-justify">Upon your turn submit documents on counter</li>
                        <li class="text-justify">A proof reading document will be provded for verification of pariculars.</li>
                        <li class="text-justify">You will get the card in maximum 10 minutes.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right: Apply Section -->
        <div id="search" class="col-span-1 mt-3">
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow ">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Verify Your IDP</h2>
                <form action="" method="">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">CNIC Number</label>
                        <input placeholder="xxxxx-xxxxxxx-x" type="text" name="cnic" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button onclick="message()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
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
                        <p><strong>IDP:</strong> {{ session('status')['receipt_no'] }}</p>
                        <p><strong>Applicant Name:</strong> {{ session('status')['First_Name'] }}</p>
                        <p><strong>Status:</strong> {{ $current_status }}</p>
                        <p><strong>Remarks:</strong> {{ session('status')['remarks'] }}</p>
                    </div>
                @endif

                
            </div>
            
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Office timinings for IDP service.</h3>
                <p class="text-gray-700">Mondy to Friday : 09:00 am to 08:00 pm.</p>
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
    <script>
        function message(){
            prevent_defualt();
            alert('Under Construction..');
        }
    </script>
</x-guest-layout>