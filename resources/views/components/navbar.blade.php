<header x-data="{ open: false }" class="bg-white shadow-sm w-full sticky top-0 z-50 border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex justify-between items-center h-20">
        {{-- LOGO --}}
        <a href="/" class="flex items-center gap-4 flex-shrink-0">
            <img src="{{ asset('images/logo_black.png') }}" alt="Logo Intan Exclusive" class="h-12 lg:h-14">
        </a>

        {{-- NAV DESKTOP --}}
        <nav class="hidden md:flex gap-2 lg:gap-4 items-center">
            {{-- BERANDA --}}
            <a href="/"
                class="px-4 py-2 font-medium text-base transition duration-300 relative group inline-block 
                {{ Request::is('/') ? 'text-[#e85d75]' : 'text-gray-700' }}">
                Beranda
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 
                    {{ Request::is('/') ? 'bg-[#e85d75] scale-x-100' : 'bg-transparent scale-x-0 group-hover:scale-x-100 group-hover:bg-[#e85d75]' }}
                    transition-all duration-300"></span>
            </a>

            {{-- PRODUK --}}
            <a href="/produk"
                class="px-4 py-2 font-medium text-base transition duration-300 relative group inline-block 
                {{ Request::is('produk') ? 'text-[#e85d75]' : 'text-gray-700' }}">
                Produk
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 
                    {{ Request::is('produk') ? 'bg-[#e85d75] scale-x-100' : 'bg-transparent scale-x-0 group-hover:scale-x-100 group-hover:bg-[#e85d75]' }}
                    transition-all duration-300"></span>
            </a>

            {{-- E-COMMERCE --}}
            <a href="/e-commerce"
                class="px-4 py-2 font-medium text-base transition duration-300 relative group inline-block 
                {{ Request::is('e-commerce') ? 'text-[#e85d75]' : 'text-gray-700' }}">
                E-Commerce
                <span
                    class="absolute left-1/2 -translate-x-1/2 bottom-0 w-full h-0.5 
                    {{ Request::is('e-commerce') ? 'bg-[#e85d75] scale-x-100' : 'bg-transparent scale-x-0 group-hover:scale-x-100 group-hover:bg-[#e85d75]' }}
                    transition-all duration-300"></span>
            </a>

            {{-- KONTAK --}}
            <a href="/kontak"
                class="ml-4 px-6 py-2.5 rounded-full font-semibold text-base text-white bg-gradient-to-br from-[#e85d75] to-[#d84a6f] shadow-lg shadow-[#e85d75]/30 transition duration-300 hover:opacity-90
                {{ Request::is('kontak') ? 'ring-2 ring-[#e85d75]/70' : '' }}">
                Kontak
            </a>
        </nav>

        {{-- HAMBURGER BUTTON (MOBILE) --}}
        <div class="md:hidden">
            <button @click="open = !open" class="text-gray-700 hover:text-[#e85d75] p-2 focus:outline-none">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <nav x-show="open" x-transition.origin.top.duration.300ms
        class="md:hidden bg-white border-t border-gray-200 shadow-md">
        <ul class="flex flex-col py-4 px-6 space-y-2">
            <li>
                <a href="/"
                    class="block px-3 py-2 rounded-md font-medium 
                    {{ Request::is('/') ? 'text-[#e85d75] bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="/produk"
                    class="block px-3 py-2 rounded-md font-medium 
                    {{ Request::is('produk') ? 'text-[#e85d75] bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                    Produk
                </a>
            </li>
            <li>
                <a href="/e-commerce"
                    class="block px-3 py-2 rounded-md font-medium 
                    {{ Request::is('e-commerce') ? 'text-[#e85d75] bg-gray-100' : 'text-gray-700 hover:bg-gray-100' }}">
                    E-Commerce
                </a>
            </li>
            <li>
                <a href="/kontak"
                    class="block text-center px-4 py-2.5 rounded-full font-semibold text-white bg-gradient-to-br from-[#e85d75] to-[#d84a6f] shadow-md shadow-[#e85d75]/30 hover:opacity-90 transition
                    {{ Request::is('kontak') ? 'ring-2 ring-[#e85d75]/70' : '' }}">
                    Kontak
                </a>
            </li>
        </ul>
    </nav>
</header>
