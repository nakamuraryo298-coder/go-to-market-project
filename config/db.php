<?php
require_once __DIR__ . '/env.php';

$host = env('DB_HOST', 'localhost');
$user = env('DB_USER', '');
$pass = env('DB_PASSWORD', '');
$db   = env('DB_NAME', '');

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

mysqli_set_charset($conn, 'utf8mb4');

function clean_input($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
