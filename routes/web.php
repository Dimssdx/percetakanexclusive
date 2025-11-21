<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('client.beranda');
});

// Route FRONTEND yang consume API BACKEND
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

Route::get('/e-commerce', function () {
    return view('client.e-commerce');
});
