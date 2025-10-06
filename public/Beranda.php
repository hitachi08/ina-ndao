<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/KontenModel.php';

$model = new KontenModel($pdo);

$sejarahData = $model->getByHalaman('beranda_sejarah')['konten'] ?? '<p>Belum ada konten sejarah.</p>';
$promosiData = $model->getByHalaman('beranda_promosi')['konten'] ?? null;

$narasi_singkat = strip_tags($sejarahData);

$promosi = [];
if ($promosiData) {
  $decoded = json_decode($promosiData, true);
  if (isset($decoded['promosi']) && is_array($decoded['promosi'])) {
    $promosi = $decoded['promosi'];
  }
}

$icons = [
  'fa-history',
  'fa-palette',
  'fa-chalkboard-teacher',
  'fa-users',
  'fa-gem',
  'fa-leaf'
];

$titles = [
  '30+ Tahun Berpengalaman',
  'Motif Otentik & Pewarna Alami',
  'Edukasi Budaya',
  'Pemberdayaan Masyarakat',
  'Kualitas Kerajinan Tinggi',
  'Tradisi Berkelanjutan'
];

$teamData = $model->getByHalaman('beranda_team')['konten'] ?? null;
$team = [];

if ($teamData) {
  $decoded = json_decode($teamData, true);
  if (isset($decoded['team']) && is_array($decoded['team'])) {
    $team = $decoded['team'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Ina Ndao - Tenun Ikat NTT</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="img/ina_ndao_logo.jpeg" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
</head>

<body>
  <!-- Spinner Start -->
  <div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <!-- Navbar Start -->
  <?php include "navbar.php" ?>
  <!-- Navbar End -->

  <!-- Hero Start -->
  <div class="container-fluid pb-5 hero-header bg-light mb-5">
    <div class="container py-5">
      <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
          <h1 class="display-1 mb-4 animated slideInRight" style="font-size: 45px;">
            Rumah Produksi <span class="text-primary">Tenun</span>
            <span style="font-size: 50px">Nusa Tenggara Timur</span>
          </h1>
          <h5 class="d-inline-block border border-2 border-white py-3 px-5 mb-0 animated slideInRight">
            Berdiri Sejak Tahun 1991
          </h5>
        </div>
        <div class="col-lg-6">
          <div class="owl-carousel header-carousel animated fadeIn">
            <img class="img-fluid" src="img/hero-slider-4.jpg" alt="" />
            <img class="img-fluid" src="img/hero-slider-5.jpg" alt="" />
            <img class="img-fluid" src="img/hero-slider-6.jpg" alt="" />
          </div>
        </div>
      </div>
      <div class="row g-5 animated fadeIn">
        <div class="col-md-6 col-lg-3">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 btn-square border border-2 border-white me-3">
              <i class="fa fa-landmark text-primary"></i>
            </div>
            <h5 class="lh-base mb-0">Warisan Budaya</h5>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 btn-square border border-2 border-white me-3">
              <i class="fa fa-leaf text-primary"></i>
            </div>
            <h5 class="lh-base mb-0">Pewarna & Bahan Alami</h5>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 btn-square border border-2 border-white me-3">
              <i class="fa fa-handshake text-primary"></i>
            </div>
            <h5 class="lh-base mb-0">Kepercayaan Pelanggan</h5>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 btn-square border border-2 border-white me-3">
              <i class="fa fa-tags text-primary"></i>
            </div>
            <h5 class="lh-base mb-0">Bernilai & Terjangkau</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Hero End -->

  <!-- Sejarah Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-6 wow fadeIn" data-wow-delay="0.1s">
              <img class="img-fluid" src="img/about-3.jpg" alt="" />
            </div>
            <div class="col-6 wow fadeIn" data-wow-delay="0.3s">
              <img class="img-fluid h-75" src="img/about-4.jpg" alt="" />
              <div class="h-25 d-flex align-items-center text-center bg-primary px-4">
                <h4 class="text-white lh-base mb-0">
                  Berkarya Sejak 1991
                </h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn d-flex flex-column" data-wow-delay="0.5s">
          <div>
            <h1 class="mb-5">
              <span class="text-uppercase text-primary bg-light px-2">Cerita</span>
              Dibalik Ina Ndao
            </h1>
            <p class="mb-4 narasi-singkat">
              <?= htmlspecialchars($narasi_singkat) ?>
            </p>
            <div class="row g-3">
              <div class="col-sm-6">
                <h6 class="mb-3">
                  <i class="fa fa-check text-primary me-2"></i>Pengakuan & Prestasi
                </h6>
                <h6 class="mb-0">
                  <i class="fa fa-check text-primary me-2"></i>Pengrajin Berpengalaman
                </h6>
              </div>
              <div class="col-sm-6">
                <h6 class="mb-3">
                  <i class="fa fa-check text-primary me-2"></i>Pelatihan & Edukasi Tenun
                </h6>
                <h6 class="mb-0">
                  <i class="fa fa-check text-primary me-2"></i>Harga Terjangkau
                </h6>
              </div>
            </div>
          </div>

          <!-- Tombol baca selengkapnya dipaksa ke bawah -->
          <div class="d-flex align-items-center mt-auto pt-4">
            <a class="btn btn-primary px-4 me-2" href="#!" data-bs-toggle="modal" data-bs-target="#historyModal">
              Baca Selengkapnya
            </a>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg rounded-4">

            <!-- Header -->
            <div class="modal-header bg-primary text-white border-0 rounded-top-4">
              <h5 class="modal-title fw-bold w-100 text-center" id="historyModalLabel">
                Sejarah Ina Ndao
              </h5>
              <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <!-- Body -->
            <div class="modal-body px-4 py-4">
              <!-- Gambar -->
              <div class="text-center mb-4">
                <img src="img/hero-slider-4.jpg" class="img-fluid w-50 rounded shadow mx-auto d-block"
                  alt="Motif Sumba" style="max-height:350px; object-fit:contain;">
              </div>

              <!-- Narasi -->
              <div class="px-2">
                <?= $sejarahData ?>
              </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Sejarah End -->

  <!-- Promosi Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="text-center wow fadeIn" data-wow-delay="0.1s">
        <h1 class="mb-5">
          Mengapa memilih
          <span class="text-uppercase text-primary bg-light px-2">Ina Ndao</span>
        </h1>
      </div>
      <div class="row g-5 align-items-center text-center">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="<?= (0.1 + ($i % 3) * 0.2) ?>s">
            <i class="fa <?= $icons[$i] ?> fa-5x text-primary mb-4"></i>
            <h4><?= $titles[$i] ?></h4>
            <p class="mb-0">
              <?= !empty($promosi[$i]) ? htmlspecialchars($promosi[$i]) : 'Belum ada teks promosi.' ?>
            </p>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
  <!-- Promosi End -->

  <!-- Team Start -->
  <div class="container-fluid bg-light py-5">
    <div class="container py-5">
      <h1 class="mb-5">
        Pengrajin & Tim
        <span class="text-uppercase text-primary bg-light px-2">Ina Ndao</span>
      </h1>

      <div class="row flex-row flex-nowrap overflow-auto g-4">
        <?php foreach ($team as $i => $anggota): ?>
          <div class="col-6 col-sm-4 col-md-3 col-lg-3 flex-shrink-0">
            <div class="team-item h-100 position-relative overflow-hidden rounded shadow-sm" style="aspect-ratio: 3 / 4;">
              <img
                src="<?= htmlspecialchars($anggota['foto']) ?>"
                alt="<?= htmlspecialchars($anggota['nama']) ?>"
                class="img-fluid w-100 h-100 rounded"
                style="object-fit: cover; object-position: center;" />
              <div class="team-overlay position-absolute bottom-0 start-0 w-100 p-3">
                <small class="mb-1 d-block text-light"><?= htmlspecialchars($anggota['jabatan']) ?></small>
                <h4 class="lh-base text-light mb-0"><?= htmlspecialchars($anggota['nama']) ?></h4>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <!-- Team End -->

  <style>
    /* Medium devices (≥768px) */
    @media (min-width: 768px) {
      .team-overlay small {
        font-size: 0.6rem;
      }

      .team-overlay h4 {
        font-size: 1rem;
      }
    }

    /* Large devices (≥992px) */
    @media (min-width: 992px) {
      .team-overlay small {
        font-size: 1.1rem;
      }

      .team-overlay h4 {
        font-size: 1.5rem;
      }
    }

    /* Large devices (≥1024px) */
    @media (min-width: 1024px) {
      .team-overlay small {
        font-size: 0.8rem;
      }

      .team-overlay h4 {
        font-size: 1.2rem;
      }
    }

    @media (min-width: 320px) and (max-width: 426px) {
      .team-overlay small {
        font-size: 0.4rem;
      }

      .team-overlay h4 {
        font-size: 0.7rem;
      }
    }
  </style>

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