<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Event - Ina Ndao</title>
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
        <h2>Kelola Event</h2>
        <button class="btn btn-primary mb-3" id="btnAdd">Tambah Event</button>

        <table class="table table-bordered table-striped" id="eventTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Event</th>
                    <th>Tempat</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Deskripsi</th>
                    <th>Banner</th>
                    <th>Dokumentasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan di-load via AJAX -->
            </tbody>
        </table>

        <?php include "footer.php" ?>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="eventForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_event" id="id_event">
                    <div class="mb-3"><label>Nama Event</label><input type="text" class="form-control" name="nama_event" id="nama_event" required></div>
                    <div class="mb-3"><label>Tempat</label><input type="text" class="form-control" name="tempat" id="tempat" required></div>
                    <div class="mb-3"><label>Tanggal</label><input type="date" class="form-control" name="tanggal" id="tanggal" required></div>
                    <div class="mb-3"><label>Waktu</label><input type="time" class="form-control" name="waktu" id="waktu" required></div>
                    <div class="mb-3"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required></textarea></div>
                    <div class="mb-3"><label>Gambar Banner</label><input type="file" class="form-control" name="gambar_banner" id="gambar_banner"></div>
                    <div class="mb-3"><label>Gambar Dokumentasi</label><input type="file" class="form-control" name="gambar_dokumentasi" id="gambar_dokumentasi"></div>
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
        $(document).ready(function() {
            // base route → arahkan ke front controller (index.php di public)
            var routeUrl = "/event";

            var table = $('#eventTable').DataTable({
                "ajax": {
                    "url": routeUrl + "/fetch_all",
                    "type": "GET",
                    "dataType": "json", // otomatis parse JSON
                    "dataSrc": function(json) {
                        if (Array.isArray(json)) {
                            return json;
                        }
                        if (json.data) {
                            return json.data;
                        }
                        return [];
                    },
                    "error": function() {
                        Swal.fire('Error', 'Gagal memuat data dari server.', 'error');
                    }
                },
                "scrollX": true,
                "responsive": true,
                "autoWidth": false,
                "columns": [{
                        "data": "id_event"
                    },
                    {
                        "data": "nama_event"
                    },
                    {
                        "data": "tempat"
                    },
                    {
                        "data": "tanggal"
                    },
                    {
                        "data": "waktu"
                    },
                    {
                        "data": "deskripsi",
                        "render": function(data) {
                            if (!data) return "";
                            return data.length > 50 ? data.substr(0, 50) + '...' : data;
                        }
                    },
                    {
                        "data": "gambar_banner",
                        "render": function(data) {
                            return data ? "<img src='../img/event/" + data + "' width='80'>" : "";
                        }
                    },
                    {
                        "data": "gambar_dokumentasi",
                        "render": function(data) {
                            return data ? "<img src='../img/event/" + data + "' width='80'>" : "";
                        }
                    },
                    {
                        "data": "id_event",
                        "render": function(data) {
                            return `
                        <button class="btn btn-warning btn-sm btnEdit" data-id="${data}">Edit</button>
                        <button class="btn btn-danger btn-sm btnDelete" data-id="${data}">Hapus</button>
                    `;
                        }
                    }
                ]
            });

            // Tambah Event
            $('#btnAdd').click(function() {
                $('#eventForm')[0].reset();
                $('#id_event').val('');
                $('#eventModal').modal('show');
            });

            // Submit Form (Add/Edit)
            $('#eventForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var action = $('#id_event').val() === '' ? 'add' : 'edit';

                $.ajax({
                    url: routeUrl + "/" + action,
                    type: "POST",
                    data: formData,
                    dataType: "json", // otomatis parse JSON
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.fire('Sukses', res.message, 'success').then(() => {
                            $('#eventModal').modal('hide');
                            table.ajax.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menyimpan data.', 'error');
                    }
                });
            });

            // Edit Event
            $('#eventTable tbody').on('click', '.btnEdit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: routeUrl + "/fetch_single",
                    type: "GET",
                    data: {
                        id_event: id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#id_event').val(data.id_event);
                        $('#nama_event').val(data.nama_event);
                        $('#tempat').val(data.tempat);
                        $('#tanggal').val(data.tanggal);
                        $('#waktu').val(data.waktu);
                        $('#deskripsi').val(data.deskripsi);
                        $('#eventModal').modal('show');
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengambil data event.', 'error');
                    }
                });
            });

            // Hapus Event
            $('#eventTable tbody').on('click', '.btnDelete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: routeUrl + "/delete",
                            type: "POST",
                            data: {
                                id_event: id
                            },
                            dataType: "json",
                            success: function(res) {
                                Swal.fire('Sukses', res.message, 'success')
                                    .then(() => table.ajax.reload());
                            },
                            error: function() {
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