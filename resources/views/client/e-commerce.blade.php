<html lang="en">

@include('layouts.head')

<body>
    @include('components.navbar')

    <section class="py-16 px-6 sm:px-8 md:px-20 bg-white text-gray-900">
        <div class="max-w-6xl mx-auto">
            <!-- Judul -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-6 text-left leading-tight">
                Belanja Produk Kami di <br class="hidden sm:block">
                Platform Favorit Anda
            </h1>

            <!-- Paragraf pembuka -->
            <p class="text-gray-700 text-base sm:text-lg md:text-2xl leading-relaxed mb-12 sm:mb-16 text-left max-w-4xl">
                Kami hadir lebih dekat denganmu melalui berbagai platform e-commerce terpercaya.
                Dapatkan produk percetakan dan konveksi berkualitas dari <strong>Intan Exclusive</strong>
                dengan mudah dan aman. Cukup pilih toko online favoritmu, temukan produk kami,
                dan nikmati kemudahan berbelanja dari mana saja, kapan saja.
            </p>

            <!-- Loading Skeleton -->
            <div id="loadingSkeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 sm:gap-10">
                <div class="skeleton h-32 rounded-2xl"></div>
                <div class="skeleton h-32 rounded-2xl"></div>
                <div class="skeleton h-32 rounded-2xl"></div>
            </div>

            <!-- Kartu platform - Dynamic dari Backend -->
            <div id="platformContainer" class="hidden grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 sm:gap-10"></div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-16">
                <div class="text-6xl mb-4">🛒</div>
                <p class="text-xl text-gray-600 mb-2">Belum ada platform e-commerce</p>
                <p class="text-gray-500">Platform akan muncul setelah ditambahkan oleh admin</p>
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

    <script>
        // Mapping logo berdasarkan platform name
        const platformLogos = {
            'Shopee': '/images/logo_shopee.png',
            'Tokopedia': '/images/logo_tokopedia.png',
            'Lazada': '/images/logo_lazada.png',
            'Lazada Indonesia': '/images/logo_lazada.png',
            'Bukalapak': '/images/logo_bukalapak.png',
            'BliBli': '/images/logo_blibli.png',
            'SIPLah': '/images/logo_siplah.png',
            'eCatalogue': '/images/logo_e-katalog.png',
            'E-Catalogue': '/images/logo_e-katalog.png',
            'TikTok Shop': '/images/logo_tiktok.png',
            'Instagram Shop': '/images/logo_instagram.png',
            'Facebook Marketplace': '/images/logo_facebook.png',
            'WhatsApp Business': '/images/logo_whatsapp.png',
        };

        // Function untuk mendapatkan logo
        function getPlatformLogo(platformName) {
            // Cari exact match
            if (platformLogos[platformName]) {
                return platformLogos[platformName];
            }

            // Cari partial match (case insensitive)
            const lowerPlatform = platformName.toLowerCase();
            for (const [key, value] of Object.entries(platformLogos)) {
                if (lowerPlatform.includes(key.toLowerCase()) || key.toLowerCase().includes(lowerPlatform)) {
                    return value;
                }
            }

            // Default logo jika tidak ditemukan
            return '/images/logo_default_ecommerce.png';
        }

        // Fetch data dari API
        async function loadEcommercePlatforms() {
            const loadingSkeleton = document.getElementById('loadingSkeleton');
            const platformContainer = document.getElementById('platformContainer');
            const emptyState = document.getElementById('emptyState');

            try {
                const response = await fetch('/api/v1/ecommerce');
                const result = await response.json();

                // Hide loading
                loadingSkeleton.classList.add('hidden');

                if (result.success && result.data && result.data.length > 0) {
                    // Show platform container
                    platformContainer.classList.remove('hidden');
                    platformContainer.classList.add('grid');

                    // Render platforms
                    result.data.forEach(item => {
                        const logo = getPlatformLogo(item.platform);

                        const platformCard = document.createElement('a');
                        platformCard.href = item.url_link;
                        platformCard.target = '_blank';
                        platformCard.rel = 'noopener noreferrer';
                        platformCard.className =
                            'flex items-center justify-center p-8 sm:p-10 bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1';

                        platformCard.innerHTML = `
                            <img src="${logo}" 
                                 alt="${item.platform}" 
                                 class="h-16 sm:h-20 object-contain"
                                 onerror="this.src='/images/logo_default_ecommerce.png'">
                        `;

                        platformContainer.appendChild(platformCard);
                    });
                } else {
                    // Show empty state
                    emptyState.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading e-commerce platforms:', error);
                loadingSkeleton.classList.add('hidden');

                // Show error message
                emptyState.classList.remove('hidden');
                emptyState.innerHTML = `
                    <div class="text-6xl mb-4">⚠️</div>
                    <p class="text-xl text-red-600 mb-2">Gagal memuat platform</p>
                    <p class="text-gray-500">Terjadi kesalahan saat mengambil data. Silakan refresh halaman.</p>
                `;
            }
        }

        // Load data saat halaman dimuat
        document.addEventListener('DOMContentLoaded', loadEcommercePlatforms);
    </script>
</body>

<style>
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Manrope', sans-serif;
        background-color: #FFFFFF;
    }

    .skeleton {
        animation: skeleton-loading 1s linear infinite alternate;
    }

    @keyframes skeleton-loading {
        0% {
            background-color: hsl(200, 20%, 80%);
        }

        100% {
            background-color: hsl(200, 20%, 95%);
        }
    }
</style>

</html>
