<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
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

    // ambil slug/id dari request body
    $param = $_POST['idOrSlug'] ?? null;

    $controller->handle($action, $param);
    exit;
}

// Route halaman admin Event
if ($uri === '/admin/event') {
    include __DIR__ . '/admin/Event.php';
    exit;
}

// ----------------- ROUTE GALERI ------------------ //
// Route: /galeri/{action}
if (preg_match('#^/galeri/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/GaleriController.php';
    $controller = new GaleriController($pdo);
    $controller->handle($action);
    exit;
}

// Route halaman admin Galeri
if ($uri === '/admin/galeri') {
    include __DIR__ . '/admin/Galeri.php';
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

// ----------------- DEFAULT 404 ------------------ //
http_response_code(404);
echo "Page not found";
