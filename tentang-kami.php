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
                    <h1 class="display-1 mb-0 animated slideInLeft">Tentang Kami</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Tentang Kami</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Tentang Ina Ndao Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <!-- Row 1 -->
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <img src="img/ina-ndao.jpg" alt="Ina Ndao" class="img-fluid w-50 rounded shadow mx-auto d-block">
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <h2 class="mb-4">Peran <span class="text-primary bg-light px-2"> INA NDAO</span></h2>
                    <p class="fs-6">
                        Ina Ndao hadir sebagai pelestari dan penggerak budaya tenun ikat khas Nusa Tenggara Timur.
                        Kami tidak hanya menjaga warisan leluhur melalui tenunan, tetapi juga memberikan nilai tambah
                        dengan desain modern yang tetap mengakar pada tradisi.
                    </p>
                    <p class="fs-6">
                        Melalui setiap helai benang, Ina Ndao membawa cerita, identitas, dan jati diri masyarakat NTT
                        agar terus hidup dan dikenal luas oleh dunia.
                    </p>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row align-items-center g-5 flex-lg-row-reverse mb-5">
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <img src="img/ina-ndao2.jpg" alt="Kolaborasi Ina Ndao" class="img-fluid w-50 rounded shadow mx-auto d-block">
                </div>
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.4s">
                    <h2 class="mb-4 text-primary">Kolaborasi & Kerja Sama</h2>
                    <p class="fs-6">
                        Ina Ndao telah menjalin kerja sama dengan berbagai komunitas, perajin lokal, desainer,
                        hingga mitra usaha di tingkat nasional dan internasional.
                        Tujuannya adalah memperluas jangkauan pemasaran sekaligus meningkatkan kesejahteraan para penenun.
                    </p>
                    <p class="fs-6">
                        Kami percaya bahwa kolaborasi adalah kunci untuk menjaga keberlanjutan budaya dan memperkuat
                        ekonomi kreatif di daerah.
                    </p>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <img src="img/ina-ndao3.jpg" alt="Visi Masa Depan Ina Ndao" class="img-fluid w-50 rounded shadow mx-auto d-block">
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                    <h2 class="mb-4 text-primary">Visi ke Depan</h2>
                    <p class="fs-6">
                        Dengan semangat inovasi, Ina Ndao berkomitmen untuk terus mengembangkan produk-produk
                        berbasis tenun ikat yang relevan dengan gaya hidup modern tanpa meninggalkan akar tradisi.
                    </p>
                    <p class="fs-6">
                        Kami ingin menjadikan tenun ikat sebagai simbol kebanggaan dan identitas, tidak hanya di NTT,
                        tetapi juga di kancah internasional.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Tentang Ina Ndao End -->

    <style>
        .project-wrapper {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            padding-bottom: 10px;
        }

        .project-grid {
            display: grid;
            grid-template-rows: repeat(2, 1fr);
            grid-auto-flow: column;
        }

        .project-item {
            width: 216px;
            height: 216px;
        }

        .project-overlay h4,
        .project-overlay small {
            white-space: normal;
            word-wrap: break-word;
            margin: 0;
            line-height: 1.2em;
            text-shadow: 1px 1px 3px black;
        }
    </style>

    <!-- Event Ina Ndao Start -->
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
                <div class="col-lg-7">
                    <div class="project-wrapper overflow-auto">
                        <div class="project-grid">
                            <!-- Event 1 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-1.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Workshop Tenun</h4>
                                    <small class="text-white">Pelatihan untuk generasi muda</small>
                                </a>
                            </div>
                            <!-- Event 2 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-2.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Pameran Budaya</h4>
                                    <small class="text-white">Kolaborasi seni & tenun</small>
                                </a>
                            </div>
                            <!-- Event 3 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-3.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Festival NTT</h4>
                                    <small class="text-white">Partisipasi dalam festival daerah</small>
                                </a>
                            </div>
                            <!-- Event 4 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-4.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Kolaborasi Desainer</h4>
                                    <small class="text-white">Karya bersama fashion designer</small>
                                </a>
                            </div>
                            <!-- Event 5 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-5.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Pentas Seni</h4>
                                    <small class="text-white">Pagelaran musik & tarian</small>
                                </a>
                            </div>
                            <!-- Event 6 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-6.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Launching Produk</h4>
                                    <small class="text-white">Koleksi terbaru Ina Ndao</small>
                                </a>
                            </div>
                            <!-- Event 7 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-1.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Pameran Nasional</h4>
                                    <small class="text-white">Partisipasi di Jakarta</small>
                                </a>
                            </div>
                            <!-- Event 8 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-2.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Pelatihan Penenun</h4>
                                    <small class="text-white">Pemberdayaan komunitas lokal</small>
                                </a>
                            </div>
                            <!-- Event 9 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-3.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Fashion Show</h4>
                                    <small class="text-white">Tenun di panggung internasional</small>
                                </a>
                            </div>
                            <!-- Event 10 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-4.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Pameran UMKM</h4>
                                    <small class="text-white">Dukungan ekonomi kreatif</small>
                                </a>
                            </div>
                            <!-- Event 11 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-5.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Bazar Tenun</h4>
                                    <small class="text-white">Promosi produk lokal</small>
                                </a>
                            </div>
                            <!-- Event 12 -->
                            <div class="project-item position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/project-6.jpg" alt="">
                                <a class="project-overlay text-decoration-none" href="#!">
                                    <h4 class="text-white">Community Gathering</h4>
                                    <small class="text-white">Silaturahmi & diskusi budaya</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Ina Ndao End -->

    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="mb-5">
                        Our Creative
                        <span class="text-uppercase text-primary bg-light px-2">Services</span>
                    </h1>
                    <p>
                        Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et
                        sit, sed stet no labore lorem sit. Sanctus clita duo justo et
                        tempor eirmod magna dolore erat amet
                    </p>
                    <p class="mb-5">
                        Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor
                        sit. Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem
                        et sit, sed stet no labore lorem sit. Sanctus clita duo justo et
                        tempor eirmod magna dolore erat amet
                    </p>
                    <div class="d-flex align-items-center bg-light">
                        <div class="btn-square flex-shrink-0 bg-primary" style="width: 100px; height: 100px">
                            <i class="fa fa-phone fa-2x text-white"></i>
                        </div>
                        <div class="px-3">
                            <h3>+0123456789</h3>
                            <span>Call us direct 24/7 for get a free consultation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-0">
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.2s">
                            <div class="service-item h-100 d-flex flex-column justify-content-center bg-primary">
                                <a href="#!" class="service-img position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/service-1.jpg" alt="" />
                                    <h3>Interior Design</h3>
                                </a>
                                <p class="mb-0">
                                    Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet lorem.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.4s">
                            <div class="service-item h-100 d-flex flex-column justify-content-center bg-light">
                                <a href="#!" class="service-img position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/service-2.jpg" alt="" />
                                    <h3>Implement</h3>
                                </a>
                                <p class="mb-0">
                                    Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet lorem.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.6s">
                            <div class="service-item h-100 d-flex flex-column justify-content-center bg-light">
                                <a href="#!" class="service-img position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/service-3.jpg" alt="" />
                                    <h3>Renovation</h3>
                                </a>
                                <p class="mb-0">
                                    Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet lorem.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 wow fadeIn" data-wow-delay="0.8s">
                            <div class="service-item h-100 d-flex flex-column justify-content-center bg-primary">
                                <a href="#!" class="service-img position-relative mb-4">
                                    <img class="img-fluid w-100" src="img/service-4.jpg" alt="" />
                                    <h3>Commercial</h3>
                                </a>
                                <p class="mb-0">
                                    Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet lorem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Footer Start -->
    <?php include "footer.html" ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>