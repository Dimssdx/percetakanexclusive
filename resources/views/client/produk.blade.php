<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body>
    {{-- Navbar --}}
    @include('components.navbar')

    {{-- SECTION PRODUK --}}
    <section class="py-16 px-6 md:px-20 bg-white text-gray-900">
        <div class="max-w-7xl mx-auto">

            {{-- Breadcrumb --}}
            {{-- Pastikan komponen ini menggunakan data-kategori-link dan data-kategori="all" untuk link "All" --}}
            <x-breadcrumbs_kategori :activeCategory="request()->query('kategori', 'all')" />

            {{-- Category Title (Hanya di-render sekali oleh Blade, selanjutnya diperbarui oleh JS) --}}
            <h2 id="category-title" class="text-xl font-semibold text-gray-900 mb-6">
                {{ request()->query('kategori') === 'all' || !request()->query('kategori')
                    ? 'Semua Produk'
                    : ucfirst(str_replace('-', ' ', request()->query('kategori'))) }}
            </h2>

            {{-- GRID PRODUK (akan di-render via JavaScript) --}}
            <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 custom-grid">
                <div id="product-loading" class="col-span-full text-center text-gray-500 py-12">
                    <svg class="animate-spin h-8 w-8 text-pink-600 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <p>Memuat produk...</p>
                </div>
            </div>

            {{-- Pesan jika tidak ada produk --}}
            <div id="no-products" class="hidden col-span-full text-center text-gray-500 py-12">
                <p class="text-lg">Tidak ada produk ditemukan</p>
            </div>

            {{-- Tombol Lihat Lebih Banyak --}}
            <div id="load-more-container" class="flex justify-center mt-12 hidden">
                <button id="load-more-btn" data-next-page="2"
                    class="px-6 py-3 rounded-full bg-gray-900 text-white text-sm font-semibold hover:bg-pink-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    @include('components.footer')

    <div id="loading-spinner" style="display: none;"
        class="fixed inset-0 bg-white bg-opacity-70 flex flex-col items-center justify-center z-50">
        <svg class="animate-spin h-10 w-10 text-pink-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-gray-700 text-sm font-medium">Memuat produk...</p>
    </div>

    <meta name="api-products-url" content="{{ url('/api/v1/produk') }}">


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
</body>

</html>
