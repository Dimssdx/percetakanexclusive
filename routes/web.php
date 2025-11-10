<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.beranda');
});

Route::get('/produk', function () {
    return view('client.produk');
});

Route::get('/e-commerce', function () {
    return view('client.e-commerce');
});

Route::get('/produk/{id}', function ($id) {
    return view('client.product-detail', [
        'product' => (object) [
            'nama' => 'Produk ' . $id,
            'harga' => 150000,
            'gambar' => 'images/produk-' . $id . '.jpg',
            'deskripsi' => 'Deskripsi lengkap produk nomor ' . $id,
            'kategori' => 'Percetakan', // tambahkan kategori di sini
        ],
    ]);
})->name('produk.detail');
