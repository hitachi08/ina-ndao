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
                    <h1 class="display-1 mb-0 animated slideInLeft">Galeri</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-lg-end justify-content-center gap-2">

                <!-- Dropdown Jenis Kain -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterJenis"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Jenis Kain
                    </button>
                    <ul class="dropdown-menu p-2" aria-labelledby="filterJenis">
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="selimut"><label
                                    class="form-check-label" for="selimut">Selimut</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                    id="selempang"><label class="form-check-label" for="selempang">Selempang</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="sarung"><label
                                    class="form-check-label" for="sarung">Sarung</label></div>
                        </li>
                    </ul>
                </div>

                <!-- Dropdown Asal Daerah -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDaerah"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Asal Daerah
                    </button>
                    <ul class="dropdown-menu p-2" aria-labelledby="filterDaerah">
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="rote"><label
                                    class="form-check-label" for="rote">Rote</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="sabu"><label
                                    class="form-check-label" for="sabu">Sabu</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="sumba"><label
                                    class="form-check-label" for="sumba">Sumba</label></div>
                        </li>
                    </ul>
                </div>

                <!-- Dropdown Ukuran -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterUkuran"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Ukuran
                    </button>
                    <ul class="dropdown-menu p-2" aria-labelledby="filterUkuran">
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="xs"><label
                                    class="form-check-label" for="xs">XS</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="s"><label
                                    class="form-check-label" for="s">S</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="m"><label
                                    class="form-check-label" for="m">M</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="l"><label
                                    class="form-check-label" for="l">L</label></div>
                        </li>
                        <li>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="xl"><label
                                    class="form-check-label" for="xl">XL</label></div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container-xxl pb-5">
            <h1 class="mb-5 text-center">Galeri Produk <span class="text-uppercase text-primary">Ina Ndao</span>
            </h1>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9">
                    <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.2s">
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img\produk\sarung-alor.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <h3>Kain Tenun Alor</h3>
                                        <p>Motif ikan melambangkan sumber penghidupan utama bagi masyarakat Alor
                                            yang sebagian besar bergantung pada hasil laut.</p>
                                        <h5 class="mb-0">Motif Ikan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img/testimonial-2.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <h3>Customer Satisfaction</h3>
                                        <p>Clita erat ipsum et lorem et sit, sed
                                            stet no labore lorem sit. Sanctus clita duo justo et tempor eirmod magna
                                            dolore erat
                                            amet</p>
                                        <h5 class="mb-0">Alexander Bell</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item">
                            <div class="row g-5 align-items-center">
                                <div class="col-md-6">
                                    <div class="testimonial-img">
                                        <img class="img-fluid" src="img/testimonial-3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="testimonial-text pb-5 pb-md-0">
                                        <h3>Budget Friendly</h3>
                                        <p>Diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed
                                            stet no labore lorem sit. Sanctus clita duo justo et tempor eirmod magna
                                            dolore erat
                                            amet</p>
                                        <h5 class="mb-0">Bradley Gordon</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Item 1 -->
            <div class="col-lg-6 col-md-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="card shadow h-100 border-0 rounded-3 overflow-hidden">
                    <div class="row g-0 align-items-center">
                        <!-- Gambar -->
                        <div class="col-5">
                            <div class="team-item position-relative overflow-hidden shadow"> <img
                                    class="img-fluid w-100" src="img/produk/sarung-sumba.png" alt="Kain Tenun Ina Ndao">
                                <div class="team-overlay"> <small
                                        class="position-absolute top-0 start-0 m-2">Sarung</small> </div>
                            </div>
                        </div>
                        <!-- Narasi -->
                        <div class="col-7 p-3">
                            <h5 class="mb-2">Motif Kakakwila</h5>
                            <p class="small mb-3" style="text-align:justify;">
                                Motif ini melambangkan persatuan dan kesatuan masyarakat Sumba,
                                menggambarkan pentingnya hidup harmoni. Motif burung (biasanya kakatua)
                                juga melambangkan persatuan dalam tenun Sumba secara umum.
                            </p>
                            <a href="#!" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalSumba">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-lg-6 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                <div class="card shadow h-100 border-0 rounded-3 overflow-hidden">
                    <div class="row g-0 align-items-center">
                        <div class="col-5">
                            <div class="team-item position-relative overflow-hidden shadow"> <img
                                    class="img-fluid w-100" src="img/produk/sarung-ende.png" alt="Kain Tenun Ina Ndao">
                                <div class="team-overlay"> <small
                                        class="position-absolute top-0 start-0 m-2">Sarung</small> </div>
                            </div>
                        </div>
                        <div class="col-7 p-3">
                            <h5 class="mb-2">Motif Ende</h5>
                            <p class="small mb-3" style="text-align:justify;">
                                Proses pewarnaan kain menggunakan bahan alami, ramah lingkungan,
                                dan menjaga keaslian tradisi tenun ikat.
                            </p>
                            <a href="#!" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalEnde">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Modal untuk Motif Sumba -->
    <div class="modal fade" id="modalSumba" tabindex="-1" aria-labelledby="modalSumbaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <!-- Header -->
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold w-100 text-center" id="modalSumbaLabel">
                        Cerita Lengkap Motif Sumba
                    </h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <!-- Body -->
                <div class="modal-body px-4 py-4">
                    <!-- Gambar -->
                    <div class="text-center mb-4">
                        <img src="img/produk/sarung-sumba.png" class="img-fluid mx-auto d-block rounded shadow-sm"
                            alt="Motif Sumba" style="max-height:350px; object-fit:contain;">
                    </div>

                    <!-- Narasi -->
                    <div class="px-2">
                        <p style="text-align:justify; margin-bottom:15px;">
                            Motif <b>Kakakwila</b> berasal dari Sumba, Nusa Tenggara Timur. Nama ini diambil dari burung
                            kakaktua yang menjadi simbol persatuan, kebersamaan, serta keharmonisan hidup masyarakat
                            Sumba.
                            Suara khas burung ini dianggap sebagai panggilan untuk berkumpul, mengingatkan pentingnya
                            menjaga hubungan harmonis antar sesama dan dengan alam.
                        </p>

                        <p style="text-align:justify; margin-bottom:15px;">
                            Proses pembuatan kain dilakukan dengan ketelitian tinggi. Dimulai dari pemintalan benang
                            katun,
                            kemudian melalui tahapan pewarnaan alami menggunakan akar, daun, kulit kayu, dan lumpur.
                            Teknik ikat khas Sumba diterapkan untuk menciptakan pola Kakakwila yang indah, menggambarkan
                            makna filosofis tentang persatuan, ketekunan, dan penghormatan terhadap leluhur.
                        </p>

                        <p style="text-align:justify; margin-bottom:15px;">
                            Kain ini tidak hanya berfungsi sebagai busana, tetapi juga sebagai simbol budaya dan
                            pewarisan nilai-nilai luhur. Setiap helai benangnya menyimpan cerita tentang kehidupan
                            dan kebersamaan masyarakat Sumba.
                        </p>
                    </div>

                    <hr class="my-4">

                    <!-- Detail Teknis -->
                    <div class="d-flex justify-content-center">
                        <div class="text-start" style="min-width:320px;">
                            <div class="d-flex mb-2">
                                <div class="fw-bold" style="width:120px;">Asal Daerah</div>
                                <div class="flex-grow-1">: Sumba, Nusa Tenggara Timur</div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="fw-bold" style="width:120px;">Ukuran</div>
                                <div class="flex-grow-1">: Panjang 152 cm x Lebar 125 cm</div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="fw-bold" style="width:120px;">Bahan</div>
                                <div class="flex-grow-1">: Benang Katun</div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="fw-bold" style="width:120px;">Pewarnaan</div>
                                <div class="flex-grow-1">: Alami</div>
                            </div>
                            <div class="d-flex">
                                <div class="fw-bold" style="width:120px;">Kategori</div>
                                <div class="flex-grow-1">: Sarung</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Motif Ende -->
    <div class="modal fade" id="modalEnde" tabindex="-1" aria-labelledby="modalEndeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEndeLabel">Cerita Lengkap Motif Ende</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- Gambar di tengah -->
                    <img src="img/produk/sarung-ende.png" class="img-fluid mx-auto d-block mb-3" alt="Motif Ende"
                        style="max-height:350px; object-fit:contain;">

                    <p style="text-align:justify;">
                        Motif Ende dikenal dengan warnanya yang khas dan proses pewarnaan alami dari bahan-bahan
                        tumbuhan sekitar. Warna-warna ini melambangkan keselarasan hidup, harapan, dan semangat
                        masyarakat Ende dalam menjaga tradisi. Teknik ikatnya yang rumit membuat setiap kain
                        menjadi unik dan bernilai tinggi.
                    </p>
                </div>
            </div>
        </div>
    </div>

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