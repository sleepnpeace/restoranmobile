<?php

return [


    // Route yang kena CORS
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Method yang diizinkan
    'allowed_methods' => ['*'],

    // Origin frontend Vue
    'allowed_origins' => ['http://localhost:8100',
        'http://127.0.0.1:8100',],

    // Pattern tambahan (kosong saja)
    'allowed_origins_patterns' => [],

    // Header apa saja yang diizinkan
    'allowed_headers' => ['*'],

    // Header yang diekspos (opsional)
    'exposed_headers' => [],

    // Berapa lama preflight disimpan
    'max_age' => 0,

    // HARUS true kalau pakai session / cookie
    'supports_credentials' => true,

];
