<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="back-width mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded relative mb-4 m-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 m-2">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center space-x-4 m-2 mb-4">
                    <form action="" method="GET" class="mt-3">
                        <div class="flex flex-row flex-wrap items-center">
                            <x-text-input id="search" class="mt-1 w-48 p-2 mx-2" type="text" name="search" value="{{ old('search') }}" autofocus autocomplete="search" />
                            <x-primary-button class="mt-1 ms-3" type="submit">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Button group aligned to the right -->
                    <div class="flex space-x-2 ml-auto">
                        <button onclick="openCreateModal()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-300">
                            Create New
                        </button>
                        <button onclick="openEditModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-300">
                            Update
                        </button>
                    </div>
                </div>
                 @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md border border-red-300">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="px-4 md:block overflow-x-auto rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th rowspan="2" class="border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                @foreach ($centers as $center)
                                    <th colspan="{{ count($center['services']) }}"
                                        class="border border-gray-300 text-center px-6 py-3 text-lg font-semibold text-gray-600 uppercase tracking-wider">
                                        {{ $center['location'] }}
                                    </th>
                                    
                                @endforeach
                                <th rowspan="2" class="border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                            <tr>
                                @foreach ($centers as $center)
                                    @foreach ($center['services'] as $service)
                                        <th class="border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ $service->service }}
                                        </th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($reportRows as $row)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800 text-center font-semibold">
                                        {{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}
                                    </td>
                                    @foreach (array_slice($row, 1) as $count)
                                        <td class="px-6 py-4 text-sm text-gray-800 text-center">{{ $count }}</td>
                                    @endforeach
                                    <td>
                                        <a class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-300" href="{{ route('statistics.pdf', ['report_date' => $row['date']]) }}" class="text-blue-600 hover:underline">
                                            Report
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="dynamicModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        
        <!-- Inner Modal -->
        <div class="bg-white rounded-2xl shadow-xl w-[95vw] sm:w-[80vw] md:w-[70vw] lg:w-[50vw] max-h-[90vh] overflow-y-auto p-6">
            
            <!-- Modal Title -->
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Create New Record</h2>

            <!-- Modal Form -->
            <form id="modalForm" method="POST" action="">
                @csrf
                <div id="formFields"><!-- Dynamic fields go here --></div>

                <!-- Footer Buttons -->
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button"
                            onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const centersData = @json($center_services);
        function openCreateModal() {
            document.getElementById("modalTitle").innerText = "Create New Report";

            const form = document.getElementById("modalForm");
            form.action = "{{ route('statistics.store') }}";

            // 🔹 Build the center dropdown
            let centerOptions = `<option value="">-- Select Center --</option>`;
            centersData.forEach(center => {
                centerOptions += `<option value="${center.id}">${center.location}</option>`;
            });

            // 🔹 Base form structure (center + date)
            document.getElementById("formFields").innerHTML = `
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium">Select Center</label>
                    <select name="center_id" id="center_id" class="w-full border rounded p-2 mt-1">
                        ${centerOptions}
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Report Date</label>
                    <input type="date"
                        name="report_date"
                        id="report_date"
                        value="{{ now()->toDateString() }}"
                        class="w-full border rounded p-2 mt-1">
                </div>

                <div id="servicesFields"></div>
            `;

            // 🔹 Show modal
            document.getElementById("dynamicModal").classList.remove("hidden");

            // 🔹 On center change → load its services dynamically
            document.getElementById("center_id").addEventListener("change", (e) => {
                const centerId = e.target.value;
                const center = centersData.find(c => String(c.id) === String(centerId));
                let servicesHTML = '';

                if (center && center.services && center.services.length > 0) {
                    servicesHTML += `<h3 class="font-semibold text-gray-700 mb-2">Services Offered</h3>`;
                    center.services.forEach(service => {
                        servicesHTML += `
                            <div class="mb-3">
                                <label class="block text-sm font-medium capitalize">${service.service}</label>
                                <input type="number"
                                    name="services[${service.id}]"
                                    min="0"
                                    class="w-full border rounded p-2 mt-1"
                                    placeholder="Enter count">
                            </div>
                        `;
                    });
                } else {
                    servicesHTML = `<p class="text-gray-500 italic">No services configured for this center.</p>`;
                }

                document.getElementById("servicesFields").innerHTML = servicesHTML;
            });
        }

        function openEditModal(statistic = null) {
            document.getElementById("modalTitle").innerText = statistic ? "Edit Report" : "Create New Report";

            const form = document.getElementById("modalForm");
            form.action = "{{ route('statistics.upsert') }}"; // unified route

            // Build center dropdown
            let centerOptions = `<option value="">-- Select Center --</option>`;
            centersData.forEach(center => {
                const selected = statistic && statistic.center_id === center.id ? 'selected' : '';
                centerOptions += `<option value="${center.id}" ${selected}>${center.location}</option>`;
            });

            // Build service dropdown
            let serviceOptions = `<option value="">-- Select Service --</option>`;
            const allServices = centersData.flatMap(c => c.services);
            const uniqueServices = Object.values(
                allServices.reduce((acc, s) => {
                    acc[s.id] = s;
                    return acc;
                }, {})
            );
            uniqueServices.forEach(service => {
                const selected = statistic && statistic.service_id === service.id ? 'selected' : '';
                serviceOptions += `<option value="${service.id}" ${selected}>${service.service}</option>`;
            });

            // Build form
            document.getElementById("formFields").innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="mb-4">
                    <label class="block text-sm font-medium">Select Center</label>
                    <select name="center_id" class="w-full border rounded p-2 mt-1">
                        ${centerOptions}
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Select Service</label>
                    <select name="service_id" class="w-full border rounded p-2 mt-1">
                        ${serviceOptions}
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Report Date</label>
                    <input type="date"
                        name="report_date"
                        value="${statistic?.report_date ?? '{{ now()->toDateString() }}'}"
                        class="w-full border rounded p-2 mt-1">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Service Count</label>
                    <input type="number"
                        name="service_count"
                        min="0"
                        value="${statistic?.service_count ?? ''}"
                        class="w-full border rounded p-2 mt-1"
                        placeholder="Enter count">
                </div>
            `;

            document.getElementById("dynamicModal").classList.remove("hidden");
        }
        function closeModal() {
            document.getElementById("dynamicModal").classList.add("hidden");
        }
    </script>
</x-app-layout>
