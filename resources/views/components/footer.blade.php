<footer id="kontak" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-8 py-20">
        {{-- CONTAINER UTAMA GRID 2 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            {{-- KOLOM KIRI (Konten Alamat & Logo) --}}
            <div class="space-y-8">
                {{-- Alamat Kantor --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold">Alamat Kantor</h3>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs">
                        Jl. Desa Nggondang No.6, Gondang II, Gondang, Kec. Karangrejo, Kabupaten Magetan, Jawa Timur
                        63395
                    </p>
                </div>

                {{-- Logo --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/logo_white.png') }}" alt="Logo Intan Exclusive" class="h-16">
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (CTA) --}}
            <div class="max-w-md ml-auto space-y-5 text-left">
                <h3 class="text-base font-semibold">Memenuhi kebutuhan<br>Percetakan dan Konveksi anda</h3>
                <div class="flex items-center gap-4 justify-start">
                    <h2 class="text-3xl font-bold leading-tight">Buat Pesanan<br>Anda Sekarang...</h2>
                    <a href="#"
                        class="flex-shrink-0 h-14 w-14 bg-gray-700 rounded-full flex items-center justify-center transition-transform hover:scale-110">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="mt-20 border-t border-gray-700 pt-8 text-center">
            <p class="text-sm text-gray-500">&copy; 2025 Intan Exclusive. All rights reserved.</p>
        </div>

    </div>
</footer>
