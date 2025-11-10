<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto ">
        <!-- Tombol Kembali -->
        <a href="{{ url('/produk') }}" class=" mb-4 inline-block">
            ← Kembali ke Produk
        </a>

        <!-- Card Produk -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Gambar Produk (rasio 16:9) -->
            <div class="relative w-full" style="padding-top: 56.25%;"> <!-- 16:9 ratio -->
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}"
                    class="absolute inset-0 w-full h-full object-cover">
            </div>

            <!-- Konten Produk -->
            <div class="p-6 space-y-4">
                <!-- Nama & Kategori -->
                <h1 class="text-3xl font-bold text-gray-800">{{ $product->nama }}</h1>
                <p class="text-sm text-gray-500">Kategori: {{ $product->kategori }}</p>

                <!-- Harga -->
                <p class="text-2xl font-semibold text-green-600">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>

                <!-- Deskripsi -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Deskripsi Produk</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $product->deskripsi }}</p>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
