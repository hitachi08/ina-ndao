<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

$current_page = basename($_SERVER['PHP_SELF']);

if (isset($_GET['lang'])) {
  $_SESSION['lang'] = $_GET['lang'];

  $redirect = strtok($_SERVER["REQUEST_URI"], '?');
  header("Location: $redirect");
  exit;
}

$currentLang = $_SESSION['lang'] ?? 'id';

$langFlags = [
  'id' => 'id',
  'en' => 'gb'
];
$langFullLabels = [
  'id' => 'Indonesia',
  'en' => 'English'
];
$currentFlagCode = $langFlags[$currentLang] ?? 'id';
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.8.0/css/flag-icons.min.css">

<!-- Navbar Start -->
<div class="container-fluid sticky-top">
  <div class="container position-relative">
    <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white">
      <a href="/Beranda.php?lang=<?= $currentLang ?>" class="nav-item nav-link <?php if ($current_page == 'Beranda.php') echo 'active'; ?>" class="navbar-brand">
        <h1>Ina Ndao</h1>
      </a>
      <div class="d-lg-none me-2">
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="langDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="fi fi-<?= $currentFlagCode ?>" style="vertical-align: middle;"></span>
          </a>
          <ul class="dropdown-menu border-0 shadow" aria-labelledby="langDropdownMobile">
            <?php foreach ($langFlags as $code => $flagCode): ?>
              <li>
                <a class="dropdown-item <?php if ($currentLang == $code) echo 'active'; ?>" href="?lang=<?= $code ?>">
                  <span class="fi fi-<?= $flagCode ?> me-2"></span> <?= $langFullLabels[$code] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <button
        type="button"
        class="navbar-toggler ms-auto me-0"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto me-0">

          <!-- Beranda -->
          <a href="/Beranda.php" class="nav-item nav-link <?php if ($current_page == 'Beranda.php') echo 'active'; ?>">Beranda</a>

          <!-- Tentang Ina Ndao -->
          <a href="/Tentang-Ina-Ndao.php" class="nav-item nav-link <?php if ($current_page == 'Tentang-Ina-Ndao.php') echo 'active'; ?>">Tentang Kami</a>

          <!-- Produk Ina Ndao -->
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle <?php if (in_array($current_page, ['Kain-Tenun.php', 'Produk-Olahan.php'])) echo 'active'; ?>"
              id="produkDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Produk
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="produkDropdown">
              <li><a class="dropdown-item <?php if ($current_page == 'Kain-Tenun.php') echo 'active'; ?>" href="/Kain-Tenun.php">Kain Tenun</a></li>
              <li><a class="dropdown-item <?php if ($current_page == 'Produk-Olahan.php') echo 'active'; ?>" href="/Produk-Olahan.php">Produk Olahan Kain</a></li>
            </ul>
          </div>

          <!-- Galeri Ina Ndao -->
          <a href="/Galeri-Ina-Ndao.php" class="nav-item nav-link <?php if ($current_page == 'Galeri-Ina-Ndao.php') echo 'active'; ?>">Galeri</a>

          <!-- Translate -->
          <div class="nav-item dropdown d-none d-lg-block">
            <a href="#" class="nav-link dropdown-toggle" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="fi fi-<?= $currentFlagCode ?>" style="vertical-align: middle;"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="langDropdown">
              <?php foreach ($langFlags as $code => $flagCode): ?>
                <li>
                  <a class="dropdown-item <?php if ($currentLang == $code) echo 'active'; ?>" href="?lang=<?= $code ?>">
                    <span class="fi fi-<?= $flagCode ?> me-2"></span> <?= $langFullLabels[$code] ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

        </div>
      </div>
    </nav>
  </div>
</div>
<!-- Navbar End -->