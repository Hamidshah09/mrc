<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Downloads') }}
        </h2>
    </x-slot>
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">
    
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">Download Link</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td role="th" class="px-6 py-4 text-center text-sm text-gray-800">IDP Zip</td>
                <td class="px-6 py-4 text-center text-sm text-gray-800 underline"><a href="{{asset('storage/zip/idp.zip')}}">Download</a></td>   
            </tr>
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td role="th" class="px-6 py-4 text-center text-sm text-gray-800">Domicile App</td>
                <td class="px-6 py-4 text-center text-sm text-gray-800 underline"><a href="{{asset('storage/zip/CFC_APP_Main.zip')}}">Download</a></td>   
            </tr>
        </tbody>
    </table>
</div>
</x-app-layout>
