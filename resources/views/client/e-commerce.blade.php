<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intan Exclusive - E-Commerce</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo only.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background-color: #FFFFFF;
        }
    </style>
</head>

<body>
    {{-- Halaman E-Commerce --}}
    @include('components.navbar')

    <section class="py-16 px-6 sm:px-8 md:px-20 bg-white text-gray-900">
        <div class="max-w-6xl mx-auto">
            <!-- Judul -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-6 text-left leading-tight">
                Belanja Produk Kami di <br class="hidden sm:block">
                Platform Favorit Anda
            </h1>

            <!-- Paragraf pembuka -->
            <p
                class="text-gray-700 text-base sm:text-lg md:text-2xl leading-relaxed mb-12 sm:mb-16 text-left max-w-4xl">
                Kami hadir lebih dekat denganmu melalui berbagai platform e-commerce terpercaya.
                Dapatkan produk percetakan dan konveksi berkualitas dari <strong>Intan Exclusive</strong>
                dengan mudah dan aman. Cukup pilih toko online favoritmu, temukan produk kami,
                dan nikmati kemudahan berbelanja dari mana saja, kapan saja.
            </p>

            <!-- Kartu platform -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 sm:gap-10">
                <!-- SIPLah -->
                <a href="https://siplah.blibli.com/merchant-detail/SEXC-0003?itemPerPage=40&page=0&merchantId=SEXC-0003"
                    target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center p-8 sm:p-10 bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="/images/logo_siplah.png" alt="SIPLah Blibli" class="h-16 sm:h-20">
                </a>

                <!-- Shopee -->
                <a href="https://shopee.co.id/" target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center p-8 sm:p-10 bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="/images/logo_shopee.png" alt="Shopee" class="h-16 sm:h-20">
                </a>

                <!-- E-Catalogue -->
                <a href="https://e-katalog.lkpp.go.id/" target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center p-8 sm:p-10 bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                    <img src="/images/logo_e-katalog.png" alt="E-catalogue" class="h-16 sm:h-20">
                </a>
            </div>


            <!-- Paragraf bawah -->
            <p
                class="mt-12 sm:mt-16 text-gray-700 text-base sm:text-lg md:text-2xl leading-relaxed text-left max-w-4xl">
                Setiap platform menawarkan promo dan produk eksklusif yang berbeda —
                yuk kunjungi sekarang dan temukan penawaran terbaik!
            </p>
        </div>
    </section>

    @include('components.footer')
</body>

</html>
