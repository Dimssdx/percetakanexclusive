<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Controllers
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FrontendEcommerceController;
use App\Http\Controllers\EcommerceController;

// =============================
// Frontend routes
// =============================
Route::get('/', function () {
    return view('client.Beranda');
})->name('home');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.detail');

Route::get('/e-commerce', [FrontendEcommerceController::class, 'index'])->name('frontend.ecommerce');

// =============================
// Helper function
// =============================
function preventSelfCall($backendUrl)
{
    $backendHost = parse_url($backendUrl, PHP_URL_HOST);
    $backendPort = parse_url($backendUrl, PHP_URL_PORT) ?: (parse_url($backendUrl, PHP_URL_SCHEME) === 'https' ? 443 : 80);

    $currentHost = request()->getHost();
    $currentPort = request()->getPort();

    return $backendHost === $currentHost && (int) $backendPort === (int) $currentPort;
}

// =============================
// API Proxy
// =============================
Route::prefix('api/v1')->group(function () {
    // Get all produk
    Route::get('/produk', function () {
        try {
            $backendUrl = env('BACKEND_API_URL') . '/api/v1/produk';

            if (preventSelfCall($backendUrl)) {
                Log::warning('Prevented self-call to backend API');

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Misconfigured BACKEND_API_URL',
                        'data' => [],
                        'pagination' => [
                            'total' => 0,
                            'per_page' => 15,
                            'current_page' => 1,
                            'last_page' => 1,
                        ],
                    ],
                    500,
                );
            }

            $params = [
                'page' => request('page', 1),
                'kategori' => match (strtolower(request('kategori', ''))) {
                    'percetakan' => 'Percetakan',
                    'konveksi' => 'Konveksi',
                    'kebutuhan-sekolah' => 'Kebutuhan Sekolah & Perusahaan',
                    'fasilitas' => 'Fasilitas',
                    default => request('kategori', ''),
                },
            ];

            $response = Http::timeout(10)->get($backendUrl, $params);

            return $response->successful()
                ? $response->json()
                : response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengambil data dari backend',
                        'data' => [],
                    ],
                    $response->status(),
                );
        } catch (\Exception $e) {
            Log::error('API Error: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage(),
                    'data' => [],
                ],
                500,
            );
        }
    });

    // Get detail produk
    Route::get('/produk/{id}', function ($id) {
        try {
            $backendUrl = env('BACKEND_API_URL') . '/api/v1/produk/' . $id;

            if (preventSelfCall($backendUrl)) {
                Log::warning('Prevented self-call to backend API (detail)');

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Misconfigured BACKEND_API_URL',
                        'data' => null,
                    ],
                    500,
                );
            }

            $response = Http::timeout(10)->get($backendUrl);

            return $response->successful()
                ? $response->json()
                : response()->json(
                    [
                        'success' => false,
                        'message' => 'Produk tidak ditemukan',
                        'data' => null,
                    ],
                    $response->status(),
                );
        } catch (\Exception $e) {
            Log::error('API Detail Error: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage(),
                    'data' => null,
                ],
                500,
            );
        }
    });

    // E-commerce list
    Route::get('/ecommerce', function () {
        try {
            $backendUrl = env('BACKEND_API_URL') . '/api/v1/ecommerce';

            if (preventSelfCall($backendUrl)) {
                Log::warning('Prevented self-call to backend API (ecommerce)');

                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Misconfigured BACKEND_API_URL',
                        'data' => [],
                    ],
                    500,
                );
            }

            $response = Http::timeout(10)->get($backendUrl);

            return $response->successful()
                ? $response->json()
                : response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal mengambil data e-commerce dari backend',
                        'data' => [],
                    ],
                    $response->status(),
                );
        } catch (\Exception $e) {
            Log::error('Ecommerce API Error: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage(),
                    'data' => [],
                ],
                500,
            );
        }
    });
});
