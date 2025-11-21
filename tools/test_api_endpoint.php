<?php
// Test API endpoint directly
$url = "http://127.0.0.1:8000/api/v1/produk?page=1";
$opts = ["http"=>["method"=>"GET","header"=>"Accept: application/json\r\n"]];
$ctx = stream_context_create($opts);
$result = @file_get_contents($url, false, $ctx);

echo "=== Testing: $url ===\n";
echo "Response Status: " . ($http_response_header[0] ?? 'unknown') . "\n";
echo "Response Body:\n";
var_dump($result);
echo "\n";

// Also test without page param
$url2 = "http://127.0.0.1:8000/api/v1/produk";
$result2 = @file_get_contents($url2, false, $ctx);
echo "=== Testing: $url2 ===\n";
echo "Response Status: " . ($http_response_header[0] ?? 'unknown') . "\n";
var_dump($result2);
