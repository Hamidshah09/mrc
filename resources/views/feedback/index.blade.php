<x-app-layout>
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Feedbacks</h1>
        <a href="{{ route('feedback.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Open Tablet Form</a>
    </div>

    <form method="GET" action="{{ route('feedback.index') }}" class="bg-white p-4 rounded shadow mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Service</label>
                <select name="service_type_id" class="w-full rounded border-gray-200 p-2">
                    <option value="">All</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" @selected(request('service_type_id') == $s->id)>{{ $s->service }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Citizen name</label>
                <input name="citizen_name" value="{{ request('citizen_name') }}" class="w-full rounded border-gray-200 p-2" placeholder="Name" />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Document No</label>
                <input name="document_no" value="{{ request('document_no') }}" class="w-full rounded border-gray-200 p-2" placeholder="Document no" />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Date range</label>
                <div class="flex gap-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded border-gray-200 p-2" />
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded border-gray-200 p-2" />
                </div>
            </div>
        </div>
        <div class="mt-4 flex gap-2 justify-end">
            <a href="{{ route('feedback.index') }}" class="px-3 py-2 border rounded">Reset</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Service</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Document No</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Citizen</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Rating</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Suggestions</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Submitted At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($feedbacks as $fb)
                    <tr>
                        <td class="px-4 py-2 text-sm">{{ $fb->id }}</td>
                        <td class="px-4 py-2 text-sm">{{ optional($fb->service)->service ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $fb->document_no ?: '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $fb->citizen_name ?: '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $fb->rating }}</td>
                        <td class="px-4 py-2 text-sm">{{ Illuminate\Support\Str::limit($fb->suggestions, 150) }}</td>
                        <td class="px-4 py-2 text-sm">{{ $fb->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-6 text-center text-gray-500">No feedbacks found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $feedbacks->links() }}</div>
</div>
</x-app-layout>
