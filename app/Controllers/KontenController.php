<?php
require_once __DIR__ . '/../Models/KontenModel.php';

class KontenController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new KontenModel($pdo);
    }

    public function handle($action)
    {
        if ($action === 'get') {
            $halaman = $_GET['halaman'] ?? 'beranda';
            $data = $this->model->getByHalaman($halaman);
            echo json_encode($data);
        }

        if ($action === 'update') {
            $halaman = $_POST['halaman'] ?? '';
            $konten = $_POST['konten'] ?? '[]';
            $kontenArray = json_decode($konten, true) ?: [];

            // proses upload file untuk halaman 'tentang_ina_ndao'
            if (!empty($_FILES) && $halaman === 'tentang_ina_ndao') {
                foreach ($_FILES as $key => $file) {
                    if ($file['error'] === UPLOAD_ERR_OK) {
                        $index = (int) str_replace('gambar_', '', $key);
                        $targetDir = __DIR__ . '/../../public/uploads/tentang/';
                        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

                        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $filename = uniqid('tentang_') . '.' . $ext;
                        $targetFile = $targetDir . $filename;

                        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                            $kontenArray[$index]['gambar'] = '/uploads/tentang/' . $filename;
                        }
                    }
                }
            }

            $ok = $this->model->updateKonten($halaman, $kontenArray);

            echo json_encode([
                'status' => $ok ? 'success' : 'error',
                'message' => $ok ? 'Konten berhasil disimpan.' : 'Gagal memperbarui konten.'
            ]);
        }

        // Tambahkan handler khusus untuk upload team foto
        if ($action === 'upload_team_foto') {
            $this->uploadTeamFoto();
        }
    }

    // Fungsi upload foto team
    private function uploadTeamFoto()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $targetDir = __DIR__ . '/../../public/uploads/team/';
            if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('team_') . '.' . $ext;
            $targetFile = $targetDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo json_encode(['filePath' => '/uploads/team/' . $filename]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Gagal upload file']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Tidak ada file diunggah']);
        }
    }
}
