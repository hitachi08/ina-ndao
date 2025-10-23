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
    <style>
        .image-wrapper {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            text-align: center;
        }

        .image-wrapper img {
            width: 100%;
            height: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .person-card {
            transition: all 0.3s ease;
        }

        .person-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .line {
            width: 120px;
            height: 2px;
            background-color: #0d6efd;
            position: relative;
        }

        .line::before,
        .line::after {
            content: "";
            position: absolute;
            top: 0;
            width: 40px;
            height: 2px;
            background-color: #0d6efd;
        }

        .line::before {
            left: -60px;
        }

        .line::after {
            right: -60px;
        }

        /* Responsive tweak */
        @media (max-width: 768px) {

            .line::before,
            .line::after {
                display: none;
            }
        }
    </style>

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

            <!-- Tingkat 1: Ketua -->
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-md-6 col-lg-4 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInDown" data-wow-delay="0.2s">
                        <h5 class="mb-1 text-primary">Yustinus Lussi</h5>
                        <small class="text-muted d-block mb-2">Penanggung Jawab</small>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <!-- Tingkat 2: Sekretaris & Bendahara -->
            <div class="row justify-content-center mb-5">
                <div class="col-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.3s">
                        <h6 class="mb-1 text-dark">Dorce Lussi</h6>
                        <small class="text-muted">Direktris</small>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <!-- Tingkat 3: Koordinator -->
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Hanny Lussi</h6>
                        <small class="text-muted">Manager</small>
                    </div>
                </div>
            </div>

            <!-- Garis penghubung -->
            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <!-- Tingkat 4: Koordinator -->
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Rety Lusi</h6>
                        <small class="text-muted">Koordinator Produksi</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
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

            <!-- Garis penghubung -->
            <div class="text-center mb-5">
                <div class="line mx-auto"></div>
            </div>

            <!-- Tingkat 5: Koordinator -->
            <div class="row justify-content-center g-4">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
                    <div class="person-card bg-light p-4 rounded shadow-sm wow fadeInUp" data-wow-delay="0.5s">
                        <h6 class="mb-1 text-dark">Robert Matatula</h6>
                        <small class="text-muted">Lapangan</small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
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
                    <!-- Kolom Gambar -->
                    <div class="col-lg-6 col-md-12 text-center wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="image-wrapper mx-auto">
                            <img src="<?= htmlspecialchars($row['gambar']) ?>"
                                alt="<?= htmlspecialchars($row['judul']) ?>"
                                class="img-fluid shadow"
                                loading="lazy" style="height: 400px; object-fit: cover; border-radius: 5px;">
                        </div>
                    </div>

                    <!-- Kolom Teks -->
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
                <!-- Bagian Kiri -->
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

                <!-- Bagian Kanan -->
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.1s">
                    <div class="project-wrapper p-0 overflow-auto">
                        <div class="project-grid" id="pastEvents">
                            <!-- Event akan di-load via AJAX -->
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
                <!-- Event akan di-render di sini via JS -->
            </div>
        </div>
    </div>
    <!-- Event UpComing End -->

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

    <!-- JavaScript Libraries -->
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/event/index',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {

                        // ==== Fungsi untuk buat slug ====
                        function slugify(text) {
                            return text
                                .toString()
                                .toLowerCase()
                                .normalize('NFD')
                                .replace(/[\u0300-\u036f]/g, '')
                                .replace(/[^a-z0-9]+/g, '-')
                                .replace(/^-+|-+$/g, '');
                        }

                        // ==== Event Yang Akan Datang ====
                        const upcomingEvents = res.upcoming || [];
                        let upcomingHTML = '';

                        upcomingEvents.forEach(ev => {
                            const tanggal = new Date(ev.tanggal).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });

                            const slug = slugify(ev.nama_event);

                            upcomingHTML += `
                            <div class="item">
                                <a href="/event/detail/${slug}?lang=<?= $currentLang ?>" class="text-decoration-none text-dark">
                                    <div class="card product-card cursor-pointer shadow border-0 h-100 mb-4">
                                        <div class="position-relative">
                                            <img class="card-img-top rounded" src="/uploads/event/${encodeURIComponent(ev.gambar_banner ?? 'no-image.png')}" alt="${ev.nama_event}">
                                            <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2">Segera Hadir</span>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">${ev.nama_event}</h5>
                                            <p class="card-text">${ev.deskripsi}</p>
                                            <ul class="list-unstyled small mb-0 mt-auto">
                                                <li><i class="fa fa-calendar text-primary me-2"></i> ${tanggal}</li>
                                                <li><i class="fa fa-map-marker-alt text-primary me-2"></i> ${ev.tempat}</li>
                                                <li><i class="fa fa-clock text-primary me-2"></i> ${ev.waktu}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>`;
                        });

                        $('#upcomingEvents').html(upcomingHTML);

                        // ==== Inisialisasi Owl Carousel ====
                        var $carousel = $('#upcomingEvents');
                        var itemCount = $carousel.find('.item').length;

                        if (itemCount > 0) {
                            $carousel.owlCarousel({
                                items: 3,
                                margin: 20,
                                autoplay: false,
                                smartSpeed: 1000,
                                dots: true,
                                loop: itemCount > 3,
                                nav: false,
                                responsive: {
                                    0: {
                                        items: 1
                                    },
                                    768: {
                                        items: 2
                                    },
                                    992: {
                                        items: 3
                                    },
                                },
                            });
                        }

                        // ==== Event Yang Telah Berlangsung ====
                        const pastEvents = res.past || [];
                        let pastHTML = '';

                        pastEvents.forEach(ev => {
                            let docImg = ev.gambar_banner || 'no-image.png';
                            let slug = slugify(ev.nama_event);

                            pastHTML += `
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="/uploads/event/${encodeURIComponent(docImg)}" alt="${ev.nama_event}">
                                <a class="project-overlay justify-content-between text-decoration-none" href="/event/detail/${slug}?lang=<?= $currentLang ?>">
                                    <h4 class="text-white description-text fs-5">${ev.nama_event}</h4>
                                    <small class="text-white description-text">${ev.deskripsi}</small>
                                </a>
                            </div>`;
                        });

                        $('#pastEvents').html(pastHTML);

                    } else {
                        Swal.fire('Oops...', res.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Oops...', 'Terjadi kesalahan saat mengambil data event', 'error');
                }
            });
        });
    </script>

</body>

</html>