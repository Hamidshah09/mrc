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
                    <div class="text-lg mb-3">
                        Audit Progress      
                    </div>
                    <div class="flex justify-between">
                        <h4 class="text-lg font-medium text-gray-800">{{$percentAudited}}%</h4>
                        <h4 class="text-lg font-medium text-gray-800">{{$totalAudited}}</h4>
                        <h4 class="text-lg font-medium text-gray-800">{{$totalLicenses}}</h4>
                    </div>
                    
                    
                    <div class="relative pt-1">
                        <div class="overflow-hidden h-4 mb-4 text-xs flex rounded-lg bg-blue-100">
                            <div style="width: {{$percentAudited}}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
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
        <div class="grid grid-cols-1 mx-3 sm:mx-2 sm:grid-cols-2 gap-6">
            <div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Year</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Month</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Approved Licenses</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($monthlyApprovedByDc as $approvedApps)
                            <tr>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->year }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->month_name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->total_approved }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Year</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Month</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Approved Licenses</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($monthlyApprovedByAdcg as $approvedApps)
                            <tr>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->year }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->month_name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $approvedApps->total_approved }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>     
        </div>
    </div>
</x-app-layout>
