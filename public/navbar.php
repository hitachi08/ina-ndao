<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navbar Start -->
<div class="container-fluid sticky-top">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white">
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

          <!-- Beranda -->
          <a
            href="Beranda.php"
            class="nav-item nav-link <?php if ($current_page == 'Beranda.php') {
                                        echo 'active';
                                      } ?>">Beranda</a>

          <!-- Tentang Kami -->
          <a
            href="Tentang-Ina-Ndao.php"
            class="nav-item nav-link <?php if ($current_page == 'Tentang-Ina-Ndao.php') {
                                        echo 'active';
                                      } ?>">Tentang Kami</a>

          <!-- Produk Dropdown -->
          <div class="nav-item dropdown">
            <a
              href="#"
              class="nav-link dropdown-toggle <?php if (in_array($current_page, ['Kain-Tenun.php', 'Produk-Olahan.php'])) {
                                                echo 'active';
                                              } ?>"
              id="produkDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              Produk Ina Ndao
            </a>
            <ul class="dropdown-menu border-0 shadow" aria-labelledby="produkDropdown">
              <li>
                <a
                  class="dropdown-item <?php if ($current_page == 'Kain-Tenun.php') {
                                          echo 'active';
                                        } ?>"
                  href="Kain-Tenun.php">Kain Tenun</a>
              </li>
              <li>
                <a
                  class="dropdown-item <?php if ($current_page == 'Produk-Olahan.php') {
                                          echo 'active';
                                        } ?>"
                  href="Produk-Olahan.php">Produk Olahan Kain</a>
              </li>
            </ul>
          </div>

          <!-- Galeri -->
          <a
            href="Galeri-Ina-Ndao.php"
            class="nav-item nav-link <?php if ($current_page == 'Galeri-Ina-Ndao.php') {
                                        echo 'active';
                                      } ?>">Galeri</a>

        </div>
      </div>
    </nav>
  </div>
</div>
<!-- Navbar End -->