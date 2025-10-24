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
    <link href="/img/ina_ndao_logo.jpeg" rel="icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/notyf.min.css">
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


    <section class="container product-section mb-5">
        <div class="detail-card">
            <div class="row g-4">
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

                <div class="col-lg-6">
                    <h3 class="fw-bold mb-2">
                        <?= htmlspecialchars($kain['nama_jenis'] . ' ' . $kain['nama_daerah']) ?>
                    </h3>
                    <div class="price fs-4 mb-3">
                        <?= rp($kain['harga']) ?>,-
                    </div>
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
                    <div class="d-flex gap-2">
                        <div class="cta-wrap text-start mb-3">
                            <a class="btn btn-order btn-sm" target="_blank"
                                href="https://wa.me/6282145209063?text=Halo%20Ina%20Ndao%2C%20saya%20tertarik%20dengan%20<?= urlencode($kain['nama_jenis'] . ' ' . $kain['nama_daerah']) ?>">
                                <i class="bi bi-whatsapp me-2"></i> Pesan via WhatsApp
                            </a>
                        </div>
                        <div class="shopeeBtn" id="shopeeBtn" title="Buka di Shopee">
                            <img src="/img/shopee.png"
                                alt="Shopee">
                        </div>
                    </div>

                    <hr>

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
            </div>
        </div>
    </section>

    <?php include "footer.php" ?>

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
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
    <script src="/js/detail-kain.js"></script>

</body>

</html>