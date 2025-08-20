<x-guest-layout>
  <div class="md:p-10">
    <h3 class="text-2xl font-semibold text-center text-gray-800 mb-8">
          No Record 
      <span class="block w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-2 rounded"></span>
    </h3>

    <div class="bg-white border border-indigo-500 shadow rounded-lg p-6 text-center">
      <p class="text-lg font-medium text-gray-700 mb-2">
        Incorrect CNIC number provided
      </p>
      <a href="{{route('domicile.index')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</a>

    </div>
  </div>
</x-guest-layout>