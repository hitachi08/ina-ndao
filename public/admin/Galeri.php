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
    <title>Kelola Galeri - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />
    <link type="text/css" href="../css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">

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
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .detail-image-modal:hover {
            transform: scale(1.5);
            z-index: 10;
            aspect-ratio: auto;
            object-fit: contain;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: #fff;
        }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>
    <main class="content p-4">
        <?php include "navbar.php" ?>
        <h2>Kelola Galeri</h2>
        <button class="btn btn-primary mb-3" id="btnAdd">Tambah Motif / Variasi</button>

        <!-- Container card galeri -->
        <div class="row" id="galeriContainer"></div>

        <?php include "footer.php" ?>
    </main>

    <!-- Modal Tambah/Edit Galeri -->
    <div class="modal fade" id="galeriModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="galeriForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_variasi" id="id_variasi">

                    <div class="mb-3">
                        <label for="nama_jenis">Jenis Kain</label>
                        <input type="text" class="form-control" name="nama_jenis" id="nama_jenis" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_daerah">Daerah</label>
                        <input type="text" class="form-control" name="nama_daerah" id="nama_daerah" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_motif">Nama Motif</label>
                        <input type="text" class="form-control" name="nama_motif" id="nama_motif" required>
                    </div>

                    <div class="mb-3">
                        <label for="cerita">Cerita</label>
                        <textarea class="form-control" name="cerita" id="cerita" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambar">Gambar Motif</label>
                        <input type="file" class="form-control" name="gambar[]" id="gambar" multiple>
                        <div id="previewGambar" class="mt-2 d-flex flex-wrap gap-2"></div>
                    </div>


                    <div class="mb-3">
                        <label>Ukuran (cm)</label>
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control" name="panjang" id="panjang" placeholder="Panjang"
                                required>
                            <input type="number" class="form-control" name="lebar" id="lebar" placeholder="Lebar"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan" id="bahan">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_pewarna">Jenis Pewarna</label>
                        <input type="text" class="form-control" name="jenis_pewarna" id="jenis_pewarna">
                    </div>

                    <div class="mb-3">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" id="harga">
                    </div>

                    <div class="mb-3">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Detail Motif -->
    <div class="modal fade" id="detailMotifModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailMotifTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="detailMotifImages" class="d-flex flex-wrap justify-content-center gap-2 mb-3"></div>
                    <!-- Judul cerita -->
                    <h6 id="detailMotifStoryTitle" class="fw-bold mb-2 text-center"></h6>
                    <!-- Cerita -->
                    <p id="detailMotifCerita"></p>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            var routeUrl = "/galeri";

            // =========================
            // Load Galeri
            // =========================
            function loadGaleri() {
                $.ajax({
                    url: routeUrl + "/fetch_all",
                    type: "GET",
                    dataType: "json",
                    success: function (res) {
                        var container = $('#galeriContainer');
                        container.empty();
                        var data = Array.isArray(res) ? res : res.data || [];

                        if (data.length === 0) {
                            container.html('<p class="text-muted">Belum ada motif.</p>');
                            return;
                        }

                        data.forEach(function (item) {
                            var gambarUtama = (item.motif_gambar && item.motif_gambar.length > 0)
                                ? item.motif_gambar[0]
                                : '/img/no-image.png';

                            var card = `
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-0 product-card">
                                    <img src="${gambarUtama}" 
                                         class="card-img-top detail-image" 
                                         alt="${item.nama_motif}"
                                         data-nama="${item.nama_motif}"
                                         data-cerita="${item.cerita || ''}"
                                         data-gambar='${JSON.stringify(item.motif_gambar)}'>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title text-truncate">${item.nama_motif}</h6>
                                        <p class="card-text text-truncate2">${item.cerita || ''}</p>
                                        <ul class="list-unstyled small text-muted mb-2">
                                            <li><strong>Jenis:</strong> ${item.nama_jenis}</li>
                                            <li><strong>Daerah:</strong> ${item.nama_daerah}</li>
                                            <li><strong>Ukuran:</strong> ${item.ukuran}</li>
                                            <li><strong>Bahan:</strong> ${item.bahan}</li>
                                            <li><strong>Pewarna:</strong> ${item.jenis_pewarna}</li>
                                            <li><strong>Harga:</strong> ${item.harga}</li>
                                            <li><strong>Stok:</strong> ${item.stok}</li>
                                        </ul>
                                        <div class="mt-auto d-flex gap-2">
                                            <button class="btn btn-warning btn-sm btnEdit w-50" data-id="${item.id_variasi}">Edit</button>
                                            <button class="btn btn-danger btn-sm btnDelete w-50" data-id="${item.id_variasi}">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    `;
                            container.append(card);
                        });
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Gagal memuat galeri: ' + xhr.responseText, 'error');
                    }
                });
            }

            loadGaleri();

            // =========================
            // Detail Modal
            // =========================
            $('#galeriContainer').on('click', '.detail-image', function (e) {
                e.stopPropagation();

                var nama = $(this).data('nama');
                var cerita = $(this).data('cerita');
                var gambar = $(this).data('gambar');

                $('#detailMotifTitle').text(nama);
                $('#detailMotifStoryTitle').text(`CERITA LENGKAP DIBALIK MOTIF ${nama.toUpperCase()}`);

                var imagesContainer = $('#detailMotifImages');
                imagesContainer.empty();

                if (gambar && gambar.length > 0) {
                    gambar.forEach(function (img) {
                        imagesContainer.append(`<img src="${img}" class="detail-image-modal me-1 mb-1">`);
                    });
                } else {
                    imagesContainer.append('<img src="/img/no-image.png" class="detail-image-modal">');
                }

                $('#detailMotifCerita').text(cerita || '');
                $('#detailMotifModal').modal('show');
            });

            // =========================
            // Tambah Modal
            // =========================
            $('#btnAdd').click(function () {
                $('#galeriForm')[0].reset();
                $('#id_variasi').val('');
                $('#galeriModal').modal('show');
            });

            // =========================
            // Submit Add/Edit
            // =========================
            $('#galeriForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                // gabungkan panjang x lebar
                var panjang = $('#panjang').val();
                var lebar = $('#lebar').val();
                formData.set('ukuran', panjang + 'x' + lebar);

                // ubah nama_jenis -> jenis_kain
                formData.set('jenis_kain', $('#nama_jenis').val());
                // ubah nama_daerah -> daerah
                formData.set('daerah', $('#nama_daerah').val());

                var action = $('#id_variasi').val() === '' ? 'add_motif' : 'update_variasi';

                $.ajax({
                    url: routeUrl + "/" + action,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (res) {
                        if (typeof res === 'string') res = JSON.parse(res);
                        if (res.status === 'success') {
                            Swal.fire('Sukses', res.message, 'success').then(loadGaleri);
                            $('#galeriModal').modal('hide');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Gagal menyimpan data: ' + xhr.responseText, 'error');
                    }
                });
            });

            // =========================
            // Edit
            // =========================
            $('#galeriContainer').on('click', '.btnEdit', function (e) {
                e.stopPropagation();
                var id = $(this).data('id');

                $.ajax({
                    url: routeUrl + "/fetch_single",
                    type: "POST",
                    data: { id_variasi: id },
                    dataType: "json",
                    success: function (res) {
                        if (res && Object.keys(res).length > 0) {
                            $('#galeriForm')[0].reset();
                            $('#id_variasi').val(res.id_variasi);
                            $('#id_motif').val(res.id_motif);
                            $('#nama_jenis').val(res.nama_jenis);
                            $('#nama_daerah').val(res.nama_daerah);
                            $('#nama_motif').val(res.nama_motif);
                            $('#cerita').val(res.cerita);
                            $('#bahan').val(res.bahan);
                            $('#jenis_pewarna').val(res.jenis_pewarna);
                            $('#harga').val(res.harga);
                            $('#stok').val(res.stok);

                            if (res.ukuran && res.ukuran.includes("x")) {
                                let parts = res.ukuran.split("x");
                                $('#panjang').val(parts[0]);
                                $('#lebar').val(parts[1]);
                            }
                            // 🔥 Tampilkan gambar lama
                            var previewContainer = $('#previewGambar');
                            previewContainer.empty();

                            if (res.motif_gambar && res.motif_gambar.length > 0) {
                                res.motif_gambar.forEach(function (img) {
                                    previewContainer.append(`
                            <div class="position-relative">
                                <img src="${img}" class="rounded border" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                        `);
                                });
                            } else {
                                previewContainer.html('<p class="text-muted">Belum ada gambar.</p>');
                            }

                            $('#galeriModal').modal('show');
                        } else {
                            Swal.fire('Error', 'Data variasi tidak ditemukan', 'error');
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Gagal memuat data variasi: ' + xhr.responseText, 'error');
                    }
                });
            });

            // =========================
            // Hapus
            // =========================
            $('#galeriContainer').on('click', '.btnDelete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: routeUrl + "/delete_variasi",
                            type: "POST",
                            data: { id_variasi: id },
                            success: function (res) {
                                if (typeof res === 'string') res = JSON.parse(res);
                                Swal.fire('Sukses', res.message, 'success').then(loadGaleri);
                            },
                            error: function (xhr) {
                                Swal.fire('Error', 'Gagal menghapus data: ' + xhr.responseText, 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>

</body>

</html>