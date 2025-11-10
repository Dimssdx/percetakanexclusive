@props(['activeCategory' => 'all'])

<nav
    class="flex flex-wrap gap-3 text-sm text-gray-500 mb-12 border-b border-gray-200 pb-4 justify-center md:justify-start">

    <a href="{{ url('/produk') }}" data-kategori-link
        class="transition hover:text-pink-600 {{ $activeCategory === 'all' ? 'font-semibold text-gray-900' : '' }}">
        All
    </a>
    <span class="hidden sm:inline">|</span>

    <a href="{{ url('/produk?kategori=percetakan') }}" data-kategori-link
        class="transition hover:text-pink-600 {{ $activeCategory === 'percetakan' ? 'font-semibold text-gray-900' : '' }}">
        Percetakan
    </a>
    <span class="hidden sm:inline">|</span>

    <a href="{{ url('/produk?kategori=konveksi') }}" data-kategori-link
        class="transition hover:text-pink-600 {{ $activeCategory === 'konveksi' ? 'font-semibold text-gray-900' : '' }}">
        Konveksi
    </a>
    <span class="hidden sm:inline">|</span>

    <a href="{{ url('/produk?kategori=kebutuhan-sekolah') }}" data-kategori-link
        class="transition hover:text-pink-600 {{ $activeCategory === 'kebutuhan-sekolah' ? 'font-semibold text-gray-900' : '' }}">
        Kebutuhan Sekolah & Perusahaan
    </a>
    <span class="hidden sm:inline">|</span>

    <a href="{{ url('/produk?kategori=fasilitas') }}" data-kategori-link
        class="transition hover:text-pink-600 {{ $activeCategory === 'fasilitas' ? 'font-semibold text-gray-900' : '' }}">
        Fasilitas
    </a>
</nav>
