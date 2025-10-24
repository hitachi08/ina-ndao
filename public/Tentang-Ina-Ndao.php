<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/KontenModel.php';
require_once __DIR__ . '/../app/TranslatePage.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

$model = new KontenModel($pdo);

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

$lang = $_SESSION['lang'] ?? 'id';
$translator = new TranslatePage($lang);
$translator->start();

$data = $model->getByHalaman('tentang_ina_ndao');

if (!empty($data['konten'])) {
    $rows = json_decode($data['konten'], true);
    if (!is_array($rows)) {
        $rows = [];
    }
} else {
    $rows = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ina Ndao - Tenun Ikat NTT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link href="img/ina_ndao_logo.jpeg" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/tentang.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?php include "navbar.php" ?>
    <!-- Navbar End -->

    <!-- Hero Start -->
    <div class="container-fluid pb-5 bg-primary hero-header">
        <div class="container py-5">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-1 mb-0 animated slideInLeft">Tentang Kami</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Tentang Kami</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Struktur Organisasi Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h1 class="mb-3">Struktur <span class="text-primary">Organisasi</span></h1>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-md-6 col-lg-4 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInDown" data-wow-delay="0.2s">
                        <h5 class="mb-1 text-primary">Yustinus Lussi</h5>
                        <small class="text-muted d-block mb-2">Penanggung Jawab</small>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">
                        <h6 class="mb-1 text-dark">Dorce Lussi</h6>
                        <small class="text-muted">Direktris</small>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Hanny Lussi</h6>
                        <small class="text-muted">Manager</small>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-2">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Rety Lusi</h6>
                        <small class="text-muted">Koordinator Produksi</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-2">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Nona Kake</h6>
                        <small class="text-muted">Admin</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Mensi Longgak</h6>
                        <small class="text-muted">Koordinator Pemasaran</small>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-2">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Robert Matatula</h6>
                        <small class="text-muted">Lapangan</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-2">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Tersiana Tobo</h6>
                        <small class="text-muted">Koordinator Desain</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Yusak Sanam</h6>
                        <small class="text-muted">Peralatan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Struktur Organisasi End -->

    <!-- Tentang Ina Ndao Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <?php foreach ($rows as $i => $row):
                $reverse = ($i % 2 == 1) ? 'flex-lg-row-reverse' : '';
            ?>
                <div class="row align-items-center g-5 mb-5 <?= $reverse ?> d-flex">
                    <div class="col-lg-6 col-md-12 text-center wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="image-wrapper mx-auto">
                            <img src="<?= htmlspecialchars($row['gambar']) ?>"
                                alt="<?= htmlspecialchars($row['judul']) ?>"
                                class="img-fluid shadow"
                                loading="lazy" style="height: 400px; object-fit: cover; border-radius: 5px;">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 wow fadeInRight" data-wow-delay="0.4s">
                        <h2 class="mb-4 text-primary text-center text-lg-start"><?= htmlspecialchars($row['judul']) ?></h2>
                        <p class="fs-6 text-justify"><?= nl2br(htmlspecialchars($row['paragraf1'])) ?></p>
                        <p class="fs-6 text-justify"><?= nl2br(htmlspecialchars($row['paragraf2'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Tentang Ina Ndao End -->

    <!-- Event PastComing Start -->
    <div class="container-fluid mt-5">
        <div class="container mt-5">
            <div class="row g-0">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column justify-content-center bg-primary h-100 p-5">
                        <h1 class="text-white mb-5">
                            Event Kami <br>
                            <span class="text-uppercase text-primary bg-light px-2">Yang Telah Berlangsung</span>
                        </h1>
                        <h4 class="text-white mb-0">
                            Dokumentasi Kegiatan Ina Ndao
                        </h4>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.1s">
                    <div class="project-wrapper p-0 overflow-auto">
                        <div class="project-grid" id="pastEvents">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event PastComing End -->

    <!-- Event UpComing Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-5 text-center">Event
                <span class="text-uppercase text-primary bg-light px-2">Ina Ndao</span>
                Yang Akan Datang
            </h1>
            <div class="owl-carousel event-carousel wow fadeIn" data-wow-delay="0.1s" id="upcomingEvents">
            </div>
        </div>
    </div>
    <!-- Event UpComing End -->

    <!-- Footer Start -->
    <?php include "footer.php" ?>
    <!-- Footer End -->

    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <?php
    if (isset($translator)) {
        $translator->translateOutput();
    }
    ?>

    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/tentang.js"></script>
    <script src="js/main.js"></script>

</body>

</html>