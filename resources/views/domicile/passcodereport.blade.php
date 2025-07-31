<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Passcodes') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Passcode Tickets for {{ $date->format('F j, Y') }}</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($passcodes as $code)
            <div class="border shadow rounded p-4 flex flex-col items-center bg-white print:break-inside-avoid">
                <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" class="w-24 h-24 mb-4">
                <div class="text-lg font-semibold tracking-widest">{{ $code->code }}</div>
            </div>
        @endforeach
    </div>
</div>



</x-app-layout>