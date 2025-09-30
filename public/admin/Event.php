<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();

// Handle AJAX Request
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add' || $action == 'edit') {
        $id = $_POST['id_event'] ?? '';
        $nama = $_POST['nama_event'];
        $tempat = $_POST['tempat'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];
        $deskripsi = $_POST['deskripsi'];

        // Upload gambar banner
        $banner = '';
        if (isset($_FILES['gambar_banner']) && $_FILES['gambar_banner']['name'] != '') {
            $banner = time() . '_' . $_FILES['gambar_banner']['name'];
            move_uploaded_file($_FILES['gambar_banner']['tmp_name'], "../img/event/" . $banner);
        }

        // Upload gambar dokumentasi
        $dokumentasi = '';
        if (isset($_FILES['gambar_dokumentasi']) && $_FILES['gambar_dokumentasi']['name'] != '') {
            $dokumentasi = time() . '_' . $_FILES['gambar_dokumentasi']['name'];
            move_uploaded_file($_FILES['gambar_dokumentasi']['tmp_name'], "../img/event/" . $dokumentasi);
        }

        if ($action == 'add') {
            $stmt = $pdo->prepare("INSERT INTO event (nama_event,tempat,tanggal,waktu,deskripsi,gambar_banner,gambar_dokumentasi) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$nama, $tempat, $tanggal, $waktu, $deskripsi, $banner, $dokumentasi]);
            echo json_encode(['status' => 'success', 'message' => 'Event berhasil ditambahkan']);
        } else {
            // Ambil gambar lama jika tidak ada upload baru
            $stmt0 = $pdo->prepare("SELECT gambar_banner, gambar_dokumentasi FROM event WHERE id_event=?");
            $stmt0->execute([$id]);
            $row = $stmt0->fetch(PDO::FETCH_ASSOC);

            if ($banner == '') $banner = $row['gambar_banner'];
            if ($dokumentasi == '') $dokumentasi = $row['gambar_dokumentasi'];

            $stmt = $pdo->prepare("UPDATE event SET nama_event=?, tempat=?, tanggal=?, waktu=?, deskripsi=?, gambar_banner=?, gambar_dokumentasi=? WHERE id_event=?");
            $stmt->execute([$nama, $tempat, $tanggal, $waktu, $deskripsi, $banner, $dokumentasi, $id]);
            echo json_encode(['status' => 'success', 'message' => 'Event berhasil diupdate']);
        }
        exit;
    }

    // Hapus Event
    if ($action == 'delete') {
        $id = $_POST['id_event'];
        $stmt0 = $pdo->prepare("SELECT gambar_banner, gambar_dokumentasi FROM event WHERE id_event=?");
        $stmt0->execute([$id]);
        $row = $stmt0->fetch(PDO::FETCH_ASSOC);

        if ($row['gambar_banner']) unlink("../img/event/" . $row['gambar_banner']);
        if ($row['gambar_dokumentasi']) unlink("../img/event/" . $row['gambar_dokumentasi']);

        $stmt = $pdo->prepare("DELETE FROM event WHERE id_event=?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success', 'message' => 'Event berhasil dihapus']);
        exit;
    }

    // Fetch single event
    if ($action == 'fetch_single') {
        $id = $_POST['id_event'];
        $stmt = $pdo->prepare("SELECT * FROM event WHERE id_event=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
        exit;
    }
}
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
                <?php
                $events = $pdo->query("SELECT * FROM event ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($events as $row):
                ?>
                    <tr>
                        <td><?= $row['id_event'] ?></td>
                        <td><?= $row['nama_event'] ?></td>
                        <td><?= $row['tempat'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['waktu'] ?></td>
                        <td><?= substr($row['deskripsi'], 0, 50) ?>...</td>
                        <td><?php if ($row['gambar_banner']) echo "<img src='../img/event/" . $row['gambar_banner'] . "' width='80'>"; ?></td>
                        <td><?php if ($row['gambar_dokumentasi']) echo "<img src='../img/event/" . $row['gambar_dokumentasi'] . "' width='80'>"; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEdit" data-id="<?= $row['id_event'] ?>">Edit</button>
                            <button class="btn btn-danger btn-sm btnDelete" data-id="<?= $row['id_event'] ?>">Hapus</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#eventTable').DataTable();

            // Tambah
            $('#btnAdd').on('click', function() {
                $('#eventForm')[0].reset();
                $('#id_event').val('');
                $('#eventModal').modal('show');
            });

            // Edit
            $('.btnEdit').on('click', function() {
                var id = $(this).data('id');
                $.post('event.php', {
                    action: 'fetch_single',
                    id_event: id
                }, function(data) {
                    data = JSON.parse(data);
                    $('#id_event').val(data.id_event);
                    $('#nama_event').val(data.nama_event);
                    $('#tempat').val(data.tempat);
                    $('#tanggal').val(data.tanggal);
                    $('#waktu').val(data.waktu);
                    $('#deskripsi').val(data.deskripsi);
                    $('#eventModal').modal('show');
                });
            });

            // Hapus
            $('.btnDelete').on('click', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('event.php', {
                            action: 'delete',
                            id_event: id
                        }, function(res) {
                            res = JSON.parse(res);
                            Swal.fire('Sukses', res.message, 'success').then(() => {
                                location.reload();
                            });
                        });
                    }
                });
            });

            // Submit Form
            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', $('#id_event').val() == '' ? 'add' : 'edit');

                $.ajax({
                    url: 'event.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        // Tampilkan dulu di console
                        console.log("Response mentah dari server:", res);

                        try {
                            res = JSON.parse(res); // baru di-parse
                            Swal.fire('Sukses', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } catch (err) {
                            console.error("JSON.parse gagal:", err);
                            Swal.fire('Error', 'Server tidak merespons JSON valid. Cek console untuk detail.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", status, error);
                        Swal.fire('Error', 'Terjadi kesalahan server. Cek console untuk detail.', 'error');
                    }
                });
            });
        });
    </script>

</body>

</html>