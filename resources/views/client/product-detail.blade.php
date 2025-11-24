<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['nama'] ?? 'Detail Produk' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo only.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #FFFFFF;
        }

        .thumbnail {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
            opacity: 0.7;
        }

        .thumbnail:hover {
            border-color: #ec4899;
            opacity: 1;
        }

        .thumbnail.active {
            border-color: #ec4899;
            opacity: 1;
        }

        .main-image {
            transition: opacity 0.3s ease;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0.5; }
            to { opacity: 1; }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                padding-top: 4rem !important;
                padding-bottom: 5rem !important;
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

<body>
    @include('components.navbar')

    <div class="content-wrapper max-w-6xl mx-auto pt-10 pb-10 px-3 md:px-6">

        <!-- Tombol Kembali -->
        <a href="{{ url('/produk') }}" class="mb-4 inline-block text-gray-700 hover:text-black transition-colors">
            ← Kembali ke Produk
        </a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Image Gallery Section -->
            <div>
                @php
                    // Safe check untuk gambar
                    $gambarUrls = $product['gambar_urls'] ?? [];
                    $gambarUtama = $product['gambar_utama'] ?? $product['gambar_display'] ?? null;
                    $hasMultipleImages = is_array($gambarUrls) && count($gambarUrls) > 1;
                    $placeholderImg = asset('images/placeholder.png');
                @endphp

                <!-- Main Image -->
                <div class="relative w-full rounded-xl overflow-hidden bg-gray-100 mb-4" style="padding-top: 100%;">
                    <img 
                        id="mainImage" 
                        src="{{ $gambarUtama ?? $placeholderImg }}" 
                        alt="{{ $product['nama'] ?? 'Produk' }}"
                        class="main-image absolute inset-0 w-full h-full object-cover"
                        onerror="this.onerror=null; this.src='{{ $placeholderImg }}'; console.error('Failed to load main image:', this.src);"
                    >
                    
                    <!-- Image Counter Badge -->
                    @if($hasMultipleImages)
                    <div class="absolute top-4 right-4 bg-black/60 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        <span id="currentImageIndex">1</span> / {{ count($gambarUrls) }}
                    </div>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($hasMultipleImages)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($gambarUrls as $index => $imageUrl)
                    <div 
                        class="thumbnail {{ $index === 0 ? 'active' : '' }} relative rounded-lg overflow-hidden bg-gray-100" 
                        style="padding-top: 100%;"
                        onclick="changeMainImage('{{ addslashes($imageUrl) }}', {{ $index }})"
                    >
                        <img 
                            src="{{ $imageUrl }}" 
                            alt="Gambar {{ $index + 1 }}"
                            class="absolute inset-0 w-full h-full object-cover"
                            onerror="this.onerror=null; this.src='{{ $placeholderImg }}'; console.error('Failed to load thumbnail {{ $index }}:', this.src);"
                        >
                    </div>
                    @endforeach
                </div>
                @elseif(!empty($gambarUrls) && count($gambarUrls) === 1)
                <p class="text-sm text-gray-500 text-center">1 Gambar Produk</p>
                @endif
            </div>

            <!-- Product Info Section -->
            <div>
                <!-- Nama Produk -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                    {{ $product['nama'] ?? 'Nama Produk' }}
                </h1>

                <!-- Kategori -->
                <div class="mb-4">
                    <span class="inline-block bg-pink-100 text-pink-600 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $product['kategori'] ?? 'Kategori' }}
                    </span>
                </div>

                <!-- Harga -->
                <p class="price-text text-3xl md:text-4xl font-bold text-green-600 mb-6">
                    Rp {{ number_format($product['harga'] ?? 0, 0, ',', '.') }}
                </p>

                <!-- Divider -->
                <hr class="my-6 border-gray-200">

                <!-- Deskripsi -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Produk</h2>
                    <p class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $product['deskripsi'] ?? 'Deskripsi tidak tersedia.' }}
                    </p>
                </div>


            </div>
        </div>

    </div>

    @include('components.footer')

    <script>
        
        function changeMainImage(imageUrl, index) {
            const mainImage = document.getElementById('mainImage');
            const counter = document.getElementById('currentImageIndex');
            const thumbnails = document.querySelectorAll('.thumbnail');
            
            console.log('Changing to image:', imageUrl, 'index:', index);
            
            mainImage.classList.remove('fade-in');
            void mainImage.offsetWidth;
            mainImage.src = imageUrl;
            mainImage.classList.add('fade-in');
            
            if (counter) {
                counter.textContent = index + 1;
            }
            
            thumbnails.forEach((thumb, i) => {
                if (i === index) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const thumbnails = document.querySelectorAll('.thumbnail');
            if (thumbnails.length <= 1) return;
            
            const activeIndex = Array.from(thumbnails).findIndex(t => t.classList.contains('active'));
            
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                const nextIndex = (activeIndex + 1) % thumbnails.length;
                thumbnails[nextIndex].click();
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                const prevIndex = (activeIndex - 1 + thumbnails.length) % thumbnails.length;
                thumbnails[prevIndex].click();
            }
        });
    </script>
</body>
</html>