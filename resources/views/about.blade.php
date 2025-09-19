<x-guest-layout>
    <x-navbar/>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <!-- Hero -->
    <section class="relative bg-gray-900 text-white">
        <div class="absolute inset-0">
            <img src="/images/out-door-corner.jpg" alt="CFC Center" class="w-full h-full object-cover opacity-60">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-6 text-center">
            <h1 class="text-4xl font-bold">Citizen Facilitation Center</h1>
            <p class="mt-4 text-lg">The Citizen Facilitation Center was established in year 2017, in order to deliver various services of  the Deputy Commissioner’s Office in a better environment. The Citizens of Capital have been provided services in a fully air-conditioned lounge along with a computerized token system, hot/cold drinking water, 56” inch TV Screens, neat & clean toilets etc. 
            </p>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="max-w-7xl mx-auto py-16 px-6 text-center grid md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow">
            <h3 class="text-2xl font-semibold text-gray-800">Our Mission</h3>
            <p class="mt-4 text-gray-600">
                To provide seamless and citizen-centered services in a modern, efficient, and transparent way.
            </p>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow">
            <h3 class="text-2xl font-semibold text-gray-800">Our Vision</h3>
            <p class="mt-4 text-gray-600">
                To be a one-stop hub for all government services with world-class standards and accessibility.
            </p>
        </div>
    </section>

    <!-- Facilities Gallery -->
    <section class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-10">Our Facilities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/token.jpg" alt="Reception" class="w-full h-64 object-cover">
                </div>
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/counters.jpg" alt="Waiting Area" class="w-full h-64 object-cover">
                </div>
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/washroom.jpg" alt="Service Counters" class="w-full h-64 object-cover">
                </div>
                <!-- Add more facility photos -->
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/facilities.jpg" alt="Reception" class="w-full h-64 object-cover">
                </div>
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/counters-inside.jpg" alt="Waiting Area" class="w-full h-64 object-cover">
                </div>
                <div class="overflow-hidden rounded-xl shadow hover:scale-105 transition">
                    <img src="/images/desk.jpg" alt="Service Counters" class="w-full h-64 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-gray-100"> 
        <div class="container mx-auto px-2 text-center my-8">
            <h2 class="text-2xl md:text-3xl font-semibold mb-4">
                📍 Our Location
            </h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3320.491529052366!2d73.00707727635888!3d33.66688817332492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df95f13168702f%3A0x5388b1b4fc48c57e!2sCitizen%20Facilitation%20Center%20Islamabad!5e0!3m2!1sen!2s!4v1726731840000!5m2!1sen!2s"
                class="w-full h-[400px] md:h-[500px] rounded-xl shadow"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>
    <section class="py-16 bg-white text-center">
        <h2 class="text-2xl font-bold">Visit Us Today</h2>
        <p class="mt-2 text-gray-600">We’re here to help at every step of your journey.</p>
        <p class="text-gray-600">Email:citizenfacalitationcenter@gmail.com</p>
        <p class="text-gray-600">Helpline:051-8899611</p>
        <p class="text-gray-600">Helpline:051-8899622</p>
    </section>
</x-guest-layout>
