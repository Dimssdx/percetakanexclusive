<?php
$url = "http://127.0.0.1:8000/api/v1/produk?_=konveksi&page=1";
$opts = ["http"=>["method"=>"GET","header"=>"Accept: application/json\r\n"]];
$context = stream_context_create($opts);
$result = @file_get_contents($url, false, $context);
var_dump($http_response_header ?? null);
var_dump($result);
