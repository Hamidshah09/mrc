<x-guest-layout>
    <x-navbar/>
    <!-- Hero Section -->
    <section class="mt-20">
        <div class="flex items-center justify-center">
             <h1 class="text-3xl text-center md:text-4xl font-bold bg-clip-text blue-400 drop-shadow-lg">
            Domicile Certificate
        </h1>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto sm:px-6 mt-5 grid sm:grid-cols-3">
        <!-- Left: Info -->
        <div class="sm:col-span-2 mt-3 bg-white/50 backdrop-blur-md border border-white/30 rounded-xl py-8 shadow p-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Overview</h2>
            <p class="text-gray-700 mb-6 leading-relaxed text-justify">
                Domicile Certificate is an essential document which proves that a person is an inhabitant or a permanent resident of the city. As per law, this certificate can be obtained from one city only. You may require domicile certificate for a job or for seeking admission in the university. In order to obtain a domicile certificate from ICT Administration, visit the Citizen Facilitation Center, Islamabad. Here is the step-by-step process.
            </p>

            <div class="space-y-4">
                <div class="">
                    <h3 class="font-semibold text-lg text-gray-900">Step One:-</h3>
                    <p class="ml-5">Check your eligiblty from following documents, to apply for Domicile:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">
                        <li class="text-justify">At least one address of Islamabad should be written on CNIC. (if applicant don't have cnic (minor) then his/her parents cnic will be checked).</li>
                        <li class="text-justify">Date of issue of CNIC should be one year old (first cnic on age of 18 is exempted from this clause)</li>
                        <li class="text-justify">valid residence proof i.e allotment letter, fard/registry, rent agreement. (either on applicants name or his/her father, mother, uncle, grandfather, grandmother's name.)</li>
                        <li class="text-justify">if applicant has two diffent addresses mentioned on his/her cnic then an NOC/Verification from concerned district will be required. (This can be obtained by issuance of letter from CFC (<a class="underline text-blue-800 font-semibold" href="{{route('noc-other-district.create')}}">Apply</a>) to concern district or applicant may apply to concerned district. )</li>
                        <li class="text-justify"><a class="underline text-blue-800 font-semibold" href="{{asset('documents/sop_urdu.pdf')}}">Checkout SOP in Urdu</a></li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Two:-</h3>
                    <p class="ml-5">Required documents:-</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Copy of CNIC</li>
                        <li class="text-justify">Residence Proof</li>
                        <li class="text-justify">Copy of Utility Bill</li>
                        <li class="text-justify">Affidavit for domicile on plain paper. Check speciment for <a class="underline text-blue-800 font-semibold" href="{{asset('documents/MINOR AFFIDAVIT.pdf')}}" target="_blank">Minor</a> and <a class="underline text-blue-800 font-semibold" href="{{asset('documents/MAJOR AFFIDAVIT.pdf')}}" target="_blank">Major</a></li>
                    </ul>
                    <h3 class="font-semibold text-lg text-gray-900 mt-2">Step Three:-</h3>
                    <p class="ml-5">Visit CFC</p>
                    <ul class="ml-5 list-disc pl-5 text-gray-700">    
                        <li class="text-justify">Get a token from que machine and wait for your turn</li>
                        <li class="text-justify">Fill up a From P digitaly <a class="underline text-blue-800 font-semibold" href="{{route('domicile.public.create')}}">click here</a> as well as in hard form.</li>
                        <li class="text-justify">Upon your turn submit documents on counter and get a prof reading document.</li>
                        <li class="text-justify">Your Domicile Certificate will be handed over to you.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right: Apply Section -->
        <div id="search" class="col-span-1 mt-3">
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow ">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Verify Your Domicile</h2>
                <form id="domicileVerifyForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">CNIC</label>
                        <input
                            id="cnic"
                            placeholder="6110112345678"
                            type="text"
                            class="w-full rounded-lg border-gray-300"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
                    >
                        Verify
                    </button>
                </form>

                <div id="domicileResult" class="hidden mt-4 p-4 rounded-lg border"              >
                </div>
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
                        if (session('status')['status']=="Approval Received"){
                            $class_type = 'green';
                            $current_status = 'Documents Approved';
                        }elseif (session('status')['status']=="Sent for Approval"){
                            $class_type = 'yellow';
                            $current_status = 'Documents sent for approval';
                        }elseif (session('status')['status']=="Objection"){
                            $class_type = 'red';
                            $current_status = 'Objection';
                        }elseif (session('status')['status']=="Exported"){
                            $class_type = 'blue';
                            $current_status = 'Domicile Issued';
                        }elseif (session('status')['status']=="Pending"){
                            $class_type = 'gray';
                            $current_status = 'Pending';
                        }
                    @endphp
                    <div class="mt-4 bg-{{$class_type}}-100 border border-{{$class_type}}-400 text-{{$class_type}}-700 px-4 py-3 rounded">
                        <h3 class="font-semibold text-lg text-center">Domicile Status</h3>
                        <p><strong>Receipt No:</strong> {{ session('status')['receipt_no'] }}</p>
                        <p><strong>Applicant Name:</strong> {{ session('status')['first_name'] }}</p>
                        <p><strong>Status:</strong> {{ $current_status }}</p>
                        @if ($current_status=='Objection')
                            <p><strong>Remarks:</strong> {{ session('status')['remarks'] }}</p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-3">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Ask a question</h2>
                <form id="askForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Question</label>
                        <input type="text" id="questionInput" name="question"
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition">
                        Submit
                    </button>
                </form>

                <div id="response-box" class="hidden mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <h3 class="font-semibold text-lg text-center">Answer</h3>
                    <p id="response"></p>
                </div>
            </div>

            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Office timinings for domicile service.</h3>
                <p class="text-gray-700">Mondy to Friday : 09:00 am to 08:00 pm.</p>
                <p class="text-gray-700">Satuarday : 09:00 am to 04:00 pm.</p>
                <p class="text-gray-700">Jumma Prayer Braek : 12:30 am to 02:30 pm.</p>
            </div>

            <div class="bg-white/50 backdrop-blur-md border border-white/30 rounded-xl sm:mx-5 p-6 shadow mt-5">
                <h3 class="font-semibold text-lg text-gray-900">Help Line</h3>
                <p class="text-gray-700">051-8899622</p>
                <p class="text-gray-700">051-8899611</p>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("askForm").addEventListener("submit", async function(e) {
            e.preventDefault();
            document.getElementById("response-box").classList
            let question = document.getElementById("questionInput").value;
            let responseEl = document.getElementById("response");
            document.getElementById("response-box").classList.remove("hidden");

            responseEl.innerText = "Loading...";

            try {
                let res = await fetch("https://cfc-ict.com/chatbot/ask?question=" + encodeURIComponent(question), {
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    }
                });

                if (!res.ok) {
                    throw new Error("HTTP " + res.status);
                }

                let data = await res.json();
                responseEl.innerText = data.answer || "No response";
            } catch (error) {
                console.error("❌ Fetch error:", error);
                responseEl.innerText = "Error: " + error.message;
            }
        });

        document.getElementById("domicileVerifyForm")
        .addEventListener("submit", async function(e) {

            e.preventDefault();

            const cnic = document
                .getElementById("cnic")
                .value
                .replace(/\D/g, "");

            const resultBox =
                document.getElementById("domicileResult");

            resultBox.classList.remove("hidden");
            resultBox.innerHTML = "Checking...";

            try {

                const response = await fetch(
                    "https://cfc-ict.com/fastapi/domicile/check/" + cnic
                );

                const data = await response.json();

                if (!data.verified) {

                    resultBox.className =
                        "mt-4 p-4 rounded-lg border bg-red-100 border-red-400 text-red-700";

                    resultBox.innerHTML =
                        "<strong>Not Verified</strong><br>" +
                        data.message;

                    return;
                }

                const record = data.data[0];

                resultBox.className =
                    "mt-4 p-4 rounded-lg border bg-green-100 border-green-400 text-green-700";

                resultBox.innerHTML = `
                    <h3 class="font-bold text-lg mb-2">
                        Domicile Verified
                    </h3>

                    <p><strong>Name:</strong> ${record.name}</p>
                    <p><strong>CNIC:</strong> ${record.cnic}</p>
                    <p><strong>Token No:</strong> ${record.token_no}</p>
                    <p><strong>Status:</strong> ${record.status}</p>
                    <p><strong>Date:</strong> ${record.date}</p>
                `;

            } catch (error) {

                resultBox.className =
                    "mt-4 p-4 rounded-lg border bg-red-100 border-red-400 text-red-700";

                resultBox.innerHTML =
                    "Unable to verify domicile.";
            }
        });
    </script>



</x-guest-layout>