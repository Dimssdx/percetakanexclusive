<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('client.beranda');
});

Route::get('/produk', function () {
    return view('client.produk');
});

Route::get('/e-commerce', function () {
    return view('client.e-commerce');
});

// (removed test route)

Route::get('/produk/{id}', function ($id) {
    return view('client.product-detail', [
        'product' => (object) [
            'nama' => 'Produk ' . $id,
            'harga' => 150000,
            'gambar' => 'images/produk-' . $id . '.jpg',
            'deskripsi' => 'Deskripsi lengkap produk nomor ' . $id,
            'kategori' => 'Percetakan',
        ],
    ]);
})->name('produk.detail');

// API Routes - Proxy/Consumer endpoints yang fetch dari backend
Route::prefix('api/v1')->group(function () {
    Route::get('/produk', function () {
        try {
            // Construct backend URL dengan query params
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/produk';
            
            // Forward query parameters
            $page = request('page', 1);
            $kategori = request('kategori', '');
            
            $params = ['page' => $page];
            if ($kategori) {
                // Map frontend slug -> backend category label if needed
                $kategoriMap = [
                    'percetakan' => 'Percetakan',
                    'konveksi' => 'Konveksi',
                    'kebutuhan-sekolah' => 'Kebutuhan Sekolah & Perusahaan',
                    'fasilitas' => 'Fasilitas',
                ];

                $mapped = $kategoriMap[strtolower($kategori)] ?? null;
                $params['kategori'] = $mapped ?: $kategori;
            }
            
            // Prevent accidental self-call: if BACKEND_API_URL points to the same host:port as the current app,
            // abort early and log a clear warning to help debugging.
            $backendHost = parse_url($backendUrl, PHP_URL_HOST);
            $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);
            $currentHost = request()->getHost();
            $currentPort = request()->getPort();

            if ($backendHost === $currentHost && (int) $backendPort === (int) $currentPort) {
                \Log::warning('Prevented self-call to backend API', ['backendUrl' => $backendUrl, 'request_host' => $currentHost, 'request_port' => $currentPort]);
                return response()->json([
                    'success' => false,
                    'message' => 'Misconfigured BACKEND_API_URL: backend points to the same host/port as frontend. Set BACKEND_API_URL in .env',
                    'data' => [],
                    'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
                ], 500);
            }

            // Fetch dari backend API
            $response = Http::timeout(10)->get($backendUrl, $params);

            if ($response->successful()) {
                return $response->json();
            }

            // Log details for easier debugging (status + body)
            \Log::error('Backend API returned non-success status', [
                'url' => $backendUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Fallback jika backend error
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari backend',
                'data' => [],
                'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
            ], $response->status());
            
        } catch (\Exception $e) {
            \Log::error('API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => [],
                'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
            ], 500);
        }
    });

    Route::get('/produk/{id}', function ($id) {
        try {
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/produk/' . $id;
            
            // Prevent self-call for detail endpoint as well
            $backendHost = parse_url($backendUrl, PHP_URL_HOST);
            $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);
            $currentHost = request()->getHost();
            $currentPort = request()->getPort();

            if ($backendHost === $currentHost && (int) $backendPort === (int) $currentPort) {
                \Log::warning('Prevented self-call to backend API (detail)', ['backendUrl' => $backendUrl, 'request_host' => $currentHost, 'request_port' => $currentPort]);
                return response()->json([
                    'success' => false,
                    'message' => 'Misconfigured BACKEND_API_URL: backend points to the same host/port as frontend. Set BACKEND_API_URL in .env',
                    'data' => null,
                ], 500);
            }

            $response = Http::timeout(10)->get($backendUrl);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('Backend API returned non-success status for detail', [
                'url' => $backendUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
                'data' => null,
            ], $response->status());
            
        } catch (\Exception $e) {
            \Log::error('API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    });
});
