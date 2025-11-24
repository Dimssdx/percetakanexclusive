// resources/js/app.js - FIX FOR CATEGORY TITLE

import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ============================================
// PRODUCT API CONSUMER - ENHANCED VERSION
// ============================================

(function() {
    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    
    function escapeHtml(unsafe) {
        return String(unsafe || '').replace(/[&<>\"]/g, function(match) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[match];
        });
    }

    function buildImageUrl(path) {
        if (!path) return null;
        if (/^https?:\/\//i.test(path)) return path;
        // Jika path tidak mengandung 'storage/', tambahkan (asumsi dari backend)
        const adjustedPath = path.startsWith('storage/') ? path : 'storage/' + path.replace(/^\//, '');
        // relative path -> prefix with origin
        return window.location.origin.replace(/\/$/, '') + '/' + adjustedPath.replace(/^\//, '');
    }

    async function fetchPage(url) {
        const res = await fetch(url, { 
            headers: { 
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            } 
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(price || 0);
    }

    // ============================================
    // PRODUCT CARD RENDERER
    // ============================================
    
    function createProductCard(product) {
        // Logika normalisasi gambar di JS sebaiknya diminimalisir jika controller sudah menanganinya
        // Di sini kita hanya mengandalkan field yang sudah dinormalisasi dari controller
        const imageUrl = product.gambar_utama || 
                         (product.gambar_urls && product.gambar_urls[0]) || 
                         null;
        
        // Kita menggunakan '/storage/' di buildImageUrl di Controller, 
        // sehingga di sini kita bisa menggunakan path yang sudah ada.
        const img = imageUrl || '/images/placeholder.png'; 
        const title = escapeHtml(product.nama || product.name || 'Produk');
        const kategori = escapeHtml(product.kategori || '');
        const price = formatPrice(product.harga);
        const id = product.id || product.slug || '';

        return `
            <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <a href="/produk/${id}" class="block">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        <img 
                            src="${img}" 
                            alt="${title}" 
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                            onerror="this.onerror=null; this.src='/images/placeholder.png';"
                            loading="lazy"
                        >
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2 min-h-[3rem]">
                            ${title}
                        </h3>
                        <p class="text-sm text-gray-500 mb-2">${kategori}</p>
                        <p class="text-pink-600 font-bold text-lg">${price}</p>
                        <button class="mt-3 w-full px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-pink-600 transition-colors duration-200">
                            Lihat Detail
                        </button>
                    </div>
                </a>
            </div>
        `;
    }

    function renderProductsIntoGrid(products, grid, append = false) {
        if (!append) grid.innerHTML = '';

        // Handle #no-products element display
        const noProductsEl = document.getElementById('no-products');
        const hasProducts = Array.isArray(products) && products.length > 0;
        
        if (noProductsEl) {
            if (!hasProducts && !append) {
                noProductsEl.classList.remove('hidden');
                // Hapus spinner jika ada
                const spinner = document.getElementById('product-loading');
                if (spinner) spinner.remove();
                grid.innerHTML = ''; // Clear grid if no products
            } else {
                noProductsEl.classList.add('hidden');
            }
        }
        
        if (!hasProducts && !append) {
            // Jika tidak ada #no-products element, tampilkan pesan di grid
            if (!noProductsEl) {
                 grid.innerHTML = `
                    <div class="col-span-full text-center text-gray-500 py-12">
                        <p class="text-lg font-semibold">Belum ada produk</p>
                        <p class="text-sm mt-2">Produk dengan kategori ini belum tersedia.</p>
                    </div>
                `;
            }
            return;
        }


        products.forEach(product => {
            const productCard = createProductCard(product);
            grid.insertAdjacentHTML('beforeend', productCard);
        });
    }

    // ============================================
    // MAIN INITIALIZATION
    // ============================================
    
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('product-grid');
        if (!grid) return; // nothing to do on pages without product grid

        // Category label mapping for nicer UI titles
        const categoryLabels = {
            'all': 'Semua Produk',
            'percetakan': 'Percetakan',
            'konveksi': 'Konveksi',
            // Gunakan key sesuai slug/URL
            'kebutuhan-sekolah-dan-perusahaan': 'Kebutuhan Sekolah & Perusahaan', 
            'fasilitas': 'Fasilitas'
        };

        // DOM Elements
        const categoryTitleEl = document.getElementById('category-title');
        const loadingSpinner = document.getElementById('product-loading') || document.getElementById('loading-spinner');
        const loadMoreBtn = document.getElementById('load-more-btn');
        const loadMoreContainer = document.getElementById('load-more-container');
        
        // API URL
        const apiMeta = document.querySelector('meta[name="api-products-url"]');
        const apiUrl = apiMeta ? apiMeta.content : (window.location.origin + '/api/v1/produk');

        // Get current category from URL search params
        const qs = new URLSearchParams(window.location.search);
        let category = (qs.get('kategori') || '');
        // FIX: Jika kategori adalah 'all' atau 'null', set ke string kosong untuk konsistensi API & UI
        if (category === 'all' || !category) category = '';

        // State
        let currentPage = 1;
        let lastPage = 1;
        let loading = false;

        // Update category title
        function updateCategoryTitle() {
            if (categoryTitleEl) {
                // Tentukan key yang akan digunakan. Jika category kosong (''), gunakan key 'all'.
                const key = category || 'all'; 
                
                let titleText;
                
                if (categoryLabels[key]) {
                    titleText = categoryLabels[key];
                } else if (category) {
                    // Jika ada kategori tapi tidak ada di mapping, format otomatis
                    titleText = key.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
                } else {
                    // Fallback untuk kategori kosong
                    titleText = categoryLabels['all']; 
                }

                categoryTitleEl.innerText = titleText;
            }
        }

        // Spinner controls
        function showSpinner() { 
            if (loadingSpinner) loadingSpinner.style.display = 'block'; 
        }
        
        function hideSpinner() { 
            if (loadingSpinner) loadingSpinner.style.display = 'none'; 
        }

        // ============================================
        // LOAD PRODUCTS FUNCTION
        // ============================================
        
        async function loadProducts(page = 1, append = false) {
            if (loading) return;
            loading = true;
            
            if (!append) {
                showSpinner();
                grid.innerHTML = '';
                // Append spinner to grid if it's the main loading indicator
                if (loadingSpinner) {
                    loadingSpinner.id = 'product-loading-active'; // Ganti ID agar tidak berkonflik
                    grid.appendChild(loadingSpinner);
                }
            } else {
                if (loadMoreBtn) {
                    loadMoreBtn.disabled = true;
                    loadMoreBtn.textContent = 'Memuat...';
                }
            }

            try {
                // Build URL
                const url = new URL(apiUrl, window.location.origin);
                // Hanya kirim kategori jika tidak kosong ('')
                if (category) url.searchParams.set('kategori', category); 
                else url.searchParams.delete('kategori'); // Hapus kategori jika 'all'

                // ... (sisanya dari build URL tetap sama) ...
                const isMobile = window.matchMedia('(max-width: 768px)').matches;
                const perPage = isMobile ? 6 : 9;
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', page);
                if (url.searchParams.has('_')) url.searchParams.delete('_');
                
                // Fetch data
                const result = await fetchPage(url.toString());
                hideSpinner();

                // Handle response
                const allProducts = Array.isArray(result) ? result : (result.data || []);
                
                // ... (hapus client-side filter karena controller sudah menanganinya) ...

                // Handle pagination
                if (result.pagination) {
                    // Backend pagination
                    const products = allProducts;
                    
                    renderProductsIntoGrid(products, grid, append);
                    
                    // Update pagination state
                    const backendTotal = parseInt(result.pagination.total || 0, 10);
                    const backendPerPage = parseInt(result.pagination.per_page || result.pagination.perPage || 0, 10);
                    currentPage = parseInt(result.pagination.current_page || page, 10);
                    
                    // Logic lastPage tetap sama
                    if (backendPerPage && backendPerPage !== perPage) {
                        lastPage = Math.max(1, Math.ceil(backendTotal / perPage));
                    } else {
                        lastPage = result.pagination.last_page || result.pagination.lastPage || lastPage;
                    }
                } else {
                    // Client-side pagination fallback (jika backend tidak mengirim pagination data)
                    const total = allProducts.length;
                    lastPage = Math.max(1, Math.ceil(total / perPage));
                    currentPage = page;
                    const start = (page - 1) * perPage;
                    const pageSlice = allProducts.slice(start, start + perPage);
                    
                    renderProductsIntoGrid(pageSlice, grid, append);
                }

                // Update Load More button (logika sama)
                if (loadMoreBtn) {
                    // ... (load more logic) ...
                    if (currentPage >= lastPage) {
                        if (loadMoreContainer) {
                            loadMoreContainer.classList.add('hidden');
                        } else {
                            loadMoreBtn.classList.add('hidden');
                        }
                    } else {
                        if (loadMoreContainer) {
                            loadMoreContainer.classList.remove('hidden');
                        } else {
                            loadMoreBtn.classList.remove('hidden');
                        }
                        loadMoreBtn.dataset.nextPage = (currentPage + 1).toString();
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Tampilkan Lebih Banyak';
                    }
                }

            } catch (error) {
                console.error('Error loading products:', error);
                hideSpinner();
                
                grid.innerHTML = `<div class="col-span-full text-center text-red-500 py-12"><p class="text-lg font-semibold">Gagal memuat produk</p><p class="text-sm mt-2 text-gray-600">${escapeHtml(error.message)}</p><button onclick="location.reload()" class="mt-4 px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">Muat Ulang</button></div>`;
                
                if (loadMoreContainer) {
                    loadMoreContainer.classList.add('hidden');
                }
            } finally {
                loading = false;
            }
        }

        // ============================================
        // EVENT LISTENERS
        // ============================================

        // Initial load
        updateCategoryTitle(); // FIX: Memastikan judul awal sudah benar
        loadProducts(1, false);

        // Load More button (Logika sama)
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const nextPage = parseInt(this.dataset.nextPage || (currentPage + 1), 10);
                if (!isNaN(nextPage)) {
                    loadProducts(nextPage, true);
                }
            });
        }

        // Category filter links (breadcrumb navigation)
        const kategoriLinks = document.querySelectorAll('[data-kategori-link]');
        if (kategoriLinks.length) {
            kategoriLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    let targetCategory = link.getAttribute('data-kategori') || '';
                    
                    // FIX: Logika untuk All (targetCategory kosong)
                    if (targetCategory === 'all') targetCategory = ''; 
                    
                    // Build new URL
                    let newPath;
                    if (!targetCategory) {
                        newPath = '/produk'; // URL tanpa parameter kategori
                    } else {
                        newPath = `/produk?kategori=${encodeURIComponent(targetCategory)}`;
                    }
                    
                    // Update browser history
                    history.pushState({}, '', newPath);
                    category = targetCategory; // <-- Global state category diatur ke '' jika 'all'
                    
                    // Update UI
                    updateCategoryTitle(); // FIX: Memperbarui judul menggunakan state category yang baru
                    
                    // Update active classes (logika sama)
                    kategoriLinks.forEach(l => l.classList.remove('font-semibold', 'text-gray-900'));
                    link.classList.add('font-semibold', 'text-gray-900');
                    
                    // Load products for new category
                    loadProducts(1, false);
                });
            });

            // Handle browser navigation (back/forward)
            window.addEventListener('popstate', () => {
                const qs2 = new URLSearchParams(window.location.search);
                category = (qs2.get('kategori') || '');
                if (category === 'all') category = ''; // FIX: Pastikan 'all' juga diset ke '' saat popstate
                
                updateCategoryTitle();
                
                // ... (update active classes logic tetap sama) ...
                kategoriLinks.forEach(l => {
                    const k = l.getAttribute('data-kategori') || '';
                    if ((k || '') === (category || '')) {
                        l.classList.add('font-semibold', 'text-gray-900');
                    } else {
                        l.classList.remove('font-semibold', 'text-gray-900');
                    }
                });
                
                loadProducts(1, false);
            });
        }
    });
})();