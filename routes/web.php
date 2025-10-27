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
