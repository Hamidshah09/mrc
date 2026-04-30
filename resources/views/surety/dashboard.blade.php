<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Surety Dashboard Charts') }}</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <form method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-6 mb-4">
            <div>
                <label class="block text-sm text-gray-600">From</label>
                <input type="date" name="from" value="{{ $from ?? '' }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <label class="block text-sm text-gray-600">To</label>
                <input type="date" name="to" value="{{ $to ?? '' }}" class="border rounded px-2 py-1">
            </div>
            <div>
                <label class="block text-sm text-gray-600">Status</label>
                <select name="status" class="border rounded px-2 py-1">
                    <option value="">All</option>
                    @foreach($surityStatuses as $s)
                        <option value="{{ $s->id }}" {{ (string)($status ?? '') === (string)$s->id ? 'selected' : '' }}>{{ $s->status_name ?? $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded mt-2 md:mt-0">Filter</button>
            </div>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Surety Types (Pie)</h3>
                <canvas id="pieChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Daily Progress (Bar)</h3>
                <canvas id="barChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">User Performance (Actions)</h3>
                <canvas id="userChart"></canvas>
            </div>
        </div>

        <div class="mt-6 bg-gray-50 p-4 rounded">
            <h4 class="font-medium mb-2">Debug (server-side)</h4>
            <div class="text-sm text-gray-700 mb-2">Total records in `suretyregister`: <strong>{{ $totalRecords ?? 0 }}</strong></div>
            <div class="text-sm text-gray-700 mb-2">Matched records for filters: <strong>{{ $matchedRecords->count() ?? 0 }}</strong></div>
            <details class="text-sm"><summary class="cursor-pointer">Show matched records (JSON)</summary>
                <pre class="whitespace-pre-wrap text-xs bg-white p-2 rounded mt-2">{{ json_encode($matchedRecords->map->toArray(), JSON_PRETTY_PRINT) }}</pre>
            </details>
        </div>

        <div class="mt-4 bg-gray-50 p-4 rounded">
            <h4 class="font-medium mb-2">First record (server-side)</h4>
            @if(isset($firstRecord) && $firstRecord)
                <div class="text-sm text-gray-700">ID: <strong>{{ $firstRecord->id }}</strong></div>
                <div class="text-sm text-gray-700">register_id: <strong>{{ $firstRecord->register_id }}</strong></div>
                <div class="text-sm text-gray-700">receipt_date: <strong>{{ optional($firstRecord->receipt_date)->format('Y-m-d H:i:s') ?? $firstRecord->receipt_date }}</strong></div>
                <div class="text-sm text-gray-700">surety_status_id: <strong>{{ $firstRecord->surety_status_id }}</strong></div>
                <details class="text-sm mt-2"><summary class="cursor-pointer">Full JSON</summary>
                    <pre class="whitespace-pre-wrap text-xs bg-white p-2 rounded mt-2">{{ json_encode($firstRecord->toArray(), JSON_PRETTY_PRINT) }}</pre>
                </details>
            @else
                <div class="text-sm text-gray-700">No records found.</div>
            @endif
        </div>
    </div>

    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        const pieLabels = {!! json_encode($pieLabels ?? []) !!};
        const pieData = {!! json_encode($pieData ?? []) !!};
        const dailyLabels = {!! json_encode($dailyLabels ?? []) !!};
        const dailyData = {!! json_encode($dailyData ?? []) !!};

        // Debug: print datasets to console
        console.log('pieLabels', pieLabels);
        console.log('pieData', pieData);
        console.log('dailyLabels', dailyLabels);
        console.log('dailyData', dailyData);

        window.addEventListener('DOMContentLoaded', function () {
            const pieCtx = document.getElementById('pieChart');
            if (pieCtx && pieData && pieData.length) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieLabels,
                        datasets: [{ data: pieData, backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'] }]
                    }
                });
            } else if (pieCtx) {
                pieCtx.parentNode.innerHTML = '<p class="text-sm text-gray-600">No data for pie chart with selected filters.</p>';
            }

            const barCtx = document.getElementById('barChart');
            if (barCtx && dailyData && dailyData.length) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: dailyLabels,
                        datasets: [{ label: 'Count', data: dailyData, backgroundColor: '#2563EB' }]
                    },
                    options: { scales: { y: { beginAtZero: true } } }
                });
            } else if (barCtx) {
                barCtx.parentNode.innerHTML = '<p class="text-sm text-gray-600">No daily data for selected filters.</p>';
            }

            // User performance chart
            const userLabels = {!! json_encode($userLabels ?? []) !!};
            const userData = {!! json_encode($userData ?? []) !!};
            const userCtx = document.getElementById('userChart');
            if (userCtx && userData && userData.length) {
                new Chart(userCtx, {
                    type: 'bar',
                    data: {
                        labels: userLabels,
                        datasets: [{ label: 'Actions', data: userData, backgroundColor: '#059669' }]
                    },
                    options: { indexAxis: 'y', scales: { x: { beginAtZero: true } } }
                });
            } else if (userCtx) {
                userCtx.parentNode.innerHTML = '<p class="text-sm text-gray-600">No user activity for selected filters.</p>';
            }
        });
    </script>
</x-app-layout>
