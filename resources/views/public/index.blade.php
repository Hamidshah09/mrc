<x-guest-layout>
  <div class="px-4 md:px-10 mx-auto max-w-4xl">
    <div class="flex items-center justify-center mb-6">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
    </div>
    <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">
      Citizen Facilitation Center
      <span class="block w-32 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto mt-2 rounded"></span>
    </h3>

    <div class="bg-white border border-indigo-500 shadow rounded-lg p-6">
      <div class="flex flex-col items-center justify-between">
        <p class="text-lg font-medium text-gray-700">Service Menu</p>
        <p class="text-sm text-gray-500">Choose a service to begin</p>
      </div>

      <nav aria-label="Service menu" class="mt-6">
        <ul class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
          <li>
            <a href="{{ route('domicile.public.create') }}" class="group block p-4 rounded-lg bg-white border border-gray-100 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition">
              <div class="flex items-center justify-center flex-col">
                <svg class="w-10 h-10 text-indigo-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c2.21 0 4-1.79 4-4S14.21 3 12 3 8 4.79 8 7s1.79 4 4 4z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"></path>
                </svg>
                <span class="text-indigo-600 font-semibold text-center">Domicile Application</span>
                <span class="sr-only">Open Domicile Application form</span>
              </div>
            </a>
          </li>

          <li>
            <a href="{{ route('noc-other-district.public.create') }}" class="group block p-4 rounded-lg bg-white border border-gray-100 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition">
              <div class="flex items-center justify-center flex-col">
                <svg class="w-10 h-10 text-indigo-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M7 2h6l4 4v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6"></path>
                </svg>
                <span class="text-indigo-600 font-semibold text-center">NOC to Other District</span>
                <span class="sr-only">Open NOC to other district form</span>
              </div>
            </a>
          </li>

          <li>
            <a href="{{ route('noc-ict.public.create') }}" class="group block p-4 rounded-lg bg-white border border-gray-100 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition">
              <div class="flex items-center justify-center flex-col">
                <svg class="w-10 h-10 text-indigo-600 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M7 2h6l4 4v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6"></path>
                </svg>
                <span class="text-indigo-600 font-semibold text-center">NOC for ICT</span>
                <span class="sr-only">Open NOC for ICT form</span>
              </div>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</x-guest-layout>