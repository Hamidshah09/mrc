<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MRC Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-[95%] mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <form class="grid gap-4 grid-cols-1 md:grid-cols-6 items-end mb-4" method="GET" action="{{ route('mrc.dashboard') }}">
            <div class="flex flex-col">
                <label for="from" class="text-sm font-medium text-gray-700">From</label>
                <input type="date" name="from" value="{{ $from }}" class="border rounded px-2 py-2 w-full">
            </div>
            <div class="flex flex-col">
                <label for="to" class="text-sm font-medium text-gray-700">To</label>
                <input type="date" name="to" value="{{ $to }}" class="border rounded px-2 py-2 w-full">
            </div>
            <div class="flex flex-col md:col-span-2">
                <label for="union_council_id" class="text-sm font-medium text-gray-700">Union Council</label>
                <select name="union_council_id" id="union_council_id" class="border rounded px-2 py-2 w-full">
                    <option value="all" {{ $selectedUnionCouncil === 'all' ? 'selected' : '' }}>All</option>
                    @foreach($unionCouncils as $council)
                        <option value="{{ $council->id }}" {{ (string) $selectedUnionCouncil === (string) $council->id ? 'selected' : '' }}>{{ $council->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-1 md:flex md:justify-end">
                <button class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-white rounded shadow">
                <h3 class="font-semibold mb-2">Daily Total Entries</h3>
                <canvas id="totalChart"></canvas>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <h3 class="font-semibold mb-2">Daily Entries Per User</h3>
                <canvas id="perUserChart"></canvas>
            </div>
        </div>

        <div class="mt-6 bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Daily entries per user (table)</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">User</th>
                            <th class="px-4 py-2 text-left">Union Council</th>
                            <th class="px-4 py-2 text-left">Count</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($tableRows as $row)
                            <tr>
                                <td class="px-4 py-2">{{ $row['user'] }}</td>
                                <td class="px-4 py-2">{{ $row['union_council'] }}</td>
                                <td class="px-4 py-2">{{ $row['count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <td class="px-4 py-3">Total</td>
                            <td class="px-4 py-3"></td>
                            <td class="px-4 py-3">{{ $totalCount ?? 0 }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        const labels = @json($period);
        const totalData = @json($totalValues);
        const series = @json($series);

        // Total chart
        const ctxTotal = document.getElementById('totalChart').getContext('2d');
        new Chart(ctxTotal, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total',
                    data: totalData,
                    borderColor: 'rgba(37,99,235,1)',
                    backgroundColor: 'rgba(37,99,235,0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { display: true },
                    y: { beginAtZero: true }
                }
            }
        });

        // Per-user stacked bar
        const ctxUser = document.getElementById('perUserChart').getContext('2d');
        const userDatasets = series.map((s, idx) => ({
            label: s.label,
            data: s.data,
            backgroundColor: `hsl(${(idx * 60) % 360} 70% 50% / 0.7)`,
            borderColor: `hsl(${(idx * 60) % 360} 70% 40%)`,
            borderWidth: 1
        }));

        new Chart(ctxUser, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: userDatasets
            },
            options: {
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>
