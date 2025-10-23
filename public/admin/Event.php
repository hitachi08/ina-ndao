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
    <title>Kelola Event - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">

    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
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

        @media (max-width: 576px) {
            .pagination .page-link {
                font-size: 0.8rem;
                width: 30px;
                height: 30px;
            }

            .card-body h6 {
                font-size: 0.9rem;
            }

            .card-text {
                font-size: 0.75rem;
            }

            .card-body span {
                font-size: 0.8rem;
            }
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        .dokumentasi-thumb {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
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
                Tambah Event
            </button>

            <nav>
                <ul class="pagination mb-0 flex-wrap justify-content-center" id="pagination"></ul>
            </nav>
        </div>

        <div class="row" id="eventContainer"></div>

        <?php include "footer.php" ?>
    </main>

    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <form id="eventForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_event" id="id_event">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Event</label>
                            <input type="text" class="form-control" name="nama_event" id="nama_event" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tempat</label>
                            <input type="text" class="form-control" name="tempat" id="tempat" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Waktu</label>
                            <input type="time" class="form-control" name="waktu" id="waktu" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Gambar Banner</label>
                        <input type="file" class="form-control" name="gambar_banner" id="gambar_banner">
                        <img id="bannerPreview" src="" alt="Preview Banner" class="img-fluid mt-4" style="width: 100px; height:150px; object-fit: cover; display:none;">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="docModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form id="docForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Dokumentasi Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_event" id="id_event">

                    <div class="mb-3">
                        <label>Tambah Dokumentasi</label>
                        <input type="file" class="form-control" name="gambar_dokumentasi[]" id="gambar_dokumentasi" multiple>
                    </div>

                    <div class="mb-3 d-flex gap-2 justify-content-end">
                        <button type="button" id="btnSelectAll" class="btn btn-secondary btn-sm">
                            Pilih Semua
                        </button>
                        <button type="button" id="btnDelSelected" class="btn btn-danger btn-sm" disabled>
                            Hapus Terpilih
                        </button>
                    </div>

                    <div id="docList" class="row g-2"></div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="detailGambar" src="" class="img-fluid shadow-sm" alt="Gambar Event" style="width: 200px; height: 250px; object-fit: cover;">
                    </div>
                    <h4 id="detailNama" class="mb-3 text-center"></h4>
                    <p id="detailDeskripsi" class="text-muted mb-3"></p>
                    <ul class="list-unstyled small">
                        <li><i class="fa fa-calendar text-primary me-2"></i><span id="detailTanggal"></span></li>
                        <li><i class="fa fa-clock text-primary me-2"></i><span id="detailWaktu"></span></li>
                        <li><i class="fa fa-map-marker-alt text-primary me-2"></i><span id="detailTempat"></span></li>
                    </ul>
                    <hr>
                    <h6 class="fw-bold mb-3"><i class="fa fa-images text-primary me-2"></i> Dokumentasi Event</h6>
                    <div id="detailDokumentasi" class="row g-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/pagination.js"></script>
    <script src="js/event.js"></script>

</body>

</html>