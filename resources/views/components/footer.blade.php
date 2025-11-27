<footer id="kontak" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-6 py-16 sm:py-16">

        {{-- GRID UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-start">

            {{-- KOLOM KIRI --}}
            <div class="space-y-8 text-center md:text-left">

                {{-- Alamat --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold">Alamat Perusahaan</h3>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs mx-auto md:mx-0">
                        Jl. Desa Nggondang No.6, Gondang II, Gondang,
                        Kec. Karangrejo, Kabupaten Magetan, Jawa Timur 63395
                    </p>
                </div>

                {{-- Kontak --}}
                <div class="space-y-3 text-gray-400 text-sm">

                    {{-- Telepon --}}
                    <p class="flex items-center gap-2 justify-center md:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-.793c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293c-.282.376-.81.524-1.257.34a12.035 12.035 0 01-7.143-7.143c-.184-.447-.036-.975.34-1.257l1.293-.97c.363-.272.53-.734.417-1.173L6.184 3.102A1.125 1.125 0 005.093 2.25H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        <a href="tel:085853418653" class="hover:text-white transition">
                            0858-5341-8653
                        </a>
                    </p>

                    {{-- Gmail --}}
                    <p class="flex items-center gap-2 justify-center md:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12 13.065L1.5 6V18.75A1.25 1.25 0 002.75 20h18.5a1.25 1.25 0 001.25-1.25V6L12 13.065z" />
                            <path d="M22.25 4H1.75l10.25 6.85L22.25 4z" />
                        </svg>
                        <a href="mailto:percetakanexclusive@gmail.com" class="hover:text-white transition">
                            percetakanexclusive@gmail.com
                        </a>
                    </p>

                    {{-- WhatsApp --}}
                    <p class="flex items-center gap-2 justify-center md:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M12.04 2C6.58 2 2.2 6.37 2.2 11.82c0 2.09.61 4.03 1.75 5.72L2 22l4.59-1.86c1.62.93 3.47 1.41 5.38 1.41h.05c5.46 0 9.83-4.37 9.83-9.82C21.85 6.37 17.5 2 12.04 2zm5.62 13.59c-.24.67-1.39 1.32-1.94 1.38-.5.05-1.12.07-1.81-.11-.42-.11-.95-.31-1.63-.61-2.87-1.25-4.74-4.16-4.88-4.35-.14-.19-1.16-1.54-1.16-2.94s.73-2.09 1-2.38c.26-.29.57-.36.76-.36h.54c.17 0 .4-.06.63.48.24.57.81 1.97.88 2.11.07.14.12.3.02.48-.1.19-.15.3-.29.46-.14.16-.3.36-.43.49-.14.14-.29.29-.13.57.16.29.7 1.16 1.5 1.88 1.03.92 1.89 1.2 2.19 1.34.29.14.46.12.62-.07.17-.19.72-.84.91-1.12.19-.29.38-.24.63-.14.26.1 1.66.78 1.95.92.29.14.48.22.55.34.07.12.07.7-.17 1.37z" />
                        </svg>
                        <a href="https://wa.me/6285853418653" target="_blank" class="hover:text-white transition">
                            +62 858-5341-8653 (WhatsApp)
                        </a>
                    </p>

                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-8 text-center md:text-right">

                {{-- Logo --}}
                <div class="flex justify-center md:justify-end items-center">
                    <img src="{{ asset('images/logo_white.png') }}" alt="Logo Intan Exclusive" class="h-14 sm:h-16">
                </div>

                {{-- CTA --}}
                <div class="max-w-md mx-auto md:ml-auto space-y-5 text-center md:text-right">

                    <h3 class="text-base font-semibold leading-snug">
                        Memenuhi kebutuhan<br class="hidden sm:block">
                        Percetakan dan Konveksi anda
                    </h3>

                    <div
                        class="flex flex-col sm:flex-row items-center md:items-end justify-center md:justify-end gap-4 sm:gap-6">

                        <h2 class="text-2xl sm:text-3xl font-bold leading-tight">
                            Buat Pesanan<br class="hidden sm:block">Anda Sekarang...
                        </h2>

                        <a href="/e-commerce"
                            class="h-12 w-12 sm:h-14 sm:w-14 bg-gray-700 rounded-full flex items-center justify-center transition-transform hover:scale-110">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="mt-16 sm:mt-20 border-t border-gray-700 pt-6 sm:pt-8 text-center">
            <p class="text-xs sm:text-sm text-gray-500">
                &copy; 2025 Intan Exclusive. All rights reserved.
            </p>
        </div>

    </div>
</footer>
