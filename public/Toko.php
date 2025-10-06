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
                    <h1 class="display-1 mb-0 animated slideInLeft">Toko</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Toko</li>
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
                <img src="img/download.jpg" alt="Banner Produk Tenun Ikat Ina Ndao"
                    class="img-fluid w-100 rounded shadow-sm banner-img">
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Cari produk...">
            </div>

            <nav>
                <ul class="pagination justify-content-end" id="pagination"></ul>
            </nav>

            <!-- Row Start -->
            <div class="row g-4">
                <!-- Sidebar Filter Start -->
                <div class="col-12 col-lg-3 d-none d-lg-block">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="fas fa-filter me-2"></i> FILTER
                            </h5>

                            <h6 class="fw-bold">Jenis Kain</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="jenisSarung">
                                <label class="form-check-label" for="jenisSarung">Sarung</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="jenisSelendang">
                                <label class="form-check-label" for="jenisSelendang">Selendang</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="jenisKain">
                                <label class="form-check-label" for="jenisKain">Kain Tenun</label>
                            </div>

                            <hr>

                            <h6 class="fw-bold">Kategori Kain</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kategoriMotifIkan">
                                <label class="form-check-label" for="kategoriMotifIkan">Motif Ikan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kategoriMotifKuda">
                                <label class="form-check-label" for="kategoriMotifKuda">Motif Kuda</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kategoriMotifGeometris">
                                <label class="form-check-label" for="kategoriMotifGeometris">Motif Geometris</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kategoriMotifFlora">
                                <label class="form-check-label" for="kategoriMotifFlora">Motif Flora</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="kategoriMotifBelis">
                                <label class="form-check-label" for="kategoriMotifBelis">Motif Belis</label>
                            </div>

                            <hr>

                            <h6 class="fw-bold">Daerah (NTT)</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="daerahFlores">
                                <label class="form-check-label" for="daerahFlores">Flores</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="daerahAlor">
                                <label class="form-check-label" for="daerahAlor">Alor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="daerahSumba">
                                <label class="form-check-label" for="daerahSumba">Sumba</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="daerahMaumere">
                                <label class="form-check-label" for="daerahMaumere">Maumere</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="daerahTimor">
                                <label class="form-check-label" for="daerahTimor">Timor</label>
                            </div>

                            <hr>

                            <h6 class="fw-bold">Aksesoris</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aksesorisTas">
                                <label class="form-check-label" for="aksesorisTas">Tas Tenun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aksesorisKalung">
                                <label class="form-check-label" for="aksesorisKalung">Kalung Tenun</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="aksesorisIkatKepala">
                                <label class="form-check-label" for="aksesorisIkatKepala">Ikat Kepala</label>
                            </div>

                            <hr>

                            <h6 class="fw-bold">Atasan</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="atasanBaju">
                                <label class="form-check-label" for="atasanBaju">Baju Tenun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="atasanKemeja">
                                <label class="form-check-label" for="atasanKemeja">Kemeja Tenun</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="atasanBlus">
                                <label class="form-check-label" for="atasanBlus">Blus Tenun</label>
                            </div>

                            <hr>

                            <h6 class="fw-bold">Bawahan</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bawahanRok">
                                <label class="form-check-label" for="bawahanRok">Rok Tenun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bawahanCelana">
                                <label class="form-check-label" for="bawahanCelana">Celana Tenun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bawahanSarung">
                                <label class="form-check-label" for="bawahanSarung">Sarung</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Filter End -->

                <!-- List Produk Start -->
                <div class="col-12 col-lg-9">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="product-list">
                        <!-- Produk 1 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
                                <img src="img/produk/sarung-alor.png" class="card-img-top product-img" alt="Sarung Alor">
                                <div class="card-body">
                                    <h6 class="card-title">Sarung Alor</h6>
                                    <p class="text-muted mb-1">Motif Ikan</p>
                                    <h6 class="text-primary">Rp 650.000</h6>
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
                        <!-- Produk 2 -->
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card product-card2 h-100 border-0 shadow-sm text-center cursor-pointer">
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
                    </div>
                </div>
                <!-- List Produk End -->

            </div>
            <!-- End row -->
        </div>
    </div>
    <!-- Product End -->

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