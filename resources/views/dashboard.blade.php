<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Online Services --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Apply for an Online Service</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                            <div class="text-4xl mb-3">
                                {{$service->icon}}
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 mb-3">{{ $service->application_type }}</h4>
                            <a href="{{ route($service->route) }}"
                               class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                Apply Now
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Submitted Applications --}}
            <div>
                <h3 class="text-xl font-bold text-gray-700 mb-4">Your Submitted Applications</h3>
                @if ($applications->isEmpty())
                    <p class="text-gray-500">You haven’t submitted any applications yet.</p>
                @else
                    <div class="bg-white overflow-hidden shadow rounded-2xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Service</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Application submitted by</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Submitted On</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Documents</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($applications as $app)
                                    <tr>
                                        <td class="px-6 py-4 text-gray-700">{{ $app->application_type->application_type }}</td>
                                        <td class="px-6 py-4 text-gray-700">{{ $app->user->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs rounded-full 
                                                {{ $app->application_status->application_status === 'approved' ? 'bg-green-100 text-green-700' :
                                                   ($app->application_status->application_status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                                   'bg-red-100 text-red-700') }}">
                                                {{ ucfirst($app->application_status->application_status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $app->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-start items-center space-x-3">
                                                <a href="{{ asset('storage/' . $app->documents) }}" 
                                                target="_blank"
                                                class="inline-flex items-center gap-1 hover:text-indigo-800 text-sm font-medium">
                                                    {{-- View icon --}}
                                                    <x-icon name="file-text" class="w-5 h-5 text-yellow-600" />
                                                    Documents
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-start items-center space-x-3">
                                                <a href="{{route('online.application.show', $app->id)}}" 
                                                    target="_blank"
                                                    class="inline-flex items-center gap-1 hover:text-indigo-800 text-sm font-medium">
                                                        {{-- View icon --}}
                                                        <x-icon name="info" class="w-5 h-5 text-green-600" />
                                                        Details
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

