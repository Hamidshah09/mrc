<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Divorce Dashboard') }}</h2>
    </x-slot>

    <div class="w-[95%] mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-yellow-100 p-4 rounded">
                <div class="text-sm text-gray-600">Pending - First Notice</div>
                <div class="text-xl font-bold">{{ $pendingFirst }}</div>
            </div>

            <div class="bg-orange-100 p-4 rounded">
                <div class="text-sm text-gray-600">Pending - Second Notice</div>
                <div class="text-xl font-bold">{{ $pendingSecond }}</div>
            </div>

            <div class="bg-red-100 p-4 rounded">
                <div class="text-sm text-gray-600">Pending - Third Notice</div>
                <div class="text-xl font-bold">{{ $pendingThird }}</div>
            </div>

            <div class="bg-green-100 p-4 rounded">
                <div class="text-sm text-gray-600">Certificate Issued</div>
                <div class="text-xl font-bold">{{ $certificateIssued }}</div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Monthly Applications (by application_date)</h3>
                <canvas id="applicationsChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-2">Court Hearings (completed)</h3>
                <canvas id="hearingsChart"></canvas>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        const months = {!! json_encode($months ?? []) !!};
        const appCounts = {!! json_encode($appCounts ?? []) !!};
        const hearingCounts = {!! json_encode($hearingCounts ?? []) !!};

        window.addEventListener('DOMContentLoaded', function () {
            const appCtx = document.getElementById('applicationsChart');
            if (appCtx && appCounts && appCounts.length) {
                new Chart(appCtx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{ label: 'Applications', data: appCounts, borderColor: '#2563EB', backgroundColor: 'rgba(37,99,235,0.1)' }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            } else if (appCtx) {
                appCtx.parentNode.innerHTML = '<p class="text-sm text-gray-600">No application data available.</p>';
            }

            const hearCtx = document.getElementById('hearingsChart');
            if (hearCtx && hearingCounts && hearingCounts.length) {
                new Chart(hearCtx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{ label: 'Hearings', data: hearingCounts, backgroundColor: '#10B981' }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            } else if (hearCtx) {
                hearCtx.parentNode.innerHTML = '<p class="text-sm text-gray-600">No hearing data available.</p>';
            }
        });
    </script>
</x-app-layout>
