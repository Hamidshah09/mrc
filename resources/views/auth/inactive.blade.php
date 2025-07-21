<x-guest-layout>
    <div class="text-center mt-8 space-y-4">
        <h1 class="text-2xl font-semibold text-red-600">Account Not Activated</h1>
        <p class="text-gray-700">Your account has been created successfully but is currently <strong>not active</strong>.</p>
        <p class="text-gray-600">Please wait for admin approval or contact support for help.</p>
        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Back to Login</a>
    </div>
</x-guest-layout>
