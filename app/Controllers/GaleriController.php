<?php
require_once __DIR__ . '/../Models/GaleriModel.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();

class GaleriController
{
    private $galeriModel;

    public function __construct($pdo)
    {
        $this->galeriModel = new Galeri($pdo);
        header('Content-Type: application/json');
    }

    // ============================
    // Handle request utama
    // ============================
    public function handle($action)
    {
        switch ($action) {
            case 'fetch_all':
                return $this->fetchAll();
            case 'add_motif':
                return $this->addMotif();
            case 'update_variasi':
                echo json_encode($this->updateVariasi());
                break;
            case 'delete_variasi':
                return $this->deleteVariasi();
            case 'fetch_single':
                return $this->fetchSingle();
            default:
                return ['status' => 'error', 'message' => 'Action tidak dikenali'];
        }
    }

    // ============================
    // Fetch all
    // ============================
    private function fetchAll()
    {
        return $this->galeriModel->fetchAll();
    }
    private function fetchSingle()
    {
        $id_variasi = $_POST['id_variasi'] ?? 0;
        return $this->galeriModel->fetchSingle($id_variasi) ?: [];
    }

    // ============================
    // Tambah motif + variasi + gambar
    // ============================

    private function addMotif()
    {
        $data = $this->sanitizeMotifInput($_POST);

        // validasi data
        $errors = $this->validateMotifData($data);
        if (!empty($errors)) {
            return ['status' => 'error', 'errors' => $errors];
        }

        // cek / buat jenis kain
        $jenis = $this->galeriModel->getJenisByName($data['jenis_kain']);
        $idJenisKain = $jenis ? $jenis['id_jenis_kain'] : $this->galeriModel->addJenisKain($data['jenis_kain']);

        // cek / buat daerah
        $daerah = $this->galeriModel->getDaerahByName($data['daerah']);
        $idDaerah = $daerah ? $daerah['id_daerah'] : $this->galeriModel->addDaerah($data['daerah']);

        // cek / buat kain
        $idKain = $this->galeriModel->getOrCreateKain($idJenisKain, $idDaerah);

        // cek / buat motif
        $motif = $this->galeriModel->getMotifByName($data['nama_motif']);
        if ($motif) {
            $idMotif = $motif['id_motif'];
        } else {
            $idMotif = $this->galeriModel->addMotif([
                'nama_motif' => $data['nama_motif'],
                'cerita' => $data['cerita']
            ]);
        }

        // cek / buat relasi kain_motif
        $kainMotif = $this->galeriModel->getKainMotif($idKain, $idMotif);
        $idKainMotif = $kainMotif ? $kainMotif['id_kain_motif'] : $this->galeriModel->addKainMotif($idKain, $idMotif);

        // tambah variasi
        $this->galeriModel->addVariasi([
            'id_kain_motif' => $idKainMotif,
            'ukuran' => $data['ukuran'],
            'bahan' => $data['bahan'],
            'jenis_pewarna' => $data['jenis_pewarna'],
            'harga' => $data['harga'],
            'stok' => $data['stok']
        ]);

        // upload multi gambar motif
        if (!empty($_FILES['gambar']['name'][0])) {
            $this->uploadMultiFiles($idMotif, $_FILES['gambar']);
        }

        return ['status' => 'success', 'message' => 'Motif berhasil ditambahkan'];
    }

    // ============================
    // Update variasi & motif
    // ============================
    private function updateVariasi()
    {
        $id_variasi = $_POST['id_variasi'] ?? null;
        if (!$id_variasi) {
            return ['status' => 'error', 'message' => 'ID variasi tidak ditemukan'];
        }

        $data = $this->sanitizeMotifInput($_POST);

        // update variasi
        $this->galeriModel->updateVariasi($id_variasi, $data);

        // update motif
        $idMotif = $_POST['id_motif'] ?? null;
        if ($idMotif) {
            $this->galeriModel->updateMotif($idMotif, [
                'nama_motif' => $data['nama_motif'],
                'cerita' => $data['cerita']
            ]);
        }

        // update gambar motif
        if (!empty($_FILES['gambar']['name'][0])) {
            $this->uploadMultiFiles($idMotif, $_FILES['gambar']);
        }

        return ['status' => 'success', 'message' => 'Variasi berhasil diperbarui'];
    }

    // ============================
    // Delete variasi + motif
    // ============================
    private function deleteVariasi()
    {
        $idMotif = $_POST['id_motif'] ?? null;
        $idKainMotif = $_POST['id_kain_motif'] ?? null;

        if (!$idMotif || !$idKainMotif) {
            return ['status' => 'error', 'message' => 'Data tidak lengkap'];
        }

        // hapus variasi
        $this->galeriModel->deleteVariasiByKainMotif($idKainMotif);

        // hapus semua gambar motif
        $this->galeriModel->deleteAllMotifGambar($idMotif);

        // hapus motif
        $this->galeriModel->deleteMotif($idMotif);

        return ['status' => 'success', 'message' => 'Motif & variasi berhasil dihapus'];
    }

    // ============================
    // Upload multi file
    // ============================
    private function uploadMultiFiles($idMotif, $files)
    {
        $uploadDir = __DIR__ . '/../../public/img/motif/';
        $baseUrl = '/img/motif/'; // URL relatif ke folder public

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . basename($files['name'][$i]);
                move_uploaded_file($files['tmp_name'][$i], $uploadDir . $fileName);

                // Simpan URL lengkap ke database
                $fileUrl = $baseUrl . $fileName;
                $this->galeriModel->addMotifGambar($idMotif, $fileUrl);
            }
        }
    }


    // ============================
    // Sanitasi & validasi
    // ============================
    private function sanitizeMotifInput($data)
    {
        return [
            'nama_motif' => ucwords(strtolower(trim($data['nama_motif'] ?? ''))),
            'cerita' => trim($data['cerita'] ?? ''),
            'jenis_kain' => ucwords(strtolower(trim($data['jenis_kain'] ?? ''))),
            'daerah' => ucwords(strtolower(trim($data['daerah'] ?? ''))),
            'ukuran' => trim($data['ukuran'] ?? ''),
            'bahan' => trim($data['bahan'] ?? ''),
            'jenis_pewarna' => trim($data['jenis_pewarna'] ?? ''),
            'harga' => $data['harga'] ?? 0,
            'stok' => $data['stok'] ?? 0
        ];
    }

    private function validateMotifData($data)
    {
        $errors = [];
        if (empty($data['nama_motif']))
            $errors[] = 'Nama motif wajib diisi';
        if (empty($data['jenis_kain']))
            $errors[] = 'Jenis kain wajib diisi';
        if (empty($data['daerah']))
            $errors[] = 'Daerah wajib diisi';
        if (empty($data['ukuran']))
            $errors[] = 'Ukuran wajib diisi';
        if (empty($data['harga']) || !is_numeric($data['harga']))
            $errors[] = 'Harga tidak valid';
        return $errors;
    }
}
