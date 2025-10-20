<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
require_once __DIR__ . '/../vendor/autoload.php';
Auth::startSession();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ----------------- ROUTE EVENT ------------------ //

// Route: /event/detail/{slug}
if (preg_match('#^/event/detail/([\w\-]+)$#', $uri, $matches)) {
    $slug = $matches[1];
    $_GET['slug'] = $slug; // supaya bisa dipakai di Detail-Event.php
    include __DIR__ . '/Detail-Event.php';
    exit;
}

// Route: /event/{action}
if (preg_match('#^/event/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/EventController.php';
    $controller = new EventController($pdo);
    $param = $_POST['idOrSlug'] ?? null;
    $controller->handle($action, $param);
    exit;
}


// Route halaman admin Event
if ($uri === '/admin/event') {
    include __DIR__ . '/admin/Event.php';
    exit;
}

// Route: /produk/{action}
if (preg_match('#^/produk/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/ProdukController.php';
    $controller = new ProdukController($pdo);

    $response = $controller->handle($action);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Route: /produk/detail/{slug}
if (preg_match('#^/produk/detail/([\w\-]+)$#', $uri, $matches)) {
    $slug = $matches[1];
    $_GET['slug'] = $slug;
    include __DIR__ . '/Detail-Produk.php';
    exit;
}

// Route halaman admin Produk
if ($uri === '/admin/produk') {
    include __DIR__ . '/admin/Produk.php';
    exit;
}

// ----------------- ROUTE GALERI ------------------ //
// Route: /galeri/{action}
if (preg_match('#^/galeri/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/KainController.php';
    $controller = new KainController($pdo);

    $response = $controller->handle($action); // controller return array
    header('Content-Type: application/json');
    echo json_encode($response); // AJAX dapat JSON valid
    exit;
}

// Route halaman admin Galeri
if ($uri === '/admin/galeri') {
    include __DIR__ . '/admin/Galeri.php';
    exit;
}

// Route: /Kain-Tenun/{slug}
if (preg_match('#^/kain/detail/([\w\-]+)$#', $uri, $matches)) {
    $slug = $matches[1];
    $_GET['slug'] = $slug;
    include __DIR__ . '/Detail-Kain.php';
    exit;
}

// ----------------- ROUTE KONTEN HALAMAN ------------------ //
if (preg_match('#^/konten/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/KontenController.php';
    $controller = new KontenController($pdo);
    $controller->handle($action);
    exit;
}

// Route halaman admin konten beranda
if ($uri === '/admin/konten-beranda') {
    include __DIR__ . '/admin/konten-beranda.php';
    exit;
}

// ----------------- ROUTE PENGATURAN ADMIN ------------------ //
if (preg_match('#^/admin/pengaturan/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->handle($action);
    exit;
}

// Notifikasi
if (preg_match('#^/notifications/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/NotificationController.php';
    $controller = new \App\Controllers\NotificationController($pdo);
    $controller->handle($action);
    exit;
}

// Route untuk request password reset via POST (AJAX)
if ($uri === '/request/reset') {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->handle('request_password_reset');
    exit;
}

// Route untuk membuka form reset (GET /reset-password/{token})
if (preg_match('#^/reset-password/([\w\-]+)$#', $uri, $matches)) {
    $token = $matches[1];
    $_GET['token'] = $token;
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->handle('reset_password_form');
    exit;
}

// Route POST perform reset
if ($uri === '/request/change') {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->handle('perform_password_reset');
    exit;
}

// Dashboard admin
if ($uri === '/admin' || $uri === '/admin/dashboard') {
    include __DIR__ . '/admin/Dashboard.php';
    exit;
}

// API: ambil statistik untuk dashboard
if ($uri === '/admin/api/stats') {
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    $controller = new DashboardController($pdo);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($controller->stats());
    exit;
}

// ----------------- API KAIN (untuk DataTables Dashboard) ------------------ //
if ($uri === '/admin/api/kain/list') {
    require_once __DIR__ . '/../app/Controllers/DashboardController.php';
    $controller = new DashboardController($pdo);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($controller->kainList()['data']);
    exit;
}

// ----------------- DEFAULT 404 ------------------ //
http_response_code(404);
include __DIR__ . '/404.php';
exit;
