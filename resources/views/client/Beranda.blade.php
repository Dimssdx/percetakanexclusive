<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intan Exclusive - Landing Page</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo only.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }

        main>div {
            scroll-snap-align: start;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background-color: #FFFFFF;
        }
    </style>
</head>

<!-- Navbar -->
@include('components.navbar')

<body>
    <!-- Beranda -->
    <div id="beranda" class="flex flex-col justify-start">
        <div class="max-w-7xl mx-auto px-8 pt-15">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-2/5 text-center lg:text-left">
                    <h1 class="text-5xl font-bold leading-tight text-slate-800">
                        Solusi Percetakan<br>& Konveksi<br>Terpercaya
                    </h1>
                    <p class="mt-5 text-base leading-relaxed text-slate-600">
                        Solusi lengkap untuk kebutuhan percetakan dan konveksi Anda. Proses produksi kami yang
                        efisien memastikan pesanan Anda selesai tepat waktu dengan standar kualitas terbaik.
                    </p>
                </div>
                <div class="lg:w-3/5">
                    <img src="{{ asset('images/main-picture.svg') }}" alt="Ilustrasi Percetakan dan Konveksi"
                        class="w-full h-auto object-contain">
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami -->
    <div id="tentang-kami" class="bg-white pt-16 pb-16 lg:pt-20 lg:pb-10">
        <div class="max-w-7xl mx-auto px-8">
            <div>
                <img src="{{ asset('images/about.svg') }}" alt="Suasana kerja di Intan Exclusive"
                    class="rounded-xl shadow-xl w-full">
            </div>
            <div class="mt-10 text-center">
                <h2 class="text-5xl font-bold text-gray-800">Percetakan dan Konveksi</h2>
                <p class="mt-4 text-base text-gray-600 leading-relaxed max-w-7xl mx-auto text-justify">
                    Kami adalah perusahaan percetakan dan konveksi yang menyediakan berbagai kebutuhan instansi,
                    sekolah, dan perusahaan.
                    Layanan kami mencakup pembuatan spanduk, banner, seragam, kaos sablon, papan nama, serta
                    perlengkapan sekolah dan kantor lainnya.
                    Dengan dukungan tim berpengalaman, teknologi modern, dan standar kualitas tinggi, kami
                    berkomitmen menghadirkan hasil yang rapi,
                    tahan lama, dan sesuai dengan kebutuhan pelanggan.
                </p>
            </div>
        </div>
    </div>

    <div id="layanan" class="bg-white pt-10 pb-24">
        <div class="max-w-7xl mx-auto px-8">
            <h2 class="text-center text-5xl font-bold text-gray-800">Layanan Kami</h2>
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                <a href="{{ url('/produk?kategori=percetakan') }}"
                    class="block p-8 rounded-xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75h6l-3-3-3 3z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Percetakan</h3>
                        <p class="mt-2 text-sm text-gray-600">Kami melayani berbagai jenis percetakan seperti banner,
                            brosur, kartu nama, dan lainnya.</p>
                    </div>
                </a>

                <a href="{{ url('/produk?kategori=konveksi') }}"
                    class="block p-8 rounded-xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Konveksi</h3>
                        <p class="mt-2 text-sm text-gray-600">Pembuatan seragam kerja, kaos sablon, jaket, topi, dan
                            kebutuhan pakaian lainnya.</p>
                    </div>
                </a>

                <a href="{{ url('/produk?kategori=kebutuhan-sekolah') }}"
                    class="block p-8 rounded-xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Kebutuhan Sekolah</h3>
                        <p class="mt-2 text-sm text-gray-600">Kami menyediakan perlengkapan sekolah seperti map raport,
                            ID card, hingga atribut siswa.</p>
                    </div>
                </a>

                <a href="{{ url('/produk?kategori=fasilitas') }}"
                    class="block p-8 rounded-xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6M9 11.25h6M9 15.75h6" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Produk Fasilitas</h3>
                        <p class="mt-2 text-sm text-gray-600">Melayani pembuatan papan nama, signage, dan produk
                            pelengkap fasilitas kantor.</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</body>
<!-- Footer -->
@include('components.footer')

</html>
