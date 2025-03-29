<?php

return [
    'paths' => ['api/*', 'login', 'logout', 'refresh', 'me'], // Sesuaikan dengan endpoint JWT Anda
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Untuk development, ganti dengan domain frontend di production
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['Authorization'], // Penting untuk JWT
    'max_age' => 0,
    'supports_credentials' => true, // Wajib true jika pakai cookie/session
];

