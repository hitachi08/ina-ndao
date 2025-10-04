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

    public function handle($action)
    {
        try {
            switch ($action) {

                // ============================
                // Fetch data
                // ============================
                case 'fetch_all':
                    echo json_encode($this->galeriModel->fetchAll());
                    break;

                case 'fetch_single':
                    $id = $_POST['id_variasi'] ?? 0;
                    echo json_encode($this->galeriModel->fetchSingle($id));
                    break;

                // ============================
                // Tambah Motif + Variasi
                // ============================
                case 'add_motif':
                    $data = $this->sanitizeMotifInput($_POST);

                    // Validasi semua field
                    $valid = $this->validateMotifData($data);
                    if (!$valid['status']) {
                        echo json_encode(['status' => 'error', 'message' => $valid['message']]);
                        exit;
                    }

                    // Jenis kain
                    $jenis = $this->galeriModel->getJenisByName($data['nama_jenis']);
                    $idJenisKain = $jenis ? $jenis['id_jenis_kain'] : $this->galeriModel->addJenisKain($data['nama_jenis']);

                    // Daerah
                    $daerah = $this->galeriModel->getDaerahByName($data['nama_daerah']);
                    $idDaerah = $daerah ? $daerah['id_daerah'] : $this->galeriModel->addDaerah($data['nama_daerah']);

                    // Kain
                    $idKain = $this->galeriModel->getOrCreateKain($idJenisKain, $idDaerah);

                    // Motif
                    $dataMotif = [
                        'id_kain' => $idKain,
                        'nama_motif' => $data['nama_motif'],
                        'cerita' => $data['cerita']
                    ];
                    $gambar = $this->uploadFile('gambar');
                    $idMotif = $this->galeriModel->addMotif($dataMotif, $gambar);

                    // Variasi
                    $ukuran = $data['panjang'] . "x" . $data['lebar'] . " cm";
                    $dataVariasi = [
                        'id_motif' => $idMotif,
                        'ukuran' => $ukuran,
                        'bahan' => $data['bahan'],
                        'jenis_pewarna' => $data['jenis_pewarna'],
                        'harga' => $data['harga'],
                        'stok' => $data['stok']
                    ];
                    $this->galeriModel->addVariasi($dataVariasi);

                    echo json_encode(['status' => 'success', 'message' => 'Motif dan variasi berhasil ditambahkan']);
                    break;

                // ============================
                // Update Variasi
                // ============================
                case 'update_variasi':
                    $idVariasi = $_POST['id_variasi'] ?? 0;
                    $data = $this->sanitizeMotifInput($_POST);

                    // Validasi semua field
                    $valid = $this->validateMotifData($data, true); // true = update
                    if (!$valid['status']) {
                        echo json_encode(['status' => 'error', 'message' => $valid['message']]);
                        exit;
                    }

                    $ukuran = $data['panjang'] . "x" . $data['lebar'] . " cm";
                    $dataUpdate = [
                        'ukuran' => $ukuran,
                        'bahan' => $data['bahan'],
                        'jenis_pewarna' => $data['jenis_pewarna'],
                        'harga' => $data['harga'],
                        'stok' => $data['stok']
                    ];
                    $this->galeriModel->updateVariasi($idVariasi, $dataUpdate);

                    echo json_encode(['status' => 'success', 'message' => 'Variasi berhasil diperbarui']);
                    break;

                // ============================
                // Delete Variasi
                // ============================
                case 'delete_variasi':
                    $idVariasi = $_POST['id_variasi'] ?? 0;
                    if ($idVariasi <= 0) {
                        echo json_encode(['status' => 'error', 'message' => 'ID variasi tidak valid']);
                        exit;
                    }
                    $this->galeriModel->deleteVariasi($idVariasi);
                    echo json_encode(['status' => 'success', 'message' => 'Variasi berhasil dihapus']);
                    break;

                default:
                    echo json_encode(['status' => 'error', 'message' => 'Action tidak dikenal']);
                    break;
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // ============================
    // Sanitasi input
    // ============================
    private function sanitizeMotifInput($input)
    {
        $data = [];
        $data['nama_jenis'] = $this->capitalizeWords($input['nama_jenis'] ?? '');
        $data['nama_daerah'] = $this->capitalizeWords($input['nama_daerah'] ?? '');
        $data['nama_motif'] = $this->capitalizeWords($input['nama_motif'] ?? '');
        $data['cerita'] = trim($input['cerita'] ?? '');
        $data['bahan'] = $this->capitalizeWords($input['bahan'] ?? '');
        $data['jenis_pewarna'] = $this->capitalizeWords($input['jenis_pewarna'] ?? '');
        $data['harga'] = isset($input['harga']) ? intval($input['harga']) : 0;
        $data['stok'] = isset($input['stok']) ? intval($input['stok']) : 0;
        $data['panjang'] = isset($input['panjang']) ? intval($input['panjang']) : 0;
        $data['lebar'] = isset($input['lebar']) ? intval($input['lebar']) : 0;
        return $data;
    }

    // ============================
    // Validasi input
    // ============================
    private function validateMotifData($data, $isUpdate = false)
    {
        $fields = [
            'nama_jenis' => 'Jenis Kain',
            'nama_daerah' => 'Daerah',
            'nama_motif' => 'Nama Motif',
            'bahan' => 'Bahan',
            'jenis_pewarna' => 'Jenis Pewarna',
            'harga' => 'Harga',
            'stok' => 'Stok',
            'panjang' => 'Panjang',
            'lebar' => 'Lebar'
        ];

        foreach ($fields as $key => $label) {
            if (!isset($data[$key]) || $data[$key] === '' || $data[$key] === 0) {
                if ($key === 'harga' && $isUpdate)
                    continue; // boleh 0 jika update tapi di form pasti >=0
                return ['status' => false, 'message' => "$label wajib diisi dan valid"];
            }
        }

        if (!is_numeric($data['harga']) || $data['harga'] <= 0) {
            return ['status' => false, 'message' => "Harga harus angka dan > 0"];
        }
        if (!is_numeric($data['stok']) || $data['stok'] < 0) {
            return ['status' => false, 'message' => "Stok harus angka dan ≥ 0"];
        }
        if (!is_numeric($data['panjang']) || $data['panjang'] <= 0 || !is_numeric($data['lebar']) || $data['lebar'] <= 0) {
            return ['status' => false, 'message' => "Panjang dan lebar harus > 0"];
        }

        return ['status' => true, 'message' => 'Valid'];
    }

    // ============================
    // Upload gambar
    // ============================
    private function uploadFile($field)
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['name'] != '') {
            $filename = time() . '_' . basename($_FILES[$field]['name']);
            $targetDir = __DIR__ . '/../../public/img/motif/';
            if (!is_dir($targetDir))
                mkdir($targetDir, 0777, true);
            move_uploaded_file($_FILES[$field]['tmp_name'], $targetDir . $filename);
            return $filename;
        }
        return null;
    }

    // ============================
    // Kapitalisasi awal kata
    // ============================
    private function capitalizeWords($str)
    {
        $str = strtolower(trim($str));
        return ucwords($str);
    }
}
