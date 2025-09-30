<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Event.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();

$eventModel = new Event($pdo);

header('Content-Type: application/json');

try {
    $action = $_POST['action'] ?? '';

    if ($action == 'add' || $action == 'edit') {
        $id = $_POST['id_event'] ?? '';
        $nama = $_POST['nama_event'];
        $tempat = $_POST['tempat'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];
        $deskripsi = $_POST['deskripsi'];

        // Upload files
        $banner = '';
        if (isset($_FILES['gambar_banner']) && $_FILES['gambar_banner']['name'] != '') {
            $banner = time() . '_' . $_FILES['gambar_banner']['name'];
            move_uploaded_file($_FILES['gambar_banner']['tmp_name'], "../img/event/" . $banner);
        }

        $doc = '';
        if (isset($_FILES['gambar_dokumentasi']) && $_FILES['gambar_dokumentasi']['name'] != '') {
            $doc = time() . '_' . $_FILES['gambar_dokumentasi']['name'];
            move_uploaded_file($_FILES['gambar_dokumentasi']['tmp_name'], "../img/event/" . $doc);
        }

        if ($action == 'add') {
            $eventModel->add($_POST, $banner, $doc);
            echo json_encode(['status' => 'success', 'message' => 'Event berhasil ditambahkan']);
        } else {
            $eventModel->update($id, $_POST, $banner, $doc);
            echo json_encode(['status' => 'success', 'message' => 'Event berhasil diupdate']);
        }
        exit;
    }

    if ($action == 'delete') {
        $id = $_POST['id_event'];
        $eventModel->delete($id);
        echo json_encode(['status' => 'success', 'message' => 'Event berhasil dihapus']);
        exit;
    }

    if ($action == 'fetch_single') {
        $id = $_POST['id_event'];
        $row = $eventModel->fetchSingle($id);
        echo json_encode($row);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
