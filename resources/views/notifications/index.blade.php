<x-app-layout>

    <div class="py-6">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">

                Notifications

            </h2>

            <div class="bg-white shadow rounded-xl overflow-hidden">

                @forelse($notifications as $notification)

                    <div class="border-b p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <h3 class="font-bold text-gray-800">

                                    {{ $notification->title }}

                                </h3>

                                <p class="text-gray-600 mt-2">

                                    {{ $notification->message }}

                                </p>

                                <div class="text-sm text-gray-400 mt-2">

                                    {{ $notification->created_at->diffForHumans() }}

                                </div>

                            </div>

                            <div class="flex flex-col gap-2">

                                @if(!$notification->is_read)

                                    <form action="{{ route('notifications.read', $notification->id) }}"
                                          method="POST">

                                        @csrf

                                        <button type="submit"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">

                                            Mark Read

                                        </button>

                                    </form>

                                @endif

                                @if($notification->complaint_id)

                                    @php

                                        $role = auth()->user()->role->role;

                                        $routeName = '';

                                        switch($role) {

                                            case 'AC':
                                                $routeName = 'ac.complaints.show';
                                                break;

                                            case 'Magistrate':
                                                $routeName = 'magistrate.complaints.show';
                                                break;

                                            case 'ADCG':
                                                $routeName = 'adcg.complaints.show';
                                                break;
                                        }

                                    @endphp

                                    @if($routeName)

                                        <a href="{{ route($routeName, $notification->complaint_id) }}"
                                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm text-center">

                                            Open Complaint

                                        </a>

                                    @endif

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="p-8 text-center text-gray-500">

                        No notifications found.

                    </div>

                @endforelse

            </div>

            <div class="mt-6">

                {{ $notifications->links() }}

            </div>

        </div>

    </div>

</x-app-layout>