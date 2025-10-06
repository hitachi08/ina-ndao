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
            case 'get_options':
                return $this->getOptions();
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
        $requiredFields = ['nama_motif', 'nama_jenis', 'nama_daerah', 'ukuran', 'panjang', 'lebar'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo json_encode(['status' => 'error', 'message' => "Field '$field' wajib diisi"]);
                exit;
            }
        }

        $id_variasi = $_POST['id_variasi'] ?? null;
        if (!$id_variasi) {
            echo json_encode(['status' => 'error', 'message' => 'ID variasi tidak ditemukan']);
            exit;
        }

        $data = $this->sanitizeMotifInput($_POST);

        // Ambil data variasi_motif
        $variasi = $this->galeriModel->getVariasiById($id_variasi);
        if (!$variasi) {
            echo json_encode(['status' => 'error', 'message' => 'Variasi tidak ditemukan']);
            exit;
        }

        $id_kain_motif = $variasi['id_kain_motif'];

        // Ambil id_kain dan id_motif dari tabel kain_motif
        $kainMotif = $this->galeriModel->getKainMotifById($id_kain_motif);
        if (!$kainMotif) {
            echo json_encode(['status' => 'error', 'message' => 'Data kain_motif tidak ditemukan']);
            exit;
        }
        $id_kain = $kainMotif['id_kain'] ?? null;
        $id_motif = $kainMotif['id_motif'] ?? null;

        // Update variasi_motif
        $this->galeriModel->updateVariasi($id_variasi, $data);

        // Update motif
        if ($id_motif) {
            $this->galeriModel->updateMotif($id_motif, [
                'nama_motif' => $data['nama_motif'],
                'cerita' => $data['cerita']
            ]);
        }

        // Update jenis_kain
        if (!empty($data['jenis_kain']) && $id_kain) {
            $idJenis = $this->galeriModel->getOrCreateJenisKain($data['jenis_kain']);
            $this->galeriModel->updateKainJenis($id_kain, $idJenis);
        }

        // Update daerah
        if (!empty($data['daerah']) && $id_kain) {
            $idDaerah = $this->galeriModel->getOrCreateDaerah($data['daerah']);
            $this->galeriModel->updateKainDaerah($id_kain, $idDaerah);
        }

        // Upload gambar motif
        if (!empty($_FILES['gambar']['name'][0])) {
            $this->uploadMultiFiles($id_motif, $_FILES['gambar']);
        }

        echo json_encode(['status' => 'success', 'message' => 'Variasi berhasil diperbarui']);
        exit;
    }


    // ============================
    // Delete variasi + motif
    // ============================
    private function deleteVariasi()
    {
        $idVariasi = $_POST['id_variasi'] ?? null;

        if (!$idVariasi) {
            echo json_encode(['status' => 'error', 'message' => 'ID variasi tidak ditemukan']);
            exit;
        }

        // Ambil data variasi untuk tahu id_kain_motif
        $variasi = $this->galeriModel->getVariasiById($idVariasi);
        if (!$variasi) {
            echo json_encode(['status' => 'error', 'message' => 'Variasi tidak ditemukan']);
            exit;
        }

        $idKainMotif = $variasi['id_kain_motif'];

        // Ambil data kain_motif untuk tahu id_motif
        $kainMotif = $this->galeriModel->getKainMotifById($idKainMotif);
        if (!$kainMotif) {
            echo json_encode(['status' => 'error', 'message' => 'Data kain motif tidak ditemukan']);
            exit;
        }

        $idMotif = $kainMotif['id_motif'];

        // Hapus variasi
        $this->galeriModel->deleteVariasiByKainMotif($idKainMotif);

        // Hapus semua gambar motif
        $this->galeriModel->deleteAllMotifGambar($idMotif);

        // Hapus motif
        $this->galeriModel->deleteMotif($idMotif);

        echo json_encode(['status' => 'success', 'message' => 'Motif & variasi berhasil dihapus']);
        exit;
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
        // Sanitasi awal (bersihkan dan ubah format huruf)
        $result = [
            'nama_motif' => ucwords(strtolower(trim($data['nama_motif'] ?? ''))),
            'cerita' => trim($data['cerita'] ?? ''),
            'jenis_kain' => ucwords(strtolower(trim($data['jenis_kain'] ?? ''))),
            'daerah' => ucwords(strtolower(trim($data['daerah'] ?? ''))),
            'ukuran' => trim($data['ukuran'] ?? ''),
            'bahan' => ucwords(strtolower(trim($data['bahan'] ?? ''))),
            'jenis_pewarna' => ucwords(strtolower(trim($data['jenis_pewarna'] ?? ''))),
            'harga' => trim($data['harga'] ?? 0),
            'stok' => trim($data['stok'] ?? 0),
        ];

        // ==== VALIDASI FORMAT ====

        // 1️⃣ Field yang hanya boleh huruf dan spasi (tanpa angka/simbol)
        $alphaOnlyFields = ['nama_motif', 'jenis_kain', 'daerah'];
        foreach ($alphaOnlyFields as $field) {
            if (!preg_match('/^[a-zA-Z\s]+$/u', $result[$field])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' hanya boleh berisi huruf dan spasi (tanpa angka atau simbol).'
                ]);
                exit;
            }
        }

        // 2️⃣ Field yang tidak boleh ada angka (bahan & jenis pewarna)
        $noNumberFields = ['bahan', 'jenis_pewarna'];
        foreach ($noNumberFields as $field) {
            if (preg_match('/\d/', $result[$field])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => ucfirst(str_replace('_', ' ', $field)) . ' tidak boleh mengandung angka.'
                ]);
                exit;
            }
        }

        // 3️⃣ Harga & stok harus angka positif
        if (!is_numeric($result['harga']) || $result['harga'] < 0) {
            echo json_encode(['status' => 'error', 'message' => 'Harga harus berupa angka positif.']);
            exit;
        }

        if (!is_numeric($result['stok']) || $result['stok'] < 0) {
            echo json_encode(['status' => 'error', 'message' => 'Stok harus berupa angka positif.']);
            exit;
        }

        // 4️⃣ Validasi format ukuran (misal: "100x50")
        if (!empty($result['ukuran']) && !preg_match('/^\d+\s*[xX]\s*\d+$/', $result['ukuran'])) {
            echo json_encode(['status' => 'error', 'message' => 'Format ukuran tidak valid. Gunakan format contoh: 100x50.']);
            exit;
        }

        return $result;
    }


    public function getOptions()
    {
        $jenis = $this->galeriModel->getAllJenisKain();
        $daerah = $this->galeriModel->getAllDaerah();
        $motif = $this->galeriModel->getAllMotif();

        echo json_encode([
            'status' => 'success',
            'jenis' => $jenis,
            'daerah' => $daerah,
            'motif' => $motif
        ]);
        exit;
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
