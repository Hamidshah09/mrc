<x-guest-layout>
    <x-navbar/>



    <!-- Hero Section -->
    <section class="h-screen bg-cover bg-center flex items-center justify-center relative"
        style="background-image: url('{{ asset('images/main.jpg') }}');">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl font-extrabold mb-6 animate-fadeInUp">
                Welcome to Citizen Facilitation Center
            </h1>
            <p class="text-xl max-w-2xl mx-auto animate-fadeIn delay-200">
                One-stop solution for your essential citizen services
            </p>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="relative py-20 bg-cover bg-center"
         style="background-image: url('{{ asset('images/middle.jpg') }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-white mb-12">Our Main Services</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                
                {{-- Arms  --}}

                <div class="bg-white/20 backdrop-blur-md border border-white/30 
                            shadow-lg rounded-2xl p-8 text-center text-white
                            transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 text-white 
                                flex items-center justify-center rounded-full 
                                text-2xl font-bold shadow-inner">
                        <img src="{{ asset('icons/pistol.svg') }}" alt="">
                    </div>
                    <h3 class="text-xl font-semibold">Arms License</h3>
                </div>
                
                {{-- Domicile --}}
                <a href="{{route('domicile.info')}}">
                    <div class="bg-white/20 backdrop-blur-md border border-white/30 
                                shadow-lg rounded-2xl p-8 text-center text-white
                                transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                        <div class="w-16 h-16 mx-auto mb-4 text-white 
                                    flex items-center justify-center rounded-full 
                                    text-2xl font-bold shadow-inner">
                            <img src="{{ asset('icons/certificate.svg') }}" alt="">
                        </div>
                        <h3 class="text-xl font-semibold">Domicile Certificate</h3>
                    </div>
                </a>

                {{-- IDP --}}
                <a href="">
                    <div class="bg-white/20 backdrop-blur-md border border-white/30 
                                shadow-lg rounded-2xl p-8 text-center text-white
                                transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                        <div class="w-16 h-16 mx-auto mb-4 text-white 
                                    flex items-center justify-center rounded-full 
                                    text-2xl font-bold shadow-inner">
                            <img src="{{ asset('icons/certificate.svg') }}" alt="">
                        </div>
                        <h3 class="text-xl font-semibold">International Driving Permit</h3>
                    </div>
                </a>

                {{-- Marriage --}}
                <a href="{{route('mrc.info')}}">
                    <div class="bg-white/20 backdrop-blur-md border border-white/30 
                                shadow-lg rounded-2xl p-8 text-center text-white
                                transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                        <div class="w-16 h-16 mx-auto mb-4 text-white 
                                    flex items-center justify-center rounded-full 
                                    text-2xl font-bold shadow-inner">
                            <img src="{{ asset('icons/marriage-certificate.svg') }}" alt="">
                        </div>
                        <h3 class="text-xl font-semibold">Marriage Certificate</h3>
                    </div>
                </a>
                
                {{-- Birth Certificate --}}
                <div class="bg-white/20 backdrop-blur-md border border-white/30 
                            shadow-lg rounded-2xl p-8 text-center text-white
                            transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 text-white 
                                flex items-center justify-center rounded-full 
                                text-2xl font-bold shadow-inner">
                        <img src="{{ asset('icons/certificate.svg') }}" alt="">
                    </div>
                    <h3 class="text-xl font-semibold">Birth Certificate</h3>
                </div>

                {{-- Character Certificate --}}
                <div class="bg-white/20 backdrop-blur-md border border-white/30 
                            shadow-lg rounded-2xl p-8 text-center text-white
                            transform hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <div class="w-16 h-16 mx-auto mb-4 text-white 
                                flex items-center justify-center rounded-full 
                                text-2xl font-bold shadow-inner">
                        <img src="{{ asset('icons/character-certificate.svg') }}" alt="">
                    </div>
                    <h3 class="text-xl font-semibold">Police Character Certificate</h3>
                </div>
            </div>
        </div>
    </section>



    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 text-center">
            <div>
                <p class="text-5xl font-extrabold counter" data-count="1200">0</p>
                <p class="mt-2 text-lg">Arms Licenses Issued</p>
            </div>
            <div>
                <p class="text-5xl font-extrabold counter" data-count="950">0</p>
                <p class="mt-2 text-lg">Domiciles Approved</p>
            </div>
            <div>
                <p class="text-5xl font-extrabold counter" data-count="750">0</p>
                <p class="mt-2 text-lg">Driving Permits Issued</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <p>&copy; {{ date('Y') }} Citizen Facilitation Center. All rights reserved.</p>
            <p>Contact: info@cfc.gov</p>
        </div>
    </footer>

    <!-- Counter Animation Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById("servicesBtn");
            const menu = document.getElementById("servicesMenu");

            btn.addEventListener("click", () => {
                menu.classList.toggle("opacity-0");
                menu.classList.toggle("invisible");
            });

            // Optional: close dropdown if clicked outside
            document.addEventListener("click", (e) => {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add("opacity-0", "invisible");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            counters.forEach(counter => {
                let target = +counter.getAttribute("data-count");
                let count = 0;
                let step = target / 100;
                let interval = setInterval(() => {
                    count += step;
                    if (count >= target) {
                        counter.textContent = target;
                        clearInterval(interval);
                    } else {
                        counter.textContent = Math.floor(count);
                    }
                }, 30);
            });
        });
    </script>
</x-guest-layout>
