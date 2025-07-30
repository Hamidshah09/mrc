<x-guest-layout>
  <div class="md:p-10">
    <h3 class="text-2xl font-semibold text-center text-gray-800 mb-8">
      🎉 Letter Created Successfully
      <span class="block w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-2 rounded"></span>
    </h3>

    <div class="bg-white border border-indigo-500 shadow rounded-lg p-6 text-center">
      <p class="text-lg font-medium text-gray-700 mb-2">
        Your letter has been saved with the following record ID:
      </p>
      <div class="text-3xl font-bold text-indigo-600">
        {{ $id }}
      </div>
      <p class="mt-4 text-gray-600">Please intimate this id to dealing person on counter.</p>

    </div>
  </div>
</x-guest-layout>