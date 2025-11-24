<?php
// app/Http/Controllers/ProdukController.php (FRONTEND - Port 8000)

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Base URL untuk Backend API
     */
    private $apiBaseUrl = 'http://localhost:8001/api/v1/produk';

    /**
     * Display a listing of products.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Build query parameters
            $params = $request->only(['page', 'per_page', 'search']);
            if ($request->has('kategori') && $request->kategori !== 'all') {
                $params['kategori'] = $request->kategori;
            }

            // Fetch dari backend API
            $response = Http::timeout(10)->get($this->apiBaseUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                
                // Normalisasi data produk
                $products = $this->normalizeProductsData($data)['data'] ?? [];
                
                // Ambil pagination data dari response API
                $pagination = $data['pagination'] ?? null;
                
                return view('client.produk', compact('products', 'pagination'));
            }

            // Handle API error
            Log::error('Failed to fetch products', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => $this->apiBaseUrl
            ]);

            return view('client.produk', ['products' => [], 'pagination' => null])
                ->with('error', 'Gagal memuat produk dari server (' . $response->status() . ')');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error in ProdukController@index: ' . $e->getMessage());
            
            return view('client.produk', ['products' => [], 'pagination' => null])
                ->with('error', 'Tidak dapat terhubung ke server. Pastikan backend API berjalan.');
                
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@index: ' . $e->getMessage());
            
            return view('client.produk', ['products' => [], 'pagination' => null])
                ->with('error', 'Terjadi kesalahan saat memuat produk.');
        }
    }

    /**
     * Display the specified product.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            // Fetch single product from backend API
            $response = Http::timeout(10)->get("{$this->apiBaseUrl}/{$id}");

            if ($response->successful()) {
                $result = $response->json();
                
                $productData = $result['data'] ?? $result;
                
                // DEBUG LOG
                Log::info('=== PRODUCT DETAIL DEBUG ===');
                Log::info('Product ID: ' . $id);
                Log::info('Raw gambar from API:', ['gambar' => $productData['gambar'] ?? null]);
                Log::info('Backend URL:', ['url' => env('BACKEND_API_URL', 'http://localhost:8001')]);
                
                // Normalisasi single product data
                $product = $this->normalizeProductData($productData);
                
                Log::info('After normalize:', [
                    'gambar_urls' => $product['gambar_urls'] ?? null,
                    'gambar_utama' => $product['gambar_utama'] ?? null,
                    'gambar_display' => $product['gambar_display'] ?? null,
                ]);
                
                return view('client.product-detail', compact('product'));
            }

            if ($response->status() === 404) {
                abort(404, 'Produk tidak ditemukan');
            }

            Log::error('Failed to fetch product detail', [
                'id' => $id,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            abort(500, 'Gagal memuat detail produk');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error in ProdukController@show: ' . $e->getMessage());
            abort(503, 'Tidak dapat terhubung ke server. Pastikan backend API berjalan di http://localhost:8001');
            
        } catch (\Exception $e) {
            Log::error('Error in ProdukController@show: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            abort(500, 'Terjadi kesalahan saat memuat produk');
        }
    }

    /**
     * API endpoint for AJAX requests (optional).
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        try {
            $params = $request->only(['kategori', 'page', 'per_page', 'search']);
            
            // FIX: Hapus kategori jika nilainya kosong (yang berarti 'All' dari JS)
            if (isset($params['kategori']) && empty($params['kategori'])) {
                 unset($params['kategori']);
            }
            
            $response = Http::timeout(10)->get($this->apiBaseUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                
                // Normalisasi data produk
                $normalizedData = $this->normalizeProductsData($data);
                
                return response()->json([
                    'success' => true,
                    'data' => $normalizedData['data'] ?? $normalizedData,
                    'pagination' => $data['pagination'] ?? null
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat produk'
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Error in ProdukController@apiIndex: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Normalize products data (for listing).
     * @param array $data
     * @return array
     */
    private function normalizeProductsData(array $data)
    {
        $products = $data['data'] ?? $data;

        if (is_array($products)) {
            // Apply normalization only if it's an array of products
            $data['data'] = array_map(function($product) {
                return $this->normalizeProductData($product);
            }, $products);
        }

        return $data; // Return the whole structure (including pagination)
    }

    /**
     * Normalize single product data.
     * @param array|null $product
     * @return array
     */
    private function normalizeProductData($product)
    {
        if (!is_array($product)) {
            return $product ?? [];
        }

        $product['gambar_utama'] = $product['gambar_utama'] ?? null;
        $product['gambar_urls'] = $product['gambar_urls'] ?? [];

        // 1. Process 'gambar' field first (legacy/main field)
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
        
        // 2. Build full URLs for all paths in gambar_urls
        if (!empty($product['gambar_urls'])) {
            $product['gambar_urls'] = array_map([$this, 'buildImageUrl'], $product['gambar_urls']);
            // Filter out null values
            $product['gambar_urls'] = array_values(array_filter($product['gambar_urls']));
        }

        // 3. Set 'gambar_utama' from the first URL
        if (empty($product['gambar_utama']) && !empty($product['gambar_urls'])) {
            $product['gambar_utama'] = $product['gambar_urls'][0];
        }
        
        // 4. Handle existing 'gambar_utama' which might be just a path
        if (isset($product['gambar_utama']) && is_string($product['gambar_utama']) && !preg_match('/^https?:\/\//i', $product['gambar_utama'])) {
             $product['gambar_utama'] = $this->buildImageUrl($product['gambar_utama']);
        }
        
        // 5. Set default placeholder if no image found
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
     * Build full image URL from path.
     * @param string|null $path
     * @return string|null
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

        // Get backend URL from env
        $backendUrl = env('BACKEND_API_URL', 'http://127.0.0.1:8001');
        $backendUrl = rtrim($backendUrl, '/');
        
        // Remove leading slash
        $path = ltrim($path, '/');
        
        Log::info('Building image URL:', [
            'original_path' => $path,
            'backend_url' => $backendUrl
        ]);
        
        // Case 1: Path is 'uploads/produk/xxx.jpg'
        if (str_starts_with($path, 'uploads/produk/')) {
            $finalUrl = $backendUrl . '/storage/' . $path;
            Log::info('Case 1 - uploads/produk/', ['url' => $finalUrl]);
            return $finalUrl;
        }
        
        // Case 2: Path is 'produk/xxx.jpg'  
        if (str_starts_with($path, 'produk/')) {
            $finalUrl = $backendUrl . '/storage/uploads/' . $path;
            Log::info('Case 2 - produk/', ['url' => $finalUrl]);
            return $finalUrl;
        }
        
        // Case 3: Path is 'storage/uploads/produk/xxx.jpg'
        if (str_starts_with($path, 'storage/')) {
            $finalUrl = $backendUrl . '/' . $path;
            Log::info('Case 3 - storage/', ['url' => $finalUrl]);
            return $finalUrl;
        }
        
        // Default: Assume it's just filename or partial path
        $finalUrl = $backendUrl . '/storage/uploads/produk/' . $path;
        Log::info('Case Default:', ['url' => $finalUrl]);
        return $finalUrl;
    }
}