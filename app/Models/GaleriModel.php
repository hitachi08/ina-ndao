<?php
class Galeri
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ============================
    // Fetch data
    // ============================
    public function fetchAll()
    {
        $stmt = $this->pdo->query("
            SELECT v.id_variasi, 
                   j.nama_jenis, 
                   d.nama_daerah, 
                   m.nama_motif, 
                   m.cerita, 
                   m.gambar,
                   v.ukuran, v.bahan, v.jenis_pewarna, v.harga, v.stok
            FROM variasi_motif v
            JOIN motif m ON v.id_motif = m.id_motif
            JOIN kain k ON m.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchSingle($id_variasi)
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*, m.nama_motif, m.cerita, m.gambar,
                   j.id_jenis_kain, j.nama_jenis,
                   d.id_daerah, d.nama_daerah
            FROM variasi_motif v
            JOIN motif m ON v.id_motif = m.id_motif
            JOIN kain k ON m.id_kain = k.id_kain
            JOIN jenis_kain j ON k.id_jenis_kain = j.id_jenis_kain
            JOIN daerah d ON k.id_daerah = d.id_daerah
            WHERE v.id_variasi = ?
        ");
        $stmt->execute([$id_variasi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // Jenis Kain
    // ============================
    public function addJenisKain($nama_jenis)
    {
        $stmt = $this->pdo->prepare("SELECT id_jenis_kain FROM jenis_kain WHERE nama_jenis = ?");
        $stmt->execute([$nama_jenis]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['id_jenis_kain'];
        }

        $stmt = $this->pdo->prepare("INSERT INTO jenis_kain (nama_jenis) VALUES (?)");
        $stmt->execute([$nama_jenis]);
        return $this->pdo->lastInsertId();
    }

    public function updateJenisKain($id, $nama_jenis)
    {
        $stmt = $this->pdo->prepare("UPDATE jenis_kain SET nama_jenis = ? WHERE id_jenis_kain = ?");
        return $stmt->execute([$nama_jenis, $id]);
    }

    public function deleteJenisKain($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM jenis_kain WHERE id_jenis_kain = ?");
        return $stmt->execute([$id]);
    }

    public function getJenisByName($nama_jenis)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM jenis_kain WHERE nama_jenis = ?");
        $stmt->execute([$nama_jenis]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // Daerah
    // ============================
    public function addDaerah($nama_daerah)
    {
        $stmt = $this->pdo->prepare("SELECT id_daerah FROM daerah WHERE nama_daerah = ?");
        $stmt->execute([$nama_daerah]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['id_daerah'];
        }

        $stmt = $this->pdo->prepare("INSERT INTO daerah (nama_daerah) VALUES (?)");
        $stmt->execute([$nama_daerah]);
        return $this->pdo->lastInsertId();
    }

    public function updateDaerah($id, $nama_daerah)
    {
        $stmt = $this->pdo->prepare("UPDATE daerah SET nama_daerah = ? WHERE id_daerah = ?");
        return $stmt->execute([$nama_daerah, $id]);
    }

    public function deleteDaerah($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM daerah WHERE id_daerah = ?");
        return $stmt->execute([$id]);
    }

    public function getDaerahByName($nama_daerah)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM daerah WHERE nama_daerah = ?");
        $stmt->execute([$nama_daerah]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================
    // Kain (kombinasi jenis + daerah)
    // ============================
    public function getOrCreateKain($id_jenis_kain, $id_daerah)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM kain WHERE id_jenis_kain = ? AND id_daerah = ?");
        $stmt->execute([$id_jenis_kain, $id_daerah]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['id_kain'];
        }

        $stmt = $this->pdo->prepare("INSERT INTO kain (id_jenis_kain, id_daerah) VALUES (?, ?)");
        $stmt->execute([$id_jenis_kain, $id_daerah]);
        return $this->pdo->lastInsertId();
    }

    // ============================
    // Motif
    // ============================
    
    public function addMotif($data, $gambar = null)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO motif (id_kain, nama_motif, cerita, gambar)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['id_kain'],
            $data['nama_motif'],
            $data['cerita'],
            $gambar
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateMotif($id, $data, $gambar = null)
    {
        if ($gambar) {
            $stmt = $this->pdo->prepare("
                UPDATE motif SET id_kain=?, nama_motif=?, cerita=?, gambar=? WHERE id_motif=?
            ");
            return $stmt->execute([
                $data['id_kain'],
                $data['nama_motif'],
                $data['cerita'],
                $gambar,
                $id
            ]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE motif SET id_kain=?, nama_motif=?, cerita=? WHERE id_motif=?
            ");
            return $stmt->execute([
                $data['id_kain'],
                $data['nama_motif'],
                $data['cerita'],
                $id
            ]);
        }
    }

    public function deleteMotif($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM motif WHERE id_motif = ?");
        return $stmt->execute([$id]);
    }

    // ============================
    // Variasi Motif
    // ============================
    public function addVariasi($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO variasi_motif (id_motif, ukuran, bahan, jenis_pewarna, harga, stok)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_motif'],
            $data['ukuran'],
            $data['bahan'],
            $data['jenis_pewarna'],
            $data['harga'],
            $data['stok']
        ]);
    }

    public function updateVariasi($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE variasi_motif 
            SET ukuran=?, bahan=?, jenis_pewarna=?, harga=?, stok=?
            WHERE id_variasi=?
        ");
        return $stmt->execute([
            $data['ukuran'],
            $data['bahan'],
            $data['jenis_pewarna'],
            $data['harga'],
            $data['stok'],
            $id
        ]);
    }

    public function deleteVariasi($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM variasi_motif WHERE id_variasi = ?");
        return $stmt->execute([$id]);
    }
}
