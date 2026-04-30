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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Surety Types (Pie)</h3>
                <canvas id="pieChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Daily Progress (Bar)</h3>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieLabels = {!! json_encode($pieLabels ?? []) !!};
        const pieData = {!! json_encode($pieData ?? []) !!};
        const dailyLabels = {!! json_encode($dailyLabels ?? []) !!};
        const dailyData = {!! json_encode($dailyData ?? []) !!};

        const pieCtx = document.getElementById('pieChart');
        if (pieCtx) {
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{ data: pieData, backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'] }]
                }
            });
        }

        const barCtx = document.getElementById('barChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: dailyLabels,
                    datasets: [{ label: 'Count', data: dailyData, backgroundColor: '#2563EB' }]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });
        }
    </script>
</x-app-layout>
