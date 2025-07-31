<x-guest-layout>
  @if ($errors->any())
      <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
          <ul class="list-disc pl-5 space-y-1">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif  
  <form action="{{route('noc.store')}}" method="POST" class="container mx-auto font-sans">
    @csrf
    
    <div class="md:p-10 relative">

      <h3 class="text-2xl font-semibold text-center text-gray-800 mb-8 relative">
        NOC to Other Districts
        <span class="block w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-2 rounded"></span>
      </h3>

      {{-- Form Section --}}
      <div class="bg-gray-100 p-6 rounded-lg border-l-4 border-indigo-600 mb-6">
        <div class="mb-4">
          <label for="letterType" class="block font-medium text-gray-700 mb-2">Letter Type</label>
          <select id="letterType" name="letterType" onchange="toggleFields()" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="Official">Official</option>
            <option selected value="Self">Self</option>
          </select>
        </div>
        <div>
            <label class="block font-medium text-gray-700 mb-2">Permenant District</label>
            <input type="text" name="district" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div class="grid md:grid-cols-2 gap-4" id="officialFields">
          <div>
            <label class="block font-medium text-gray-700 mb-2">Referenced Letter No</label>
            <input type="text" name="referenced_letter_no" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
          </div>
          <div>
            <label class="block font-medium text-gray-700 mb-2">Referenced Letter Date</label>
            <input type="date" name="referenced_letter_date" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
          </div>
        </div>
      </div>
      {{-- Applicant Table --}}
      <div class="bg-gray-100 p-6 rounded-lg border-l-4 border-indigo-500 mb-6">
        <table class="min-w-full table-auto text-left text-sm bg-blue-50">
          <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
            <h1 class="p-4 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white">Applicant Details</h1>
          </thead>
          
            <tbody id="table-body">
                                      
            </tbody>
          
        </table>
        <div class="mt-2 flex flex-row justify-between items-center">
            <button type="button" onclick="addApplicant()" class="bg-gradient-to-r from-indigo-500 to-purple-500 px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1 transition">
            Add Applicant
          </button>
          <button type="button" onclick="deleteLastApplicant()" class="bg-gradient-to-r from-red-500 to-red-600 px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1 transition">
              Del Applicant
          </button>
        </div>
          
      </div>

      {{-- Save Button --}}
      <div class="bg-gray-100 p-6 rounded-lg border-l-4 border-green-600">
        <div>
            <label class="block font-medium text-gray-700 mb-2">Pass Code</label>
            <input type="text" name="code" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </div>
        <button type="submit" class="mt-3 bg-gradient-to-r from-indigo-500 to-purple-500 px-4 py-2 rounded-full font-medium shadow-md hover:shadow-lg transform hover:-translate-y-1 transition">
          Save Letter
        </button>
      </div>
    </div>
  
</form>
  <script>
    let applicantCounter = 0;

    function toggleFields() {
      const letterType = document.getElementById("letterType").value;
      const officialFields = document.getElementById("officialFields");
      officialFields.style.display = letterType === "Self" ? "none" : "grid";
    }

    window.onload = toggleFields;

    function addApplicant() {
      applicantCounter++;
      const row = `
                <tr>
                  <td colspan="100" class="px-4 py-2">
                    <div class="bg-white border border-gray-200 shadow rounded-lg p-4 mb-4 space-y-4">
                      <div class="flex flex-col">
                        <label class="font-semibold text-gray-700">Applicant #${applicantCounter}</label>
                      </div>
                      <div class="flex flex-col">
                        <label class="font-semibold text-gray-700">CNIC</label>
                        <input type="text" id="cnic" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="applicantCnic[${applicantCounter - 1}]" />
                      </div>
                      <div class="flex flex-col">
                        <label class="font-semibold text-gray-700">Name</label>
                        <input type="text" id="name" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="applicantName[${applicantCounter - 1}]"  />
                      </div>
                      <div class="flex flex-col">
                        <label class="font-semibold text-gray-700">Relation</label>
                        <select name="applicantRelation[${applicantCounter - 1}]" id="relation" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                          <option value="s/o">S/o</option>
                          <option value="d/o">D/o</option>
                          <option value="w/o">W/o</option>
                        </select>
                      </div>
                      <div class="flex flex-col">
                        <label class="font-semibold text-gray-700">Father Name</label>
                        <input type="text" id="father" class="w-full border-2 border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" name="applicantFather[${applicantCounter - 1}]"  />
                      </div>
                    </div>
                  </td>
                </tr>
              `;
      document.getElementById("table-body").insertAdjacentHTML("beforeend", row);

    }
    addApplicant();
    function deleteLastApplicant() {
      const tbody = document.getElementById("table-body");
      if (tbody.lastElementChild) {
        tbody.removeChild(tbody.lastElementChild);
        applicantCounter--;
      }
    }
  </script>
</x-guest-layout>
