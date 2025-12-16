<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arms Statistics') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">

       <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4 mx-3 sm:mx-2">Arms Statistics</h3>
            <div class="grid grid-cols-1 mx-3 sm:mx-2 sm:grid-cols-2 lg:grid-cols-3 gap-6" >
                
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-lg font-semibold mb-4 text-gray-800">
                        Audit Progress
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                        <div>
                            <div class="text-sm text-gray-500">Progress</div>
                            <div class="text-lg font-medium text-gray-800">
                                {{ $percentAudited }}%
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500">Audited</div>
                            <div class="text-lg font-medium text-gray-800">
                                {{ $totalAudited }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500">Total</div>
                            <div class="text-lg font-medium text-gray-800">
                                {{ $totalLicenses }}
                            </div>
                        </div>
                    </div>

                    @php
                        $progressWidth = max(0, min(100, round($percentAudited)));
                    @endphp

                    {{-- Progress Bar --}}
                    <div class="w-full bg-blue-100 rounded-full h-4 overflow-hidden">
                        <div
                            class="h-full bg-blue-600 transition-all duration-700 ease-out"
                            style="width: {{ $progressWidth }}%;">
                        </div>
                    </div>

                    {{-- Label --}}
                    <div class="mt-2 text-sm text-gray-600 text-right">
                        {{ $totalAudited }} of {{ $totalLicenses }} audited
                    </div>
                </div>


                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">Approved By DC</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$approvedByDc}}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">Approved By Adcg</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$approvedByAdcg}}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">No Address on CNIC Approved By DC</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$noAddressByDc}}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">No Address on CNIC Approved By ADCG</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$noAddressByAdcg}}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">No Character Certificate Approved By DC</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$nocharacterByDc}}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-3">
                        
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-3">No Character Certificate Approved By ADCG</h4>
                    <div class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        {{$nocharacterByAdcg}}
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        <div class="grid grid-cols-1 mx-3">
            <div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Year</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Month</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Total Issued</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Identified as Approved By DC</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Identified as Approved By ADCG</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Remaining</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($monthlyissued as $issued)
                            @php
                                $key = $issued->year . '-' . $issued->month;

                                $dcCount       = $dcApproved[$key]->total_approved ?? 0;
                                $adcgCount     = $adcgApproved[$key]->total_approved ?? 0;
                                $remainingCount = $remainingLicenses[$key]->total_approved ?? 0;
                            @endphp

                            <tr>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $issued->year }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $issued->month_name }}
                                </td>

                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    {{ $issued->total_approved }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $dcCount }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $adcgCount }}
                                </td>

                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    {{ $remainingCount }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                </table>
            </div> 
        </div>
    </div>
</x-app-layout>
