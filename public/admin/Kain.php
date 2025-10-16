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
    <title>Manajemen Data - Ina Ndao</title>
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

        <?php include "navbar.php" ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start py-4 gap-3">
            <button class="btn btn-primary d-inline-flex align-items-center" id="btnAdd">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Kain
            </button>

            <nav>
                <ul class="pagination mb-0 flex-wrap justify-content-center" id="pagination"></ul>
            </nav>
        </div>

        <div class="row" id="galeriContainer"></div>

        <?php include "footer.php" ?>
    </main>

    <!-- Modal Detail Motif -->
    <div class="modal fade" id="detailMotifModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-gradient py-3">
                    <h5 class="modal-title fw-bold" id="detailMotifTitle">Nama Motif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="detailMotifImages" class="row g-3 mb-4 justify-content-center"></div>
                    <h6 id="detailMotifStoryTitle" class="text-center fw-bold mb-3 text-dark">
                        Cerita di Balik Motif
                    </h6>
                    <div id="detailMotifCerita"
                        class="bg-white border rounded-3 shadow-sm p-3 text-muted text-center"
                        style="max-height: 320px; overflow-y: auto; overflow-x: hidden; word-wrap: break-word; white-space: pre-wrap;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded-2" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Galeri -->
    <div class="modal fade" id="galeriModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <form id="galeriForm" enctype="multipart/form-data" class="modal-content rounded-2 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <input type="hidden" name="id_variasi" id="id_variasi">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_jenis" class="form-label">Jenis Kain</label>
                            <select class="form-select select2" name="id_jenis_kain" id="nama_jenis" required></select>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_daerah" class="form-label">Daerah</label>
                            <select class="form-select select2" name="id_daerah" id="nama_daerah" required></select>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_motif" class="form-label">Nama Motif</label>
                            <select class="form-select select2" name="id_motif" id="nama_motif" required></select>
                        </div>
                        <div class="col-md-6">
                            <label for="bahan" class="form-label">Bahan</label>
                            <input type="text" class="form-control" name="bahan" id="bahan">
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_pewarna" class="form-label">Jenis Pewarna</label>
                            <input type="text" class="form-control" name="jenis_pewarna" id="jenis_pewarna">
                        </div>
                        <div class="col-md-6">
                            <label>Ukuran (cm)</label>
                            <div class="d-flex gap-2">
                                <input type="number" class="form-control" name="panjang" id="panjang" placeholder="Panjang" required>
                                <input type="number" class="form-control" name="lebar" id="lebar" placeholder="Lebar" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="cerita" class="form-label">Cerita</label>
                            <textarea class="form-control" name="cerita" id="cerita" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="gambar" class="form-label">Gambar Motif</label>
                            <input type="file" class="form-control" name="gambar[]" id="gambar" multiple>
                            <div id="previewGambar" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" value="Rp " placeholder="Rp 0">
                        </div>
                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok">
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
    <script src="js/kain.js"></script>

</body>

</html>