@props([
    'id' => null,
    'image' => null,
    'title' => 'Nama Produk',
])

<a href="{{ route('produk.detail', ['id' => $id]) }}"
    class="border border-gray-300 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition transform hover:-translate-y-1 bg-white block">

    <div class="aspect-[4/3] bg-gray-100 flex items-center justify-center overflow-hidden">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="object-cover w-full h-full">
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-10 h-10 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25v11.25M3 16.5l4.5-4.5a2.121 2.121 0 013 0L15 16.5M3 16.5l2.25 2.25A2.25 2.25 0 007.5 19.5h9a2.25 2.25 0 002.25-2.25L21 16.5M15 16.5l2.25 2.25M9 10.5h.008v.008H9v-.008z" />
            </svg>
        @endif
    </div>

    <div class="p-4 text-center">
        <h3 class="font-semibold text-gray-800 text-sm md:text-base">{{ $title }}</h3>
    </div>
</a>
