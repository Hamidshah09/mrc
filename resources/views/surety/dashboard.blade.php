<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Surety Dashboard Charts') }}</h2>
    </x-slot>

    <div class="w-[95%] mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-blue-100 p-4 rounded">
                <div class="text-sm text-gray-600">Total Records</div>
                <div class="text-xl font-bold">{{ $totalRecords }}</div>
            </div>

            <div class="bg-green-100 p-4 rounded">
                <div class="text-sm text-gray-600">Total Amount</div>
                <div class="text-xl font-bold">{{ number_format($totalAmount) }}</div>
            </div>

            <div class="bg-yellow-100 p-4 rounded">
                <div class="text-sm text-gray-600">Today Entries</div>
                <div class="text-xl font-bold">{{ $todayCount }}</div>
            </div>

            <div class="bg-purple-100 p-4 rounded">
                <div class="text-sm text-gray-600">Completed</div>
                <div class="text-xl font-bold">{{ $completedCount }}</div>
            </div>

        </div>
        <form method="GET" class="w-full flex flex-col md:flex-row md:items-end md:space-x-6 mb-4">
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Daily Progress (Bar)</h3>
                <canvas id="barChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">User Performance (Actions)</h3>
                <canvas id="userChart"></canvas>
            </div>
        
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Daily Amount</h3>
                <canvas id="amountChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold mb-2">Surety Types (Pie)</h3>
                    <canvas id="pieChart"></canvas>
            </div>
        </div>
            
            
        <div class="w-[95%] mx-auto bg-white shadow-lg rounded-xl mt-6 overflow-hidden">

            <div class="px-6 py-4 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-800">
                    User Performance Today
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Entries created by users today
                </p>
            </div>

            @if(!empty($userPerformance) && count($userPerformance))

                @php
                    $maxEntries = collect($userPerformance)->max('total');
                    $grandTotal = collect($userPerformance)->sum('total');
                @endphp

                <div class="divide-y divide-gray-100">

                    @foreach($userPerformance as $i => $u)

                        @php
                            $percentage = $maxEntries > 0
                                ? ($u['total'] / $maxEntries) * 100
                                : 0;

                            $share = $grandTotal > 0
                                ? round(($u['total'] / $grandTotal) * 100, 1)
                                : 0;
                        @endphp

                        <div class="px-6 py-4 hover:bg-gray-50 transition">

                            <div class="flex items-center justify-between mb-2">

                                <div class="flex items-center gap-3">

                                    {{-- Rank --}}
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                                        {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $i === 1 ? 'bg-gray-200 text-gray-700' : '' }}
                                        {{ $i === 2 ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $i > 2 ? 'bg-blue-100 text-blue-700' : '' }}
                                    ">
                                        {{ $i + 1 }}
                                    </div>

                                    {{-- User --}}
                                    <div>
                                        <div class="font-medium text-gray-800">
                                            {{ $u['name'] }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $share }}% of today's entries
                                        </div>
                                    </div>

                                </div>

                                {{-- Count --}}
                                <div class="text-right">
                                    <div class="text-xl font-bold text-gray-800">
                                        {{ $u['total'] }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        entries
                                    </div>
                                </div>

                            </div>

                            {{-- Progress Bar --}}
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600"
                                    style="width: {{ $percentage }}%">
                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="p-6 text-sm text-gray-500">
                    No user activity for selected date range.
                </div>

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
        const amountLabels = {!! json_encode($amountLabels ?? []) !!};
        const amountData = {!! json_encode($amountData ?? []) !!};

        const amountCtx = document.getElementById('amountChart');
        if (amountCtx && amountData.length) {
            new Chart(amountCtx, {
                type: 'line',
                data: {
                    labels: amountLabels,
                    datasets: [{
                        label: 'Amount',
                        data: amountData
                    }]
                }
            });
        }
    </script>
</x-app-layout>
