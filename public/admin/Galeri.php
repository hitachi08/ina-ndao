<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Galeri - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />
    <link type="text/css" href="../css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link type="text/css" href="../css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <main class="content p-4">
        <h2>Kelola Galeri</h2>
        <button class="btn btn-primary mb-3" id="btnAdd">Tambah Motif / Variasi</button>

        <table class="table table-bordered table-striped" id="galeriTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Kain</th>
                    <th>Daerah</th>
                    <th>Nama Motif</th>
                    <th>Cerita</th>
                    <th>Gambar</th>
                    <th>Ukuran</th>
                    <th>Bahan</th>
                    <th>Pewarna</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data via AJAX -->
            </tbody>
        </table>

        <?php include "footer.php" ?>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="galeriModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="galeriForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_variasi" id="id_variasi">
                    <div class="mb-3"><label>Jenis Kain</label><input type="text" class="form-control" name="nama_jenis"
                            id="nama_jenis" required></div>
                    <div class="mb-3"><label>Daerah</label><input type="text" class="form-control" name="nama_daerah"
                            id="nama_daerah" required></div>
                    <div class="mb-3"><label>Nama Motif</label><input type="text" class="form-control" name="nama_motif"
                            id="nama_motif" required></div>
                    <div class="mb-3"><label>Cerita</label><textarea class="form-control" name="cerita" id="cerita"
                            rows="4"></textarea></div>
                    <div class="mb-3"><label>Gambar Motif</label><input type="file" class="form-control" name="gambar"
                            id="gambar"></div>
                    <div class="mb-3">
                        <label>Ukuran</label>
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control" name="panjang" id="panjang"
                                placeholder="Panjang (cm)" required>
                            <input type="number" class="form-control" name="lebar" id="lebar" placeholder="Lebar (cm)"
                                required>
                        </div>
                    </div>

                    <div class="mb-3"><label>Bahan</label><input type="text" class="form-control" name="bahan"
                            id="bahan"></div>
                    <div class="mb-3"><label>Jenis Pewarna</label><input type="text" class="form-control"
                            name="jenis_pewarna" id="jenis_pewarna"></div>
                    <div class="mb-3"><label>Harga</label><input type="number" class="form-control" name="harga"
                            id="harga"></div>
                    <div class="mb-3"><label>Stok</label><input type="number" class="form-control" name="stok"
                            id="stok"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>


    <script>
        $(document).ready(function () {
            var routeUrl = "/galeri";

            var table = $('#galeriTable').DataTable({
                "ajax": {
                    "url": routeUrl + "/fetch_all",
                    "type": "GET",
                    "dataType": "json",
                    "dataSrc": function (json) {
                        if (Array.isArray(json)) return json;
                        if (json.data) return json.data;
                        return [];
                    },
                    "error": function () {
                        Swal.fire('Error', 'Gagal memuat data galeri.', 'error');
                    }
                },
                "scrollX": true,
                "responsive": true,
                "autoWidth": false,
                "columns": [
                    { "data": "id_variasi" },
                    { "data": "nama_jenis" },
                    { "data": "nama_daerah" },
                    { "data": "nama_motif" },
                    {
                        "data": "cerita",
                        "render": function (data) {
                            return data && data.length > 50 ? data.substr(0, 50) + "..." : data;
                        }
                    },
                    {
                        "data": "gambar",
                        "render": function (data) {
                            return data ? "<img src='../img/motif/" + data + "' width='80'>" : "";
                        }
                    },
                    { "data": "ukuran" },
                    { "data": "bahan" },
                    { "data": "jenis_pewarna" },
                    { "data": "harga" },
                    { "data": "stok" },
                    {
                        "data": "id_variasi",
                        "render": function (data) {
                            return `
                                <button class="btn btn-warning btn-sm btnEdit" data-id="${data}">Edit</button>
                                <button class="btn btn-danger btn-sm btnDelete" data-id="${data}">Hapus</button>
                            `;
                        }
                    }
                ]
            });

            // Tambah
            $('#btnAdd').click(function () {
                $('#galeriForm')[0].reset();
                $('#id_variasi').val('');
                $('#galeriModal').modal('show');
            });

            // Submit Add/Edit
            $('#galeriForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action;

                if ($('#id_variasi').val() === '') {
                    // Kalau belum ada variasi → berarti tambah motif baru + variasinya
                    action = 'add_motif';
                } else {
                    // Kalau sudah ada → berarti update variasi
                    action = 'update_variasi';
                }

                $.ajax({
                    url: routeUrl + "/" + action,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Swal.fire('Sukses', res.message, 'success').then(() => {
                            $('#galeriModal').modal('hide');
                            table.ajax.reload();
                        });
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menyimpan data.', 'error');
                    }
                });
            });


            // Edit
            $('#galeriTable tbody').on('click', '.btnEdit', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: routeUrl + "/fetch_single",
                    type: "GET",
                    data: { id_variasi: id },
                    dataType: "json",
                    success: function (data) {
                        $('#id_variasi').val(data.id_variasi);
                        $('#nama_jenis').val(data.nama_jenis);
                        $('#nama_daerah').val(data.nama_daerah);
                        $('#nama_motif').val(data.nama_motif);
                        $('#cerita').val(data.cerita);
                        $('#ukuran').val(data.ukuran);
                        $('#bahan').val(data.bahan);
                        $('#jenis_pewarna').val(data.jenis_pewarna);
                        $('#harga').val(data.harga);
                        $('#stok').val(data.stok);
                        $('#galeriModal').modal('show');
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal mengambil data.', 'error');
                    }
                });
            });

            // Hapus
            $('#galeriTable tbody').on('click', '.btnDelete', function () {
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
                                Swal.fire('Sukses', res.message, 'success')
                                    .then(() => table.ajax.reload());
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>