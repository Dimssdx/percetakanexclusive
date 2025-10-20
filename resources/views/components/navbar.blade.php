<header class="bg-white shadow-sm w-full sticky top-0 z-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex justify-between items-center h-20">
        <a href="/" class="flex items-center gap-4 flex-shrink-0">
            <img src="{{ asset('images/logo_black.png') }}" alt="Logo Intan Exclusive" class="h-12 lg:h-14">
        </a>

        <nav class="hidden md:flex gap-2 lg:gap-4 items-center">
            <a href="/"
                class="px-4 py-2 font-medium text-base text-gray-700 transition duration-300 relative group inline-block">
                Beranda
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 bg-transparent group-hover:bg-[#e85d75] transition-all duration-300 scale-x-0 group-hover:scale-x-100"></span>
            </a>
            <a href="/produk"
                class="px-4 py-2 font-medium text-base text-gray-700 transition duration-300 relative group inline-block">
                Produk
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 bg-transparent group-hover:bg-[#e85d75] transition-all duration-300 scale-x-0 group-hover:scale-x-100"></span>
            </a>
            <a href="/e-commerce"
                class="px-4 py-2 font-medium text-base text-gray-700 transition duration-300 relative group inline-block">
                E-Commerce
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 bg-transparent group-hover:bg-[#e85d75] transition-all duration-300 scale-x-0 group-hover:scale-x-100"></span>
            </a>

            <a href="/kontak"
                class="ml-4 px-6 py-2.5 rounded-full font-semibold text-base text-white bg-gradient-to-br from-[#e85d75] to-[#d84a6f] shadow-lg shadow-[#e85d75]/30 transition duration-300 hover:opacity-90">
                Kontak
            </a>
        </nav>

        <div class="md:hidden">
            <button class="text-gray-700 hover:text-[#e85d75] p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</header>
