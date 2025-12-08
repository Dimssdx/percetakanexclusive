<?php
// routes/web.php (FRONTEND)

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FrontendEcommerceController;

// ============================================
// PUBLIC PAGES
// ============================================

Route::get('/', function () {
    return view('client.Beranda');
})->name('home');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

Route::get('/e-commerce', [FrontendEcommerceController::class, 'index'])->name('frontend.ecommerce');

// ============================================
// AJAX API ENDPOINTS (untuk JavaScript)
// ============================================

Route::prefix('api/v1')->group(function () {
    Route::get('/produk', function () {
        try {
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/produk';
            $params = request()->only(['page', 'kategori', 'search']);

            // Map kategori dari slug ke format backend
            if (!empty($params['kategori'])) {
                $kategoriMap = [
                    'percetakan' => 'Percetakan',
                    'konveksi' => 'Konveksi',
                    'kebutuhan-sekolah' => 'Kebutuhan Sekolah & Perusahaan',
                    'fasilitas' => 'Fasilitas',
                ];
                $params['kategori'] = $kategoriMap[strtolower($params['kategori'])] ?? $params['kategori'];
            }

            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($backendUrl, $params);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('Backend API Error', [
                'url' => $backendUrl,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Backend error',
                    'data' => [],
                    'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
                ],
                500,
            );
        } catch (\Exception $e) {
            \Log::error('API Proxy Error: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => [],
                    'pagination' => ['total' => 0, 'per_page' => 15, 'current_page' => 1, 'last_page' => 1],
                ],
                500,
            );
        }
    });

    Route::get('/ecommerce', function () {
        try {
            $backendUrl = env('BACKEND_API_URL', 'http://localhost:8001') . '/api/v1/ecommerce';
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($backendUrl);

            if ($response->successful()) {
                return $response->json();
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Backend error',
                    'data' => [],
                ],
                500,
            );
        } catch (\Exception $e) {
            \Log::error('E-Commerce API Error: ' . $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => [],
                ],
                500,
            );
        }
    });
});
