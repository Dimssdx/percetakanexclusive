<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FrontendEcommerceController;
use App\Http\Controllers\EcommerceController;

// ============================================
// FRONTEND ROUTES (PUBLIC)
// ============================================

Route::get('/', function () {
    return view('client.beranda');
})->name('home');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

// Route E-Commerce Frontend
Route::get('/e-commerce', [FrontendEcommerceController::class, 'index'])->name('frontend.ecommerce');

// ============================================
// API ROUTES - Proxy/Consumer endpoints
// ============================================

Route::prefix('api/v1')->group(function () {
    
    // API untuk Produk (Proxy ke Backend)
    Route::get('/produk', function () {
        try {
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/produk';
            $page = request('page', 1);
            $kategori = request('kategori', '');
            
            $params = ['page' => $page];
            if ($kategori) {
                $kategoriMap = [
                    'percetakan' => 'Percetakan',
                    'konveksi' => 'Konveksi',
                    'kebutuhan-sekolah' => 'Kebutuhan Sekolah & Perusahaan',
                    'fasilitas' => 'Fasilitas',
                ];
                $mapped = $kategoriMap[strtolower($kategori)] ?? null;
                $params['kategori'] = $mapped ?: $kategori;
            }
            
            $backendHost = parse_url($backendUrl, PHP_URL_HOST);
            $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);
            $currentHost = request()->getHost();
            $currentPort = request()->getPort();

            if ($backendHost === $currentHost && (int) $backendPort === (int) $currentPort) {
                \Log::warning('Prevented self-call to backend API', [
                    'backendUrl' => $backendUrl, 
                    'request_host' => $currentHost, 
                    'request_port' => $currentPort
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Misconfigured BACKEND_API_URL',
                    'data' => [],
                    'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
                ], 500);
            }

            $response = Http::timeout(10)->get($backendUrl, $params);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('Backend API returned non-success status', [
                'url' => $backendUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

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
            
            $backendHost = parse_url($backendUrl, PHP_URL_HOST);
            $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);
            $currentHost = request()->getHost();
            $currentPort = request()->getPort();

            if ($backendHost === $currentHost && (int) $backendPort === (int) $currentPort) {
                \Log::warning('Prevented self-call to backend API (detail)');
                return response()->json([
                    'success' => false,
                    'message' => 'Misconfigured BACKEND_API_URL',
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

    // API untuk E-Commerce - Proxy ke Backend
    Route::get('/ecommerce', function () {
        try {
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/ecommerce';
            
            // Prevent self-call
            $backendHost = parse_url($backendUrl, PHP_URL_HOST);
            $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);
            $currentHost = request()->getHost();
            $currentPort = request()->getPort();

            if ($backendHost === $currentHost && (int) $backendPort === (int) $currentPort) {
                \Log::warning('Prevented self-call to backend API (ecommerce)', [
                    'backendUrl' => $backendUrl, 
                    'request_host' => $currentHost, 
                    'request_port' => $currentPort
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Misconfigured BACKEND_API_URL: backend points to the same host/port as frontend',
                    'data' => []
                ], 500);
            }

            // Fetch dari backend API
            $response = Http::timeout(10)->get($backendUrl);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('Backend API returned non-success status for ecommerce', [
                'url' => $backendUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data e-commerce dari backend',
                'data' => []
            ], $response->status());
            
        } catch (\Exception $e) {
            \Log::error('E-Commerce API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    });
});