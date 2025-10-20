<?php
require_once __DIR__ . '/../Models/KainModel.php';

class KainController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new KainModel($pdo);
    }

    public function handle($action)
    {
        switch ($action) {
            case 'fetch_all':
                return $this->fetchAll();
            case 'fetch_single':
                return $this->fetchSingle();
            case 'add_kain':
                return $this->addKain();
            case 'update_kain':
                return $this->updateKain();
            case 'delete_kain':
                return $this->deleteKain();
            case 'get_options':
                return $this->getOptions();
            case 'search':
                return $this->search();
            case 'get_options_kain':
                return $this->getOptionsKain();
            case 'filter':
                return $this->filter();
            case 'detail':
                return $this->detail();
            default:
                return ['status' => 'error', 'message' => 'Action not found'];
        }
    }

    private function fetchAll()
    {
        $data = $this->model->getAllKain();
        foreach ($data as &$item) {
            $item['motif_gambar'] = $this->model->getGambarByKain($item['id_kain']);
        }
        return ['status' => 'success', 'data' => $data];
    }

    private function fetchSingle()
    {
        $id = $_POST['id_kain'] ?? null;
        if (!$id) return ['status' => 'error', 'message' => 'ID Kain dibutuhkan'];
        $data = $this->model->getKainById($id);
        if ($data) {
            $data['motif_gambar'] = $this->model->getGambarByKain($id);
            return ['status' => 'success', 'data' => $data];
        } else {
            return ['status' => 'error', 'message' => 'Data kain tidak ditemukan'];
        }
    }

    private function addKain()
    {
        $input = $_POST;

        if (empty($input['id_jenis_kain']) || empty($input['id_daerah']) || empty($input['id_motif'])) {
            return ['status' => 'error', 'message' => 'Jenis, Daerah, dan Motif wajib diisi'];
        }

        $pdo = $this->model->getPDO();

        try {
            $pdo->beginTransaction();

            $jenis = $input['id_jenis_kain'];
            if (!is_numeric($jenis)) {
                $stmt = $pdo->prepare("INSERT INTO jenis_kain (nama_jenis) VALUES (?)");
                $stmt->execute([$jenis]);
                $jenis = $pdo->lastInsertId();
            }

            $daerah = $input['id_daerah'];
            if (!is_numeric($daerah)) {
                $stmt = $pdo->prepare("INSERT INTO daerah (nama_daerah) VALUES (?)");
                $stmt->execute([$daerah]);
                $daerah = $pdo->lastInsertId();
            }

            $motif = $input['id_motif'];
            if (!is_numeric($motif)) {
                $stmt = $pdo->prepare("INSERT INTO motif (nama_motif) VALUES (?)");
                $stmt->execute([$motif]);
                $motif = $pdo->lastInsertId();
            }

            $stmt = $pdo->prepare("SELECT id_kain FROM kain WHERE id_jenis_kain = ? AND id_daerah = ? AND id_motif = ?");
            $stmt->execute([$jenis, $daerah, $motif]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $pdo->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Kombinasi Jenis, Daerah, dan Motif sudah ada!'
                ];
            }

            $success = $this->model->insertKain([
                'id_jenis_kain' => $jenis,
                'id_daerah' => $daerah,
                'id_motif' => $motif,
                'panjang' => $input['panjang'] ?? null,
                'lebar' => $input['lebar'] ?? null,
                'bahan' => $input['bahan'] ?? null,
                'jenis_pewarna' => $input['jenis_pewarna'] ?? null,
                'harga' => $input['harga'] ?? 0,
                'stok' => $input['stok'] ?? 0
            ]);

            if (!$success) {
                throw new Exception("Gagal menambahkan data kain");
            }

            $id_kain = $pdo->lastInsertId();

            $cerita = $input['cerita'] ?? null;
            if ($cerita) {
                $stmt = $pdo->prepare("
                INSERT INTO makna_motif (id_motif, id_daerah, makna)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE makna=VALUES(makna)
            ");
                $stmt->execute([$motif, $daerah, $cerita]);
            }

            if (!empty($_FILES['gambar']['name'][0])) {
                $uploadDir = __DIR__ . '/../../public/uploads/motif/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                foreach ($_FILES['gambar']['tmp_name'] as $index => $tmpName) {
                    $originalName = basename($_FILES['gambar']['name'][$index]);
                    $filename = time() . '_' . $originalName;
                    $targetPath = $uploadDir . $filename;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $this->model->insertGambar($id_kain, '/uploads/motif/' . $filename);
                    }
                }
            }

            $pdo->commit();

            return [
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan'
            ];
        } catch (Exception $e) {
            $pdo->rollBack();
            return ['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    private function updateKain()
    {
        $id = $_POST['id_variasi'] ?? null;
        if (!$id) return ['status' => 'error', 'message' => 'ID Kain dibutuhkan'];

        $input = $_POST;
        $pdo = $this->model->getPDO();

        try {
            $pdo->beginTransaction();

            $jenis = $input['id_jenis_kain'];
            if (!is_numeric($jenis)) {
                $stmt = $pdo->prepare("INSERT INTO jenis_kain (nama_jenis) VALUES (?)");
                $stmt->execute([trim($jenis)]);
                $jenis = $pdo->lastInsertId();
            }

            $daerah = $input['id_daerah'];
            if (!is_numeric($daerah)) {
                $stmt = $pdo->prepare("INSERT INTO daerah (nama_daerah) VALUES (?)");
                $stmt->execute([trim($daerah)]);
                $daerah = $pdo->lastInsertId();
            }

            $motif = $input['id_motif'];
            if (!is_numeric($motif)) {
                $stmt = $pdo->prepare("INSERT INTO motif (nama_motif) VALUES (?)");
                $stmt->execute([trim($motif)]);
                $motif = $pdo->lastInsertId();
            }

            $stmt = $pdo->prepare("SELECT id_kain FROM kain WHERE id_jenis_kain = ? AND id_daerah = ? AND id_motif = ? AND id_kain != ?");
            $stmt->execute([$jenis, $daerah, $motif, $id]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $pdo->rollBack();
                return ['status' => 'error', 'message' => 'Kombinasi Jenis, Daerah, dan Motif sudah ada pada produk lain.'];
            }

            $rawHarga = $input['harga'] ?? 0;
            $hargaClean = preg_replace('/[^0-9.]/', '', (string)$rawHarga);
            $hargaValue = $hargaClean === '' ? 0 : (float)$hargaClean;

            $success = $this->model->updateKain($id, [
                'id_jenis_kain' => $jenis,
                'id_daerah' => $daerah,
                'id_motif' => $motif,
                'panjang' => $input['panjang'] ?? null,
                'lebar' => $input['lebar'] ?? null,
                'bahan' => $input['bahan'] ?? null,
                'jenis_pewarna' => $input['jenis_pewarna'] ?? null,
                'harga' => $hargaValue,
                'stok' => $input['stok'] ?? 0
            ]);

            if (!$success) {
                throw new Exception('Gagal update data kain');
            }

            $cerita = $input['cerita'] ?? null;
            if ($cerita !== null) {
                $stmt = $pdo->prepare("
                INSERT INTO makna_motif (id_motif, id_daerah, makna)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE makna = VALUES(makna)
            ");
                $stmt->execute([$motif, $daerah, $cerita]);
            }

            if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'][0])) {
                $oldImages = $this->model->getGambarByKain($id);
                foreach ($oldImages as $img) {
                    $this->model->deleteGambar($img['id_gambar']);
                    if (file_exists(__DIR__ . '/../../public' . $img['path_gambar'])) {
                        @unlink(__DIR__ . '/../../public' . $img['path_gambar']);
                    }
                }

                $uploadDir = __DIR__ . '/../../public/uploads/motif/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                foreach ($_FILES['gambar']['tmp_name'] as $key => $tmpName) {
                    $orig = basename($_FILES['gambar']['name'][$key]);
                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $orig);
                    $target = $uploadDir . $filename;
                    if (move_uploaded_file($tmpName, $target)) {
                        $this->model->insertGambar($id, '/uploads/motif/' . $filename);
                    }
                }
            }

            $pdo->commit();
            return ['status' => 'success', 'message' => 'Data berhasil diupdate'];
        } catch (Exception $e) {
            $pdo->rollBack();
            return ['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    private function deleteKain()
    {
        $id = $_POST['id_kain'] ?? null;
        if (!$id) return ['status' => 'error', 'message' => 'ID Kain dibutuhkan'];
        $success = $this->model->deleteKain($id);
        return ['status' => $success ? 'success' : 'error', 'message' => $success ? 'Data berhasil dihapus' : 'Gagal hapus data'];
    }

    private function getOptions()
    {
        return [
            'status' => 'success',
            'jenis' => $this->model->getAllJenis(),
            'daerah' => $this->model->getAllDaerah(),
            'motif' => $this->model->getAllMotif()
        ];
    }
    public function search()
    {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if ($keyword === '') {
            return ['status' => 'error', 'message' => 'Keyword kosong'];
        }

        $data = $this->model->searchGaleri($keyword);

        return [
            'status' => 'success',
            'data' => $data
        ];
    }

    private function detail()
    {
        $slug = $_POST['slug'] ?? $_GET['slug'] ?? null;
        if (!$slug) {
            return ['status' => 'error', 'message' => 'Slug tidak ditemukan'];
        }

        $data = $this->model->getKainBySlug($slug);
        if (!$data) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }

        return ['status' => 'success', 'data' => $data];
    }

    private function filter()
    {
        $filters = [
            'daerah' => $_POST['daerah'] ?? [],
            'jenis_kain' => $_POST['jenis_kain'] ?? [],
            'harga_min' => $_POST['harga_min'] ?? null,
            'harga_max' => $_POST['harga_max'] ?? null
        ];

        $data = $this->model->filterKain($filters);

        foreach ($data as &$item) {
            $item['motif_gambar'] = $this->model->getGambarByKain($item['id_kain']);
        }

        return ['status' => 'success', 'data' => $data];
    }

    private function getOptionsKain()
    {
        $daerah = $this->model->getAllDaerah();
        $jenis = $this->model->getAllJenis();
        return ['status' => 'success', 'daerah' => $daerah, 'jenis' => $jenis];
    }
}
