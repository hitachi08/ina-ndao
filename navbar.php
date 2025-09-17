<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navbar Start -->
<div class="container-fluid sticky-top">
  <div class="container">
    <nav
      class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white"
    >
      <a href="index.php" class="navbar-brand">
        <h1>Ina Ndao</h1>
      </a>
      <button
        type="button"
        class="navbar-toggler ms-auto me-0"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto">
          <a
            href="index.php"
            class="nav-item nav-link <?php if($current_page=='index.php'){echo 'active';} ?>"
            >Beranda</a
          >
          <a
            href="tentang-kami.php"
            class="nav-item nav-link <?php if($current_page=='tentang-kami.php'){echo 'active';} ?>"
            >Tentang Kami</a
          >
          <a
            href="toko.php"
            class="nav-item nav-link <?php if($current_page=='toko.php'){echo 'active';} ?>"
            >Toko</a
          >
          <a
            href="galeri.php"
            class="nav-item nav-link <?php if($current_page=='galeri.php'){echo 'active';} ?>"
            >Galeri</a
          >
        </div>
      </div>
    </nav>
  </div>
</div>
<!-- Navbar End -->
