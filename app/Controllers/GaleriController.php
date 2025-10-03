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

                case 'fetch_all':
                    echo json_encode($this->galeriModel->fetchAll());
                    break;

                case 'fetch_single':
                    $id = $_POST['id_variasi'] ?? 0;
                    echo json_encode($this->galeriModel->fetchSingle($id));
                    break;

                case 'add_motif':
                    $namaJenis = $this->cleanText($_POST['nama_jenis']);
                    $namaDaerah = $this->cleanText($_POST['nama_daerah']);
                    $namaMotif = $this->cleanText($_POST['nama_motif']);
                    $bahan = $this->cleanText($_POST['bahan'] ?? '');
                    $jenisPewarna = $this->cleanText($_POST['jenis_pewarna'] ?? '');
                    $harga = isset($_POST['harga']) ? intval($_POST['harga']) : 0;
                    $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;

                    if ($harga < 0 || $stok < 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Harga dan stok harus ≥ 0']);
                        exit;
                    }

                    $panjang = isset($_POST['panjang']) ? intval($_POST['panjang']) : 0;
                    $lebar = isset($_POST['lebar']) ? intval($_POST['lebar']) : 0;
                    if ($panjang <= 0 || $lebar <= 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Panjang dan lebar harus > 0']);
                        exit;
                    }
                    $ukuran = $panjang . "x" . $lebar . " cm";

                    // Jenis kain
                    $jenis = $this->galeriModel->getJenisByName($namaJenis);
                    $idJenisKain = $jenis ? $jenis['id_jenis_kain'] : $this->galeriModel->addJenisKain($namaJenis);

                    // Daerah
                    $daerah = $this->galeriModel->getDaerahByName($namaDaerah);
                    $idDaerah = $daerah ? $daerah['id_daerah'] : $this->galeriModel->addDaerah($namaDaerah);

                    // Kain
                    $idKain = $this->galeriModel->getOrCreateKain($idJenisKain, $idDaerah);

                    // Motif
                    $dataMotif = [
                        'id_kain' => $idKain,
                        'nama_motif' => $namaMotif,
                        'cerita' => trim($_POST['cerita'] ?? '')
                    ];
                    $gambar = $this->uploadFile('gambar');
                    $idMotif = $this->galeriModel->addMotif($dataMotif, $gambar);

                    // Variasi
                    $dataVariasi = [
                        'id_motif' => $idMotif,
                        'ukuran' => $ukuran,
                        'bahan' => $bahan,
                        'jenis_pewarna' => $jenisPewarna,
                        'harga' => $harga,
                        'stok' => $stok
                    ];
                    $this->galeriModel->addVariasi($dataVariasi);

                    echo json_encode(['status' => 'success', 'message' => 'Motif dan variasi berhasil ditambahkan']);
                    break;

                case 'update_variasi':
                    $id = $_POST['id_variasi'];
                    $bahan = $this->cleanText($_POST['bahan'] ?? '');
                    $jenisPewarna = $this->cleanText($_POST['jenis_pewarna'] ?? '');
                    $harga = isset($_POST['harga']) ? intval($_POST['harga']) : 0;
                    $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;

                    if ($harga < 0 || $stok < 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Harga dan stok harus ≥ 0']);
                        exit;
                    }

                    $panjang = isset($_POST['panjang']) ? intval($_POST['panjang']) : 0;
                    $lebar = isset($_POST['lebar']) ? intval($_POST['lebar']) : 0;
                    if ($panjang <= 0 || $lebar <= 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Panjang dan lebar harus > 0']);
                        exit;
                    }
                    $ukuran = $panjang . "x" . $lebar . " cm";

                    $data = [
                        'ukuran' => $ukuran,
                        'bahan' => $bahan,
                        'jenis_pewarna' => $jenisPewarna,
                        'harga' => $harga,
                        'stok' => $stok
                    ];
                    $this->galeriModel->updateVariasi($id, $data);
                    echo json_encode(['status' => 'success', 'message' => 'Variasi berhasil diperbarui']);
                    break;

                // Hapus variasi
                case 'delete_variasi':
                    $this->galeriModel->deleteVariasi($_POST['id_variasi']);
                    echo json_encode(['status' => 'success', 'message' => 'Variasi berhasil dihapus']);
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
            $targetDir = __DIR__ . '/../../public/img/motif/';
            if (!is_dir($targetDir))
                mkdir($targetDir, 0777, true);
            move_uploaded_file($_FILES[$field]['tmp_name'], $targetDir . $filename);
            return $filename;
        }
        return null;
    }

    private function cleanText($str)
    {
        $str = preg_replace("/[^a-zA-Z\s]/", "", $str);
        $str = strtolower(trim($str));
        return ucfirst($str);
    }
}
