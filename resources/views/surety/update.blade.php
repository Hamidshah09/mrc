<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Update Surety Record
            </h2>

            <div class="text-right">

                <div class="text-sm text-gray-600">
                    Progress:
                    <span id="progressText">
                        {{ $doc->entered_entries }}
                        /
                        {{ $doc->total_expected_entries ?? '?' }}
                    </span>
                </div>

                <div class="w-56 bg-gray-200 rounded-full h-3 mt-2 overflow-hidden">

                    <div id="progressBar"
                        class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500"
                        style="width: {{ $doc->total_expected_entries ? ($doc->entered_entries / $doc->total_expected_entries) * 100 : 0 }}%">
                    </div>

                </div>

            </div>

        </div>

    </x-slot>


    <div class="max-w-7xl mx-auto mt-8 space-y-6">

        {{-- Document Preview --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-4 flex items-center justify-between">

                <h3 class="text-white text-lg font-semibold">
                    Document Preview
                </h3>

                <div class="flex gap-2">

                    <button onclick="zoomIn()"
                        class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg transition">
                        +
                    </button>

                    <button onclick="zoomOut()"
                        class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg transition">
                        -
                    </button>

                </div>

            </div>

            <div class="p-4">

                <div class="border rounded-xl overflow-auto bg-gray-50"
                    style="height: 350px;">

                    @php
                        $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array($ext, ['jpg','jpeg','png']))

                        <img id="docImage"
                            src="{{ asset('storage/'.$doc->file_path) }}"
                            class="mx-auto block transition-all duration-300"
                            style="width:100%; max-width:none;">

                    @else

                        <iframe
                            src="{{ asset('storage/'.$doc->file_path) }}"
                            class="w-full h-full">
                        </iframe>

                    @endif

                </div>

            </div>

        </div>


        {{-- Search + Table --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            {{-- Search Bar --}}
            <div class="bg-gray-50 border-b px-6 py-4">

                <div class="flex flex-col md:flex-row gap-3">

                    <div class="flex-1">

                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search by Register ID, Guarantor or Receipt No"
                            class="w-full rounded-xl border-gray-300 shadow-sm
                                   focus:ring-2 focus:ring-indigo-500
                                   focus:border-indigo-500">

                    </div>

                    <button
                        type="button"
                        onclick="loadRecords(searchInput.value)"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700
                               text-white rounded-xl shadow transition">

                        Search

                    </button>

                </div>

                <input
                    type="hidden"
                    id="documentId"
                    value="{{ $doc->id }}">

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                Register ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                Guarantor
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                Receipt
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                Receiving Date
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">
                                Amount
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="recordsTableBody"
                        class="bg-white divide-y divide-gray-100">

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <script>

        /*
        |--------------------------------------------------------------------------
        | Zoom Controls
        |--------------------------------------------------------------------------
        */

        let scale = 1;

        function zoomIn() {

            let img = document.getElementById('docImage');

            if (!img) return;

            scale += 0.2;

            img.style.width = (scale * 100) + '%';
        }

        function zoomOut() {

            let img = document.getElementById('docImage');

            if (!img) return;

            scale = Math.max(0.5, scale - 0.2);

            img.style.width = (scale * 100) + '%';
        }



        /*
        |--------------------------------------------------------------------------
        | Toast
        |--------------------------------------------------------------------------
        */

        function showToast(msg, type = 'success') {

            let bg = type === 'error'
                ? 'bg-red-600'
                : 'bg-green-600';

            let toast = document.createElement('div');

            toast.innerText = msg;

            toast.className =
                `fixed top-5 right-5 ${bg}
                 text-white px-5 py-3 rounded-xl
                 shadow-lg z-50`;

            document.body.appendChild(toast);

            setTimeout(() => {

                toast.remove();

            }, 2500);
        }



        /*
        |--------------------------------------------------------------------------
        | Dynamic Search
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.getElementById(
                'searchInput'
            );

        const tableBody =
            document.getElementById(
                'recordsTableBody'
            );

        let searchTimeout = null;


        searchInput.addEventListener('keyup', function () {

            if (
                this.value.length > 0 &&
                this.value.length < 3
            ) {
                return;
            }

            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {

                loadRecords(this.value);

            }, 400);
        });



        /*
        |--------------------------------------------------------------------------
        | Load Records
        |--------------------------------------------------------------------------
        */

        async function loadRecords(search = '') {

            tableBody.innerHTML = `
                <tr>
                    <td colspan="7"
                        class="text-center py-8 text-gray-500">

                        Loading records...

                    </td>
                </tr>
            `;

            try {

                const documentId =
                    document.getElementById(
                        'documentId'
                    ).value;

                const response = await fetch(

                    `/surety/search/ajax?search=${encodeURIComponent(search)}&document_id=${documentId}`

                );

                const data = await response.json();

                if (!data.success) {

                    throw new Error(
                        'Invalid server response'
                    );
                }

                renderRecords(data.records);

            } catch (error) {

                console.error(error);

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7"
                            class="text-center py-8 text-red-500">

                            Failed to load records

                        </td>
                    </tr>
                `;

                showToast(
                    'Unable to load records',
                    'error'
                );
            }
        }



        /*
        |--------------------------------------------------------------------------
        | Render Records
        |--------------------------------------------------------------------------
        */

        function renderRecords(records) {

            tableBody.innerHTML = '';

            if (!records.length) {

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7"
                            class="text-center py-8 text-gray-500">

                            No records found

                        </td>
                    </tr>
                `;

                return;
            }

            records.forEach(record => {

                const status =
                    record.surety_status?.status_name
                    ??
                    'Unknown';


                const row = `

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 text-sm font-medium text-gray-800">
                            ${record.register_id ?? ''}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            ${record.guarantor_name ?? ''}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            ${record.receipt_no ?? ''}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            ${record.receiving_date ?? ''}
                        </td>

                        <td class="px-6 py-4 text-sm text-right font-semibold text-gray-800">
                            ${Number(record.amount ?? 0).toLocaleString()}
                        </td>

                        <td class="px-6 py-4 text-sm">

                            <span class="
                                px-3 py-1 rounded-full text-xs font-semibold

                                ${record.surety_status_id == 2
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-yellow-100 text-yellow-700'}
                            ">

                                ${status}

                            </span>

                        </td>

                        <td class="px-6 py-4 text-center">

                            ${
                                record.surety_status_id == 2

                                ?

                                `<span class="text-gray-400 text-sm">
                                    Released
                                </span>`

                                :

                                `<button
                                    onclick="releaseRecord(${record.id})"

                                    class="inline-flex items-center
                                           gap-2 px-4 py-2 rounded-xl
                                           bg-green-600 hover:bg-green-700
                                           text-white text-sm shadow
                                           transition">

                                    ✔ Release

                                </button>`
                            }

                        </td>

                    </tr>
                `;

                tableBody.insertAdjacentHTML(
                    'beforeend',
                    row
                );
            });
        }



        /*
        |--------------------------------------------------------------------------
        | Release Record
        |--------------------------------------------------------------------------
        */

        async function releaseRecord(id) {

            if (
                !confirm(
                    'Are you sure you want to release this record?'
                )
            ) {
                return;
            }

            try {

                const response = await fetch(

                    `/surety/release/${id}`,

                    {
                        method: 'POST',

                        headers: {
                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'Accept':
                                'application/json'
                        }
                    }
                );

                const data = await response.json();

                if (!data.success) {

                    throw new Error(
                        data.message ??
                        'Unable to release'
                    );
                }

                showToast(
                    data.message
                );

                /*
                |--------------------------------------------------------------------------
                | Update Progress
                |--------------------------------------------------------------------------
                */

                if (
                    data.entered !== undefined &&
                    data.total !== undefined
                ) {

                    document.getElementById(
                        'progressText'
                    ).innerText =
                        `${data.entered} / ${data.total}`;

                    let percent =
                        (data.entered / data.total) * 100;

                    document.getElementById(
                        'progressBar'
                    ).style.width =
                        percent + '%';
                }

                loadRecords(
                    searchInput.value
                );

            } catch (error) {

                console.error(error);

                showToast(
                    'Unable to release record',
                    'error'
                );
            }
        }



        /*
        |--------------------------------------------------------------------------
        | Initial Load
        |--------------------------------------------------------------------------
        */

        loadRecords();

    </script>

</x-app-layout>