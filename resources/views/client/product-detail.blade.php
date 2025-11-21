<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo only.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #FFFFFF;
        }

        /* Mobile adjustments */
        @media (max-width: 480px) {
            .content-wrapper {
                padding-left: 0.75rem !important;
                /* px-3 */
                padding-right: 0.75rem !important;
                padding-top: 4rem !important;
                /* pt-16 */
                padding-bottom: 5rem !important;
                /* pb-20 */
            }

            h1 {
                font-size: 1.6rem !important;
            }

            .price-text {
                font-size: 1.8rem !important;
            }
        }
    </style>
</head>

@include('components.navbar')

<body>

    <!-- Wrapper -->
    <div class="content-wrapper max-w-6xl mx-auto pt-10 pb-10 px-3 md:px-6">

        <!-- Tombol Kembali -->
        <a href="{{ url('/produk') }}" class="mb-4 inline-block text-gray-700 hover:text-black">
            ← Kembali ke Produk
        </a>

        <!-- Gambar Produk -->
        <div class="relative w-full rounded-xl overflow-hidden" style="padding-top: 56.25%;">
            <img src="{{ $product['gambar'] }}" alt="{{ $product['nama'] }}"
                class="absolute inset-0 w-full h-full object-cover">
        </div>

        <!-- Nama, Kategori, Harga -->
        <div class="mt-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                {{ $product['nama'] }}
            </h1>

            <p class="text-md text-gray-500 mt-1">
                Kategori: {{ $product['kategori'] }}
            </p>

            <p class="price-text text-3xl md:text-4xl font-semibold text-green-600 mt-3">
                Rp {{ number_format($product['harga'], 0, ',', '.') }}
            </p>
        </div>

        <!-- Deskripsi -->
        <div class="mt-6">
            <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                {{ $product['deskripsi'] }}
            </p>
        </div>

    </div>

</body>

@include('components.footer')

</html>
