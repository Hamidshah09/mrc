<x-guest-layout>
  <div class="md:p-10">
    <h3 class="text-2xl font-semibold text-center text-gray-800 mb-8">
      🎉 Record Saved
      <span class="block w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-2 rounded"></span>
    </h3>

    <div class="bg-white border border-indigo-500 shadow rounded-lg p-6 text-center">
      <p class="text-lg font-medium text-gray-700 mb-2">
        Your Record has been saved with the following record ID:
      </p>
      <div class="text-3xl font-bold text-indigo-600">
        {{ $id }}
      </div>
      <a class="p-2 text-center text-white w-full bg-blue-400 rounded-lg block mt-2" href="{{route('idp.edit',  ['id'   => $id,'cnic' => $cnic])}}">Update Current Record</a>
      <a class="p-2 text-center text-white w-full bg-blue-400 rounded-lg block mt-2" href="{{route('idp.create')}}"> Apply another one</a>

    </div>
  </div>
</x-guest-layout>