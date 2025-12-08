<?php
// app/Http/Controllers/ProdukController.php (FRONTEND - Port 8000)

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Get Backend API Base URL from environment
     */
    private function getBackendUrl()
    {
        return env('BACKEND_API_URL', 'http://localhost:8001');
    }

    /**
     * Get API endpoint for products
     */
    private function getProductsApiUrl()
    {
        return rtrim($this->getBackendUrl(), '/') . '/api/v1/produk';
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        try {
            $params = $request->only(['page', 'per_page', 'search']);
            if ($request->has('kategori') && $request->kategori !== 'all') {
                $params['kategori'] = $request->kategori;
            }

            $apiUrl = $this->getProductsApiUrl();

            Log::info('Fetching products from backend', [
                'url' => $apiUrl,
                'params' => $params,
            ]);

            $response = Http::timeout(10)->get($apiUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                $products = $this->normalizeProductsData($data)['data'] ?? [];
                $pagination = $data['pagination'] ?? null;

                Log::info('Products fetched successfully', [
                    'count' => count($products),
                ]);

                return view('client.produk', compact('products', 'pagination'));
            }

            Log::error('Backend API returned non-success status', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $apiUrl,
            ]);

            return view('client.produk', ['products' => [], 'pagination' => null])->with('error', 'Gagal memuat produk dari server (' . $response->status() . ')');
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error - Backend tidak dapat dijangkau', [
                'error' => $e->getMessage(),
                'backend_url' => $this->getBackendUrl(),
            ]);

            return view('client.produk', ['products' => [], 'pagination' => null])->with('error', 'Tidak dapat terhubung ke server backend. Pastikan backend berjalan di: ' . $this->getBackendUrl());
        } catch (\Exception $e) {
            Log::error('Unexpected error in ProdukController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return view('client.produk', ['products' => [], 'pagination' => null])->with('error', 'Terjadi kesalahan saat memuat produk.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        try {
            $apiUrl = $this->getProductsApiUrl() . '/' . $id;

            Log::info('Fetching product detail', [
                'id' => $id,
                'url' => $apiUrl,
            ]);

            $response = Http::timeout(10)->get($apiUrl);

            if ($response->successful()) {
                $result = $response->json();
                $productData = $result['data'] ?? $result;

                Log::info('Product detail received', [
                    'id' => $id,
                    'nama' => $productData['nama'] ?? 'N/A',
                    'raw_gambar' => $productData['gambar'] ?? null,
                ]);

                $product = $this->normalizeProductData($productData);

                Log::info('After normalization', [
                    'gambar_utama' => $product['gambar_utama'] ?? null,
                    'gambar_urls_count' => count($product['gambar_urls'] ?? []),
                ]);

                return view('client.produk-detail', compact('product'));
            }

            if ($response->status() === 404) {
                Log::warning('Product not found', ['id' => $id]);
                abort(404, 'Produk tidak ditemukan');
            }

            Log::error('Failed to fetch product detail', [
                'id' => $id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            abort(500, 'Gagal memuat detail produk');
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error - Backend tidak dapat dijangkau (detail)', [
                'id' => $id,
                'error' => $e->getMessage(),
                'backend_url' => $this->getBackendUrl(),
            ]);

            abort(503, 'Backend API tidak dapat dijangkau. URL: ' . $this->getBackendUrl());
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            throw $e; // Re-throw HTTP exceptions (404, 503, etc.)
        } catch (\Exception $e) {
            Log::error('Unexpected error in ProdukController@show', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Terjadi kesalahan saat memuat produk: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint for AJAX requests.
     */
    public function apiIndex(Request $request)
    {
        try {
            $params = $request->only(['kategori', 'page', 'per_page', 'search']);

            // Remove empty kategori parameter
            if (isset($params['kategori']) && empty($params['kategori'])) {
                unset($params['kategori']);
            }

            $apiUrl = $this->getProductsApiUrl();
            $response = Http::timeout(10)->get($apiUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                $normalizedData = $this->normalizeProductsData($data);

                return response()->json([
                    'success' => true,
                    'data' => $normalizedData['data'] ?? $normalizedData,
                    'pagination' => $data['pagination'] ?? null,
                ]);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memuat produk',
                ],
                $response->status(),
            );
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@apiIndex', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan server',
                ],
                500,
            );
        }
    }

    /**
     * Normalize products data (for listing).
     */
    private function normalizeProductsData(array $data)
    {
        $products = $data['data'] ?? $data;

        if (is_array($products)) {
            $data['data'] = array_map(function ($product) {
                return $this->normalizeProductData($product);
            }, $products);
        }

        return $data;
    }

    /**
     * Normalize single product data and build image URLs.
     */
    private function normalizeProductData($product)
    {
        if (!is_array($product)) {
            return $product ?? [];
        }

        // Initialize arrays
        $product['gambar_urls'] = $product['gambar_urls'] ?? [];
        $product['gambar_utama'] = $product['gambar_utama'] ?? null;

        // Process 'gambar' field from backend
        if (isset($product['gambar'])) {
            $gambarField = $product['gambar'];

            if (is_string($gambarField)) {
                $decoded = json_decode($gambarField, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $product['gambar_urls'] = array_filter($decoded);
                } else {
                    $product['gambar_urls'] = [$gambarField];
                }
            } elseif (is_array($gambarField)) {
                $product['gambar_urls'] = array_filter($gambarField);
            }
        }

        // Build full URLs for all image paths
        if (!empty($product['gambar_urls'])) {
            $product['gambar_urls'] = array_map([$this, 'buildImageUrl'], $product['gambar_urls']);
            $product['gambar_urls'] = array_values(array_filter($product['gambar_urls']));
        }

        // Set main image from first URL
        if (empty($product['gambar_utama']) && !empty($product['gambar_urls'])) {
            $product['gambar_utama'] = $product['gambar_urls'][0];
        }

        // Handle existing 'gambar_utama' which might be just a path
        if (isset($product['gambar_utama']) && is_string($product['gambar_utama']) && !preg_match('/^https?:\/\//i', $product['gambar_utama'])) {
            $product['gambar_utama'] = $this->buildImageUrl($product['gambar_utama']);
        }

        // Set placeholder if no image found
        if (empty($product['gambar_utama'])) {
            $product['gambar_utama'] = asset('images/placeholder.png');
        }

        if (empty($product['gambar_urls'])) {
            $product['gambar_urls'] = [asset('images/placeholder.png')];
        }

        $product['gambar_display'] = $product['gambar_utama'];

        return $product;
    }

    /**
     * Build full image URL from relative path.
     * This method handles various path formats and converts them to full URLs.
     */
    private function buildImageUrl($path)
    {
        if (empty($path)) {
            return null;
        }

        // If already absolute URL, return as is
        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        $backendUrl = rtrim($this->getBackendUrl(), '/');
        $path = ltrim($path, '/');

        // Case 1: Path is 'uploads/produk/xxx.jpg'
        if (str_starts_with($path, 'uploads/produk/')) {
            return $backendUrl . '/storage/' . $path;
        }

        // Case 2: Path is 'produk/xxx.jpg'
        if (str_starts_with($path, 'produk/')) {
            return $backendUrl . '/storage/uploads/' . $path;
        }

        // Case 3: Path is 'storage/uploads/produk/xxx.jpg'
        if (str_starts_with($path, 'storage/')) {
            return $backendUrl . '/' . $path;
        }

        // Default: Assume it's just filename
        return $backendUrl . '/storage/uploads/produk/' . $path;
    }
}
