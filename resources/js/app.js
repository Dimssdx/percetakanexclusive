// resources/js/app.js

import './bootstrap';

import Alpine from 'alpinejs'; // Tambahkan ini
window.Alpine = Alpine;       // Tambahkan ini

Alpine.start();               // Tambahkan ini

// --- Product API consumer ---
// This module looks for a `#product-grid` element on the page
// and fetches product data from the API specified in a meta tag
// <meta name="api-products-url" content="...">
// It supports simple "Load more" pagination using a button with id `load-more-btn`.

(function() {
	function escapeHtml(unsafe) {
		return String(unsafe || '').replace(/[&<>\"]/g, function(match) {
			return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[match];
		});
	}

	function buildImageUrl(path) {
		if (!path) return null;
		if (/^https?:\/\//i.test(path)) return path;
		// relative path -> prefix with origin
		return window.location.origin.replace(/\/$/, '') + '/' + path.replace(/^\//, '');
	}

	async function fetchPage(url) {
		const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
		if (!res.ok) throw new Error(`HTTP ${res.status}`);
		return res.json();
	}

	function renderProductsIntoGrid(products, grid, append = false) {
		if (!append) grid.innerHTML = '';

		// If no products to render (and not appending), show friendly message
		if (!append && (!Array.isArray(products) || products.length === 0)) {
			grid.innerHTML = `<div class="col-span-full text-center text-gray-500">Belum ada produk dengan kategori ini.</div>`;
			return;
		}

		products.forEach(p => {
			// Normalize gambar field: backend sometimes returns JSON-encoded array as a string
			let gambarField = p.gambar;
			if (typeof gambarField === 'string') {
				try {
					const parsed = JSON.parse(gambarField);
					if (Array.isArray(parsed)) gambarField = parsed;
				} catch (e) {
					// not JSON, keep as-is
				}
			}

			const baseImg = (Array.isArray(gambarField) && gambarField.length) ? gambarField[0] : (gambarField || null);
			const img = buildImageUrl(baseImg) || (window.location.origin + '/images/main-picture.svg');
			const title = p.nama || p.name || 'Produk';
			const desc = p.deskripsi || p.description || '';
			const price = p.harga ? `Rp ${Number(p.harga).toLocaleString('id-ID')}` : '';
			const id = p.id || p.slug || '';

			const a = document.createElement('a');
			a.href = `/produk/${id}`;
			a.className = 'block p-4 rounded-lg bg-white shadow-sm hover:shadow-md transition';
			a.innerHTML = `
				<div class="w-full h-44 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center">
					<img src="${img}" alt="${escapeHtml(title)}" class="object-contain h-full w-full">
				</div>
				<h3 class="mt-3 text-lg font-semibold text-gray-900">${escapeHtml(title)}</h3>
				<p class="mt-2 text-sm text-gray-600 line-clamp-2">${escapeHtml(desc)}</p>
				<div class="mt-3 flex items-center justify-between">
					<span class="text-sm font-semibold text-pink-600">${price}</span>
					<span class="text-xs text-gray-400">Lihat detail</span>
				</div>
			`;

			const wrapper = document.createElement('div');
			wrapper.className = 'bg-transparent';
			wrapper.appendChild(a);
			grid.appendChild(wrapper);
		});
	}

	document.addEventListener('DOMContentLoaded', () => {
			// Category label mapping for nicer UI titles
			const categoryLabels = {
				'all': 'All',
				'percetakan': 'Percetakan',
				'konveksi': 'Konveksi',
				'kebutuhan-sekolah': 'Kebutuhan Sekolah & Perusahaan',
				'fasilitas': 'Fasilitas'
			};

			// Update category title element if present
			const categoryTitleEl = document.getElementById('category-title');
		const grid = document.getElementById('product-grid');
		if (!grid) return; // nothing to do on pages without product grid

		const apiMeta = document.querySelector('meta[name="api-products-url"]');
		const apiUrl = apiMeta ? apiMeta.content : (window.location.origin + '/api/v1/produk');
		const spinner = document.getElementById('loading-spinner');
		const loadMoreBtn = document.getElementById('load-more-btn');
		const qs = new URLSearchParams(window.location.search);
		// Support legacy/accidental cache-buster param '_' used as category in some flows
		let category = (qs.get('kategori') || qs.get('_') || '');
		// normalize 'all' -> treat as no category (show everything)
		if (category === 'all') category = '';

		// set readable title from mapping
		if (categoryTitleEl) {
			categoryTitleEl.innerText = categoryLabels[category] || (category ? category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) : 'All');
		}

		let currentPage = 1;
		let lastPage = 1;
		let loading = false;

		function showSpinner() { if (spinner) spinner.style.display = 'flex'; }
		function hideSpinner() { if (spinner) spinner.style.display = 'none'; }

		async function loadPage(page = 1, append = false) {
			if (loading) return;
			loading = true; showSpinner();
			try {
				const url = new URL(apiUrl, window.location.origin);
				if (category) url.searchParams.set('kategori', category);

				// Always request limited items per page (6 mobile / 9 desktop) for any category
				const isMobile = window.matchMedia('(max-width: 768px)').matches;
				const perPage = isMobile ? 6 : 9;
				url.searchParams.set('per_page', perPage);
				// ensure accidental '_' param is not forwarded to API
				if (url.searchParams.has('_')) url.searchParams.delete('_');
				url.searchParams.set('page', page);

				const json = await fetchPage(url.toString());
				// API returns { data: [...], pagination: { ... } } per backend
				const allProducts = Array.isArray(json) ? json : (json.data || []);

				// apply client-side category filter if needed
				let productsToUse = allProducts;
				if (category) {
					const expectedLabel = categoryLabels[category] || category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
					productsToUse = allProducts.filter(p => p && p.kategori && String(p.kategori).toLowerCase().includes(String(expectedLabel).toLowerCase()));
				}

				// determine per-page for client-side slicing (use same perPage as requested)
				// perPage already computed above

				// If backend provided pagination metadata, trust it and render returned page
				if (json.pagination) {
					const products = productsToUse;
					// prefer backend category label for title
					if (!append && Array.isArray(products) && products.length > 0) {
						const backendCat = products[0].kategori || products[0].category || null;
						if (backendCat && categoryTitleEl) categoryTitleEl.innerText = backendCat;
					}
					// render returned products
					renderProductsIntoGrid(products, grid, append);
					// Use backend pagination but respect requested perPage: if backend per_page differs,
					// compute lastPage based on total and our perPage so Load More reflects client expectation.
					const backendTotal = parseInt(json.pagination.total || 0, 10);
					const backendPerPage = parseInt(json.pagination.per_page || json.pagination.perPage || 0, 10);
					currentPage = parseInt(json.pagination.current_page || page, 10);
					if (backendPerPage && backendPerPage !== perPage) {
						lastPage = Math.max(1, Math.ceil(backendTotal / perPage));
					} else {
						lastPage = json.pagination.last_page || json.pagination.lastPage || lastPage;
					}
				} else {
					// backend did not paginate; perform client-side pagination on productsToUse
					const total = productsToUse.length;
					lastPage = Math.max(1, Math.ceil(total / perPage));
					currentPage = page;
					const start = (page - 1) * perPage;
					const pageSlice = productsToUse.slice(start, start + perPage);
					// prefer backend category label if available
					if (!append && Array.isArray(productsToUse) && productsToUse.length > 0) {
						const backendCat = productsToUse[0].kategori || productsToUse[0].category || null;
						if (backendCat && categoryTitleEl) categoryTitleEl.innerText = backendCat;
					}
					// render the slice
					renderProductsIntoGrid(pageSlice, grid, append);
				}

				// Update Load More visibility based on computed pagination
				if (loadMoreBtn) {
					if (currentPage >= lastPage) {
						loadMoreBtn.classList.add('hidden');
					} else {
						loadMoreBtn.classList.remove('hidden');
						loadMoreBtn.dataset.nextPage = (currentPage + 1).toString();
					}
				}

				// update Load More button
				if (loadMoreBtn) {
					if (currentPage >= lastPage) {
						loadMoreBtn.classList.add('hidden');
					} else {
						loadMoreBtn.classList.remove('hidden');
						loadMoreBtn.dataset.nextPage = (currentPage + 1).toString();
					}
				}
			} catch (err) {
				console.error('Error loading products', err);
				grid.innerHTML = `<div class="col-span-full text-center text-red-500">Gagal memuat produk.</div>`;
			} finally {
				loading = false; hideSpinner();
			}
		}

		// initial load
		loadPage(1, false);

		// Breadcrumb links: intercept clicks to filter without full page reload
		const kategoriLinks = document.querySelectorAll('[data-kategori-link]');
		if (kategoriLinks.length) {
			kategoriLinks.forEach(link => {
				link.addEventListener('click', (e) => {
					e.preventDefault();
					let targetCategory = link.getAttribute('data-kategori') || '';
					// if target is 'all', treat as no category and keep URL as /produk
					let newPath;
					if (!targetCategory || targetCategory === 'all') {
						newPath = '/produk';
						targetCategory = '';
					} else {
						newPath = `/produk?kategori=${encodeURIComponent(targetCategory)}`;
					}
					history.pushState({}, '', newPath);
					category = targetCategory;
					// update title
					if (categoryTitleEl) categoryTitleEl.innerText = (category ? (categoryLabels[category] || category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())) : 'All');
					// update active classes
					kategoriLinks.forEach(l => l.classList.remove('font-semibold', 'text-gray-900'));
					link.classList.add('font-semibold', 'text-gray-900');
					// load products for new category
					loadPage(1, false);
				});
			});

			// handle browser navigation (back/forward)
			window.addEventListener('popstate', () => {
				const qs2 = new URLSearchParams(window.location.search);
				category = (qs2.get('kategori') || qs2.get('_') || '');
				if (category === 'all') category = '';
				if (categoryTitleEl) categoryTitleEl.innerText = (category ? (categoryLabels[category] || category.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase())) : 'All');
				// update active classes
				kategoriLinks.forEach(l => {
					const k = l.getAttribute('data-kategori') || '';
					if ((k || '') === (category || '')) {
						l.classList.add('font-semibold', 'text-gray-900');
					} else {
						l.classList.remove('font-semibold', 'text-gray-900');
					}
				});
				loadPage(1, false);
			});
		}

		if (loadMoreBtn) {
			loadMoreBtn.addEventListener('click', (e) => {
				e.preventDefault();
				const next = parseInt(loadMoreBtn.dataset.nextPage || (currentPage + 1), 10);
				if (!isNaN(next)) loadPage(next, true);
			});
		}
	});
})();