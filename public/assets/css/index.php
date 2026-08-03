<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// Simple Router
$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];

if ($path === '/' || $path === '/index.php') {
    require __DIR__ . '/../views/front/home.php';
} elseif ($path === '/api/projects') {
    $controller = new \App\Controllers\ProjectController();
    $controller->index();
} elseif (preg_match('/^\/cv\/download\/([a-zA-Z0-9]+)$/', $path, $matches)) {
    $controller = new \App\Controllers\CvController();
    $controller->downloadCv($matches[1]);
} else {
    http_response_code(404);
    echo "404 - Terminal Access Denied (Not Found)";
}