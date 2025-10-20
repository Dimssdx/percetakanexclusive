<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intan Exclusive - Produk</title>
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

        @media (max-width: 1060px) {
            .custom-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 780px) {
            .custom-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            .custom-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    @include('components.navbar')

    {{-- SECTION PRODUK --}}
    <section class="py-16 px-6 md:px-20 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto">

            {{-- Breadcrumb --}}
            <x-breadcrumbs_kategori :activeCategory="request()->query('kategori', 'all')" />

            {{-- GRID PRODUK --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 custom-grid">
                @for ($i = 1; $i <= 12; $i++)
                    <x-product-card :title="'Produk ' . $i" :image="asset('images/produk-' . $i . '.jpg')" />
                @endfor
            </div>

            {{-- Tombol Lihat Lebih Banyak --}}
            <div class="flex justify-center mt-12">
                <button
                    class="px-6 py-3 rounded-full bg-gray-900 text-white text-sm font-semibold hover:bg-pink-600 transition">
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    @include('components.footer')
</body>

</html>
