<?php
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/EventDokumentasi.php';

class EventController
{
    private $eventModel;
    private $docModel;

    public function __construct(PDO $pdo)
    {
        $this->eventModel = new Event($pdo);
        $this->docModel   = new EventDokumentasi($pdo);

        header('Content-Type: application/json');
    }

    /** Router Handler */
    public function handle($action, $param = null)
    {
        try {
            switch ($action) {
                case 'create':
                    $this->create();
                    break;

                case 'index':
                    $this->index();
                    break;

                case 'update':
                    $id = $_POST['id_event'] ?? null;
                    if (!$id) {
                        echo json_encode(['status' => 'error', 'message' => 'ID event tidak ditemukan']);
                        return;
                    }
                    $this->update($id);
                    break;

                case 'delete':
                    $id = $_POST['id_event'] ?? null;
                    if (!$id) {
                        echo json_encode(['status' => 'error', 'message' => 'ID event tidak ditemukan']);
                        return;
                    }
                    $this->delete($id);
                    break;

                case 'add_dokumentasi':
                    $id = $_POST['id_event'] ?? null;
                    if (!$id) {
                        echo json_encode(['status' => 'error', 'message' => 'ID event tidak ditemukan']);
                        return;
                    }
                    $this->addDokumentasi($id);
                    break;

                case 'delete_dokumentasi':
                    $id_event       = $_POST['id_event'] ?? null;
                    $id_dokumentasi = $_POST['id_dokumentasi'] ?? null;
                    if (!$id_event || !$id_dokumentasi) {
                        echo json_encode(['status' => 'error', 'message' => 'ID event / dokumentasi tidak ditemukan']);
                        return;
                    }
                    $this->deleteDokumentasi($id_event, $id_dokumentasi);
                    break;

                case 'fetch_paginated':
                    $this->fetch_paginated();
                    break;

                case 'fetch_single':
                    $this->fetch_single();
                    break;

                case 'delete_multiple_dokumentasi':
                    $ids = $_POST['id_dokumentasi'] ?? [];
                    if (!is_array($ids) || empty($ids)) {
                        echo json_encode(['status' => 'error', 'message' => 'Tidak ada dokumentasi yang dipilih']);
                        return;
                    }
                    $this->deleteMultipleDokumentasi($ids);
                    break;

                case 'detail':
                    if (!$param) {
                        echo json_encode(['status' => 'error', 'message' => 'Parameter tidak ditemukan']);
                        return;
                    }
                    $this->detail($param);
                    break;

                case 'search':
                    $this->search();
                    break;

                default:
                    http_response_code(404);
                    echo json_encode(['status' => 'error', 'message' => 'Action tidak ditemukan']);
                    break;
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 1. Tambah Event Baru */
    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'nama_event' => $_POST['nama_event'],
                    'tempat'     => $_POST['tempat'],
                    'tanggal'    => $_POST['tanggal'],
                    'waktu'      => $_POST['waktu'],
                    'deskripsi'  => $_POST['deskripsi']
                ];

                // Upload banner
                $bannerFile = null;
                if (!empty($_FILES['gambar_banner']['name'])) {
                    $bannerFile = time() . "_" . basename($_FILES['gambar_banner']['name']);
                    move_uploaded_file(
                        $_FILES['gambar_banner']['tmp_name'],
                        __DIR__ . "/../../public/img/event/" . $bannerFile
                    );
                }

                $eventId = $this->eventModel->add($data, $bannerFile);

                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Event berhasil ditambahkan',
                    'id'      => $eventId
                ]);
                return;
            }
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 2. Tampilkan Semua Event */
    public function index()
    {
        try {
            // Ambil event mendatang + dokumentasi
            $upcoming = $this->eventModel->fetchUpcomingWithDocs();

            // Ambil event yang telah berlalu + dokumentasi
            $past = $this->eventModel->fetchPastWithDocs();

            echo json_encode([
                'status' => 'success',
                'upcoming' => $upcoming, // Event yang akan datang
                'past'     => $past      // Event yang sudah selesai
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 3. Update Event */
    public function update($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'nama_event' => $_POST['nama_event'],
                    'tempat'     => $_POST['tempat'],
                    'tanggal'    => $_POST['tanggal'],
                    'waktu'      => $_POST['waktu'],
                    'deskripsi'  => $_POST['deskripsi']
                ];

                $bannerFile = null;
                if (!empty($_FILES['gambar_banner']['name'])) {
                    $bannerFile = time() . "_" . basename($_FILES['gambar_banner']['name']);
                    move_uploaded_file(
                        $_FILES['gambar_banner']['tmp_name'],
                        __DIR__ . "/../../public/img/event/" . $bannerFile
                    );
                }

                // Upload dokumentasi baru
                $docFiles = [];
                if (!empty($_FILES['dokumentasi']['name'][0])) {
                    foreach ($_FILES['dokumentasi']['name'] as $i => $name) {
                        $fileName = time() . "_" . basename($name);
                        move_uploaded_file(
                            $_FILES['dokumentasi']['tmp_name'][$i],
                            __DIR__ . "/../../public/img/event/" . $fileName
                        );
                        $docFiles[] = $fileName;
                    }
                }

                $this->eventModel->update($id, $data, $bannerFile, $docFiles);

                echo json_encode([
                    'status'  => 'success',
                    'message' => 'Event berhasil diupdate'
                ]);
                return;
            }
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 4. Detail Event */
    public function detail($idOrSlug)
    {
        try {
            // Bisa ambil berdasarkan slug atau id_event
            $event = $this->eventModel->findBySlugOrId($idOrSlug);

            if (!$event) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Event tidak ditemukan'
                ]);
                return;
            }

            // Ambil dokumentasi event terkait
            $docs = $this->docModel->getByEventId($event['id_event']);

            echo json_encode([
                'status' => 'success',
                'event'  => $event,
                'dokumentasi' => $docs
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /** 4. Hapus Event */
    public function delete($id)
    {
        try {
            $this->eventModel->delete($id);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Event berhasil dihapus'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 5. Tambah Dokumentasi */
    public function addDokumentasi($id_event = null)
    {
        try {
            // ID event dari form (hidden input)
            $id_event = $_POST['id_event'] ?? $id_event;

            if (!$id_event) {
                echo json_encode(['status' => 'error', 'message' => 'ID event tidak ditemukan']);
                return;
            }

            $uploadedFiles = [];
            $uploadDir = __DIR__ . '/../../public/img/event/';

            // Pastikan folder ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!empty($_FILES['gambar_dokumentasi']['name'][0])) {
                foreach ($_FILES['gambar_dokumentasi']['tmp_name'] as $key => $tmpName) {
                    $originalName = $_FILES['gambar_dokumentasi']['name'][$key];
                    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                    $newName = uniqid("doc_") . "." . $ext;
                    $targetPath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedFiles[] = $newName;
                    }
                }
            }

            // Simpan ke DB
            if (!empty($uploadedFiles)) {
                $this->eventModel->addDokumentasi($id_event, $uploadedFiles);
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Dokumentasi berhasil ditambahkan',
                'files'  => $uploadedFiles
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 6. Hapus Dokumentasi */
    public function deleteDokumentasi($id_event, $id_dokumentasi)
    {
        try {
            $this->docModel->delete($id_dokumentasi);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Dokumentasi berhasil dihapus'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 7. Fetch Event dengan Pagination */
    public function fetch_paginated()
    {
        try {
            $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
            $offset = ($page - 1) * $limit;

            $events = $this->eventModel->fetchPaginated($limit, $offset);
            $total  = $this->eventModel->countAll();
            $totalPages = ceil($total / $limit);

            echo json_encode([
                'status'      => 'success',
                'data'        => $events,
                'page'        => $page,
                'total_pages' => $totalPages
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 8. Fetch Single Event + Dokumentasi */
    public function fetch_single()
    {
        try {
            $id = $_POST['id_event'] ?? null;
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
                return;
            }

            $event = $this->eventModel->findById($id);
            $docs  = $this->eventModel->getDokumentasi($id);

            if (!$event) {
                echo json_encode(['status' => 'error', 'message' => 'Event tidak ditemukan']);
                return;
            }

            $event['dokumentasi'] = $docs;

            echo json_encode([
                'status' => 'success',
                'data'   => $event
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** Hapus banyak dokumentasi sekaligus */
    public function deleteMultipleDokumentasi($ids = [])
    {
        try {
            if (empty($ids)) {
                echo json_encode(['status' => 'error', 'message' => 'Tidak ada dokumentasi terpilih']);
                return;
            }

            // Ambil file fisik dari model
            $files = $this->docModel->getFilesByIds($ids);

            // Hapus file fisik
            foreach ($files as $row) {
                $file = __DIR__ . "/../../public/img/event/" . $row['gambar_dokumentasi'];
                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            // Hapus di DB via model
            $this->docModel->deleteMultiple($ids);

            echo json_encode([
                'status' => 'success',
                'message' => count($ids) . " dokumentasi berhasil dihapus"
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /** 🔍 Pencarian Event berdasarkan nama_event */
    public function search()
    {
        try {
            $keyword = $_GET['keyword'] ?? '';

            $results = $this->eventModel->searchByName($keyword);

            echo json_encode([
                'status' => 'success',
                'data'   => $results
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
