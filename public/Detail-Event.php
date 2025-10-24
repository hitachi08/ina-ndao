<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

$lang = $_SESSION['lang'] ?? 'id';
$translator = new TranslatePage($lang);
$translator->start();

$current_page = basename($_SERVER['PHP_SELF']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$slug = end($segments);
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    echo "Slug tidak ditemukan";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Ina Ndao - Tenun Ikat NTT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link href="/img/ina_ndao_logo.jpeg" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/tentang.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar Start -->
    <?php include "navbar.php" ?>
    <!-- Navbar End -->

    <!-- Hero Start -->
    <div class="container-fluid pb-5 bg-primary hero-header">
        <div class="container py-5">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-1 mb-0 animated slideInLeft" style="font-size: 4rem;">Event <span>Ina Ndao</span></h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="/Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="/Tentang-Ina-Ndao.php">Tentang Kami</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Detail Event</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <div class="container py-5">
        <div class="container">
            <div id="event-detail"></div>
            <div id="event-docs" class="row mt-4"></div>
        </div>
    </div>

    <!-- Footer Start -->
    <?php include "footer.php" ?>
    <!-- Footer End -->

    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <?php
    if (isset($translator)) {
        $translator->translateOutput();
    }
    ?>
    <script>
        const slug = <?= json_encode($slug) ?>;
    </script>

    <script src="/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/wow/wow.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/waypoints/waypoints.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/js/detail-event.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>