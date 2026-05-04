<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Domicile Applicants') }}
        </h2>
    </x-slot>
    
    
    <div class="max-w-7xl bg-white mt-3 shadow-md rounded-lg mx-auto overflow-hidden">
        <div class="px-4 py-3 border-b bg-white flex justify-end items-center">
            <a href="{{route('domicile.create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">New Applicant</a>
        </div>
        <div class="px-4 py-3 border-b bg-white">
            <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                <div>
                    <label class="text-sm text-gray-600">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Name, CNIC or ID">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Passcode</label>
                    <input type="text" name="passcode" value="{{ request('passcode') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Passcode">
                </div>
                <div>
                    <label class="text-sm text-gray-600">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
                    <a href="{{ url()->current() }}" class="px-3 py-2 bg-gray-300 rounded">Reset</a>
                </div>
            </form>
        </div>
    <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Applicant Name</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Passcode</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($records as $record)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $record->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $record->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $record->passcode }}</td>
                    <td class="px-6 py-4 text-sm flex flex-row justify-center">
                        <a href="#" onclick="askCnic({{ $record->id }})"
                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                            <x-icons.pencil-square />
                        </a>
                        <a href="{{route('domicile.form_p', $record->id)}}" 
                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                            <x-icons.document-text />
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$records->links()}}
</div>
<script>
function askCnic(recordId) {
    let cnic = prompt("Please enter your 13-digit CNIC number:");

    if (cnic === null) {
        return; // cancelled
    }

    // Must be exactly 13 digits
    let regex = /^[0-9]{13}$/;
    if (!regex.test(cnic)) {
        alert("Invalid CNIC. Please enter a valid 13-digit number.");
        return;
    }

    // Redirect to your route
    window.location.href = `/domicile/edit/${recordId}/${cnic}`;
}
// function askCnicFp(recordId) {
//     let cnic = prompt("Please enter your 13-digit CNIC number:");

//     if (cnic === null) {
//         return; // cancelled
//     }

//     // Must be exactly 13 digits
//     let regex = /^[0-9]{13}$/;
//     if (!regex.test(cnic)) {
//         alert("Invalid CNIC. Please enter a valid 13-digit number.");
//         return;
//     }

//     // Redirect to your route
//     window.location.href = `/domicile/form-p/${recordId}/${cnic}`;
// }
</script>
</x-app-layout>
