<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/GaleriModel.php';
require_once __DIR__ . '/../app/Controllers/GaleriController.php';

// debug friendly: (hapus/komentar saat production)
// ini membantu menampilkan error jika masih ada masalah require/include
// ini_set('display_errors',1); error_reporting(E_ALL);

$controller = new GaleriController($pdo);
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

// helper untuk format harga
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

    <!-- Template Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <style>
        :root {
            --indigo: #15345B;
            --brick: #9E2A2B;
            --gold: #D4A017;
            --terra: #D97B38;
            --cream: #FFF7EE;
            --muted: #6b6b6b;
        }

        /* Hero */
        .hero-ntt {
            background: linear-gradient(135deg, rgba(21, 52, 91, 0.95), rgba(158, 42, 43, 0.9));
            color: var(--cream);
            padding: 56px 0;
            position: relative;
            overflow: visible;
        }

        .hero-ntt .subtitle {
            color: rgba(255, 255, 255, 0.9);
            opacity: 0.95;
        }

        /* floating card */
        .detail-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(21, 52, 91, 0.12);
            padding: 28px;
            margin-top: -60px;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .gallery-grid .thumb {
            border-radius: 12px;
            overflow: hidden;
            background: #f7f5f2;
        }

        .gallery-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .35s ease, filter .35s ease;
        }

        .gallery-grid .thumb:hover img {
            transform: scale(1.06);
            filter: saturate(1.05);
        }

        /* Info */
        .kain-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--indigo);
        }

        .kain-meta {
            color: var(--muted);
            font-size: .95rem;
        }

        .makna {
            background: linear-gradient(90deg, rgba(217, 123, 56, 0.06), rgba(212, 160, 23, 0.04));
            border-left: 4px solid var(--terra);
            padding: 14px;
            border-radius: 10px;
            color: #333;
        }

        .specs td {
            padding: 6px 0;
            vertical-align: top;
        }

        .specs .label {
            color: var(--muted);
            width: 140px;
        }

        .price {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--brick);
            letter-spacing: .4px;
        }

        .cta-wrap .btn {
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
        }

        .btn-order {
            background: linear-gradient(90deg, var(--brick), var(--terra));
            color: #fff;
            border: none;
            box-shadow: 0 10px 30px rgba(158, 42, 43, 0.14);
        }

        .btn-order:hover {
            transform: translateY(-3px);
            color: #fff;
        }

        /* share area */
        .share-row {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 14px;
        }

        .share-btn {
            background: #fff;
            border: 1px solid #eee;
            padding: 8px 10px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all .18s;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(21, 52, 91, 0.06);
        }

        /* QR */
        .qr-card {
            background: var(--cream);
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }

        .gallery-thumbs .owl-item.active.center img {
            border: 2px solid #9E2A2B;
            opacity: 1;
        }

        .gallery-thumbs img {
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .gallery-thumbs img:hover {
            opacity: 1;
            transform: scale(1.05);
        }

        .gallery-thumbs .owl-nav {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .gallery-thumbs .owl-prev {
            padding: 5px 10px;
            background-color: #ffffff78;
            border: 1px solid gray;
            border-radius: 10px;
        }

        .gallery-thumbs .owl-next {
            padding: 5px 10px;
            background-color: #ffffff78;
            border: 1px solid gray;
            border-radius: 10px;
        }

        .gallery-thumbs .disabled {
            cursor: auto !important;
            opacity: 0.5;
        }

        .gallery-thumbs .owl-item.selected-thumb img {
            border: 2px solid #9E2A2B;
            opacity: 1;
        }

        /* responsive tweaks */
        @media (max-width: 991px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .detail-card {
                padding: 18px;
                margin-top: -40px;
            }
        }

        @media (max-width: 575px) {
            .kain-title {
                font-size: 1.25rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .img-ori {
                height: 200px !important;
            }

            .img-thumb {
                height: 60px !important;
            }

            td {
                width: 50% !important;
            }

            .share-btn {
                width: 35% !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav
                class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white">
                <a href="Beranda.php" class="navbar-brand">
                    <h1>Ina Ndao</h1>
                </a>
                <button
                    type="button"
                    class="navbar-toggler ms-auto me-0"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="/Beranda.php" class="nav-item nav-link">Beranda</a>
                        <a href="/Tentang-Ina-Ndao.php" class="nav-item nav-link">Tentang Kami</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" id="produkDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Produk Ina Ndao
                            </a>
                            <ul class="dropdown-menu border-0 shadow" aria-labelledby="produkDropdown">
                                <li><a class="dropdown-item active" href="/Kain-Tenun.php">Kain Tenun</a></li>
                                <li><a class="dropdown-item" href="/Produk-Olahan.php">Produk Olahan Kain</a></li>
                            </ul>
                        </div>

                        <a href="/Galeri-Ina-Ndao.php" class="nav-item nav-link">Galeri</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Navbar End -->

    <!-- Hero Start -->
    <div class="container-fluid pb-5 bg-primary hero-header">
        <div class="container py-5">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-1 mb-0 animated slideInLeft" style="font-size: 4rem;">Kain Ina Ndao</h1>
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
                            Perbesar QR Code
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
                    <div class="cta-wrap text-start mb-3">
                        <a class="btn btn-order btn-sm" target="_blank"
                            href="https://wa.me/6287848738402?text=Halo%20Ina%20Ndao%2C%20saya%20tertarik%20dengan%20<?= urlencode($kain['nama_jenis'] . ' ' . $kain['nama_daerah']) ?>">
                            <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                        </a>
                    </div>

                    <hr>

                    <!-- Deskripsi Kain -->
                    <div class="kain-detail mb-3">
                        <p class="mb-2 makna">
                            <strong>Makna Motif:</strong><br>
                            <?= nl2br(htmlspecialchars($kain['makna'] ?? 'Belum ada makna yang tercatat.')) ?>
                        </p>

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
                                    <?= htmlspecialchars($panjang . ' x ' . $lebar . ' cm') ?>
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

    <?php include "footer.html" ?>

    <!-- JS libs -->
    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="/js/jquery.min.js"></script>
    <script src="/lib/wow/wow.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/waypoints/waypoints.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>

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

        // Carousel thumbnail (pagination)
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
            // Set thumbnail pertama aktif secara manual
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

        // QR small
        new QRCode(document.getElementById("qrcode-small"), {
            text: window.location.href,
            width: 96,
            height: 96,
            colorDark: "#15345B",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Buat QR besar di dalam modal
        const largeQR = new QRCode(document.getElementById("qrcode-large"), {
            text: window.location.href,
            width: 250,
            height: 250
        });

        // Opsional: agar QR besar di-refresh setiap kali modal dibuka
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
                alert('Tautan disalin ke clipboard!');
            }, function(err) {
                alert('Gagal menyalin tautan: ' + err);
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


        // keyboard friendly: press "s" to copy link (nice UX)
        document.addEventListener('keydown', function(e) {
            if (e.key === 's' || e.key === 'S') {
                navigator.clipboard.writeText(window.location.href);
                const t = document.createElement('div');
                t.textContent = 'Tautan disalin (shortcut: S)';
                t.style.position = 'fixed';
                t.style.right = '20px';
                t.style.bottom = '20px';
                t.style.background = '#15345B';
                t.style.color = '#fff';
                t.style.padding = '10px 14px';
                t.style.borderRadius = '8px';
                t.style.boxShadow = '0 8px 30px rgba(21,52,91,0.12)';
                document.body.appendChild(t);
                setTimeout(() => t.remove(), 1700);
            }
        });
    </script>
</body>

</html>