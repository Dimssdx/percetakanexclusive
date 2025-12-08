<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FrontendEcommerceController;

// Public pages
Route::get('/', fn() => view('client.Beranda'))->name('home');

// Produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

// API untuk AJAX
Route::prefix('api/v1')->group(function () {
    Route::get('/produk', [ProdukController::class, 'apiIndex'])->name('api.produk.index');
    Route::get('/ecommerce', [FrontendEcommerceController::class, 'apiIndex'])->name('api.ecommerce.index');
});
