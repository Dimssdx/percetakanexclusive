<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intan Exclusive - Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }
        main > div {
            scroll-snap-align: start;
        }
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #FFFFFF;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="bg-white shadow-sm w-full sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-7 py-1 flex justify-between items-center">
            <a href="/" class="flex items-center gap-4">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo Intan Exclusive" class="h-16">
            </a>
            <nav class="flex gap-4 items-center">
                <a href="#beranda" class="px-7 py-3 rounded-full font-medium text-base transition-all duration-300 hover:bg-gradient-to-br hover:from-[#e85d75] hover:to-[#d84a6f] hover:text-white hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#e85d75]/30">
                    Beranda
                </a>
                <a href="#" class="px-7 py-3 rounded-full font-medium text-base transition-all duration-300 hover:bg-gradient-to-br hover:from-[#e85d75] hover:to-[#d84a6f] hover:text-white hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#e85d75]/30">
                    Produk
                </a>
                <a href="#" class="px-7 py-3 rounded-full font-medium text-base transition-all duration-300 hover:bg-gradient-to-br hover:from-[#e85d75] hover:to-[#d84a6f] hover:text-white hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#e85d75]/30">
                    E-Commerce
                </a>
                <a href="#kontak" class="px-7 py-3 rounded-full font-medium text-base transition-all duration-300 hover:bg-gradient-to-br hover:from-[#e85d75] hover:to-[#d84a6f] hover:text-white hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#e85d75]/30">
                    Kontak
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Beranda -->
        <div id="beranda" class="min-h-screen flex flex-col justify-start scroll-mt-36">
            <div class="max-w-7xl mx-auto px-8 pt-36">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-2/5 text-center lg:text-left">
                        <h1 class="text-5xl font-bold leading-tight text-slate-800">
                            Solusi Percetakan<br>& Konveksi<br>Terpercaya
                        </h1>
                        <p class="mt-5 text-base leading-relaxed text-slate-600">
                            Solusi lengkap untuk kebutuhan percetakan dan konveksi Anda. Proses produksi kami yang efisien memastikan pesanan Anda selesai tepat waktu dengan standar kualitas terbaik.
                        </p>
                    </div>
                    <div class="lg:w-3/5">
                        <img src="{{ asset('images/main-picture.svg') }}" alt="Ilustrasi Percetakan dan Konveksi" class="w-full h-auto object-contain">
                    </div>
                </div>
            </div>
        </div>

   <!-- Tentang Kami -->
  <div id="tentang-kami" class="bg-white pt-20 pb-20">
    <div class="max-w-5xl mx-auto px-8">
      <div>
        <img src="{{ asset('images/about.svg') }}" 
             alt="Suasana kerja di Intan Exclusive" 
             class="rounded-xl shadow-xl w-full">
      </div>
      <div class="mt-10 text-center">
        <h2 class="text-3xl font-bold text-gray-800">Percetakan dan Konveksi</h2>
        <p class="mt-4 text-base text-gray-600 leading-relaxed max-w-4xl mx-auto text-justify">
          Kami adalah perusahaan percetakan dan konveksi yang menyediakan berbagai kebutuhan instansi, sekolah, dan perusahaan. 
          Layanan kami mencakup pembuatan spanduk, banner, seragam, kaos sablon, papan nama, serta perlengkapan sekolah dan kantor lainnya. 
          Dengan dukungan tim berpengalaman, teknologi modern, dan standar kualitas tinggi, kami berkomitmen menghadirkan hasil yang rapi, 
          tahan lama, dan sesuai dengan kebutuhan pelanggan.
        </p>
      </div>
    </div>
  </div>

  <!-- Pembatas lembut -->
  <div class="border-t border-gray-200"></div>

  <!-- Layanan -->
  <div id="layanan" class="bg-slate-50 pt-20 pb-24">
    <div class="max-w-7xl mx-auto px-8">
      <h2 class="text-center text-3xl font-bold text-gray-800">Layanan Kami</h2>
      <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Percetakan -->
        <div class="text-center bg-white p-8 rounded-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
          <div class="flex justify-center items-center">
            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75h6l-3-3-3 3z" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Percetakan</h3>
          <p class="mt-2 text-sm text-gray-600">Kami melayani berbagai jenis percetakan seperti banner, brosur, kartu nama, dan lainnya.</p>
        </div>

        <!-- Konveksi -->
        <div class="text-center bg-white p-8 rounded-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
          <div class="flex justify-center items-center">
            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Konveksi</h3>
          <p class="mt-2 text-sm text-gray-600">Pembuatan seragam kerja, kaos sablon, jaket, topi, dan kebutuhan pakaian lainnya.</p>
        </div>

        <!-- Kebutuhan Sekolah -->
        <div class="text-center bg-white p-8 rounded-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
          <div class="flex justify-center items-center">
            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path d="M12 14l9-5-9-5-9 5 9 5z" />
              <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Kebutuhan Sekolah</h3>
          <p class="mt-2 text-sm text-gray-600">Kami menyediakan perlengkapan sekolah seperti map raport, ID card, hingga atribut siswa.</p>
        </div>

        <!-- Produk Fasilitas -->
        <div class="text-center bg-white p-8 rounded-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-gradient-to-br hover:from-pink-50 hover:to-red-50">
          <div class="flex justify-center items-center">
            <svg class="w-12 h-12 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6M9 11.25h6M9 15.75h6" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900">Produk Fasilitas</h3>
          <p class="mt-2 text-sm text-gray-600">Melayani pembuatan papan nama, signage, dan produk pelengkap fasilitas kantor.</p>
        </div>

      </div>
    </div>
  </div>
<footer id="kontak" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-8 py-20">
        {{-- CONTAINER UTAMA GRID 2 KOLOM --}}
        {{-- Pertahankan items-start agar kolom kiri tetap di atas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            
            {{-- KOLOM KIRI (Konten Alamat & Logo) --}}
            <div class="space-y-8">
                {{-- Alamat Kantor --}}
                <div class="space-y-4">
                    <h3 class="text-base font-semibold">Alamat Kantor</h3>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs">
                        Jl. Desa Nggondang No.6, Gondang II, Gondang, Kec. Karangrejo, Kabupaten Magetan, Jawa Timur 63395
                    </p>
                </div>
                
                {{-- Logo --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        {{-- Ganti tag ini sesuai dengan cara Anda memuat aset --}}
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo Intan Exclusive" class="h-16">
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Konten CTA yang Dibuat Agak ke Kanan) --}}
            {{-- Penambahan kelas mt-8 (margin-top: 2rem) untuk menggeser ke bawah --}}
            <div class="max-w-md ml-auto space-y-4 text-left **mt-24**">
                <h3 class="text-base font-semibold">Memenuhi kebetuhuan<br>Percetakan dan Konveksi anda</h3>
                <div class="flex items-center gap-4 justify-start">
                    <h2 class="text-3xl font-bold leading-tight">Buat Pesanan<br>Anda Sekarang...</h2>
                    <a href="#" class="flex-shrink-0 h-14 w-14 bg-gray-700 rounded-full flex items-center justify-center transition-transform hover:scale-110">
                        <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
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
    </body>
</html>