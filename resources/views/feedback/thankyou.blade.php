<x-guest-layout>
<div class="min-h-screen bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-8 text-center">
        <div class="text-white">
            <svg class="mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <h2 class="text-2xl font-semibold mb-2">Thank you!</h2>
            <p class="mb-6 text-indigo-100">Your feedback has been received. We appreciate you taking time to help us improve our services.</p>
            <a href="{{ route('feedback.create') }}" class="inline-block px-6 py-2 bg-white text-indigo-700 rounded-md font-medium">Submit another feedback</a>
        </div>
    </div>
</div>
</x-guest-layout>
