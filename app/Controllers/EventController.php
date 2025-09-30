<?php
require_once __DIR__ . '/../Models/Event.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();

class EventController
{
    private $eventModel;

    public function __construct($pdo)
    {
        $this->eventModel = new Event($pdo);
        header('Content-Type: application/json');
    }

    public function handle($action)
    {
        try {
            switch ($action) {
                case 'fetch_all':
                    echo json_encode($this->eventModel->fetchAll());
                    break;

                case 'fetch_single':
                    $id = $_POST['id_event'] ?? 0;
                    echo json_encode($this->eventModel->fetchSingle($id));
                    break;

                case 'add':
                case 'edit':
                    $id = $_POST['id_event'] ?? '';
                    $data = [
                        'nama_event' => trim($_POST['nama_event'] ?? ''),
                        'tempat' => trim($_POST['tempat'] ?? ''),
                        'tanggal' => $_POST['tanggal'] ?? '',
                        'waktu' => $_POST['waktu'] ?? '',
                        'deskripsi' => trim($_POST['deskripsi'] ?? '')
                    ];

                    // Upload file
                    $banner = $this->uploadFile('gambar_banner');
                    $doc = $this->uploadFile('gambar_dokumentasi');

                    if ($action === 'add') {
                        $this->eventModel->add($data, $banner, $doc);
                        echo json_encode(['status' => 'success', 'message' => 'Event berhasil ditambahkan']);
                    } else {
                        $this->eventModel->update($id, $data, $banner, $doc);
                        echo json_encode(['status' => 'success', 'message' => 'Event berhasil diupdate']);
                    }
                    break;

                case 'delete':
                    $id = $_POST['id_event'];
                    $this->eventModel->delete($id);
                    echo json_encode(['status' => 'success', 'message' => 'Event berhasil dihapus']);
                    break;

                default:
                    echo json_encode(['status' => 'error', 'message' => 'Action tidak dikenal']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function uploadFile($field)
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['name'] != '') {
            $filename = time() . '_' . basename($_FILES[$field]['name']);
            move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . '/../../public/img/event/' . $filename);
            return $filename;
        }
        return null;
    }
}
