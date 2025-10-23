<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/KainModel.php';
require_once __DIR__ . '/../app/Controllers/KainController.php';
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

$controller = new KainController($pdo);
$slug = $_GET['slug'] ?? null;

if (!$slug) {
    echo "Slug tidak ditemukan";
    exit;
}

$result = $controller->handle('detail');
if ($result['status'] === 'success') {
    $kain = $result['data'];
} else {
    echo $result['message'];
    exit;
}

function rp($num)
{
    return 'Rp ' . number_format((float)$num, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Ina Ndao - Tenun Ikat NTT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="/img/ina_ndao_logo.jpeg" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/notyf.min.css">

    <!-- Template Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
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
                    <h1 class="display-1 mb-0 animated slideInLeft" style="font-size: 4rem;">Kain <span>Ina Ndao</span></h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="/Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="/Kain-Tenun.php">Kain Tenun</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Detail Kain</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- DETAIL CARD -->
    <section class="container product-section mb-5">
        <div class="detail-card">
            <div class="row g-4">
                <!-- LEFT: Gallery -->
                <div class="col-lg-6">
                    <div class="gallery-main owl-carousel owl-theme mb-3">
                        <?php if (!empty($kain['motif_gambar'])): ?>
                            <?php foreach ($kain['motif_gambar'] as $idx => $img): ?>
                                <div class="item text-center">
                                    <a href="<?= htmlspecialchars($img['path_gambar']) ?>"
                                        class="glightbox"
                                        data-gallery="kain-<?= htmlspecialchars($kain['slug']) ?>">
                                        <img src="<?= htmlspecialchars($img['path_gambar']) ?>"
                                            class="img-fluid img-ori rounded shadow-sm" style="height: 400px;"
                                            alt="<?= htmlspecialchars($kain['nama_motif']) ?> <?= $idx + 1 ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="item">
                                <img src="/assets/img/no-image.png" alt="no image" class="img-fluid rounded shadow-sm">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination Thumbnails -->
                    <div class="gallery-thumbs owl-carousel owl-theme mt-3">
                        <?php if (!empty($kain['motif_gambar'])): ?>
                            <?php foreach ($kain['motif_gambar'] as $idx => $img): ?>
                                <div class="item">
                                    <img src="<?= htmlspecialchars($img['path_gambar']) ?>"
                                        class="img-thumbnail img-thumb"
                                        style="height:70px; object-fit:cover; cursor:pointer;"
                                        alt="thumb <?= $idx + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="mt-2 text-muted small text-center">
                        Klik gambar untuk zoom • Geser untuk melihat lainnya
                    </div>
                </div>

                <!-- RIGHT: Info & Actions -->
                <div class="col-lg-6">
                    <!-- Nama kain -->
                    <h3 class="fw-bold mb-2">
                        <?= htmlspecialchars($kain['nama_jenis'] . ' ' . $kain['nama_daerah']) ?>
                    </h3>

                    <!-- Harga -->
                    <div class="price fs-4 mb-3">
                        <?= rp($kain['harga']) ?>,-
                    </div>

                    <!-- QR Code -->
                    <div class="mb-3 text-start">
                        <div id="qrcode-small"
                            style="display:inline-block; cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#qrModal"></div>
                        <div style="font-size:12px; color:var(--muted); margin-top:6px; cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#qrModal">
                            Perbesar QR Halaman
                        </div>
                    </div>

                    <!-- Modal QR Code -->
                    <div class="modal modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 10px;">
                                <div class="modal-body d-flex flex-column align-items-center py-5">
                                    <div id="qrcode-large"></div>
                                    <small class="pt-3">Scan QR Halaman Produk</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol WhatsApp -->
                    <div class="d-flex gap-2">
                        <div class="cta-wrap text-start mb-3">
                            <a class="btn btn-order btn-sm" target="_blank"
                                href="https://wa.me/6287848738402?text=Halo%20Ina%20Ndao%2C%20saya%20tertarik%20dengan%20<?= urlencode($kain['nama_jenis'] . ' ' . $kain['nama_daerah']) ?>">
                                <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                            </a>
                        </div>
                        <div class="shopeeBtn" id="shopeeBtn" title="Buka di Shopee">
                            <img src="/img/shopee.png"
                                alt="Shopee">
                        </div>
                    </div>

                    <hr>

                    <!-- Deskripsi Kain -->
                    <div class="kain-detail mb-3">
                        <div class="mb-2">
                            <strong>Makna Motif:</strong><br>
                            <p class="makna mb-0" id="maknaText">
                                <?= nl2br(htmlspecialchars($kain['makna'] ?? 'Belum ada makna yang tercatat.')) ?>
                            </p>
                            <span class="toggle-makna" id="toggleMakna">Lihat Selengkapnya</span>
                        </div>


                        <table class="table table-sm table-borderless mt-2">
                            <tr>
                                <td style="width:30%;"><strong>Jenis Motif</strong></td>
                                <td><?= htmlspecialchars($kain['nama_motif'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Bahan</strong></td>
                                <td><?= htmlspecialchars($kain['bahan'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Pewarna</strong></td>
                                <td><?= htmlspecialchars($kain['jenis_pewarna'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran</strong></td>
                                <td>
                                    <?php
                                    $panjang = isset($kain['panjang_cm']) ? rtrim(rtrim(number_format($kain['panjang_cm'], 2, '.', ''), '0'), '.') : '-';
                                    $lebar   = isset($kain['lebar_cm']) ? rtrim(rtrim(number_format($kain['lebar_cm'], 2, '.', ''), '0'), '.') : '-';
                                    ?>
                                    <?= htmlspecialchars($panjang . ' cm x ' . $lebar . ' cm') ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Stok</strong></td>
                                <td><?= htmlspecialchars($kain['stok'] ?? '0') ?></td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <!-- Bagikan -->
                    <div>
                        <small class="d-block text-muted mb-2">Bagikan / Simpan</small>
                        <div class="share-row d-flex justify-content-between text-center">
                            <div class="share-btn flex-fill py-2" id="copyBtn" title="Salin tautan">
                                <i class="bi bi-link-45deg d-block fs-5"></i>
                                <small>Salin Link</small>
                            </div>
                            <div class="share-btn flex-fill py-2" id="waShare" title="Bagikan ke WhatsApp">
                                <i class="bi bi-whatsapp d-block fs-5"></i>
                                <small>WhatsApp</small>
                            </div>
                            <div class="share-btn flex-fill py-2" id="fbShare" title="Bagikan ke Facebook">
                                <i class="bi bi-facebook d-block fs-5"></i>
                                <small>Facebook</small>
                            </div>
                            <div class="share-btn flex-fill py-2" id="twShare" title="Bagikan ke Twitter">
                                <i class="bi bi-twitter d-block fs-5"></i>
                                <small>Twitter</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end detail card -->
    </section>

    <?php include "footer.php" ?>

    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <?php
    if (isset($translator)) {
        $translator->translateOutput();
    }
    ?>
    
    <script src="/js/jquery.min.js"></script>
    <script src="/lib/wow/wow.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/waypoints/waypoints.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/js/notyf.min.js"></script>

    <!-- Template Javascript -->
    <script src="/js/main.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

    <script>
        // init lightbox
        const lightbox = GLightbox({
            selector: '.glightbox'
        });

        // init Notyf
        const notyf = new Notyf({
            duration: 2500,
            position: {
                x: 'right',
                y: 'top'
            },
            ripple: true
        });

        // Carousel utama
        const mainCarousel = $(".gallery-main").owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            dots: false,
            margin: 10,
            autoplay: false,
            smartSpeed: 500,
        });

        // Carousel thumbnail
        const thumbCarousel = $(".gallery-thumbs").owlCarousel({
            items: 4,
            margin: 10,
            dots: false,
            nav: true,
            center: false,
            loop: false,
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            responsive: {
                0: {
                    items: 3
                },
                576: {
                    items: 4
                },
                768: {
                    items: 5
                }
            }
        });

        // Setelah inisialisasi kedua carousel
        mainCarousel.on('initialized.owl.carousel', function() {
            thumbCarousel.find('.owl-item').eq(0).addClass('selected-thumb');
        }).trigger('initialized.owl.carousel');

        // Klik thumbnail → pindah ke gambar utama + update aktif
        $('.gallery-thumbs').on('click', '.owl-item', function() {
            const index = $(this).index();
            mainCarousel.trigger('to.owl.carousel', [index, 300, true]);
            thumbCarousel.find('.owl-item').removeClass('selected-thumb');
            $(this).addClass('selected-thumb');
        });

        // Sinkronisasi: saat main geser → aktifkan thumbnail terkait
        mainCarousel.on('changed.owl.carousel', function(event) {
            const index = event.item.index - event.relatedTarget._clones.length / 2;
            const currentIndex = (index + event.item.count) % event.item.count;
            thumbCarousel.find('.owl-item').removeClass('selected-thumb');
            thumbCarousel.find('.owl-item').eq(currentIndex).addClass('selected-thumb');
        });

        // QR kecil
        new QRCode(document.getElementById("qrcode-small"), {
            text: window.location.href,
            width: 96,
            height: 96,
            colorDark: "#15345B",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // QR besar
        const qrModal = document.getElementById('qrModal');
        qrModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('qrcode-large').innerHTML = '';
            new QRCode(document.getElementById("qrcode-large"), {
                text: window.location.href,
                width: 250,
                height: 250
            });
        });

        // copy link
        document.getElementById('copyBtn').addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                notyf.success('Tautan disalin ke clipboard!');
            }, function(err) {
                notyf.error('Gagal menyalin tautan: ' + err);
            });
        });

        // Share handlers
        document.getElementById('waShare').addEventListener('click', function() {
            const url = encodeURIComponent(window.location.href);
            window.open('https://wa.me/?text=' + url, '_blank');
        });

        document.getElementById('fbShare').addEventListener('click', function() {
            const url = encodeURIComponent(window.location.href);
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
        });

        document.getElementById('twShare').addEventListener('click', function() {
            const url = encodeURIComponent(window.location.href);
            window.open('https://twitter.com/intent/tweet?url=' + url, '_blank');
        });
        // Shopee link handler
        document.getElementById('shopeeBtn').addEventListener('click', function() {
            window.open('https://shopee.co.id/inandao', '_blank');
        });


        // keyboard shortcut (S)
        document.addEventListener('keydown', function(e) {
            if (e.key === 's' || e.key === 'S') {
                navigator.clipboard.writeText(window.location.href);
                notyf.success('Tautan disalin ke clipboard!');
            }
        });

        // Toggle Makna Motif
        const maknaText = document.getElementById('maknaText');
        const toggleMakna = document.getElementById('toggleMakna');

        if (maknaText && toggleMakna) {
            let expanded = false;

            toggleMakna.addEventListener('click', function() {
                expanded = !expanded;
                maknaText.classList.toggle('expanded', expanded);
                toggleMakna.textContent = expanded ? 'Lebih Pendek' : 'Lihat Selengkapnya';
            });
        }
    </script>

</body>

</html>