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

<<<<<<< HEAD
            {{-- Category Title (set by JS mapping) --}}
            <h2 id="category-title" class="text-xl font-semibold text-gray-900 mb-6">{{ request()->query('kategori', 'all') === 'all' ? 'All' : ucfirst(str_replace('-', ' ', request()->query('kategori', 'all'))) }}</h2>

            {{-- GRID PRODUK (akan di-render via API) --}}
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 custom-grid">
                <div id="product-loading" class="col-span-full text-center text-gray-500">Memuat produk...</div>
=======
            {{-- GRID PRODUK --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 custom-grid">
                @foreach ($products as $item)
                    <x-product-card :id="$item['id']" :title="$item['nama']" :image="$item['gambar']" />
                @endforeach

>>>>>>> 642d0b1202c1087889fc2f5867bf0d8633c61439
            </div>

            {{-- Tombol Lihat Lebih Banyak --}}
            <div class="flex justify-center mt-12">
                <button id="load-more-btn" data-next-page="2" class="px-6 py-3 rounded-full bg-gray-900 text-white text-sm font-semibold hover:bg-pink-600 transition">
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    @include('components.footer')

    <!-- Spinner Overlay -->
    <div id="loading-spinner" style="display: none;" class="fixed inset-0 bg-white bg-opacity-70 flex flex-col items-center justify-center z-50">
        <svg class="animate-spin h-10 w-10 text-pink-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-gray-700 text-sm font-medium">Memuat produk...</p>
    </div>

    <!-- note: product fetch & render moved to resources/js/app.js; app.js reads the meta below -->
    <meta name="api-products-url" content="{{ url('/api/v1/produk') }}">

</body>

</html>
