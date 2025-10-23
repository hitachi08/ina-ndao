<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();
$username = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <style>
        .card-img-top {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .text-truncate2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .detail-image-modal {
            width: 48%;
            height: 50%;
            object-fit: cover;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>

    <?php include "sidebar.php"; ?>

    <main class="content">

        <?php include "navbar.php"; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-4 gap-3">
            <button class="btn btn-primary d-inline-flex align-items-center" id="btnAdd">
                <i class="bi bi-plus-lg me-2"></i> Tambah Produk
            </button>
            <nav>
                <ul class="pagination mb-0 flex-wrap justify-content-center" id="pagination"></ul>
            </nav>
        </div>

        <div class="row" id="produkContainer"></div>

        <?php include "footer.php" ?>
        
    </main>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="detailProdukModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-gradient py-3">
                    <h5 class="modal-title fw-bold" id="detailProdukTitle">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="detailProdukImages" class="d-flex flex-wrap justify-content-center gap-3 mb-4"></div>
                    <div class="bg-white border rounded-3 shadow-sm p-3 text-muted"
                        style="max-height: 320px; overflow-y: auto; overflow-x: hidden; word-wrap: break-word; white-space: pre-wrap;"
                        id="detailProdukDeskripsi"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-2" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Produk -->
    <div class="modal fade" id="produkModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <form id="produkForm" enctype="multipart/form-data" class="modal-content rounded-2 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <input type="hidden" name="id_produk" id="id_produk">
                    <div class="row g-3">

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-select select2" name="id_kategori" id="id_kategori" required></select>
                        </div>

                        <!-- Sub Kategori -->
                        <div class="col-md-6">
                            <label for="id_sub_kategori" class="form-label">Sub Kategori</label>
                            <select class="form-select select2" name="id_sub_kategori" id="id_sub_kategori" required></select>
                        </div>

                        <!-- Pilih Kain -->
                        <div class="col-md-6">
                            <label for="id_kain" class="form-label">Pilih Kain</label>
                            <select class="form-select select2" name="id_kain" id="id_kain" required></select>
                        </div>


                        <!-- Nama Produk Otomatis -->
                        <div class="col-md-6">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk">
                        </div>

                        <!-- Ukuran -->
                        <div class="col-md-6">
                            <label for="ukuran" class="form-label">Ukuran</label>
                            <input type="text" class="form-control" name="ukuran" id="ukuran">
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" placeholder="Rp ">
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                        </div>

                        <!-- Gambar -->
                        <div class="col-12">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="gambar[]" id="gambar" multiple>
                            <div id="previewGambar" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/select2.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/pagination.js"></script>
    <script src="js/produk.js"></script>
</body>

</html>