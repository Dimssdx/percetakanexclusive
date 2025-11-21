<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    public function index()
    {
        // URL backend API kamu (ganti sesuai backend)
        $response = Http::get('http://localhost:8000/api/v1/produk');

        // Convert ke array
        $products = $response->json();

        return view('client.produk', compact('products'));
    }

    public function show($id)
    {
        $response = Http::get("http://localhost:8000/api/v1/produk/$id");

        $product = $response->json();

        return view('client.product-detail', compact('product'));
    }
}
