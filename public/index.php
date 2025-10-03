<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ----------------- ROUTE EVENT ------------------ //
// Route: /event/{action}
if (preg_match('#^/event/([a-z_]+)$#', $uri, $matches)) {
    $action = $matches[1];
    require_once __DIR__ . '/../app/Controllers/EventController.php';
    $controller = new EventController($pdo);
    $controller->handle($action);
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

// ----------------- DEFAULT 404 ------------------ //
http_response_code(404);
echo "Page not found";
