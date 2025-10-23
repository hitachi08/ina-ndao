<?php
require_once __DIR__ . '/../app/TranslatePage.php';
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ina Ndao - Tenun Ikat NTT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="img/ina_ndao_logo.jpeg" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
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
                    <h1 class="display-1 mb-0 animated slideInLeft">Produk Olahan</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Produk Olahan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Product Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <h1 class="mb-4 text-center">
                Produk Tenun Ikat <span class="text-uppercase bg-light text-primary px-2">Ina Ndao</span>
            </h1>
            <div class="mb-4">
                <img src="img/banner.jpg" alt="Banner Produk Olahan Tenun Ikat Ina Ndao"
                    class="img-fluid w-100 rounded shadow-sm banner-img">
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="searchProduk" class="form-control border-start-0" placeholder="Cari produk...">
            </div>

            <!-- Row Start -->
            <div class="row g-4">
                <!-- Sidebar Filter Start -->
                <div class="col-12 col-lg-3 d-none d-lg-block">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="fas fa-filter me-2"></i> FILTER
                            </h5>

                            <!-- Filter Daerah -->
                            <h6 class="fw-bold">Daerah</h6>
                            <div id="filterDaerahContainer">
                                <!-- Akan diisi dinamis dari tabel daerah -->
                            </div>

                            <hr>

                            <!-- Filter Jenis Kain -->
                            <h6 class="fw-bold">Jenis Kain</h6>
                            <div id="filterJenisKainContainer">
                                <!-- Akan diisi dinamis dari tabel jenis_kain -->
                            </div>

                            <hr>

                            <!-- Filter Kategori -->
                            <h6 class="fw-bold">Kategori</h6>
                            <div id="filterKategoriContainer">
                                <!-- Akan diisi dinamis dari tabel kategori -->
                            </div>

                            <hr>

                            <!-- Filter Sub-Kategori -->
                            <h6 class="fw-bold">Sub Kategori</h6>
                            <div id="filterSubKategoriContainer">
                                <!-- Akan diisi dinamis dari tabel sub-kategori sesuai dengan pilihan pada kategori -->
                            </div>

                            <hr>

                            <!-- Filter Harga -->
                            <h6 class="fw-bold">Rentang Harga</h6>
                            <div class="d-flex align-items-center">
                                <input type="number" class="form-control form-control-sm me-2" id="hargaMin" placeholder="Min">
                                <span class="mx-1">-</span>
                                <input type="number" class="form-control form-control-sm ms-2" id="hargaMax" placeholder="Max">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Filter End -->

                <!-- List Produk Start -->
                <div class="col-12 col-lg-9">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="product-olahan-list"></div>
                    <nav>
                        <ul class="pagination justify-content-end" id="pagination"></ul>
                    </nav>
                </div>
                <!-- List Produk End -->

            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- Product End -->

    <!-- Footer Start -->
    <?php include "footer.php" ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <?php
    if (isset($translator)) {
        $translator->translateOutput();
    }
    ?>

    <script>
        const currentLang = "<?= $currentLang ?>";
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/produk-olahan.js"></script>