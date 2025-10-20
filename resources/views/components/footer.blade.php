<footer id="kontak" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-6 py-16 sm:py-16">

        {{-- CONTAINER UTAMA GRID RESPONSIF --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-16 items-center">

            {{-- KOLOM KIRI (Alamat & Logo) --}}
            <div class="space-y-8 text-center md:text-left">
                {{-- Alamat Kantor --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold">Alamat Perusahaan</h3>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs mx-auto md:mx-0">
                        Jl. Desa Nggondang No.6, Gondang II, Gondang, Kec. Karangrejo, Kabupaten Magetan, Jawa Timur
                        63395
                    </p>
                </div>

                {{-- Logo --}}
                <div class="flex justify-center md:justify-start items-center">
                    <img src="{{ asset('images/logo_white.png') }}" alt="Logo Intan Exclusive" class="h-14 sm:h-16">
                </div>
            </div>

            {{-- KOLOM KANAN (CTA) --}}
            <div class="max-w-md mx-auto md:ml-auto space-y-5 text-center md:text-left">
                <h3 class="text-base font-semibold leading-snug">
                    Memenuhi kebutuhan<br class="hidden sm:block">Percetakan dan Konveksi anda
                </h3>

                <div
                    class="flex flex-col sm:flex-row items-center sm:items-start justify-center md:justify-start gap-4 sm:gap-6">
                    <h2 class="text-2xl sm:text-3xl font-bold leading-tight">
                        Buat Pesanan<br class="hidden sm:block">Anda Sekarang...
                    </h2>
                    <a href="/e-commerce"
                        class="h-12 w-12 sm:h-14 sm:w-14 bg-gray-700 rounded-full flex items-center justify-center transition-transform hover:scale-110">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- COPYRIGHT --}}
        <div class="mt-16 sm:mt-20 border-t border-gray-700 pt-6 sm:pt-8 text-center">
            <p class="text-xs sm:text-sm text-gray-500">&copy; 2025 Intan Exclusive. All rights reserved.</p>
        </div>
    </div>
</footer>
