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
        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            font-size: 14px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
        }

        .text-warning.small {
            font-size: 12px;
        }

        .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Samakan tinggi judul */
        .product-card .card-title {
            min-height: 45px;
            /* atur sesuai kebutuhan */
            font-size: 16px;
            font-weight: 600;
        }

        /* Samakan tinggi deskripsi */
        .product-card .text-muted.mb-1 {
            min-height: 25px;
            /* biar rata */
            font-size: 14px;
        }

        /* Harga tetap menempel di bawah deskripsi */
        .product-card h6 {
            margin: 5px 0;
            font-weight: bold;
        }

        /* Rating tetap rata di bawah */
        .product-card .d-flex {
            margin-top: auto;
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
                    <h1 class="display-1 mb-0 animated slideInLeft">Toko</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Toko</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Product List Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-5 text-center">Produk Tenun Ikat <span class="text-uppercase text-primary">Ina Ndao</span></h1>
            <div class="row g-3">
                <!-- Produk 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Alor</h5>
                            <p class="text-muted mb-1">Motif Ikan</p>
                            <h6 class="text-primary">Rp 650.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(12)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-maumere.png" class="card-img-top product-img" alt="Selendang Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Sumba</h5>
                            <p class="text-muted mb-1">Motif Kuda</p>
                            <h6 class="text-primary">Rp 450.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(8)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-ende.png" class="card-img-top product-img" alt="Sarung Flores">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Flores</h5>
                            <p class="text-muted mb-1">Motif Geometris</p>
                            <h6 class="text-primary">Rp 500.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(20)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/buna-nunkolo.png" class="card-img-top product-img" alt="Selendang Putih Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Putih</h5>
                            <p class="text-muted mb-1">Sumba</p>
                            <h6 class="text-primary">Rp 400.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(5)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-sumba.png" class="card-img-top product-img" alt="Sarung Timor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Timor</h5>
                            <p class="text-muted mb-1">Motif Belis</p>
                            <h6 class="text-primary">Rp 700.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(10)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-amarasi.png" class="card-img-top product-img" alt="Selendang Ina Ndao">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Ina Ndao</h5>
                            <p class="text-muted mb-1">Motif Flora</p>
                            <h6 class="text-primary">Rp 550.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(7)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Alor</h5>
                            <p class="text-muted mb-1">Motif Ikan</p>
                            <h6 class="text-primary">Rp 650.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(12)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-maumere.png" class="card-img-top product-img" alt="Selendang Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Sumba</h5>
                            <p class="text-muted mb-1">Motif Kuda</p>
                            <h6 class="text-primary">Rp 450.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(8)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-ende.png" class="card-img-top product-img" alt="Sarung Flores">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Flores</h5>
                            <p class="text-muted mb-1">Motif Geometris</p>
                            <h6 class="text-primary">Rp 500.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(20)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/buna-nunkolo.png" class="card-img-top product-img" alt="Selendang Putih Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Putih</h5>
                            <p class="text-muted mb-1">Sumba</p>
                            <h6 class="text-primary">Rp 400.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(5)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-sumba.png" class="card-img-top product-img" alt="Sarung Timor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Timor</h5>
                            <p class="text-muted mb-1">Motif Belis</p>
                            <h6 class="text-primary">Rp 700.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(10)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-amarasi.png" class="card-img-top product-img" alt="Selendang Ina Ndao">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Ina Ndao</h5>
                            <p class="text-muted mb-1">Motif Flora</p>
                            <h6 class="text-primary">Rp 550.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(7)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Alor</h5>
                            <p class="text-muted mb-1">Motif Ikan</p>
                            <h6 class="text-primary">Rp 650.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(12)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-maumere.png" class="card-img-top product-img" alt="Selendang Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Sumba</h5>
                            <p class="text-muted mb-1">Motif Kuda</p>
                            <h6 class="text-primary">Rp 450.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(8)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-ende.png" class="card-img-top product-img" alt="Sarung Flores">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Flores</h5>
                            <p class="text-muted mb-1">Motif Geometris</p>
                            <h6 class="text-primary">Rp 500.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(20)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/buna-nunkolo.png" class="card-img-top product-img" alt="Selendang Putih Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Putih</h5>
                            <p class="text-muted mb-1">Sumba</p>
                            <h6 class="text-primary">Rp 400.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(5)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-sumba.png" class="card-img-top product-img" alt="Sarung Timor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Timor</h5>
                            <p class="text-muted mb-1">Motif Belis</p>
                            <h6 class="text-primary">Rp 700.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(10)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-amarasi.png" class="card-img-top product-img" alt="Selendang Ina Ndao">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Ina Ndao</h5>
                            <p class="text-muted mb-1">Motif Flora</p>
                            <h6 class="text-primary">Rp 550.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(7)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Alor</h5>
                            <p class="text-muted mb-1">Motif Ikan</p>
                            <h6 class="text-primary">Rp 650.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(12)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-maumere.png" class="card-img-top product-img" alt="Selendang Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Sumba</h5>
                            <p class="text-muted mb-1">Motif Kuda</p>
                            <h6 class="text-primary">Rp 450.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(8)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-ende.png" class="card-img-top product-img" alt="Sarung Flores">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Flores</h5>
                            <p class="text-muted mb-1">Motif Geometris</p>
                            <h6 class="text-primary">Rp 500.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(20)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/buna-nunkolo.png" class="card-img-top product-img" alt="Selendang Putih Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Putih</h5>
                            <p class="text-muted mb-1">Sumba</p>
                            <h6 class="text-primary">Rp 400.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(5)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-sumba.png" class="card-img-top product-img" alt="Sarung Timor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Timor</h5>
                            <p class="text-muted mb-1">Motif Belis</p>
                            <h6 class="text-primary">Rp 700.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(10)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-amarasi.png" class="card-img-top product-img" alt="Selendang Ina Ndao">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Ina Ndao</h5>
                            <p class="text-muted mb-1">Motif Flora</p>
                            <h6 class="text-primary">Rp 550.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(7)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 1 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Alor</h5>
                            <p class="text-muted mb-1">Motif Ikan</p>
                            <h6 class="text-primary">Rp 650.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(12)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-maumere.png" class="card-img-top product-img" alt="Selendang Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Sumba</h5>
                            <p class="text-muted mb-1">Motif Kuda</p>
                            <h6 class="text-primary">Rp 450.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(8)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-ende.png" class="card-img-top product-img" alt="Sarung Flores">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Flores</h5>
                            <p class="text-muted mb-1">Motif Geometris</p>
                            <h6 class="text-primary">Rp 500.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(20)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/buna-nunkolo.png" class="card-img-top product-img" alt="Selendang Putih Sumba">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Putih</h5>
                            <p class="text-muted mb-1">Sumba</p>
                            <h6 class="text-primary">Rp 400.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(5)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/sarung-sumba.png" class="card-img-top product-img" alt="Sarung Timor">
                        <div class="card-body">
                            <h5 class="card-title">Sarung Timor</h5>
                            <p class="text-muted mb-1">Motif Belis</p>
                            <h6 class="text-primary">Rp 700.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(10)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card product-card h-100 border-0 shadow-sm text-center">
                        <img src="img/produk/kain-amarasi.png" class="card-img-top product-img" alt="Selendang Ina Ndao">
                        <div class="card-body">
                            <h5 class="card-title">Selendang Ina Ndao</h5>
                            <p class="text-muted mb-1">Motif Flora</p>
                            <h6 class="text-primary">Rp 550.000</h6>
                            <div class="d-flex align-items-center mt-2">
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-warning"><i class="fas fa-star"></i></span>
                                <span class="text-secondary"><i class="fas fa-star"></i></span>
                                <small class="ms-2 text-muted">(7)</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- end row -->
        </div>
    </div>
    <!-- Product List End -->

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