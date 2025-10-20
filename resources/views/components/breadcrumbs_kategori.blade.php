@props(['activeCategory' => 'all'])

<nav
    class="flex flex-wrap gap-3 text-sm text-gray-500 mb-12 border-b border-gray-200 pb-4 justify-center md:justify-start">
    <a href="{{ url('/produk') }}"
        class="{{ $activeCategory === 'all' ? 'font-semibold text-gray-900' : '' }} hover:text-pink-600 transition">All</a>
    <span>|</span>
    <a href="{{ url('/produk?kategori=percetakan') }}"
        class="{{ $activeCategory === 'percetakan' ? 'font-semibold text-gray-900' : '' }} hover:text-pink-600 transition">Percetakan</a>
    <span>|</span>
    <a href="{{ url('/produk?kategori=konveksi') }}"
        class="{{ $activeCategory === 'konveksi' ? 'font-semibold text-gray-900' : '' }} hover:text-pink-600 transition">Konveksi</a>
    <span>|</span>
    <a href="{{ url('/produk?kategori=kebutuhan-sekolah') }}"
        class="{{ $activeCategory === 'kebutuhan-sekolah' ? 'font-semibold text-gray-900' : '' }} hover:text-pink-600 transition">Kebutuhan Sekolah & Perusahaan</a>
    <span>|</span>
    <a href="{{ url('/produk?kategori=fasilitas') }}"
        class="{{ $activeCategory === 'fasilitas' ? 'font-semibold text-gray-900' : '' }} hover:text-pink-600 transition">Fasilitas</a>
</nav>