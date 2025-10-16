<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

if (isset($_GET['lang'])) {
  $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'] ?? 'id';

$current_page = basename($_SERVER['PHP_SELF']);

$langFlags = [
  'id' => 'id',
  'en' => 'gb',
  'fr' => 'fr'
];

$langFullLabels = [
  'id' => 'Indonesia',
  'en' => 'English',
  'fr' => 'Français'
];

$currentFlagCode = $langFlags[$currentLang] ?? 'id';
?>

<div class="container-fluid bg-dark text-white-50 footer pt-5">
  <div class="container">
    <div class="row g-5 mb-3">
      <div
        class="col-md-6 col-lg-3 wow fadeIn d-flex align-items-start justify-content-center"
        data-wow-delay="0.1s">
        <img
          src="/img/ina_ndao_logo.jpeg"
          alt="Ina Ndao Logo"
          class="img-fluid"
          width="220px" />
      </div>
      <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
        <h5 class="text-white mb-4">Kontak Kami</h5>
        <p>
          <i class="fa fa-map-marker-alt me-3"></i>Jl. Kebun Raja II, Naikoten
        </p>
        <p><i class="fa fa-phone-alt me-3"></i>+62 812 3785 620</p>
        <p><i class="fa fa-envelope me-3"></i>inandao@gmail.com</p>
        <div class="d-flex pt-2">
          <a class="btn btn-outline-primary btn-square border-2 me-2" href="https://web.facebook.com/ina.ndao.ntt/?locale=id_ID&_rdc=1&_rdr#" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-outline-primary btn-square border-2 me-2" href="https://www.instagram.com/tenuninandao/?hl=id" target="_blank"><i class="fab fa-instagram"></i></a>
          <a class="btn btn-outline-primary btn-square border-2 me-2" href="https://shopee.co.id/inandao" target="_blank"><i class="fas fa-shopping-bag"></i></a>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3926.9692286335053!2d123.5891227406035!3d-10.1831542854452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c569b5f9bf05d51%3A0x787471a2f2a1ebe2!2sRumah%20Produksi%20Tenun%20NTT-Inandao%202!5e0!3m2!1sid!2sid!4v1758709163844!5m2!1sid!2sid"
          width="100%"
          height="250"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
    <div class="container wow fadeIn" data-wow-delay="0.1s">
      <div class="copyright">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy; Rumah Produksi Tenun NTT <span><strong>Ina Ndao</strong></span>, All Right Reserved.
          </div>
          <div class="col-md-6 text-center text-md-end">
            <div class="footer-menu">
              <a href="/Beranda.php?lang=<?= $currentLang ?>" class="nav-item nav-link <?php if ($current_page == 'Beranda.php') echo 'active'; ?>">Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>