<x-guest-layout>
    <x-navbar/>
    <!-- Hero Section -->
    <section class="mt-20">
        <div class="flex items-center justify-center">
             <h1 class="text-3xl text-center md:text-4xl font-bold bg-clip-text blue-400 drop-shadow-lg">
            Divorce Registraion Certificate
        </h1>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto md:px-6 mt-5 grid sm:grid-cols-3">
        <!-- Left: Info -->
        <div class="sm:col-span-2 mt-3 bg-white/50 backdrop-blur-md border border-white/30 rounded-xl py-8 shadow p-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Overview</h2>
            <p class="text-gray-700 mb-6 leading-relaxed text-justify">
                Divorce Registration Certificate is issued on the basis of a Divorce Effectiveness Certificate. After a divorce is initiated by either the husband or the wife, they must apply to the Arbitration Council for the issuance of the Divorce Effectiveness Certificate.

This process takes 90 days to complete. During this period, the Arbitration Council will summon both parties and attempt to reconcile them. If both parties do not agree to reconciliation, a Divorce Effectiveness Certificate will be issued.

To obtain a Divorce Registration Certificate from the ICT Administration, visit the Citizen Facilitation Center, G-11/4, Islamabad. Below is the step-by-step process.
            </p>

            <div class="space-y-4">
                <div class="">
                    <h3 class="font-semibold text-lg text-gray-900">Step One:-</h3>
                    <p class="ml-5">Check your eligiblty to apply for DRC from ICT:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">
                        <li class="text-justify">Primary eligibilty document is Divorce Effecetness certificate issued by Arbitration Council G-11/4, Islamabad</li>
                        <li class="text-justify">In case, Divorce Effecetness certificate is issued by rural area of Islamabad or any other region of Pakistan, the applicant should apply to conerned union council</li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Two:-</h3>
                    <p class="ml-5">Required documents:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Copy of CNICs of Groom or Bride</li>
                        <li class="text-justify">Copy of Passport (if groom or bride is foreigner)</li>
                        <li class="text-justify">Copy of Divorce Effecetness Certificate</li>
                        <li class="text-justify">Application Form <a class="underline text-blue-800 font-semibold" href="">Download</a></li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Three:-</h3>
                    <p class="ml-5">Visit CFC (first visit)</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Get a token from que machine and wait for your turn</li>
                        <li class="text-justify">Fill up Application Form</li>
                        <li class="text-justify">Upon your turn submit documents on counter and get a receipt.</li>
                        <li class="text-justify">Your documents will be sent to Competent Authority for Approval/Signature.</li>
                        <li class="text-justify">You will be advised to revisit CFC after 3 working days.</li>
                        <li class="text-justify">Note:-Any athorized person can submit documents.</li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Four:-</h3>
                    <p class="ml-5">Re-visit CFC (second visit)</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Before arrival you may confirm your file status <a class="underline text-blue-800 font-semibold" href="#search">from here</a></li>
                        <li class="text-justify">Get your Certificate from concerned counter</li>
                    </ul>
                </div>

                
            </div>
        </div>

        <!-- Right: Apply Section -->
        <div id="search" class="col-span-1 mt-3">
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow ">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Check DRC Status</h2>
                <form action="{{route('mrc.check')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">CNIC Number</label>
                        <input placeholder="xxxxx-xxxxxxx-x" type="text" name="cnic" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
                        Submit
                    </button>
                </form>

                @if(session('status'))
                    @php
                        $class_type = 'gray';
                        if (session('status')['status']=="Certificate Signed"){
                            $class_type = 'green';
                        }elseif (session('status')['status']=="Sent for Verification"){
                            $class_type = 'yellow';
                        }elseif (session('status')['status']=="Objection"){
                            $class_type = 'red';
                        }
                    @endphp
                    <div class="mt-4 bg-{{$class_type}}-100 border border-{{$class_type}}-400 text-{{$class_type}}-700 px-4 py-3 rounded">
                        <h3 class="font-semibold text-lg text-center">DRC Status</h3>
                        <p><strong>Certificate Type:</strong> {{ session('status')['certificate_type'] }}</p>
                        <p><strong>Applicant Name:</strong> {{ session('status')['applicant_name'] }}</p>
                        <p><strong>Status:</strong> {{ session('status')['status'] }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

            </div>
            
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Office timinings for submission of documents for DRC service.</h3>
                <p class="text-gray-700">Mondy to Friday : 09:00 am to 05:00 pm.</p>
                <h3 class="font-semibold text-lg text-gray-900">Office timinings for colleciton of MRC.</h3>
                <p class="text-gray-700">Mondy to Friday : 09:00 am to 08:00 pm.</p>
                <p class="text-gray-700">Satuarday : 09:00 am to 04:00 pm.</p>
            </div>

            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Help Line</h3>
                <p class="text-gray-700">051-8899221</p>
                <p class="text-gray-700">051-8899331</p>
            </div>
        </div>
    </div>
</x-guest-layout>