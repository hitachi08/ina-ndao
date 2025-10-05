<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="index.php">
        <img src="../img/ina_ndao_logo.jpeg" alt="Ina Ndao Logo" class="me-2" style="width:40px; height:40px; object-fit:cover; border-radius:2px;">
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-3 pt-3">

        <!-- Logo + Nama -->
        <div class="d-flex d-lg-block align-items-center justify-content-evenly mb-4">
            <img src="../img/ina_ndao_logo.jpeg" alt="Ina Ndao Logo" class="me-2" style="width:40px; height:40px; object-fit:cover; border-radius:2px;">
            <span class="h5 mb-0 fw-bold">INA NDAO</span>
        </div>

        <!-- User Card -->
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="../img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white" alt="Admin">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3"><?php echo htmlspecialchars($username); ?></h2>
                    <a href="../logout.php" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                        <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <?php
        // ambil nama file saat ini, misal: "dashboard.php"
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>

        <!-- Sidebar Menu -->
        <ul class="nav flex-column pt-3 pt-md-0">

            <!-- Dashboard -->
            <li class="nav-item <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                <a href="../admin/index.php" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            <!-- Toko / Produk -->
            <?php
            $produk_pages = ['produk-list.php', 'produk-tambah.php', 'kategori-produk.php'];
            $produk_active = in_array($current_page, $produk_pages) ? 'show' : '';
            ?>
            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center <?= $produk_active ? '' : 'collapsed' ?>"
                    data-bs-toggle="collapse" data-bs-target="#submenu-produk">
                    <span>
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span class="sidebar-text">Toko / Produk</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse <?= $produk_active ?>" id="submenu-produk">
                    <ul class="flex-column nav">
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'produk-list.php') ? 'active' : '' ?>" href="../admin/produk-list.php"><span class="sidebar-text">Daftar Produk</span></a></li>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'produk-tambah.php') ? 'active' : '' ?>" href="../admin/produk-tambah.php"><span class="sidebar-text">Tambah Produk</span></a></li>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'kategori-produk.php') ? 'active' : '' ?>" href="../admin/kategori-produk.php"><span class="sidebar-text">Kategori Produk</span></a></li>
                    </ul>
                </div>
            </li>

            <!-- Galeri -->
            <li class="nav-item <?= ($current_page == 'galeri.php') ? 'active' : '' ?>">
                <a href="../admin/galeri.php" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2a1 1 0 00-1 1v2h10V3a1 1 0 00-1-1H6zM3 6h14v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Galeri</span>
                </a>
            </li>

            <!-- Event -->
            <li class="nav-item <?= ($current_page == 'event.php') ? 'active' : '' ?>">
                <a href="../admin/event.php" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Event</span>
                </a>
            </li>

            <!-- Konten Halaman -->
            <?php
            $konten_pages = ['konten-beranda.php', 'konten-tentang.php'];
            $konten_active = in_array($current_page, $konten_pages) ? 'show' : '';
            ?>
            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center <?= $konten_active ? '' : 'collapsed' ?>"
                    data-bs-toggle="collapse" data-bs-target="#submenu-konten">
                    <span>
                        <span class="sidebar-icon">
                            <!-- 🔄 Ikon Baru: file-text -->
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0A1.5 1.5 0 0 0 2 1.5v13A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0h-9zM3 1.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5V3H3V1.5z" />
                            </svg>
                        </span>
                        <span class="sidebar-text">Konten Halaman</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 
                    7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 
                    010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse <?= $konten_active ?>" id="submenu-konten">
                    <ul class="flex-column nav">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'konten-beranda.php') ? 'active' : '' ?>"
                                href="../admin/konten-beranda.php">
                                <span class="sidebar-text">Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'konten-tentang.php') ? 'active' : '' ?>"
                                href="../admin/konten-tentang.php">
                                <span class="sidebar-text">Tentang Kami</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- User / Admin -->
            <?php
            $user_pages = ['user-list.php', 'user-tambah.php'];
            $user_active = in_array($current_page, $user_pages) ? 'show' : '';
            ?>
            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center <?= $user_active ? '' : 'collapsed' ?>"
                    data-bs-toggle="collapse" data-bs-target="#submenu-user">
                    <span>
                        <span class="sidebar-icon">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 100 10 5 5 0 000-10z"></path>
                                <path fill-rule="evenodd" d="M2 18a8 8 0 0116 0H2z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span class="sidebar-text">User Admin</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse <?= $user_active ?>" id="submenu-user">
                    <ul class="flex-column nav">
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'user-list.php') ? 'active' : '' ?>" href="../admin/user-list.php"><span class="sidebar-text">Daftar User</span></a></li>
                        <li class="nav-item"><a class="nav-link <?= ($current_page == 'user-tambah.php') ? 'active' : '' ?>" href="../admin/user-tambah.php"><span class="sidebar-text">Tambah User</span></a></li>
                    </ul>
                </div>
            </li>

            <!-- Pengaturan Sistem -->
            <li class="nav-item <?= ($current_page == 'pengaturan.php') ? 'active' : '' ?>">
                <a href="../admin/pengaturan.php" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Pengaturan Sistem</span>
                </a>
            </li>
        </ul>
    </div>
</nav>