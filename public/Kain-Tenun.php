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
                    <h1 class="display-1 mb-0 animated slideInLeft">Kain Tenun</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Kain Tenun</li>
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
                <img src="img/banner.jpg" alt="Banner Produk Tenun Ikat Ina Ndao"
                    class="img-fluid w-100 rounded shadow-sm banner-img">
            </div>
            <div class="input-group mb-4">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="searchKain" class="form-control border-start-0" placeholder="Cari kain, motif, atau daerah...">
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

                            <!-- Filter Harga -->
                            <h6 class="fw-bold">Rentang Harga</h6>
                            <div class="d-flex align-items-center">
                                <input type="number" class="form-control form-control-sm me-2" id="hargaMin"
                                    placeholder="Min">
                                <span class="mx-1">-</span>
                                <input type="number" class="form-control form-control-sm ms-2" id="hargaMax"
                                    placeholder="Max">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Filter End -->

                <!-- List Produk Start -->
                <div class="col-12 col-lg-9">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="product-list"></div>
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

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/pagination.js"></script>

    <script>
        $(document).ready(function() {
            let allData = []; // semua data kain
            let filteredData = []; // hasil filter aktif
            let currentPage = 1;
            const itemsPerPage = 12;

            loadKain();
            loadFilters();

            // ==================== LOAD FILTER OPTIONS ====================
            function loadFilters() {
                $.ajax({
                    url: '/galeri/get_options_kain',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const daerahContainer = $("#filterDaerahContainer");
                            const jenisContainer = $("#filterJenisKainContainer");

                            daerahContainer.empty();
                            response.daerah.forEach(item => {
                                daerahContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input filter-daerah" type="checkbox" value="${item.id_daerah}" id="daerah${item.id_daerah}">
                                <label class="form-check-label" for="daerah${item.id_daerah}">${item.nama_daerah}</label>
                            </div>
                        `);
                            });

                            jenisContainer.empty();
                            response.jenis.forEach(item => {
                                jenisContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input filter-jenis" type="checkbox" value="${item.id_jenis_kain}" id="jenis${item.id_jenis_kain}">
                                <label class="form-check-label" for="jenis${item.id_jenis_kain}">${item.nama_jenis}</label>
                            </div>
                        `);
                            });
                        }
                    }
                });
            }

            // ==================== EVENT FILTER ====================
            $(document).on('change', '.filter-daerah, .filter-jenis', function() {
                applyFilter();
            });
            $('#hargaMin, #hargaMax').on('input', function() {
                applyFilter();
            });

            // ==================== APPLY FILTER ====================
            function applyFilter() {
                const daerah = $('.filter-daerah:checked').map(function() {
                    return $(this).val();
                }).get();
                const jenis_kain = $('.filter-jenis:checked').map(function() {
                    return $(this).val();
                }).get();
                const harga_min = $('#hargaMin').val();
                const harga_max = $('#hargaMax').val();

                const container = $('#product-list');
                container.css('position', 'relative');

                // tampilkan spinner tengah
                container.html(`
                    <div class="loading-overlay d-flex flex-column align-items-center justify-content-center w-100" style="min-height:300px;">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                        <p class="mt-3 text-muted">Menyaring data...</p>
                    </div>
                `);

                $.ajax({
                    url: '/galeri/filter',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        daerah,
                        jenis_kain,
                        harga_min,
                        harga_max
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            filteredData = response.data;
                            currentPage = 1;
                            renderProdukWithPagination(filteredData);
                        } else {
                            container.html(`<div class="col-12 text-center py-4 w-100"><p class="text-muted">Tidak ditemukan hasil sesuai filter.</p></div>`);
                            $('#pagination').empty();
                        }
                    },
                    error: function() {
                        container.html(`<div class="col-12 text-center py-4 w-100"><p class="text-danger">Terjadi kesalahan saat memuat data filter.</p></div>`);
                        $('#pagination').empty();
                    }
                });
            }

            // ==================== EVENT SEARCH ====================
            $("#searchKain").on("input", function() {
                const keyword = $(this).val().trim();
                if (keyword === "") {
                    // Jika kosong, tampilkan semua data lagi
                    filteredData = allData;
                    currentPage = 1;
                    renderProdukWithPagination(filteredData);
                } else {
                    applySearch(keyword);
                }
            });

            // ==================== FUNGSI SEARCH AJAX ====================
            function applySearch(keyword) {
                const container = $('#product-list');
                container.html(`
                    <div class="loading-overlay d-flex flex-column align-items-center justify-content-center w-100" style="min-height:300px;">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                        <p class="mt-3 text-muted">Mencari kain "${keyword}"...</p>
                    </div>
                `);

                $.ajax({
                    url: '/galeri/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: keyword
                    },
                    success: function(response) {
                        if (response.status === 'success' && response.data.length > 0) {
                            filteredData = response.data;
                            currentPage = 1;
                            renderProdukWithPagination(filteredData);
                        } else {
                            container.html(`
                    <div class="col-12 text-center py-5 w-100">
                        <p class="text-muted">Tidak ditemukan kain yang cocok dengan "<strong>${keyword}</strong>".</p>
                    </div>
                `);
                            $('#pagination').empty();
                        }
                    },
                    error: function() {
                        container.html(`
                <div class="col-12 text-center py-5 w-100">
                    <p class="text-danger">Terjadi kesalahan saat mencari kain.</p>
                </div>
            `);
                    }
                });
            }

            // ==================== LOAD SEMUA DATA ====================
            function loadKain() {
                $.ajax({
                    url: '/galeri/fetch_all',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.data.length > 0) {
                            allData = response.data;
                            filteredData = allData;
                            renderProdukWithPagination(allData);
                        } else {
                            $('#product-list').html(`<div class="col-12 text-center py-4 w-100"><p class="text-muted">Belum ada data kain yang tersedia.</p></div>`);
                        }
                    },
                    error: function() {
                        $('#product-list').html(`<div class="col-12 text-center py-4 w-100"><p class="text-danger">Terjadi kesalahan saat memuat data galeri.</p></div>`);
                    }
                });
            }

            // ==================== RENDER DENGAN PAGINATION ====================
            function renderProdukWithPagination(data) {
                const totalPages = Math.ceil(data.length / itemsPerPage);
                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const pageData = data.slice(start, end);

                renderProduk(pageData);
                renderPagination(totalPages);
            }

            // ==================== RENDER PRODUK ====================
            function renderProduk(data) {
                const container = $('#product-list');
                container.empty();

                if (!data || data.length === 0) {
                    container.html(`<div class="col-12 text-center py-4 w-100"><p class="text-muted">Tidak ada data yang sesuai filter.</p></div>`);
                    return;
                }

                data.forEach(item => {
                    const imgSrc = item.motif_gambar?.length ? item.motif_gambar[0].path_gambar : '/assets/img/no-image.png';
                    const namaProduk = `${item.nama_jenis || ''} ${item.nama_daerah || ''}`.trim() || '-';
                    const motif = item.nama_motif || '-';
                    const harga = formatRupiah(item.harga);

                    const card = `
                                <div class="col-6 col-md-4 col-lg-3 mb-4">
                                    <a href="/kain/detail/${item.slug}?lang=<?= $currentLang ?>" class="text-decoration-none">
                                        <div class="box-card shadow h-100 cursor-pointer">
                                            <figure>
                                                <img src="${imgSrc}" alt="${motif}">
                                            </figure>
                                            <div class="desc-card">
                                                <h5><div class="fw-bold text-dark mb-1">${namaProduk}</div></h5>
                                                <div class="abs-btm">
                                                    <div class="text-muted small mb-2 motif">Motif ${motif}</div>
                                                    <div class="fw-bold text-primary price" style="font-size: 1rem;">${harga},-</div>
                                                    <div class="small fw-semibold text-secondary mt-2" style="letter-spacing: .5px; font-size: .8rem;">
                                                        <span class="d-inline d-md-none">Tenun NTT</span>
                                                        <span class="d-none d-md-inline">Tenun Tradisional NTT</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `;
                    container.append(card);
                });
            }

            function renderPagination(totalPages) {
                renderPaginationGlobal('#pagination', currentPage, totalPages, function(page) {
                    currentPage = page;
                    renderProdukWithPagination(filteredData);
                });
            }

            // ==================== FORMAT RUPIAH ====================
            function formatRupiah(angka) {
                if (!angka) return 'Rp 0';
                return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
            }
        });
    </script>
</body>

</html>