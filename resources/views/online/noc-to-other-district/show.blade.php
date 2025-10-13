<x-app-layout>
  {{-- Error Messages --}}
  @if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300 max-w-3xl mx-auto">
      <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif  

  {{-- Main Form --}}
  <form 
    action="{{ route('noc.other_district.store') }}" 
    method="POST" 
    enctype="multipart/form-data" 
    class="max-w-3xl mt-2 mx-auto bg-white shadow-lg rounded-2xl p-6 sm:p-10 font-sans space-y-8"
  >
    @csrf

    {{-- Heading --}}
    <h3 class="text-3xl font-semibold text-center text-gray-800">
      NOC for Other Districts Domicile
    </h3>

    {{-- Letter Details --}}
    <div class="p-6 rounded-xl shadow-lg space-y-4">
      <div>
        <label for="letterType" class="block font-medium text-gray-700 mb-1">Letter Type</label>
        <select 
          id="letterType" 
          name="letterType" 
          onchange="toggleFields()" 
          class="w-full rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        >
          <option value="Official">Official</option>
          <option selected value="Self">Self</option>
        </select>
      </div>

      <div>
        <label class="block font-medium text-gray-700 mb-1">Permanent District</label>
        <input 
          type="text" 
          name="district" 
          maxlength="25"
          class="w-full rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div class="grid md:grid-cols-2 gap-4" id="officialFields">
        <div>
          <label class="block font-medium text-gray-700 mb-1">Referenced Letter No</label>
          <input 
            type="text" 
            name="referenced_letter_no" 
            class="w-full rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
          />
        </div>
        <div>
          <label class="block font-medium text-gray-700 mb-1">Referenced Letter Date</label>
          <input 
            type="date" 
            name="referenced_letter_date" 
            class="w-full rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
          />
        </div>
      </div>
    </div>

    {{-- Applicant Details --}}
    <div class=" p-4 rounded-xl shadow-lg">
      <h2 class="text-lg font-semibold mb-4 text-indigo-700">Applicant Details</h2>

      <table class="w-full text-left text-sm bg-white rounded-lg overflow-hidden">
        <tbody id="table-body"></tbody>
      </table>

      <div class="mt-4 flex flex-col sm:flex-row gap-3">
        <button 
          type="button" 
          onclick="addApplicant()" 
          class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-4 py-2 rounded-lg font-medium shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1"
        >
          Add Applicant
        </button>
        <button 
          type="button" 
          onclick="deleteLastApplicant()" 
          class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg font-medium shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-1"
        >
          Delete Applicant
        </button>
      </div>
    </div>

    <div class="p-6 rounded-2xl shadow-lg space-y-6">
      <div>
        <label class="block font-semibold text-gray-700 mb-2">
          Upload CNIC / Form-B and Affidavit
        </label>

        <div class="flex items-center justify-center w-full">
          <label 
            for="documents" 
            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-indigo-300 rounded-xl cursor-pointer bg-white hover:bg-indigo-50 transition duration-200 ease-in-out"
          >
            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
              <svg class="w-10 h-10 mb-3 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01.88-7.903A5.002 5.002 0 0117 9h1a3 3 0 010 6h-1m-4 4l-4-4m0 0l-4 4m4-4v12" />
              </svg>
              <p class="text-gray-600 font-medium">Click to upload or drag & drop</p>
              <p class="text-sm text-gray-500 mt-1">Only PDF, JPG, or PNG files accepted</p>
            </div>
            <input id="documents" type="file" name="documents" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required/>
          </label>
        </div>
      </div>

      <button 
        type="submit" 
        class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white py-3 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-200 ease-in-out"
      >
        Save Letter
      </button>
    </div>
  </form>

  {{-- JS Logic --}}
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
        <td colspan="100" class="p-4">
          <div class="bg-white shadow-sm rounded-xl p-4 space-y-4">
            <h3 class="font-semibold text-indigo-700">Applicant #${applicantCounter}</h3>

            <div>
              <label class="font-medium text-gray-700">CNIC</label>
              <input type="text" maxlength="13" minlength="13" required
                class="w-full rounded-lg p-3 focus:outline-none"
                name="applicantCnic[${applicantCounter - 1}]"
                oninput="clearError(this)"
                onblur="validate13DigitNumber(this)"
              />
              <p class="text-red-500 text-sm hidden mt-1">Please enter exactly 13 digits (numbers only).</p>
            </div>

            <div>
              <label class="font-medium text-gray-700">Name</label>
              <input type="text" maxlength="50" required
                class="w-full rounded-lg p-3 focus:outline-none"
                name="applicantName[${applicantCounter - 1}]"
              />
            </div>

            <div>
              <label class="font-medium text-gray-700">Relation</label>
              <select required name="applicantRelation[${applicantCounter - 1}]"
                class="w-full rounded-lg p-3 focus:outline-none">
                <option value="s/o">S/o</option>
                <option value="d/o">D/o</option>
                <option value="w/o">W/o</option>
              </select>
            </div>

            <div>
              <label class="font-medium text-gray-700">Father Name</label>
              <input type="text" maxlength="50" required
                class="w-full rounded-lg p-3 focus:outline-none"
                name="applicantFather[${applicantCounter - 1}]"
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

  function validate13DigitNumber(input) {
    const regex = /^\d{13}$/;
    const errorMsg = input.parentElement.querySelector('p');
    if (!regex.test(input.value.trim())) {
      errorMsg.classList.remove("hidden");
    } else {
      errorMsg.classList.add("hidden");
    }
  }

  function clearError(input) {
    const errorMsg = input.parentElement.querySelector('p');
    errorMsg.classList.add("hidden");
  }

  addApplicant(); // add first applicant automatically
</script>

</x-app-layout>
