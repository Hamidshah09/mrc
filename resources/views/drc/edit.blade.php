<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Divorce Case') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded mt-10">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('drc.update', $divorceCase) }}" method="POST">
            @method('PUT')
            @include('drc._form', ['formMode' => $divorceCase->entry_type === 'old' ? 'old' : 'live'])
        </form>
    </div>
</x-app-layout>
