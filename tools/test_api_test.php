<?php
$ctx = stream_context_create(["http" => ["method" => "GET", "header" => "Accept: application/json\r\n"]]);
$url = "http://127.0.0.1:8000/api/test";
$r = @file_get_contents($url, false, $ctx);
echo "=== Testing: $url ===\n";
echo "Response Status: " . ($http_response_header[0] ?? 'unknown') . "\n";
echo "Body:\n";
var_dump($r);
